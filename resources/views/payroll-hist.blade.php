@extends('layouts.app')

@section('title', 'Payroll History')

@section('content')

<main class="dash-page">

    <div class="dash-welcome">
        <div>
            <p class="dash-welcome__greeting">Payroll</p>
            <h1 class="dash-welcome__title">Payroll History</h1>
        </div>
        <div style="display:flex;gap:.75rem;align-items:center">
            <select id="filterMonth" class="form-input" style="min-width:70px">
                <option value="">All Months</option>
            </select>
            <select id="filterYear" class="form-input" style="min-width:45px">
                <option value="">All Years</option>
            </select>
            <select id="perPage" class="form-input" style="min-width:55px">
                <option value="10" selected>10 / page</option>
                <option value="50">50 / page</option>
                <option value="100">100 / page</option>
                <option value="0">Show All</option>
            </select>
            <button onclick="applyFilter()" class="cmsp-btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Filter
            </button>
            <button onclick="exportCSV()" class="btn btn-ghost" id="exportBtn" disabled style="white-space:nowrap;background-color:#16c757;color:#f0f0f0">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export CSV
            </button>
        </div>
    </div>

    <div class="dash-section" style="animation-delay:.15s">
        <div class="dash-table-wrap" style="overflow-x:auto">
            <table class="dash-table" style="width:100%;min-width:1100px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Dept</th>
                        <th>Position</th>
                        <th>Period</th>
                        <th>OT Pay</th>
                        <th>Gross Pay</th>
                        <th>Tax (8%)</th>
                        <th>EPF Emp (11%)</th>
                        <th>EPF Empl (13%)</th>
                        <th>Net Pay</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="histTableBody">
                    <tr>
                        <td colspan="12">
                            <div class="empty-state"><p>Loading...</p></div>
                        </td>
                    </tr>
                </tbody>
                <tfoot id="histTableFoot" style="display:none">
                    <tr style="font-weight:600;background:var(--dash-hover)">
                        <td colspan="5" style="padding:10px 12px;font-size:.8125rem;color:var(--dash-muted)">
                            Totals (<span id="footTotalRows">0</span> records)
                        </td>
                        <td class="td-mono" id="footOtPay">—</td>
                        <td class="td-mono" id="footGross">—</td>
                        <td class="td-mono" id="footTax">—</td>
                        <td class="td-mono" id="footEpfEmp">—</td>
                        <td class="td-mono" id="footEpfEmpl">—</td>
                        <td class="td-mono" id="footNet">—</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div id="paginationBar"
             style="display:none;align-items:center;justify-content:space-between;
                    gap:1rem;padding:12px 0;flex-wrap:wrap">
            <p id="paginationInfo"
               style="margin:0;font-size:.8125rem;color:var(--dash-muted)"></p>
            <div id="paginationBtns" style="display:flex;gap:4px;flex-wrap:wrap"></div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

</main>

@endsection

@push('scripts')
<script src="{{ asset('js/payroll-hist.js') }}"></script>
@endpush
