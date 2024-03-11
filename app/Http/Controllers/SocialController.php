<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\social;

class SocialController extends Controller
{
    public function getSocial()
    {
        return response()->json(social::all(), 200);
    }

    public function getSocialId($id)
    {
        $social = social::find($id);
        if (is_null($social)) {
            return response()->json(['message' => 'Social Content not found'], 404);
        }
        return response()->json(social::find($id), 200);
    }

    public function addSocial(Request $request)
    {
        $social = social::create($request->all());
        return response($social, 201);
    }

    public function updateSocial(Request $request, $id)
    {
        $social = social::find($id);
        if (is_null($social)) {
            return response()->json(['message' => 'Social Content not found'], 404);
        }
        $social->update($request->all());
        return response($social, 200);
    }


    public function deleteSocial(Request $request, $id)
    {
        $social = social::find($id);
        if (is_null($social)) {
            return response()->json(['message' => 'Social Content not found'], 404);
        }
        $social->delete();
        return response()->json(null, 204);
    }
}
