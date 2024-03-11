<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\schedule;

class ScheduleController extends Controller
{
    public function getSchedule()
    {
        return response()->json(schedule::all(), 200);
    }

    public function getScheduleId($id)
    {
        $schedule = schedule::find($id);
        if (is_null($schedule)) {
            return response()->json(['message' => 'Schedule Content not found'], 404);
        }
        return response()->json(schedule::find($id), 200);
    }

    public function addSchedule(Request $request)
    {
        $schedule = schedule::create($request->all());
        return response($schedule, 201);
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = schedule::find($id);
        if (is_null($schedule)) {
            return response()->json(['message' => 'Schedule Content not found'], 404);
        }
        $schedule->update($request->all());
        return response($schedule, 200);
    }


    public function deleteSchedule(Request $request, $id)
    {
        $schedule = schedule::find($id);
        if (is_null($schedule)) {
            return response()->json(['message' => 'Schedule Content not found'], 404);
        }
        $schedule->delete();
        return response()->json(null, 204);
    }
}
