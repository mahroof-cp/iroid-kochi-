<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request, $company_id)
    {
        $company = Company::findOrFail($company_id);
    
        $employees = $company->employees; 
    
        if ($employees->isEmpty()) {
            return response()->json(['message' => 'No employees found for this company.',], 404); 
        }

        return response()->json($employees, 200);
    }
    
}
