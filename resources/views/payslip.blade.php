@extends('layouts.app')

@section('title', 'Payslip — ' . $record->employee?->name)

@push('styles')
<style>
    .payslip-wrap {
        max-width: 720px;
        margin: 2rem auto;
        background: var(--dash-surface);
        border: 1px solid var(--dash-border);
        border-radius: var(--dash-radius);
        overflow: hidden;
    }

    .payslip-header {
        background: var(--dash-accent);
        color: #09090b;
        padding: 2rem 2.5rem 1.5rem;
    }

    .payslip-header__company {
        font-size: .6875rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        opacity: .7;
        margin-bottom: .25rem;
    }

    .payslip-header__title {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -.02em;
        margin: 0 0 .25rem;
    }

    .payslip-header__period {
        font-size: .875rem;
        font-weight: 500;
        opacity: .75;
    }

    .payslip-emp {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .375rem 2rem;
        padding: 1.5rem 2.5rem;
        border-bottom: 1px solid var(--dash-border);
    }

    .payslip-emp__row {
        display: flex;
        flex-direction: column;
    }

    .payslip-emp__label {
        font-size: .6875rem;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--dash-muted);
        margin-bottom: .125rem;
    }

    .payslip-emp__value {
        font-size: .9375rem;
        font-weight: 600;
        color: var(--dash-text);
    }

    .payslip-body {
        padding: 1.5rem 2.5rem;
    }

    .payslip-section-title {
        font-size: .6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--dash-muted);
        margin: 0 0 .625rem;
    }

    .payslip-lines {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.25rem;
    }

    .payslip-lines td {
        padding: .5rem 0;
        font-size: .875rem;
        border-bottom: 1px solid var(--dash-border);
        color: var(--dash-text);
    }

    .payslip-lines td:last-child {
        text-align: right;
        font-variant-numeric: tabular-nums;
        font-family: 'Courier New', monospace;
    }

    .payslip-lines tr:last-child td {
        border-bottom: none;
    }

    .payslip-lines .deduction td {
        color: var(--dash-danger);
    }

    .payslip-divider {
        height: 1px;
        background: var(--dash-border);
        margin: .5rem 0 1.25rem;
    }

    .payslip-net {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--dash-active-bg);
        border: 1px solid var(--dash-border);
        border-radius: var(--dash-radius);
        padding: 1rem 1.25rem;
        margin-top: 1rem;
    }

    .payslip-net__label {
        font-size: .875rem;
        font-weight: 600;
        color: var(--dash-text);
    }

    .payslip-net__amount {
        font-size: 1.375rem;
        font-weight: 800;
        color: var(--dash-accent);
        font-variant-numeric: tabular-nums;
        letter-spacing: -.02em;
    }

    .payslip-footer {
        padding: 1rem 2.5rem 1.5rem;
        border-top: 1px solid var(--dash-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .payslip-footer__meta {
        font-size: .75rem;
        color: var(--dash-muted);
    }

    @media print {
        .dash-header, .dash-main > .payslip-actions { display: none !important; }
        body { background: #fff !important; }
        .payslip-wrap { border: none; box-shadow: none; margin: 0; }
        .payslip-net { background: #f5f5f5 !important; }
    }
</style>
@endpush

@section('content')

@php
    $months = ['January','February','March','April','May','June',
               'July','August','September','October','November','December'];
    $emp = $record->employee;
@endphp

<main class="dash-page">

    <div class="dash-welcome" style="margin-bottom:1.25rem">
        <div>
            <p class="dash-welcome__greeting">Payroll</p>
            <h1 class="dash-welcome__title">Payslip</h1>
        </div>
        <div style="display:flex;gap:.75rem;align-items:center">
            <a href="{{ route('payroll-history') }}" class="btn btn-ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Back
            </a>
            <button onclick="window.print()" class="cmsp-btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Print / Save PDF
            </button>
        </div>
    </div>

    <div class="payslip-wrap">

        <div class="payslip-header">
            <p class="payslip-header__company">Payslip</p>
            <h2 class="payslip-header__title">{{ $months[$record->month - 1] }} {{ $record->year }}</h2>
            <p class="payslip-header__period">Generated {{ $record->created_at?->format('d M Y, H:i') }}</p>
        </div>

        <div class="payslip-emp">
            <div class="payslip-emp__row">
                <span class="payslip-emp__label">Employee</span>
                <span class="payslip-emp__value">{{ $emp?->name ?? '—' }}</span>
            </div>
            <div class="payslip-emp__row">
                <span class="payslip-emp__label">Department</span>
                <span class="payslip-emp__value">{{ $emp?->department?->name ?? '—' }}</span>
            </div>
            <div class="payslip-emp__row">
                <span class="payslip-emp__label">Position</span>
                <span class="payslip-emp__value">{{ $emp?->position ?? '—' }}</span>
            </div>
            <div class="payslip-emp__row">
                <span class="payslip-emp__label">Employee ID</span>
                <span class="payslip-emp__value">#{{ str_pad($record->employee_id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <div class="payslip-body">

            <p class="payslip-section-title">Earnings</p>
            <table class="payslip-lines">
                <tr>
                    <td>Overtime Pay</td>
                    <td>RM {{ number_format($record->overtime_pay, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Gross Pay</strong></td>
                    <td><strong>RM {{ number_format($record->gross_pay, 2) }}</strong></td>
                </tr>
            </table>

            <p class="payslip-section-title">Deductions</p>
            <table class="payslip-lines">
                <tr class="deduction">
                    <td>Income Tax (8%)</td>
                    <td>- RM {{ number_format($record->tax, 2) }}</td>
                </tr>
                <tr class="deduction">
                    <td>EPF (Employee 11%)</td>
                    <td>- RM {{ number_format($record->epf_employee, 2) }}</td>
                </tr>
                <tr>
                    <td style="color:var(--dash-muted);font-size:.8125rem">EPF (Employer 13%) <em>— not deducted</em></td>
                    <td style="color:var(--dash-muted);font-size:.8125rem">RM {{ number_format($record->epf_employer, 2) }}</td>
                </tr>
            </table>

            <div class="payslip-net">
                <span class="payslip-net__label">Net Pay (Take-Home)</span>
                <span class="payslip-net__amount">RM {{ number_format($record->net_pay, 2) }}</span>
            </div>

        </div>

        <div class="payslip-footer">
            <span class="payslip-footer__meta">Record #{{ $record->id }}</span>
            <span class="payslip-footer__meta">This is a system-generated payslip.</span>
        </div>

    </div>

</main>

@endsection
