<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregnancy;

class PregnancyController extends Controller
{
    //



    public function pregnancy(Request $request,$currentweek){
        try {
            $currentweek = $request->week;
            $pregnancy = Pregnancy::find($currentweek );
            return response()->json([
                'status'=>'success',
                'message'=>'home',
                'data'=>$pregnancy
            ],200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }
}
