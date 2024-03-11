<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Coach;
use App\Models\Student;

class AppController extends Controller
{
    public function student(User $user) {

        $students = $user->load('students');

        return response()->json($students);
    }

    public function coach(User $user) {

        $coaches = $user->load('coaches');

        return response()->json($coaches);
    }

    // Create a new user
    public function create(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'course' => 'required|string',
            'branch' => 'required|string',
            'userType' => 'required|in:student,coach',
            // Add other validation rules as needed
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->input('name'),
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),  
            'password' => $request->input('password'),
            'course' => $request->input('course'),
            'branch' => $request->input('branch'),
            'userType' => $request->input('userType'),
            // Add other fields as needed
        ]);

        // If UserType is 'student', create a Student record
        if ($request->input('userType') === 'student') {
            Student::create([
                'user_id' => $user->id,
                'firstname' => $user->firstname,
                'middlename' => $user->middlename,
                'lastname' => $user->lastname,
                'branch' => $user->branch,
                'course' => $user->course
                // Add other fields for Student model as needed
            ]);

            $checkStudent = $user->load('students');

            return response()->json($checkStudent);
        }

        // If UserType is 'coach', create a Coach record
        if ($request->input('userType') === 'coach') {
            Coach::create([
                'user_id' => $user->id,
                'firstname' => $user->firstname,
                'middlename' => $user->middlename,
                'lastname' => $user->lastname,
                'branch' => $user->branch,
                'course' => $user->course
                // Add other fields for Coach model as needed
            ]);

            $checkCoach = $user->load('coaches');

            return response()->json($checkCoach);
        }
    }

    // Read a user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => 'string',
            'firstname' => 'string',
            'middlename' => 'string',
            'lastname' => 'string',
            'email' => 'string',
            'password' => 'string',
            'course' => 'string',
            'branch' => 'string',
            'userType' => 'in:student,coach',
            // Add other validation rules as needed
        ]);

        // Update user details
        $user->update($request->all());

        // Update related Student or Coach record if UserType is changed
        if ($request->has('userType')) {
            if ($request->input('userType') === 'student') {
                $user->students()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['firstname' => $user->firstname],
                    ['middlename' => $user->middlename],
                    ['lastname' => $user->lastname],
                    ['course' => $user->course],
                    ['branch' => $user->branch],
                    // Add other fields for Student model as needed
                );

                $checkStudent = $user->load('students');

                return response()->json($checkStudent);

            } elseif ($request->input('userType') === 'coach') {
                $user->coaches()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['firstname' => $user->firstname],
                    ['middlename' => $user->middlename],
                    ['lastname' => $user->lastname],
                    ['course' => $user->course],
                    ['branch' => $user->branch],
                    // Add other fields for Coach model as needed
                );

                $checkCoach = $user->load('coaches');

                return response()->json($checkCoach);
            }
        }
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Also delete related Student or Coach record if exists
        $user->students()->delete();
        $user->coaches()->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
