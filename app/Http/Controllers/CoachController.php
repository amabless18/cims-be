<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Student;


class CoachController extends Controller
{
    public function index()
    {
        return response()->json(Coach::all(), 200);
    }

    public function getStudentsForLoggedInCoach()
    {
        // Get the currently logged-in coach
        // Get the current authenticated user's ID
        $userId = auth()->id();

        // Query the Coach model to find the coach with the current user's ID
        $coach = Coach::where('user_id', $userId)->first();

        if ($coach) {
            // If the coach is found, fetch the associated students
            $students = $coach->students;

            return response()->json($students);
        } else {
            return response()->json(['error' => 'No associated students found for the logged-in coach'], 404);
        }
    }

    public function assignStudent(Request $request, $coachId, $studentId)
    {
        $coach = Coach::findOrFail($coachId);
        $student = Student::findOrFail($studentId);

        $coach->students()->attach($student);

        $student->coaches()->syncWithoutDetaching([$coach->id]);

        $coaches = $coach->load('students');

        return response()->json($coaches);
    }

    public function coachwithStudents(Coach $coach, $coachId)
    {
        $coach = Coach::findOrFail($coachId);

        $coaches = $coach->load('students');

        return response()->json($coaches);
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
        $coach = Coach::find($id);
        if (is_null($coach)) {
            return response()->json(['message' => 'Coach not found'], 404);
        }
        return response()->json(Coach::find($id), 200);
    }


    public function update(Request $request, $id)
    {
        $coach = coach::find($id);
        if (is_null($coach)) {
            return response()->json(['message' => 'Coach not found'], 404);
        }
        $coach->update($request->all());
        return response($coach, 200);
    }


    public function delete($id)
    {
        $coach = coach::find($id);
        if (is_null($coach)) {
            return response()->json(['message' => 'Coach not found'], 404);
        }
        $coach->delete();
        return response()->json(null, 204);
    }

}
