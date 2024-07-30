<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SleepController extends Controller
{
    public function sleep(): \Illuminate\Http\JsonResponse
    {
        // Read the contents of the sleep.json file
        $sleepData = Storage::get('public/sleep.json');

        // Convert the JSON string to an associative array
        $sleepArray = json_decode($sleepData, true);

        // Return the sleep data as JSON response
        return response()->json($sleepArray);
    }
}
