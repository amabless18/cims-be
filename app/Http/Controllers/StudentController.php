<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{   
    public function index(){
        return response()->json(Student::all(), 200);
    }


    
    // public function create(Request $request)
    // {
    //     $branch = new Student();
    //     $branch->name = $request->input('name');
    //     $branch->save();

    //     return response()->json(['message' => 'Branch created successfully', 'data' => $branch], 201);
    // }

    public function read($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json(Student::find($id), 200);
    }


    public function update(Request $request, $id)
    {
        $student = student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $student->update($request->all());
        return response($student, 200);
    }


    public function delete($id)
    {
        $student = student::find($id);
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $student->delete();
        return response()->json(null, 204);
    }

}
