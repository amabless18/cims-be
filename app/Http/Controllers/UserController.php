<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function getUser()
    {
        return response()->json(User::all(), 200);
    }


    public function updateEmail(Request $request) {
        // Validate the request data for email update
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Update Email
        $user->email = $request->email;
    
        // Save changes
        $user->save();
    
        return "Email updated successfully!";
    }
    
    public function updatePassword(Request $request) {
        // Validate the request data for password update
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Update Password
        $user->password = Hash::make($request->password);
    
        // Save changes
        $user->save();
    
        return "Password updated successfully!";
    }

    public function filter(Request $request)
    {
        $query = User::query();

        // Filter by roles
        if ($request->has('roles')) {
            $roles = $request->input('roles');
            $query->whereIn('role', $roles);
        }

        // Filter by course
        if ($request->has('course')) {
            $course = $request->input('course');
            $query->where('course', $course);
        }

        $users = $query->get();

        return response()->json($users);
    }

    public function getUserId($id)
    {
        $user = user::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(User::find($id), 200);
    }

    public function addUser(Request $request)
    {
        $user = user::create($request->all());
        return response($user, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update($request->all());

        // Update related Student or Coach record if UserType is changed
        if ($request->has('userType')) {
            if ($request->input('userType') === 'student') {
                $user->students()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'firstname' => $user->firstname,
                        'middlename' => $user->middlename,
                        'lastname' => $user->lastname,
                        'course' => $user->course,
                        'branch' => $user->branch,
                        'status' => $user->status,
                        // Add other fields for Student model as needed
                    ]
                    // Add other fields for Student model as needed
                );

                $checkStudent = $user->load('students');

                return response()->json($checkStudent);

            } elseif ($request->input('userType') === 'coach') {
                $user->coaches()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'firstname' => $user->firstname,
                        'middlename' => $user->middlename,
                        'lastname' => $user->lastname,
                        'course' => $user->course,
                        'branch' => $user->branch,
                        'status' => $user->status,
                        // Add other fields for Student model as needed
                    ]
                    // Add other fields for Coach model as needed
                );

                $checkCoach = $user->load('coaches');

                return response()->json($checkCoach);
            }
        }
        return response($user, 200);
    }


    public function deleteUser(Request $request, $id)
    {
        $user = user::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(null, 204);
    }

    // public function storeStudent(Request $request)
    // {
    //     $data = $request->validate([
    //         // Validation rules for your user data
    //     ]);

    //     // Create the user
    //     $user = User::create($data);

    //     // Check if the user is a student and coach_id is provided
    //     if ($user->userType === 'student' && $request->filled('coach_id')) {
    //         // Get the coach
    //         $coach = User::find($request->coach_id);

    //         // If coach exists, add the student to the coach's list of students
    //         if ($coach) {
    //             $coach->student()->save($user);
    //         }
    //     }

    //     $checkCoach = $user->load('student');

    //     return response()->json($checkCoach);
    // }

    // // Method to update an existing user
    // public function updateStudent(Request $request, User $user)
    // {
    //     $data = $request->validate([
    //         // Validation rules for your user data
    //     ]);

    //     $user->update($data);

    //     // Check if the user is a student and coach_id is provided
    //     if ($user->userType === 'student' && $request->filled('coach_id')) {
    //         // Get the coach
    //         $coach = User::find($request->coach_id);

    //         // If coach exists, add the student to the coach's list of students
    //         if ($coach) {
    //             $coach->student()->save($user);
    //         }
    //     }

    //     $checkCoach = $user->load('student');

    //     return response()->json($checkCoach);
    // }

    // public function showStudent(User $user)
    // {
    //     // Include coach information if necessary
    //     $userData = $user->toArray();

    //     if ($user->role === 'student' && $user->coach) {
    //         $userData['coach'] = $user->coach->toArray();
    //     }

    //     return response($userData, 200);
    // }

    // public function studentsUnderCoach(User $coach)
    // {
    //     // Retrieve the coach's students
    //     $students = $coach->students()->where('userType', 'student')->get();

    //     return response()->json(['students' => $students]);
    // }

    public function studentRelationship(User $user) {

        $students = $user->load('student');

        return response()->json($students);
    }


}
