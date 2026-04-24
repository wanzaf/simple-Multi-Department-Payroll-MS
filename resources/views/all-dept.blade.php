@extends('layouts.app')

@section('title', 'Departments')

@push('styles')
@endpush

@section('content')

<main class="dash-page">

    <div class="dash-welcome">
        <div>
            <p class="dash-welcome__greeting">Organization</p>
            <h1 class="dash-welcome__title">Departments</h1>
        </div>
        <div style="display:flex;gap:.75rem;align-items:center">
        <button onclick="openModal()" class="cmsp-btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add New Department
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
        <div class="dash-table-wrap" style="overflow:visible">
            <table id="projectsTable" class="dash-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>No. of Employees</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="deptTableBody">
                    <tr>
                        <td colspan="5">
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

    <div class="modal-overlay" id="createModal" onclick="handleOverlayClick(event)">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">New Department</h2>
                <button class="modal-close" onclick="closeModal()" aria-label="Close">&times;</button>
            </div>
            <form id="createDeptForm" onsubmit="submitCreate(event)">
                <div class="form-group">
                    <label class="form-label" for="deptName">Department Name</label>
                    <input class="form-input" type="text" id="deptName" autocomplete="off">
                    <p class="form-error" id="deptNameError"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="spinner" id="submitSpinner"></span>
                        <span id="submitLabel">Create</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editModal" onclick="handleOverlayClick(event, 'edit')">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Edit Department</h2>
                <button class="modal-close" onclick="closeEditModal()" aria-label="Close">&times;</button>
            </div>
            <form id="editDeptForm" onsubmit="submitEdit(event)">
                <div class="form-group">
                    <label class="form-label" for="editDeptName">Department Name</label>
                    <input class="form-input" type="text" id="editDeptName" autocomplete="off">
                    <p class="form-error" id="editDeptNameError"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                        <span class="spinner" id="editSubmitSpinner"></span>
                        <span id="editSubmitLabel">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="toast" id="toast"></div>

</main>

@endsection
@push('scripts')
<script src="{{ asset('js/departments.js') }}"></script>
@endpush

