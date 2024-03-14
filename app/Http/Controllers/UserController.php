<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser()
    {
        return response()->json(User::all(), 200);
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
}
