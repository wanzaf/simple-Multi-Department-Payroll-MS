const CSRF = document.querySelector('meta[name="csrf-token"]').content;

let allDepts = [];
let currentPage = 1;

function getPerPage() {
    return parseInt(document.getElementById("perPage").value);
}

function escapeHtml(str) {
    return String(str)
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

function showToast(msg, type = "success") {
    const t = document.getElementById("toast");
    t.textContent = msg;
    t.className = `toast ${type} show`;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove("show"), 3500);
}

async function loadDepartments() {
    const tbody = document.getElementById("deptTableBody");
    tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><p>Loading…</p></div></td></tr>`;
    document.getElementById("paginationBar").style.display = "none";

    try {
        const res = await fetch("/api/departments");
        allDepts = await res.json();
        currentPage = 1;
        renderPage();
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><p>Failed to load departments.</p></div></td></tr>`;
    }
}

function renderPage() {
    const tbody = document.getElementById("deptTableBody");
    const perPage = getPerPage();
    const total = allDepts.length;

    if (!total) {
        tbody.innerHTML = `
            <tr><td colspan="5">
                <div class="empty-state">
                    <p>No departments yet. Create one.</p>
                </div>
            </td></tr>`;
        document.getElementById("paginationBar").style.display = "none";
        return;
    }

    let pageDepts;
    let lastPage = 1;

    if (perPage === 0) {
        pageDepts = allDepts;
        currentPage = 1;
    } else {
        lastPage = Math.ceil(total / perPage);
        currentPage = Math.min(currentPage, lastPage);
        const start = (currentPage - 1) * perPage;
        pageDepts = allDepts.slice(start, start + perPage);
    }

    const globalOffset = perPage === 0 ? 0 : (currentPage - 1) * perPage;

    tbody.innerHTML = pageDepts
        .map(
            (dept, i) => `
        <tr id="row-${dept.id}">
            <td class="td-muted">${globalOffset + i + 1}</td>
            <td>
                <div class="cmsp-cell-title">${escapeHtml(dept.name)}</div>
            </td>
            <td class="td-muted">${dept.employees_count || 0}</td>
            <td class="td-muted">${formatDate(dept.created_at)}</td>
            <td>
                <div class="cmsp-row-actions">
                    <button class="cmsp-icon-btn cmsp-icon-btn--edit"
                        onclick="openEditModal(${dept.id}, '${escapeHtml(dept.name).replace(/'/g, "\\'")}')"
                        title="Edit department">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"
                            stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button class="cmsp-icon-btn cmsp-icon-btn--delete"
                        onclick="deleteDept(${dept.id}, '${escapeHtml(dept.name).replace(/'/g, "\\'")}')"
                        title="Delete department">
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

    if (perPage === 0) {
        document.getElementById("paginationBar").style.display = "none";
    } else {
        renderPagination(total, perPage, lastPage);
    }
}

function renderPagination(total, perPage, lastPage) {
    const bar = document.getElementById("paginationBar");
    const info = document.getElementById("paginationInfo");
    const btns = document.getElementById("paginationBtns");

    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, total);
    info.textContent = `Showing ${start}–${end} of ${total} departments`;

    btns.innerHTML = "";

    const btn = (label, page, disabled = false, active = false) => {
        const el = document.createElement("button");
        el.className = `btn ${active ? "btn-primary" : "btn-ghost"}`;
        el.style.cssText = "min-width:32px;padding:4px 8px;font-size:.8125rem";
        el.textContent = label;
        el.disabled = disabled;
        if (!disabled) el.onclick = () => goToPage(page);
        btns.appendChild(el);
    };

    btn("‹", currentPage - 1, currentPage === 1);

    if (lastPage <= 7) {
        for (let p = 1; p <= lastPage; p++) btn(p, p, false, p === currentPage);
    } else {
        btn(1, 1, false, currentPage === 1);
        if (currentPage > 3) {
            const ellipsis = document.createElement("span");
            ellipsis.textContent = "…";
            ellipsis.style.cssText =
                "padding:4px 2px;font-size:.8125rem;color:var(--dash-muted)";
            btns.appendChild(ellipsis);
        }
        for (
            let p = Math.max(2, currentPage - 1);
            p <= Math.min(lastPage - 1, currentPage + 1);
            p++
        ) {
            btn(p, p, false, p === currentPage);
        }
        if (currentPage < lastPage - 2) {
            const ellipsis = document.createElement("span");
            ellipsis.textContent = "…";
            ellipsis.style.cssText =
                "padding:4px 2px;font-size:.8125rem;color:var(--dash-muted)";
            btns.appendChild(ellipsis);
        }
        btn(lastPage, lastPage, false, currentPage === lastPage);
    }

    btn("›", currentPage + 1, currentPage === lastPage);

    bar.style.display = "flex";
}

function goToPage(page) {
    currentPage = page;
    renderPage();
}

function openModal() {
    document.getElementById("deptName").value = "";
    document.getElementById("deptNameError").style.display = "none";
    document.getElementById("createModal").classList.add("is-open");
    setTimeout(() => document.getElementById("deptName").focus(), 120);
}

function closeModal() {
    document.getElementById("createModal").classList.remove("is-open");
}

function openEditModal(id, name) {
    window.editingDeptId = id;
    document.getElementById("editDeptName").value = name;
    document.getElementById("editDeptNameError").style.display = "none";
    document.getElementById("editModal").classList.add("is-open");
    setTimeout(() => document.getElementById("editDeptName").focus(), 120);
}

function closeEditModal() {
    document.getElementById("editModal").classList.remove("is-open");
    window.editingDeptId = null;
}

function handleOverlayClick(e, modal = "create") {
    const modalElement =
        modal === "edit"
            ? document.getElementById("editModal")
            : document.getElementById("createModal");
    if (e.target === modalElement) {
        if (modal === "edit") closeEditModal();
        else closeModal();
    }
}

async function submitCreate(e) {
    e.preventDefault();

    const name = document.getElementById("deptName").value.trim();
    const errEl = document.getElementById("deptNameError");
    errEl.style.display = "none";

    if (!name) {
        errEl.textContent = "Department name is required.";
        errEl.style.display = "block";
        return;
    }

    const spinner = document.getElementById("submitSpinner");
    const label = document.getElementById("submitLabel");
    const btn = document.getElementById("submitBtn");
    spinner.style.display = "block";
    label.textContent = "Creating…";
    btn.disabled = true;

    try {
        const res = await fetch("/api/departments", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
            },
            body: JSON.stringify({ name }),
        });
        const data = await res.json();

        if (!res.ok) {
            const msg =
                data.errors?.name?.[0] ??
                data.message ??
                "Something went wrong.";
            errEl.textContent = msg;
            errEl.style.display = "block";
            return;
        }

        closeModal();
        showToast(`Department "${data.name}" created.`);
        loadDepartments();
    } catch (err) {
        errEl.textContent = "Network error. Please try again.";
        errEl.style.display = "block";
    } finally {
        spinner.style.display = "none";
        label.textContent = "Create";
        btn.disabled = false;
    }
}

async function submitEdit(e) {
    e.preventDefault();

    const name = document.getElementById("editDeptName").value.trim();
    const errEl = document.getElementById("editDeptNameError");
    errEl.style.display = "none";

    if (!name) {
        errEl.textContent = "Department name is required.";
        errEl.style.display = "block";
        return;
    }

    const spinner = document.getElementById("editSubmitSpinner");
    const label = document.getElementById("editSubmitLabel");
    const btn = document.getElementById("editSubmitBtn");
    spinner.style.display = "block";
    label.textContent = "Saving…";
    btn.disabled = true;

    try {
        const res = await fetch(`/api/departments/${window.editingDeptId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
            },
            body: JSON.stringify({ name }),
        });
        const data = await res.json();

        if (!res.ok) {
            const msg =
                data.errors?.name?.[0] ??
                data.message ??
                "Something went wrong.";
            errEl.textContent = msg;
            errEl.style.display = "block";
            return;
        }

        closeEditModal();
        showToast(`Department updated to "${data.name}".`);
        loadDepartments();
    } catch (err) {
        errEl.textContent = "Network error. Please try again.";
        errEl.style.display = "block";
    } finally {
        spinner.style.display = "none";
        label.textContent = "Save";
        btn.disabled = false;
    }
}

async function deleteDept(id, name) {
    const result = await Swal.fire({
        title: "Delete Department?",
        html: `Are you sure you want to delete <strong>${escapeHtml(name)}</strong>?<br><span style="font-size:0.8125rem;color:var(--dash-muted)">This cannot be undone.</span>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "transparent",
        background: "var(--dash-surface)",
        color: "var(--dash-text)",
        customClass: {
            cancelButton: "swal-cancel-btn",
        },
        reverseButtons: true,
    });

    if (!result.isConfirmed) return;

    try {
        const res = await fetch(`/api/departments/${id}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": CSRF },
        });
        const data = await res.json();

        if (res.status === 409) {
            showToast(data.message, "error");
            return;
        }
        if (!res.ok) {
            showToast(data.message ?? "Failed to delete.", "error");
            return;
        }

        allDepts = allDepts.filter((d) => d.id !== id);
        showToast(`Department "${name}" deleted.`);
        renderPage();
    } catch (err) {
        showToast("Network error. Please try again.", "error");
    }
}

loadDepartments();
