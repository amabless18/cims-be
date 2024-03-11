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
