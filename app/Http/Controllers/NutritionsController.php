<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class NutritionsController extends Controller
{
    public function nutrition(): \Illuminate\Http\JsonResponse
    {
        // Read the contents of the nutrition.json file
        $nutritionData = Storage::get('public/nutrition.json');

        // Convert the JSON string to an associative array
        $nutritionArray = json_decode($nutritionData, true);

        // Return the nutrition data as JSON response
        return response()->json($nutritionArray);
    }
}
