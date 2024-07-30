<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Pregnant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required|string|min:6',

                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Successfully Registered',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required|string|min:6',

                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password do not match with our record.'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("API TOKEN")->plainTextToken;
                $user->token = $token;
            };


            $pregnant = $user->pregnant;
            $mom = $user->mom;
        
            return response()->json([
                'status' => 'success',
                'message' => 'Logged In Successfully',
                'data' => $user,
                
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function getProfile(Request $request)
    {
        try {
            // Get the currently authenticated user
            $user = $request->user();
    
            // Load the related pregnant record
            $pregnant = $user->pregnant;
    
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile',
                'data' => [
                    'user' => $user,
                    //'pregnant' => $pregnant
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    


    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,bmp,png,svg',
            'phone_number' => 'nullable',
            'due_date' => 'required|date|before_or_equal:today'

        ]);

        $validator->after(function ($validator) use ($request) {
            $date = [ 'due_date'];
            foreach ($date as $dateField) {
                if ($request->filled($dateField) && Carbon::parse($request->$dateField)->isFuture()) {
                    $validator->errors()->add($dateField, ucfirst(str_replace('_', ' ', $dateField)) . ' must be a date in the past.');
                }
            }
        });
        $ageByWeek = null;
        $currentDate = Carbon::now();


        if ($request->filled('due_date')) {
            $date = Carbon::parse($request->due_date);
           $ageByWeek = $date->diffInWeeks($currentDate);
        } 

        if ($ageByWeek > 40) {
            return response()->json([
                'status' => false,
                'message' => "The date entered indicates a pregnancy period of more than 40 weeks. Please switch to mom mode."
            ], 422);
        }

        $navigationMessage = null;
        if ($ageByWeek == 40) {
            $navigationMessage = "Congratulations! You have reached 40 weeks. It's time to switch from pregnant mode to mom mode.";
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        $user = $request->user();
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                $old_path = public_path() . '/images/' . $user->profile_picture;
                if (File::exists($old_path)) {
                    File::delete($old_path);
                }
            }

            $image_name = 'profile_picture-' . time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('/images/'), $image_name);
        } else {
            $image_name = $user->profile_picture;
        }

        $user->update([
            'name' => $request->name,
            //'password' => $request->password,
            'profile_picture' => $image_name,
            'phone_number' => $request->phone_number ]);
        $pregnant = $user->pregnant; 
        if ($pregnant) {
            $pregnant->update([
                'due_date' => $request->due_date,
            ]);
        } else {
            $pregnant = $user->pregnant()->create([
                'due_date' => $request->due_date,
        ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Profile Updated',
            'user' => $user,
            //'pregnant'=>$pregnant,
            'navigation_message' => $navigationMessage
            
        ], 200);
    }



    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = $request->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'message' => ' Password successfully updated',
            ], 200);

        } else {
            return response()->json([
                'message' => 'Old Password does not match',
            ], 400);

        }


    }


    public function selectYourRole(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:mom,pregnant',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User role updated successfully',
            'user' => $user,
        ], 200);
    }

}
