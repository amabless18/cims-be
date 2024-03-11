<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\branch;

class branchController extends Controller
{   
    public function index(){
        return response()->json(branch::all(), 200);
    }


    
    public function create(Request $request)
    {
        $branch = new Branch();
        $branch->name = $request->input('name');
        $branch->save();

        return response()->json(['message' => 'Branch created successfully', 'data' => $branch], 201);
    }

    public function read($id)
    {
        $branch = branch::find($id);
        if (is_null($branch)) {
            return response()->json(['message' => 'Branch not found'], 404);
        }
        return response()->json(Branch::find($id), 200);
    }


    public function update(Request $request, $id)
    {
        $branch = branch::find($id);
        if (is_null($branch)) {
            return response()->json(['message' => 'Branch not found'], 404);
        }
        $branch->update($request->all());
        return response($branch, 200);
    }


    public function delete($id)
    {
        $branch = branch::find($id);
        if (is_null($branch)) {
            return response()->json(['message' => 'Branch not found'], 404);
        }
        $branch->delete();
        return response()->json(null, 204);
    }

}
