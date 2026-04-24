const CSRF = document.querySelector('meta[name="csrf-token"]').content;

const MONTHS = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

const TAX_RATE = 0.08;
const EPF_EMP_RATE = 0.11;
const EPF_EMPL_RATE = 0.13;

function fmt(val) {
    return Number(val).toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function escapeHtml(str) {
    return String(str ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

function round2(n) {
    return Math.round(n * 100) / 100;
}

function calcRow(basicSalary, allowance, otHours, hourlyRate) {
    const otPay = round2(otHours * hourlyRate);
    const grossPay = round2(
        parseFloat(basicSalary) + parseFloat(allowance) + otPay,
    );
    const tax = round2(grossPay * TAX_RATE);
    const epfEmp = round2(grossPay * EPF_EMP_RATE);
    const epfEmpl = round2(grossPay * EPF_EMPL_RATE);
    const netPay = round2(grossPay - tax - epfEmp);
    return { otPay, grossPay, tax, epfEmp, epfEmpl, netPay };
}

function showToast(msg, type = "success") {
    const t = document.getElementById("toast");
    t.textContent = msg;
    t.className = `toast ${type} show`;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove("show"), 3500);
}

function initFilters() {
    const now = new Date();
    const curMonth = now.getMonth() + 1;
    const curYear = now.getFullYear();
    const monthSel = document.getElementById("filterMonth");
    const yearSel = document.getElementById("filterYear");

    MONTHS.forEach((name, i) => {
        const opt = document.createElement("option");
        opt.value = i + 1;
        opt.textContent = name;
        if (i + 1 === curMonth) opt.selected = true;
        monthSel.appendChild(opt);
    });

    for (let y = curYear; y >= curYear - 5; y--) {
        const opt = document.createElement("option");
        opt.value = y;
        opt.textContent = y;
        if (y === curYear) opt.selected = true;
        yearSel.appendChild(opt);
    }
}

let employees = [];

async function loadPreview() {
    const tbody = document.getElementById("payrollBody");
    tbody.innerHTML = `<tr><td colspan="14"><div class="empty-state"><p>Loading…</p></div></td></tr>`;
    document.getElementById("payrollFooter").style.display = "none";

    try {
        const res = await fetch("/api/employees");
        employees = await res.json();

        if (!employees.length) {
            tbody.innerHTML = `<tr><td colspan="14"><div class="empty-state"><p>No employees found.</p></div></td></tr>`;
            return;
        }

        renderRows();

        const month = parseInt(document.getElementById("filterMonth").value);
        const year = parseInt(document.getElementById("filterYear").value);
        document.getElementById("payrollPeriodLabel").textContent =
            `${employees.length} employee(s) staged for ${MONTHS[month - 1]} ${year}`;

        const footer = document.getElementById("payrollFooter");
        footer.style.display = "flex";
    } catch (_) {
        tbody.innerHTML = `<tr><td colspan="14"><div class="empty-state"><p>Failed to load employees.</p></div></td></tr>`;
    }
}

function renderRows() {
    const tbody = document.getElementById("payrollBody");
    tbody.innerHTML = employees
        .map((emp, i) => {
            const c = calcRow(
                emp.basic_salary,
                emp.allowance,
                emp.overtime_hours,
                emp.hourly_rate,
            );
            return `
        <tr id="pr-row-${emp.id}"
            data-id="${emp.id}"
            data-basic="${emp.basic_salary}"
            data-allowance="${emp.allowance}"
            data-rate="${emp.hourly_rate}">
            <td class="td-muted">${i + 1}</td>
            <td><div class="cmsp-cell-title">${escapeHtml(emp.name)}</div></td>
            <td class="td-muted">${escapeHtml(emp.department ?? "—")}</td>
            <td class="td-mono">${fmt(emp.basic_salary)}</td>
            <td class="td-mono">${fmt(emp.allowance)}</td>
            <td>
                <input type="number"
                    class="form-input pr-ot-input"
                    style="width:76px;padding:4px 8px;font-size:.8125rem"
                    min="0" step="0.5"
                    value="${emp.overtime_hours}"
                    oninput="recalcRow(${emp.id})">
            </td>
            <td class="td-mono">${fmt(emp.hourly_rate)}</td>
            <td class="td-mono" id="pr-ot-${emp.id}">${fmt(c.otPay)}</td>
            <td class="td-mono" id="pr-gross-${emp.id}">${fmt(c.grossPay)}</td>
            <td class="td-mono" id="pr-tax-${emp.id}">${fmt(c.tax)}</td>
            <td class="td-mono" id="pr-epfemp-${emp.id}">${fmt(c.epfEmp)}</td>
            <td class="td-mono" id="pr-epfempl-${emp.id}">${fmt(c.epfEmpl)}</td>
            <td class="td-mono" id="pr-net-${emp.id}"><strong>${fmt(c.netPay)}</strong></td>
        </tr>`;
        })
        .join("");
}

function recalcRow(empId) {
    const row = document.getElementById(`pr-row-${empId}`);
    const basic = parseFloat(row.dataset.basic);
    const allowance = parseFloat(row.dataset.allowance);
    const rate = parseFloat(row.dataset.rate);
    const otHours = parseFloat(row.querySelector(".pr-ot-input").value) || 0;
    const c = calcRow(basic, allowance, otHours, rate);

    document.getElementById(`pr-ot-${empId}`).textContent = fmt(c.otPay);
    document.getElementById(`pr-gross-${empId}`).textContent = fmt(c.grossPay);
    document.getElementById(`pr-tax-${empId}`).textContent = fmt(c.tax);
    document.getElementById(`pr-epfemp-${empId}`).textContent = fmt(c.epfEmp);
    document.getElementById(`pr-epfempl-${empId}`).textContent = fmt(c.epfEmpl);
    document.getElementById(`pr-net-${empId}`).innerHTML =
        `<strong>${fmt(c.netPay)}</strong>`;
}

async function confirmPayroll() {
    const month = parseInt(document.getElementById("filterMonth").value);
    const year = parseInt(document.getElementById("filterYear").value);
    const btn = document.getElementById("confirmBtn");

    btn.disabled = true;
    document.getElementById("confirmSpinner").style.display = "inline-block";
    document.getElementById("confirmLabel").textContent = "Saving…";

    const records = employees.map((emp) => {
        const row = document.getElementById(`pr-row-${emp.id}`);
        const otHours =
            parseFloat(row.querySelector(".pr-ot-input").value) || 0;
        const c = calcRow(
            emp.basic_salary,
            emp.allowance,
            otHours,
            emp.hourly_rate,
        );
        return {
            employee_id: emp.id,
            overtime_pay: c.otPay,
            gross_pay: c.grossPay,
            tax: c.tax,
            epf_employee: c.epfEmp,
            epf_employer: c.epfEmpl,
            net_pay: c.netPay,
        };
    });

    try {
        const res = await fetch("/api/payroll/bulk", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
            },
            body: JSON.stringify({ month, year, records }),
        });
        const data = await res.json();

        if (!res.ok) {
            showToast(data.message ?? "Failed to save payroll.", "error");
        } else {
            showToast(
                `Payroll for ${MONTHS[month - 1]} ${year} saved successfully.`,
            );
        }
    } catch (_) {
        showToast("An unexpected error occurred.", "error");
    } finally {
        btn.disabled = false;
        document.getElementById("confirmSpinner").style.display = "none";
        document.getElementById("confirmLabel").textContent = "Confirm & Save";
    }
}

document.addEventListener("DOMContentLoaded", initFilters);
