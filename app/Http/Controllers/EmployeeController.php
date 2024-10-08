<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
          /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::with(['company', 'creator', 'updater'])->get();

            return Datatables::of($data)
                ->editColumn('image', function($row){
                    $src = asset('storage/image/' . $row->image);
                    return "<a href='{$src}' target='_blank'><img src='{$src}' width='50' height='50' alt='Image' class='image-img'></a>";
                })
                ->addColumn('company', function ($row) {
                    return $row->company_id ? $row->company->name : 'N/A'; 
                })
                ->addColumn('created_by', function ($row) {
                    return $row->creator ? $row->creator->name : 'N/A'; 
                })
                ->addColumn('updated_by', function ($row) {
                    return $row->updater ? $row->updater->name : 'N/A'; 
                })
                ->editColumn('created_at', function ($row) {
                    return  Carbon::parse($row->created_at)->format('Y-m-d h:i A') . ' (From Admin Login From India)';
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d h:i A') . ' (From Admin Login From India)';
                })
                ->addColumn('action', function($row){
                    $btn1 = '<a href="' . route('employee.createUpdate', $row->id) . '" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editEmployee">Edit</a>';
                    $btn2 = ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="deleteEmployee btn btn-danger btn-sm">Delete</a>';
                    return $btn1 . $btn2;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('Employee.index');
    }

    public function createUpdate($id = 0)
    {
        $employee = Employee::find($id);
        $companies = Company::get();
        if (!$employee) {
            $employee =  new Employee();
        }
        return view('Employee.createUpdate', compact('employee', 'companies'));
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth()->id();
        $data['updated_by'] = Auth()->id();

        if ($request->hasFile('image')) {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $request->file('image')->storeAs('public/image', $fileNameToStore);
            $data['image'] = $fileNameToStore;
        }

        Employee::updateOrCreate(['id' => $data['id']], $data);
        return redirect()->route('employee.list');
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 400);  
        }
    
        $employee->delete();
        return response()->json(['success' => 'Employee deleted successfully!'], 200);
    }
    
}
