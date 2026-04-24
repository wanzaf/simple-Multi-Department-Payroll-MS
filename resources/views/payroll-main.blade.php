@extends('layouts.app')

@section('title', 'Payroll Staging')

@section('content')

<main class="dash-page">

    <div class="dash-welcome">
        <div>
            <p class="dash-welcome__greeting">Payroll</p>
            <h1 class="dash-welcome__title">Payroll Staging</h1>
        </div>
        <div style="display:flex;gap:.75rem;align-items:center">
            <select id="filterMonth" class="form-input" style="min-width:70px"></select>
            <select id="filterYear"  class="form-input" style="min-width:45px"></select>
            <button onclick="loadPreview()" class="cmsp-btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Preview
            </button>
        </div>
    </div>

    <div class="dash-section" style="animation-delay:.15s">
        <div class="dash-table-wrap" style="overflow-x:auto">
            <table class="dash-table" style="width:100%;min-width:1180px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Dept</th>
                        <th>Basic Salary</th>
                        <th>Allowance</th>
                        <th>OT Hrs</th>
                        <th>Hourly Rate</th>
                        <th>OT Pay</th>
                        <th>Gross Pay</th>
                        <th>Tax (8%)</th>
                        <th>EPF Emp (11%)</th>
                        <th>EPF Empl (13%)</th>
                        <th>Net Pay</th>
                    </tr>
                </thead>
                <tbody id="payrollBody">
                    <tr>
                        <td colspan="14">
                            <div class="empty-state">
                                <p>Select a month and year, then click Preview.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="payrollFooter"
         style="display:none;padding:1.125rem 1.5rem;background:var(--dash-surface);
                border-top:1px solid var(--dash-border);position:sticky;bottom:0;z-index:10;
                justify-content:space-between;align-items:center;gap:1rem">
        <p style="margin:0;font-size:.875rem;color:var(--dash-muted)" id="payrollPeriodLabel"></p>
        <button onclick="confirmPayroll()" class="cmsp-btn-primary" id="confirmBtn">
            <span class="spinner" id="confirmSpinner"></span>
            <span id="confirmLabel">Confirm &amp; Run Payroll</span>
        </button>
    </div>

    <div class="toast" id="toast"></div>

</main>

@endsection

@push('scripts')
<script src="{{ asset('js/payroll.js') }}"></script>
@endpush
