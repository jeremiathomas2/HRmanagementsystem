<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index(Request $request): JsonResponse
    {
        $companies = Company::where('is_active', true)
            ->with(['departments', 'employees'])
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $companies
        ]);
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:companies',
            'tax_identification_number' => 'required|string',
            'sector' => 'required|string',
            'risk_level' => 'required|in:low,medium,high',
            'address' => 'required|string',
            'city' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:companies',
            'website' => 'nullable|url',
            'union_status' => 'required|in:unionized,non_unionized',
            'employee_count' => 'required|integer|min:0',
            'registration_date' => 'required|date',
        ]);

        $company = Company::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company): JsonResponse
    {
        $company->load(['departments', 'employees']);
        
        return response()->json([
            'success' => true,
            'data' => $company
        ]);
    }

    /**
     * Update the specified company.
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'registration_number' => 'sometimes|required|string|unique:companies,registration_number,' . $company->id,
            'tax_identification_number' => 'sometimes|required|string',
            'sector' => 'sometimes|required|string',
            'risk_level' => 'sometimes|required|in:low,medium,high',
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'region' => 'sometimes|required|string',
            'postal_code' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:companies,email,' . $company->id,
            'website' => 'nullable|url',
            'union_status' => 'sometimes|required|in:unionized,non_unionized',
            'employee_count' => 'sometimes|required|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully',
            'data' => $company
        ]);
    }

    /**
     * Remove the specified company.
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Company deleted successfully'
        ]);
    }

    /**
     * Get company analytics.
     */
    public function analytics(Company $company): JsonResponse
    {
        $analytics = [
            'total_employees' => $company->employees()->count(),
            'active_employees' => $company->employees()->where('is_active', true)->count(),
            'total_departments' => $company->departments()->count(),
            'employee_by_category' => $company->employees()
                ->selectRaw('employment_category, COUNT(*) as count')
                ->groupBy('employment_category')
                ->get(),
            'compliance_status' => [
                'compliant' => $company->employees()->where('compliance_status', 'compliant')->count(),
                'non_compliant' => $company->employees()->where('compliance_status', 'non_compliant')->count(),
                'pending_review' => $company->employees()->where('compliance_status', 'pending_review')->count(),
            ],
            'disciplinary_cases' => $company->disciplines()->count(),
            'compliance_issues' => $company->compliances()->where('status', '!=', 'resolved')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }
}
