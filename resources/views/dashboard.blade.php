@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<main class="dash-page">

    <div class="dash-welcome">
        <div>
            <p class="dash-welcome__greeting">Welcome back, {{ auth()->user()->name }}</p>
            <h1 class="dash-welcome__title">Dashboard</h1>
        </div>
        <p class="dash-welcome__meta" style="align-self:flex-end">
            {{ now()->format('l, d F Y') }}
        </p>
    </div>

    {{-- Stat Cards --}}
    <div class="dash-stats">

        <div class="dash-stat" style="--i:0">
            <div class="dash-stat__top">
                <span class="dash-stat__label">Total Employees</span>
                <div class="dash-stat__icon">
                    <svg viewBox="0 0 24 24"><path d="M9 7a4 4 0 1 1 8 0a4 4 0 0 1 -8 0"/><path d="M3 21v-2a6 6 0 0 1 6 -6h6a6 6 0 0 1 6 6v2"/></svg>
                </div>
            </div>
            <p class="dash-stat__value">{{ $totalEmployees }}</p>
            <p class="dash-stat__sub">Across <strong>{{ $totalDepts }}</strong> department{{ $totalDepts !== 1 ? 's' : '' }}</p>
        </div>

        <div class="dash-stat" style="--i:1">
            <div class="dash-stat__top">
                <span class="dash-stat__label">Departments</span>
                <div class="dash-stat__icon">
                    <svg viewBox="0 0 24 24"><path d="M3 9l0 .01"/><path d="M6 20h12a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2"/><path d="M3 9h18"/><path d="M9 9v11"/><path d="M15 9v11"/></svg>
                </div>
            </div>
            <p class="dash-stat__value">{{ $totalDepts }}</p>
            <p class="dash-stat__sub">Active organisational units</p>
        </div>

        <div class="dash-stat" style="--i:2">
            <div class="dash-stat__top">
                <span class="dash-stat__label">Payroll Records</span>
                <div class="dash-stat__icon">
                    <svg viewBox="0 0 24 24"><circle cx="7" cy="7" r="2"/><circle cx="17" cy="17" r="2"/><path d="M6 18l12 -12"/></svg>
                </div>
            </div>
            <p class="dash-stat__value">{{ $totalPayrolls }}</p>
            <p class="dash-stat__sub">All-time processed runs</p>
        </div>

        <div class="dash-stat" style="--i:3">
            <div class="dash-stat__top">
                <span class="dash-stat__label">This Month Net Pay</span>
                <div class="dash-stat__icon">
                    <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                </div>
            </div>
            <p class="dash-stat__value" style="font-size:1.5rem">RM {{ number_format($monthNetPay, 2) }}</p>
            <p class="dash-stat__sub">Total net pay of <strong>{{ now()->format('M Y') }}</strong></p>
        </div>

    </div>

    {{-- Recent Employees --}}
    <div class="dash-section" style="animation-delay:.32s">
        <div class="dash-section__head">
            <h2 class="dash-section__title">Recent Employees</h2>
            <a href="{{ route('employees') }}" class="dash-section__link">
                View all
                <svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="dash-table-wrap">
            <table class="dash-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Basic Salary</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentEmployees as $i => $emp)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $emp->name }}</td>
                        <td>{{ $emp->department?->name ?? '—' }}</td>
                        <td>{{ $emp->position }}</td>
                        <td>RM {{ number_format($emp->basic_salary, 2) }}</td>
                        <td>{{ $emp->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state"><p>No employees yet.</p></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Payroll --}}
    <div class="dash-section" style="animation-delay:.42s">
        <div class="dash-section__head">
            <h2 class="dash-section__title">Recent Payroll Records</h2>
            <a href="{{ route('payroll-history') }}" class="dash-section__link">
                View all
                <svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="dash-table-wrap" style="overflow-x:auto">
            <table class="dash-table" style="width:100%;min-width:700px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Period</th>
                        <th>Gross Pay</th>
                        <th>Net Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPayrolls as $i => $pr)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $pr->employee?->name ?? '—' }}</td>
                        <td>{{ $pr->employee?->department?->name ?? '—' }}</td>
                        <td>{{ \DateTime::createFromFormat('!m', $pr->month)->format('M') }} {{ $pr->year }}</td>
                        <td>RM {{ number_format($pr->gross_pay, 2) }}</td>
                        <td><strong style="color:var(--dash-accent)">RM {{ number_format($pr->net_pay, 2) }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state"><p>No payroll records yet.</p></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

@endsection

