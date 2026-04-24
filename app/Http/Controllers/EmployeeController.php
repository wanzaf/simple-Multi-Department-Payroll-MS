<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('all-employee');
    }

    public function apiIndex(Request $request)
    {
        $query = Employee::with('department')
            ->orderBy('created_at', 'desc');

        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        $employees = $query->get()
            ->map(fn($e) => [
                'id'             => $e->id,
                'name'           => $e->name,
                'position'       => $e->position,
                'basic_salary'   => $e->basic_salary,
                'allowance'      => $e->allowance,
                'overtime_hours' => $e->overtime_hours,
                'hourly_rate'    => $e->hourly_rate,
                'department_id'  => $e->department_id,
                'department'     => $e->department?->name,
                'created_at'     => $e->created_at,
            ]);

        return response()->json($employees);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'position'       => 'required|string|max:255',
            'department_id'  => 'nullable|exists:departments,id',
            'basic_salary'   => 'required|numeric|min:0',
            'allowance'      => 'nullable|numeric|min:0',
            'overtime_hours' => 'nullable|integer|min:0',
            'hourly_rate'    => 'nullable|numeric|min:0',
        ]);

        $employee = Employee::create([
            'name'           => $data['name'],
            'position'       => $data['position'],
            'department_id'  => $data['department_id'] ?? null,
            'basic_salary'   => $data['basic_salary'],
            'allowance'      => $data['allowance'] ?? 0,
            'overtime_hours' => $data['overtime_hours'] ?? 0,
            'hourly_rate'    => $data['hourly_rate'] ?? 0,
        ]);

        $employee->load('department');

        return response()->json([
            'id'             => $employee->id,
            'name'           => $employee->name,
            'position'       => $employee->position,
            'basic_salary'   => $employee->basic_salary,
            'allowance'      => $employee->allowance,
            'overtime_hours' => $employee->overtime_hours,
            'hourly_rate'    => $employee->hourly_rate,
            'department_id'  => $employee->department_id,
            'department'     => $employee->department?->name,
            'created_at'     => $employee->created_at,
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'position'       => 'required|string|max:255',
            'department_id'  => 'nullable|exists:departments,id',
            'basic_salary'   => 'required|numeric|min:0',
            'allowance'      => 'nullable|numeric|min:0',
            'overtime_hours' => 'nullable|integer|min:0',
            'hourly_rate'    => 'nullable|numeric|min:0',
        ]);

        $employee->update([
            'name'           => $data['name'],
            'position'       => $data['position'],
            'department_id'  => $data['department_id'] ?? null,
            'basic_salary'   => $data['basic_salary'],
            'allowance'      => $data['allowance'] ?? 0,
            'overtime_hours' => $data['overtime_hours'] ?? 0,
            'hourly_rate'    => $data['hourly_rate'] ?? 0,
        ]);

        $employee->load('department');

        return response()->json([
            'id'             => $employee->id,
            'name'           => $employee->name,
            'position'       => $employee->position,
            'basic_salary'   => $employee->basic_salary,
            'allowance'      => $employee->allowance,
            'overtime_hours' => $employee->overtime_hours,
            'hourly_rate'    => $employee->hourly_rate,
            'department_id'  => $employee->department_id,
            'department'     => $employee->department?->name,
            'created_at'     => $employee->created_at,
        ]);
    }

    public function apiDestroy($id)
    {
        $employee = Employee::findOrFail($id);

        try {
            $employee->delete();
            return response()->json(['message' => 'Employee deleted.']);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return response()->json([
                    'message' => 'This employee still has payroll records.'
                ], 409);
            }
            throw $e;
        }
    }
}
