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

function showToast(msg, type = "success") {
    const t = document.getElementById("toast");
    t.textContent = msg;
    t.className = `toast ${type} show`;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove("show"), 3500);
}

// ─── State ────────────────────────────────────────────────────────────────────

let allRecords = [];
let currentPage = 1;

function getPerPage() {
    return parseInt(document.getElementById("perPage").value);
}

// ─── Filter selects init ──────────────────────────────────────────────────────

function initFilters() {
    const monthSel = document.getElementById("filterMonth");
    const yearSel = document.getElementById("filterYear");
    const now = new Date();
    const curYear = now.getFullYear();

    MONTHS.forEach((name, i) => {
        const opt = document.createElement("option");
        opt.value = i + 1;
        opt.textContent = name;
        monthSel.appendChild(opt);
    });

    for (let y = curYear; y >= curYear - 10; y--) {
        const opt = document.createElement("option");
        opt.value = y;
        opt.textContent = y;
        yearSel.appendChild(opt);
    }
}

// ─── Load & render ────────────────────────────────────────────────────────────

async function applyFilter() {
    const month = document.getElementById("filterMonth").value;
    const year = document.getElementById("filterYear").value;

    const params = new URLSearchParams();
    if (month) params.set("month", month);
    if (year) params.set("year", year);

    const tbody = document.getElementById("histTableBody");
    tbody.innerHTML = `<tr><td colspan="12"><div class="empty-state"><p>Loading…</p></div></td></tr>`;
    document.getElementById("histTableFoot").style.display = "none";
    document.getElementById("paginationBar").style.display = "none";

    try {
        const res = await fetch(`/api/payroll?${params.toString()}`);
        allRecords = await res.json();
        currentPage = 1;
        renderPage();
        document.getElementById("exportBtn").disabled = allRecords.length === 0;
    } catch (_) {
        tbody.innerHTML = `<tr><td colspan="12"><div class="empty-state"><p>Failed to load records.</p></div></td></tr>`;
        showToast("Failed to load payroll history.", "error");
        document.getElementById("exportBtn").disabled = true;
    }
}

function renderPage() {
    const tbody = document.getElementById("histTableBody");
    const perPage = getPerPage();
    const total = allRecords.length;

    if (!total) {
        tbody.innerHTML = `<tr><td colspan="12"><div class="empty-state"><p>No payroll records found.</p></div></td></tr>`;
        document.getElementById("histTableFoot").style.display = "none";
        document.getElementById("paginationBar").style.display = "none";
        return;
    }

    // Slice for current page
    let pageRecords;
    let lastPage = 1;

    if (perPage === 0) {
        pageRecords = allRecords;
        currentPage = 1;
    } else {
        lastPage = Math.ceil(total / perPage);
        currentPage = Math.min(currentPage, lastPage);
        const start = (currentPage - 1) * perPage;
        pageRecords = allRecords.slice(start, start + perPage);
    }

    // Global offset for # numbering
    const globalOffset = perPage === 0 ? 0 : (currentPage - 1) * perPage;

    tbody.innerHTML = pageRecords
        .map(
            (rec, i) => `
        <tr>
            <td class="td-muted">${globalOffset + i + 1}</td>
            <td><div class="cmsp-cell-title">${escapeHtml(rec.employee)}</div></td>
            <td class="td-muted">${escapeHtml(rec.department ?? "—")}</td>
            <td class="td-muted">${escapeHtml(rec.position ?? "—")}</td>
            <td class="td-muted">${MONTHS[rec.month - 1]} ${rec.year}</td>
            <td class="td-mono">${fmt(rec.overtime_pay)}</td>
            <td class="td-mono">${fmt(rec.gross_pay)}</td>
            <td class="td-mono">${fmt(rec.tax)}</td>
            <td class="td-mono">${fmt(rec.epf_employee)}</td>
            <td class="td-mono">${fmt(rec.epf_employer)}</td>
            <td class="td-mono"><strong>${fmt(rec.net_pay)}</strong></td>
            <td>
                <div class="cmsp-row-actions">
                    <a href="/payslip/${rec.id}"
                       class="cmsp-icon-btn cmsp-icon-btn--view"
                       title="View Payslip" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                            width="14" height="14">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </a>
                </div>
            </td>
        </tr>
    `,
        )
        .join("");

    // Footer totals (always over ALL filtered records)
    const sum = (key) =>
        allRecords.reduce((s, r) => s + parseFloat(r[key] ?? 0), 0);
    document.getElementById("footTotalRows").textContent = total;
    document.getElementById("footOtPay").textContent = fmt(sum("overtime_pay"));
    document.getElementById("footGross").textContent = fmt(sum("gross_pay"));
    document.getElementById("footTax").textContent = fmt(sum("tax"));
    document.getElementById("footEpfEmp").textContent = fmt(
        sum("epf_employee"),
    );
    document.getElementById("footEpfEmpl").textContent = fmt(
        sum("epf_employer"),
    );
    document.getElementById("footNet").textContent = fmt(sum("net_pay"));
    document.getElementById("histTableFoot").style.display = "";

    // Pagination
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
    info.textContent = `Showing ${start}–${end} of ${total} records`;

    // Build page buttons — show at most 7 slots: prev, 1, ..., cur-1, cur, cur+1, ..., last, next
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

// ─── Export CSV ───────────────────────────────────────────────────────────────

function csvCell(val) {
    const str = String(val ?? "");
    // Wrap in quotes if the value contains a comma, quote, or newline
    return /[",\n\r]/.test(str) ? `"${str.replace(/"/g, '""')}"` : str;
}

function exportCSV() {
    if (!allRecords.length) return;

    const month = document.getElementById("filterMonth").value;
    const year = document.getElementById("filterYear").value;

    const headers = [
        "#",
        "Employee",
        "Department",
        "Position",
        "Period",
        "OT Pay",
        "Gross Pay",
        "Tax (8%)",
        "EPF Employee (11%)",
        "EPF Employer (13%)",
        "Net Pay",
    ];

    const rows = allRecords.map((rec, i) =>
        [
            i + 1,
            rec.employee,
            rec.department ?? "",
            rec.position ?? "",
            `${MONTHS[rec.month - 1]} ${rec.year}`,
            rec.overtime_pay,
            rec.gross_pay,
            rec.tax,
            rec.epf_employee,
            rec.epf_employer,
            rec.net_pay,
        ]
            .map(csvCell)
            .join(","),
    );

    // Totals footer row
    const sum = (key) =>
        allRecords.reduce((s, r) => s + parseFloat(r[key] ?? 0), 0);
    const totals = [
        "TOTAL",
        "",
        "",
        "",
        "",
        sum("overtime_pay").toFixed(2),
        sum("gross_pay").toFixed(2),
        sum("tax").toFixed(2),
        sum("epf_employee").toFixed(2),
        sum("epf_employer").toFixed(2),
        sum("net_pay").toFixed(2),
    ]
        .map(csvCell)
        .join(",");

    const csv = [headers.join(","), ...rows, totals].join("\r\n");

    // Build filename: payroll_YYYY-MM.csv or payroll_all.csv
    let filename = "payroll";
    if (year && month) filename += `_${year}-${String(month).padStart(2, "0")}`;
    else if (year) filename += `_${year}`;
    else if (month) filename += `_${MONTHS[month - 1].toLowerCase()}`;
    else filename += "_all";
    filename += ".csv";

    const blob = new Blob(["\uFEFF" + csv], {
        type: "text/csv;charset=utf-8;",
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}
document.addEventListener("DOMContentLoaded", () => {
    initFilters();
    applyFilter(); // load all on page open
    document.getElementById("perPage").addEventListener("change", () => {
        currentPage = 1;
        renderPage();
    });
});
