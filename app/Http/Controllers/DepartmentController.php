<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('all-dept');
    }

    public function apiIndex()
    {
        return response()->json(Department::withCount('employees')->orderBy('created_at', 'desc')->get());
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
        ]);

        $dept = Department::create(['name' => $request->name]);

        return response()->json($dept, 201);
    }

    public function apiDestroy($id)
    {
        $dept = Department::findOrFail($id);

        try {
            $dept->delete();
            return response()->json(['message' => 'Department deleted.']);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return response()->json([
                    'message' => 'This department still has employees assigned to it.'
                ], 409);
            }
            throw $e;
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name,' . $id,
        ]);

        $dept = Department::findOrFail($id);
        $dept->update(['name' => $request->name]);

        return response()->json($dept);
    }
}
