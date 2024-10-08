<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
    
        if ($companies->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No companies found'], 404);
        }
    
        return response()->json(['status' => true, 'message' => 'Companies fetched successfully', 'data' => $companies], 200);
    }
    
}
