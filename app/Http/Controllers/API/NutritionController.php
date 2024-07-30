<?php

namespace App\Http\Controllers\API;

use App\Models\Breakfast;
use App\Models\Lunch;
use App\Models\Dinner;
use App\Models\Snack;
use App\Models\Drink;
use App\Models\Fruit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NutritionController extends Controller
{
    public function breakfast(Request $request){
        try {
            
            $breakfast = Breakfast::all();
            return response()->json($breakfast,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }


    }





    public function lunch(Request $request){
        try {
            
            $lunch = Lunch::all();
            return response()->json($lunch,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }





    public function dinner(Request $request){
        try {
            
            $dinner = Dinner::all();
            return response()->json($dinner ,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }





    public function snacks(Request $request){
        try {
            
            $snacks = Snack::all();
            return response()->json($snacks,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }





    public function drink(Request $request){
        try {
            
            $drinks = Drink::all();
            return response()->json($drinks,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }






    public function fruit(Request $request){
        try {
            
            $fruits = Fruit::all();
            return response()->json($fruits,200);
        }catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }






}
