<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenderTypeController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Return a view or any other response as needed for the index route
        // For now, returning an empty response
        return response()->json([]);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $themeColor = $request->input('gender') === 'male' ? 'blue' : 'pink';
        session(['theme_color' => $themeColor]);

        // Return the updated theme color as JSON response
        return response()->json(['theme_color' => $themeColor]);
    }
}
