<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index(Request $request): JsonResponse
    {
        $departments = Department::where('is_active', true)
            ->with(['company', 'manager'])
            ->when($request->company_id, function ($query, $companyId) {
                return $query->where('company_id', $companyId);
            })
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $departments
        ]);
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments',
            'description' => 'nullable|string',
            'parent_department_id' => 'nullable|exists:departments,id',
            'manager_id' => 'nullable|exists:employees,id',
            'type' => 'required|in:operational,support,administrative,executive',
            'employee_count' => 'required|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'company_id' => 'required|exists:companies,id',
        ]);

        $department = Department::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'data' => $department
        ], 201);
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department): JsonResponse
    {
        $department->load(['company', 'manager', 'employees']);
        
        return response()->json([
            'success' => true,
            'data' => $department
        ]);
    }

    /**
     * Update the specified department.
     */
    public function update(Request $request, Department $department): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'parent_department_id' => 'nullable|exists:departments,id',
            'manager_id' => 'nullable|exists:employees,id',
            'type' => 'sometimes|required|in:operational,support,administrative,executive',
            'employee_count' => 'sometimes|required|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $department->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully',
            'data' => $department
        ]);
    }

    /**
     * Remove the specified department.
     */
    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully'
        ]);
    }

    /**
     * Get department employees.
     */
    public function employees(Department $department): JsonResponse
    {
        $employees = $department->employees()->with(['roles'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
}
