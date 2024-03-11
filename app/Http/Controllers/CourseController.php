<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\course;

class courseController extends Controller
{   
    public function index(){
        return response()->json(course::all(), 200);
    }


    
    public function create(Request $request)
    {
        $course = new Course();
        $course->name = $request->input('name');
        $course->save();

        return response()->json(['message' => 'Course created successfully', 'data' => $course], 201);
    }

    public function read($id)
    {
        $course = course::find($id);
        if (is_null($course)) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        return response()->json(Course::find($id), 200);
    }


    public function update(Request $request, $id)
    {
        $course = course::find($id);
        if (is_null($course)) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        $course->update($request->all());
        return response($course, 200);
    }


    public function delete($id)
    {
        $course = course::find($id);
        if (is_null($course)) {
            return response()->json(['message' => 'Course not found'], 404);
        }
        $course->delete();
        return response()->json(null, 204);
    }

}
