<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BabyBOY;
use App\Models\BabyGirl;

class BabyNamesController extends Controller
{

    function getboyname(){
        try {

            $boyname = BabyBOY::all();
            return response()->json($boyname

            ,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }

    function getgirlname(){
        try {

            $girlname = BabyGirl::all();
            return response()->json($girlname

            ,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }


}
