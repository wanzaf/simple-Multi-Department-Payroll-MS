const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function escapeHtml(str) {
    return String(str ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

function formatDate(iso) {
    return new Date(iso).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
}

function formatMoney(val) {
    return Number(val).toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function showToast(msg, type = "success") {
    const t = document.getElementById("toast");
    t.textContent = msg;
    t.className = `toast ${type} show`;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove("show"), 3500);
}

function clearFormErrors(prefix = "") {
    [
        "Name",
        "Position",
        "Dept",
        "BasicSalary",
        "Allowance",
        "OtHours",
        "HourlyRate",
    ].forEach((f) => {
        const el = document.getElementById(`${prefix}Emp${f}Error`);
        if (el) el.style.display = "none";
    });
}

function showFieldError(id, msg) {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = msg;
    el.style.display = "block";
}

let departments = [];

async function loadDepartmentsDropdown() {
    try {
        const res = await fetch("/api/departments");
        departments = await res.json();
        populateDeptSelects();
        populateDepartmentFilter();
    } catch (_) {}
}

function populateDeptSelects() {
    ["empDept", "editEmpDept"].forEach((id) => {
        const sel = document.getElementById(id);
        const current = sel.value;
        sel.innerHTML = '<option value="">— None —</option>';
        departments.forEach((d) => {
            const opt = document.createElement("option");
            opt.value = d.id;
            opt.textContent = d.name;
            sel.appendChild(opt);
        });
        sel.value = current;
    });
}

function populateDepartmentFilter() {
    const sel = document.getElementById("departmentFilter");
    if (!sel) return;
    sel.innerHTML = '<option value="">All Departments</option>';
    departments.forEach((d) => {
        const opt = document.createElement("option");
        opt.value = d.id;
        opt.textContent = d.name;
        sel.appendChild(opt);
    });
    sel.value = "";
}

function handleDepartmentFilter() {
    loadEmployees();
}

async function loadEmployees() {
    const tbody = document.getElementById("empTableBody");
    const filterValue =
        document.getElementById("departmentFilter")?.value || "";
    const url = filterValue
        ? `/api/employees?department_id=${filterValue}`
        : "/api/employees";

    try {
        const res = await fetch(url);
        const data = await res.json();

        if (!data.length) {
            tbody.innerHTML = `
                <tr><td colspan="10">
                    <div class="empty-state"><p>No employees yet. Add one.</p></div>
                </td></tr>`;
            return;
        }

        tbody.innerHTML = data
            .map(
                (emp, i) => `
            <tr id="emp-row-${emp.id}">
                <td class="td-muted">${i + 1}</td>
                <td><div class="cmsp-cell-title">${escapeHtml(emp.name)}</div></td>
                <td class="td-muted">${escapeHtml(emp.department ?? "—")}</td>
                <td class="td-muted">${escapeHtml(emp.position)}</td>
                <td class="td-mono">${formatMoney(emp.basic_salary)}</td>
                <td class="td-mono">${formatMoney(emp.allowance)}</td>
                <td class="td-muted">${emp.overtime_hours}</td>
                <td class="td-mono">${formatMoney(emp.hourly_rate)}</td>
                <td class="td-muted">${formatDate(emp.created_at)}</td>
                <td>
                    <div class="cmsp-row-actions">
                        <button class="cmsp-icon-btn cmsp-icon-btn--edit"
                            onclick="openEditModal(${emp.id})"
                            title="Edit employee">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"
                                stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        <button class="cmsp-icon-btn cmsp-icon-btn--delete"
                            onclick="deleteEmployee(${emp.id}, '${escapeHtml(emp.name).replace(/'/g, "\\'")}')"
                            title="Delete employee">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"
                                stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6"/><path d="M14 11v6"/>
                                <path d="M9 6V4h6v2"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>`,
            )
            .join("");
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="10"><div class="empty-state"><p>Failed to load employees.</p></div></td></tr>`;
    }
}

function openModal() {
    document.getElementById("createEmpForm").reset();
    clearFormErrors("create");
    document.getElementById("empAllowance").value = "0";
    document.getElementById("empOtHours").value = "0";
    document.getElementById("empHourlyRate").value = "0";
    document.getElementById("createModal").classList.add("is-open");
    setTimeout(() => document.getElementById("empName").focus(), 120);
}

function closeModal() {
    document.getElementById("createModal").classList.remove("is-open");
}

let editingEmpId = null;
let employeesCache = {};

async function openEditModal(id) {
    editingEmpId = id;
    clearFormErrors("edit");

    const row = document.getElementById(`emp-row-${id}`);
    const cells = row?.querySelectorAll("td");

    try {
        const res = await fetch("/api/employees");
        const data = await res.json();
        const emp = data.find((e) => e.id == id);
        if (!emp) return;

        document.getElementById("editEmpName").value = emp.name;
        document.getElementById("editEmpPosition").value = emp.position;
        document.getElementById("editEmpBasicSalary").value = emp.basic_salary;
        document.getElementById("editEmpAllowance").value = emp.allowance;
        document.getElementById("editEmpOtHours").value = emp.overtime_hours;
        document.getElementById("editEmpHourlyRate").value = emp.hourly_rate;

        populateDeptSelects();
        document.getElementById("editEmpDept").value = emp.department_id ?? "";
    } catch (_) {}

    document.getElementById("editModal").classList.add("is-open");
    setTimeout(() => document.getElementById("editEmpName").focus(), 120);
}

function closeEditModal() {
    document.getElementById("editModal").classList.remove("is-open");
    editingEmpId = null;
}

function handleOverlayClick(e, modal = "create") {
    const el =
        modal === "edit"
            ? document.getElementById("editModal")
            : document.getElementById("createModal");
    if (e.target === el) {
        modal === "edit" ? closeEditModal() : closeModal();
    }
}

async function submitCreate(e) {
    e.preventDefault();
    clearFormErrors("create");

    const payload = {
        name: document.getElementById("empName").value.trim(),
        position: document.getElementById("empPosition").value.trim(),
        department_id: document.getElementById("empDept").value || null,
        basic_salary: document.getElementById("empBasicSalary").value,
        allowance: document.getElementById("empAllowance").value,
        overtime_hours: document.getElementById("empOtHours").value,
        hourly_rate: document.getElementById("empHourlyRate").value,
    };

    let valid = true;
    if (!payload.name) {
        showFieldError("empNameError", "Name is required.");
        valid = false;
    }
    if (!payload.position) {
        showFieldError("empPositionError", "Position is required.");
        valid = false;
    }
    if (payload.basic_salary === "" || payload.basic_salary === null) {
        showFieldError("empBasicSalaryError", "Basic salary is required.");
        valid = false;
    }
    if (!valid) return;

    const spinner = document.getElementById("createSpinner");
    const label = document.getElementById("createLabel");
    const btn = document.getElementById("createSubmitBtn");
    spinner.style.display = "block";
    label.textContent = "Creating…";
    btn.disabled = true;

    try {
        const res = await fetch("/api/employees", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                if (data.errors.name)
                    showFieldError("empNameError", data.errors.name[0]);
                if (data.errors.position)
                    showFieldError("empPositionError", data.errors.position[0]);
                if (data.errors.department_id)
                    showFieldError(
                        "empDeptError",
                        data.errors.department_id[0],
                    );
                if (data.errors.basic_salary)
                    showFieldError(
                        "empBasicSalaryError",
                        data.errors.basic_salary[0],
                    );
                if (data.errors.allowance)
                    showFieldError(
                        "empAllowanceError",
                        data.errors.allowance[0],
                    );
                if (data.errors.overtime_hours)
                    showFieldError(
                        "empOtHoursError",
                        data.errors.overtime_hours[0],
                    );
                if (data.errors.hourly_rate)
                    showFieldError(
                        "empHourlyRateError",
                        data.errors.hourly_rate[0],
                    );
            } else {
                showFieldError(
                    "empNameError",
                    data.message ?? "Something went wrong.",
                );
            }
            return;
        }

        closeModal();
        showToast(`Employee "${data.name}" created.`);
        document.getElementById("departmentFilter").value = "";
        loadEmployees();
    } catch (_) {
        showFieldError("empNameError", "Network error. Please try again.");
    } finally {
        spinner.style.display = "none";
        label.textContent = "Create";
        btn.disabled = false;
    }
}

async function submitEdit(e) {
    e.preventDefault();
    clearFormErrors("edit");

    const payload = {
        name: document.getElementById("editEmpName").value.trim(),
        position: document.getElementById("editEmpPosition").value.trim(),
        department_id: document.getElementById("editEmpDept").value || null,
        basic_salary: document.getElementById("editEmpBasicSalary").value,
        allowance: document.getElementById("editEmpAllowance").value,
        overtime_hours: document.getElementById("editEmpOtHours").value,
        hourly_rate: document.getElementById("editEmpHourlyRate").value,
    };

    let valid = true;
    if (!payload.name) {
        showFieldError("editEmpNameError", "Name is required.");
        valid = false;
    }
    if (!payload.position) {
        showFieldError("editEmpPositionError", "Position is required.");
        valid = false;
    }
    if (payload.basic_salary === "" || payload.basic_salary === null) {
        showFieldError("editEmpBasicSalaryError", "Basic salary is required.");
        valid = false;
    }
    if (!valid) return;

    const spinner = document.getElementById("editSpinner");
    const label = document.getElementById("editLabel");
    const btn = document.getElementById("editSubmitBtn");
    spinner.style.display = "block";
    label.textContent = "Saving…";
    btn.disabled = true;

    try {
        const res = await fetch(`/api/employees/${editingEmpId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                if (data.errors.name)
                    showFieldError("editEmpNameError", data.errors.name[0]);
                if (data.errors.position)
                    showFieldError(
                        "editEmpPositionError",
                        data.errors.position[0],
                    );
                if (data.errors.department_id)
                    showFieldError(
                        "editEmpDeptError",
                        data.errors.department_id[0],
                    );
                if (data.errors.basic_salary)
                    showFieldError(
                        "editEmpBasicSalaryError",
                        data.errors.basic_salary[0],
                    );
                if (data.errors.allowance)
                    showFieldError(
                        "editEmpAllowanceError",
                        data.errors.allowance[0],
                    );
                if (data.errors.overtime_hours)
                    showFieldError(
                        "editEmpOtHoursError",
                        data.errors.overtime_hours[0],
                    );
                if (data.errors.hourly_rate)
                    showFieldError(
                        "editEmpHourlyRateError",
                        data.errors.hourly_rate[0],
                    );
            } else {
                showFieldError(
                    "editEmpNameError",
                    data.message ?? "Something went wrong.",
                );
            }
            return;
        }

        closeEditModal();
        showToast(`Employee "${data.name}" updated.`);
        document.getElementById("departmentFilter").value = "";
        loadEmployees();
    } catch (_) {
        showFieldError("editEmpNameError", "Network error. Please try again.");
    } finally {
        spinner.style.display = "none";
        label.textContent = "Save";
        btn.disabled = false;
    }
}

async function deleteEmployee(id, name) {
    const result = await Swal.fire({
        title: "Delete Employee?",
        html: `Are you sure you want to delete <strong>${escapeHtml(name)}</strong>?<br><span style="font-size:0.8125rem;color:var(--dash-muted)">This cannot be undone.</span>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "transparent",
        background: "var(--dash-surface)",
        color: "var(--dash-text)",
        customClass: { cancelButton: "swal-cancel-btn" },
        reverseButtons: true,
    });

    if (!result.isConfirmed) return;

    try {
        const res = await fetch(`/api/employees/${id}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": CSRF },
        });
        const data = await res.json();

        if (!res.ok) {
            showToast(data.message ?? "Failed to delete.", "error");
            return;
        }

        document.getElementById(`emp-row-${id}`)?.remove();
        showToast(`Employee "${name}" deleted.`);

        if (!document.querySelector("#empTableBody tr[id]")) {
            document.getElementById("departmentFilter").value = "";
            loadEmployees();
        }
    } catch (_) {
        showToast("Network error. Please try again.", "error");
    }
}

loadDepartmentsDropdown();
loadEmployees();
