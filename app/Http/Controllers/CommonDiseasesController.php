<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CommonDiseasesController extends Controller
{
    public function commonDisease(): \Illuminate\Http\JsonResponse
    {
        // Read the contents of the nutrition.json file
        $commonDiseaseData = Storage::get('public/common-diseases.json');

        // Convert the JSON string to an associative array
        $commonDiseaseArray = json_decode($commonDiseaseData, true);

        // Return the common disease data as JSON response
        return response()->json($commonDiseaseArray);
    }
}
