<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRequest;
use Illuminate\Http\Request;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
      /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::with(['creator', 'updater'])->get();

            return Datatables::of($data)
                ->editColumn('logo', function($row){
                    $src = asset('storage/logo/' . $row->logo);
                    return "<a href='{$src}' target='_blank'><img src='{$src}' width='50' height='50' alt='Logo' class='logo-img'></a>";
                })
                ->addColumn('created_by', function ($row) {
                    return $row->creator ? $row->creator->name : 'N/A'; 
                })
                ->addColumn('updated_by', function ($row) {
                    return $row->updater ? $row->updater->name : 'N/A'; 
                })
                ->editColumn('created_at', function ($row) {
                    return 'Created At ' . Carbon::parse($row->created_at)->format('Y-m-d h:i A') . ' (From Admin Login From India)';
                })
                ->editColumn('updated_at', function ($row) {
                    return 'Updated At ' . Carbon::parse($row->updated_at)->format('Y-m-d h:i A') . ' (From Admin Login From India)';
                })
                ->addColumn('action', function($row){
                    $btn1 = '<a href="' . route('company.createUpdate', $row->id) . '" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCompany">Edit</a>';
                    $btn2 = ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="deleteCompany btn btn-danger btn-sm">Delete</a>';
                    return $btn1 . $btn2;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'logo'])
                ->make(true);
        }

        return view('Company.index');
    }

    public function createUpdate($id = 0)
    {
        $company = Company::find($id);
        if (!$company) {
            $company =  new Company();
        }
        return view('company.createUpdate', compact('company'));
    }

    public function store(CompanyRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth()->id();
        $data['updated_by'] = Auth()->id();

        if ($request->hasFile('logo')) {
            $fileNameWithExt = $request->file('logo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $request->file('logo')->storeAs('public/logo', $fileNameToStore);
            $data['logo'] = $fileNameToStore;
        }

        Company::updateOrCreate(['id' => $data['id']], $data);
        return redirect()->route('company.list');
    }

    public function destroy($id)
    {
        $company = Company::with('employees')->findOrFail($id);
        
        if ($company->employees()->count() > 0) {
            return response()->json(['error' => 'Cannot delete company with associated employees.'], 400);  
        }

        $company->delete();
        return response()->json(['success' => 'Company deleted successfully!'], 200);  
    }
    
}
