<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class MomController extends Controller
{
    /**
     * Store a new mom record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'baby_name' => 'required|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get authenticated user's ID
        $userId = Auth::id();

        // Create a new mom record associated with the authenticated user
        $mom = Mom::create([
            'user_id' => $userId,
            'baby_name' => $request->baby_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return response()->json([
            'status' => 'success',
            'mom' => $mom,
        ], 201);
    }

    /**
     * Display the specified mom.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $mom = Mom::find($id);

        if (!$mom) {
            return response()->json([
                'status' => false,
                'message' => 'Child not found',
            ], 404);
        }

        // Check if the authenticated user owns this mom record
        if ($mom->user_id !== Auth::id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'mom' => $mom,
        ], 200);
    }
}
