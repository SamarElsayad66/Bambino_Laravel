<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GeneralTopicsController extends Controller
{
    public function generalTopics(): \Illuminate\Http\JsonResponse
    {
        // Read the contents of the general_topics.json file
        $generalTopicsData = Storage::get('public/general-topics.json');

        // Convert the JSON string to an associative array
        $generalTopicsArray = json_decode($generalTopicsData, true, 512, JSON_THROW_ON_ERROR);

        // Return the general topics data as JSON response
        return response()->json($generalTopicsArray);
    }
}
