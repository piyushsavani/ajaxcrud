<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        return view('students.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'required|max:11',
            'course' => 'required|max:25',
        ]);

        if($validator->fails())
         {
            return response()->json([
                'status' => 404,
                'errors' => $validator->messages()
            ]);
        } else {
            $student = new Student;
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->course = $request->course;
            $student->save();

            return response()->json([
                'status' => 200,
                'message' => 'Student Added Successfully'
            ]);
        }       
       
    }

    public function fetch() 
    {
        $students = Student::all();
        return response()->json([
                'status' => 200,
                'students' => $students,
            ]);
        
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ]);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        return response()->json([
            'status' => 200,
            'student' => $student
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'required|max:11',
            'course' => 'required|max:25',
        ]);

        if($validator->fails())
         {
            return response()->json([
                'status' => 404,
                'errors' => $validator->messages()
            ]);
        } else {
            $student = Student::find($id);
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->course = $request->course;
            $student->update();

            return response()->json([
                'status' => 200,
                'message' => 'Student updated Successfully'
            ]);
        } 
    }

}

