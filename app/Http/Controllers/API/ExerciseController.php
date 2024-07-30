<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends Controller

{
  //

   /* function exercise(Request $request){
    try {

        $exercise = Exercise::all();
        return response()->json([$exercise

        ],200);
    }catch (\Throwable $th) {
        return response()->json([
            'status'=>false,
            'message'=>$th->getMessage()
        ], 500);
    };
}*/


public function exercise(Request $request,$currentexercise){
    try {
        $currentexercise = $request->tirmester;
        $exercise = exercise::where("tirmester", $currentexercise)->get();
        return response()->json([
            'status'=>'success',
            'message'=>'home',
            'data'=>$exercise
        ],200);
    }catch (\Throwable $th) {
        return response()->json([
            'status'=>false,
            'message'=>$th->getMessage()
        ], 500);
    }
}
}



