<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\Student;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::query()->get();

            return Datatables::of($data)
                ->editColumn('avatar', function($row){
                    $src = asset('storage/images/' . $row->avatar);
                    return "<a href='{$src}' target='_blank'><img src='{$src}' width='50' height='50' alt='Avatar' class='avatar-img'></a>";
                })
                ->addColumn('action', function($row){
                    $btn1 = '<a href="' . route('students.createUpdate', $row->id) . '" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editStudent">Edit</a>';
                    $btn2 = '<a href="' . route('students.delete', $row->id) . '" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteStudent">Delete</a>';
                    return $btn1 . $btn2;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'avatar'])
                ->make(true);
        }

        return view('students.index');
    }

    public function createUpdate($id = 0)
    {
        $student = Student::find($id);
        if (!$student) {
            $student =  new Student();
        }
        return view('students.createUpdate', compact('student'));
    }

    public function store(StudentRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $fileNameWithExt = $request->file('avatar')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $request->file('avatar')->storeAs('public/images', $fileNameToStore);
            $data['avatar'] = $fileNameToStore;
        }

        Student::updateOrCreate(['id' => $data['id']], $data);
        return redirect()->route('students.list');
    }


    public function destroy($id)
    {
        Student::find($id)->delete();
        return redirect()->route('students.list');
    }
}
