<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    public function getData(Request $request)
    {
        $query = User::query();

        // Role filtering
        if ($request->has('roles')) {
            $query->where('roles', $request->input('roles'));
        }

        // Course filtering
        if ($request->has('course')) {
            $query->where('course', $request->input('course'));
        }

        $data = $query->get();

        return response()->json($data);
    }
}
