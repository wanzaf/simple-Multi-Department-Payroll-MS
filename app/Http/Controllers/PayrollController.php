<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PayrollController extends Controller
{
    public function index()
    {
        return view('payroll-main');
    }

    public function payroll_history(){
        return view('payroll-hist');
    }

    public function payslip($id)
    {
        $record = Payroll::with('employee.department')->findOrFail($id);
        return view('payslip', ['record' => $record]);
    }

    //API
    public function apiHistory(Request $request)
    {
        $query = Payroll::with('employee.department')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('employee_id');

        if ($request->filled('month')) {
            $query->where('month', $request->integer('month'));
        }

        if ($request->filled('year')) {
            $query->where('year', $request->integer('year'));
        }

        $records = $query->get()->map(fn($p) => [
            'id'           => $p->id,
            'employee_id'  => $p->employee_id,
            'employee'     => $p->employee?->name,
            'department'   => $p->employee?->department?->name,
            'position'     => $p->employee?->position,
            'month'        => $p->month,
            'year'         => $p->year,
            'overtime_pay' => $p->overtime_pay,
            'gross_pay'    => $p->gross_pay,
            'tax'          => $p->tax,
            'epf_employee' => $p->epf_employee,
            'epf_employer' => $p->epf_employer,
            'net_pay'      => $p->net_pay,
            'created_at'   => $p->created_at,
        ]);

        return response()->json($records);
    }
    public function apiBulkStore(Request $request)
    {
        $data = $request->validate([
            'month'                  => 'required|integer|between:1,12',
            'year'                   => 'required|integer|min:2000|max:2100',
            'records'                => 'required|array|min:1',
            'records.*.employee_id'  => 'required|exists:employees,id',
            'records.*.overtime_pay' => 'required|numeric|min:0',
            'records.*.gross_pay'    => 'required|numeric|min:0',
            'records.*.tax'          => 'required|numeric|min:0',
            'records.*.epf_employee' => 'required|numeric|min:0',
            'records.*.epf_employer' => 'required|numeric|min:0',
            'records.*.net_pay'      => 'required|numeric|min:0',
        ]);

        foreach ($data['records'] as $rec) {
            Payroll::updateOrCreate(
                [
                    'employee_id' => $rec['employee_id'],
                    'month'       => $data['month'],
                    'year'        => $data['year'],
                ],
                [
                    'overtime_pay' => $rec['overtime_pay'],
                    'gross_pay'    => $rec['gross_pay'],
                    'tax'          => $rec['tax'],
                    'epf_employee' => $rec['epf_employee'],
                    'epf_employer' => $rec['epf_employer'],
                    'net_pay'      => $rec['net_pay'],
                ]
            );
        }

        return response()->json(['message' => 'Payroll saved successfully.']);
    }
}
