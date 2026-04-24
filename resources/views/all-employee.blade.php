@extends('layouts.app')

@section('title', 'Employees')

@push('styles')
@endpush

@section('content')

<main class="dash-page">

    <div class="dash-welcome">
        <div>
            <p class="dash-welcome__greeting">Organization</p>
            <h1 class="dash-welcome__title">Employees</h1>
        </div>

        <div style="display:flex;gap:1rem;align-items:center">
            <div style="min-width:200px">
                <select id="departmentFilter" class="form-input" onchange="handleDepartmentFilter()">
                    <option value="">All Departments</option>
                </select>
            </div>
            
            <button onclick="openModal()" class="cmsp-btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add New Employee
        </button>
            <select id="perPage" class="form-input" style="min-width:55px" onchange="currentPage=1;renderPage()">
                <option value="10" selected>10 / page</option>
                <option value="50">50 / page</option>
                <option value="100">100 / page</option>
                <option value="0">Show All</option>
            </select>
        </div>
    </div>

    <div class="dash-section" style="animation-delay:.15s">
        <div class="dash-table-wrap">
            <table class="dash-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Basic Salary</th>
                        <th>Allowance</th>
                        <th>OT/Hrs</th>
                        <th>Hourly Rate</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="empTableBody">
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <p>Loading...</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
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

    {{-- Create Modal --}}
    <div class="modal-overlay" id="createModal" onclick="handleOverlayClick(event)">
        <div class="modal" style="max-width:560px">
            <div class="modal-header">
                <h2 class="modal-title">New Employee</h2>
                <button class="modal-close" onclick="closeModal()" aria-label="Close">&times;</button>
            </div>
            <form id="createEmpForm" onsubmit="submitCreate(event)">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem">
                    <div class="form-group">
                        <label class="form-label" for="empName">Full Name</label>
                        <input class="form-input" type="text" id="empName" autocomplete="off">
                        <p class="form-error" id="empNameError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="empPosition">Position</label>
                        <input class="form-input" type="text" id="empPosition" autocomplete="off">
                        <p class="form-error" id="empPositionError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="empDept">Department</label>
                        <select class="form-input" id="empDept">
                            <option value="">— None —</option>
                        </select>
                        <p class="form-error" id="empDeptError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="empBasicSalary">Basic Salary</label>
                        <input class="form-input" type="number" id="empBasicSalary" min="0" step="0.01" autocomplete="off">
                        <p class="form-error" id="empBasicSalaryError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="empAllowance">Allowance</label>
                        <input class="form-input" type="number" id="empAllowance" min="0" step="0.01" value="0" autocomplete="off">
                        <p class="form-error" id="empAllowanceError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="empOtHours">Overtime Hours</label>
                        <input class="form-input" type="number" id="empOtHours" min="0" value="0" autocomplete="off">
                        <p class="form-error" id="empOtHoursError"></p>
                    </div>
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label" for="empHourlyRate">Hourly Rate</label>
                        <input class="form-input" type="number" id="empHourlyRate" min="0" step="0.01" value="0" autocomplete="off">
                        <p class="form-error" id="empHourlyRateError"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="createSubmitBtn">
                        <span class="spinner" id="createSpinner"></span>
                        <span id="createLabel">Create</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal-overlay" id="editModal" onclick="handleOverlayClick(event, 'edit')">
        <div class="modal" style="max-width:560px">
            <div class="modal-header">
                <h2 class="modal-title">Edit Employee</h2>
                <button class="modal-close" onclick="closeEditModal()" aria-label="Close">&times;</button>
            </div>
            <form id="editEmpForm" onsubmit="submitEdit(event)">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem">
                    <div class="form-group">
                        <label class="form-label" for="editEmpName">Full Name</label>
                        <input class="form-input" type="text" id="editEmpName" autocomplete="off">
                        <p class="form-error" id="editEmpNameError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editEmpPosition">Position</label>
                        <input class="form-input" type="text" id="editEmpPosition" autocomplete="off">
                        <p class="form-error" id="editEmpPositionError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editEmpDept">Department</label>
                        <select class="form-input" id="editEmpDept">
                            <option value="">— None —</option>
                        </select>
                        <p class="form-error" id="editEmpDeptError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editEmpBasicSalary">Basic Salary</label>
                        <input class="form-input" type="number" id="editEmpBasicSalary" min="0" step="0.01" autocomplete="off">
                        <p class="form-error" id="editEmpBasicSalaryError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editEmpAllowance">Allowance</label>
                        <input class="form-input" type="number" id="editEmpAllowance" min="0" step="0.01" autocomplete="off">
                        <p class="form-error" id="editEmpAllowanceError"></p>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="editEmpOtHours">Overtime Hours</label>
                        <input class="form-input" type="number" id="editEmpOtHours" min="0" autocomplete="off">
                        <p class="form-error" id="editEmpOtHoursError"></p>
                    </div>
                    <div class="form-group" style="grid-column:1/-1">
                        <label class="form-label" for="editEmpHourlyRate">Hourly Rate</label>
                        <input class="form-input" type="number" id="editEmpHourlyRate" min="0" step="0.01" autocomplete="off">
                        <p class="form-error" id="editEmpHourlyRateError"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                        <span class="spinner" id="editSpinner"></span>
                        <span id="editLabel">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="toast" id="toast"></div>

</main>

@endsection

@push('scripts')
<script src="{{ asset('js/employees.js') }}"></script>

@endpush
