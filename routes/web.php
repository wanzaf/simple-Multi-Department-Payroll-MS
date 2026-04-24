<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Guarded routes
Route::middleware('auth')->group(function () {
    
//hes special
Route::get('/dashboard', function () {
        $totalEmployees  = Employee::count();
        $totalDepts      = Department::count();
        $totalPayrolls   = Payroll::count();
        $totalNetPay     = Payroll::sum('net_pay');

        $currentMonth = now()->month;
        $currentYear  = now()->year;
        $monthNetPay  = Payroll::where('month', $currentMonth)->where('year', $currentYear)->sum('net_pay');

        $recentEmployees = Employee::with('department')->latest()->take(5)->get();
        $recentPayrolls  = Payroll::with('employee.department')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalEmployees', 'totalDepts', 'totalPayrolls', 'totalNetPay',
            'monthNetPay', 'recentEmployees', 'recentPayrolls'
        ));
    })->name('dashboard');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll');
    Route::get('/payroll-history', [PayrollController::class, 'payroll_history'])->name('payroll-history');
    Route::get('/payslip/{id}', [PayrollController::class, 'payslip'])->name('payslip');

    // Departments API
    Route::prefix('api')->group(function () {
        Route::get('/departments', [DepartmentController::class, 'apiIndex']);
        Route::post('/departments', [DepartmentController::class, 'apiStore']);
        Route::delete('/departments/{id}', [DepartmentController::class, 'apiDestroy']);
        Route::put('/departments/{id}', [DepartmentController::class, 'apiUpdate']);

        Route::get('/employees', [EmployeeController::class, 'apiIndex']);
        Route::post('/employees', [EmployeeController::class, 'apiStore']);
        Route::put('/employees/{id}', [EmployeeController::class, 'apiUpdate']);
        Route::delete('/employees/{id}', [EmployeeController::class, 'apiDestroy']);

        Route::post('/payroll/bulk', [PayrollController::class, 'apiBulkStore']);
        Route::get('/payroll', [PayrollController::class, 'apiHistory']);
    });
});
