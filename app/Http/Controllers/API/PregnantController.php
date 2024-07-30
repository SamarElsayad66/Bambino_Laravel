<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregnant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PregnantController extends Controller
{

    public function __construct()
    {
        $this->middleware('pregnant.role')->only('store');
    }

    /**
     * Store a new pregnant record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_day_of_last_period' => 'nullable|date|before_or_equal:today',
            'due_date' => 'nullable|date|before_or_equal:today',
            'date_of_conception' => 'nullable|date|before_or_equal:today',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!$request->hasAny(['first_day_of_last_period', 'due_date', 'date_of_conception'])) {
                $validator->errors()->add('fields', 'At least one date field must be provided.');
            }

            $dates = ['first_day_of_last_period', 'due_date', 'date_of_conception'];
            foreach ($dates as $dateField) {
                if ($request->filled($dateField) && Carbon::parse($request->$dateField)->isFuture()) {
                    $validator->errors()->add($dateField, ucfirst(str_replace('_', ' ', $dateField)) . ' must be a date in the past.');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Calculate age by week based on the first available date
        $ageByWeek = null;
        $currentDate = Carbon::now();

        if ($request->filled('first_day_of_last_period')) {
            $date = Carbon::parse($request->first_day_of_last_period);
            $ageByWeek = $date->diffInWeeks($currentDate);
        } elseif ($request->filled('due_date')) {
            $date = Carbon::parse($request->due_date);
           // $ageByWeek = Carbon::parse($date)->subWeeks(40)->diffInWeeks($currentDate);
           $ageByWeek = $date->diffInWeeks($currentDate);
        } elseif ($request->filled('date_of_conception')) {
            $date = Carbon::parse($request->date_of_conception);
            $ageByWeek = $date->diffInWeeks($currentDate);
        }

        // Check if the age by week is 40 or more
        if ($ageByWeek > 40) {
            return response()->json([
                'status' => false,
                'message' => "The date entered indicates a pregnancy period of more than 40 weeks. Please switch to mom mode."
            ], 422);
        }

        $pregnant = Pregnant::create([
            'user_id' => $user->id,
            'first_day_of_last_period' => $request->first_day_of_last_period,
            'due_date' => $request->due_date,
            'date_of_conception' => $request->date_of_conception,
            'age_by_week' => $ageByWeek,
        ]);

        // Check if it's time to switch to mom mode
        $navigationMessage = null;
        if ($ageByWeek == 40) {
            $navigationMessage = "Congratulations! You have reached 40 weeks. It's time to switch from pregnant mode to mom mode.";
        }

        return response()->json([
            'status' => 'success',
            'pregnant' => $pregnant,
            'navigation_message' => $navigationMessage,
        ], 201);
    }
}
