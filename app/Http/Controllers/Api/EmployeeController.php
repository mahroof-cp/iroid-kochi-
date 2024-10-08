<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request, $company_id)
    {
        $company = Company::findOrFail($company_id);
        $employees = $company->employees;

        if ($employees->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No employees found for this company.'], 404);
        }
    
        return response()->json(['status' => true, 'message' => 'Employees fetched successfully', 'data' => $employees], 200);
    }
    
    
}
