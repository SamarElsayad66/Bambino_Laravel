<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BabyNamesController;
use App\Http\Controllers\API\ExerciseController;
use App\Http\Controllers\API\NutritionController;
use App\Http\Controllers\API\PasswordResetController;
use App\Http\Controllers\API\PregnancyController;
use App\Http\Controllers\API\PregnantController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\CommonDiseasesController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\GenderTypeController;
use App\Http\Controllers\GeneralTopicsController;
use App\Http\Controllers\API\MomController;
use App\Http\Controllers\NutritionsController;
use App\Http\Controllers\SleepController;
use Illuminate\Support\Facades\Route;


# Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

# Forgot Password
Route::post('forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('verify-otp', [PasswordResetController::class, 'verifyOtp']);
Route::post('reset-password', [PasswordResetController::class, 'resetPassword']);

# Roles
Route::middleware('auth:sanctum')->group(function () {
    Route::post('select-role', [AuthController::class, 'selectYourRole']);
    Route::post('pregnant', [PregnantController::class, 'store']);

    # Mom
    Route::post('moms', [MomController::class, 'store']);
    Route::get('children/{id}', [MomController::class, 'show']);

});

# Articles
Route::group(['middleware' => 'api', 'prefix' => 'articles'], function () {
    Route::get('common-diseases', [CommonDiseasesController::class, 'commonDisease'])->name('common-diseases.index');
    Route::get('exercises', [ExercisesController::class, 'exercise'])->name('exercises.index');
    Route::get('general-topics', [GeneralTopicsController::class, 'generalTopics'])->name('general-topics.index');
    Route::get('nutrition', [NutritionsController::class, 'nutrition'])->name('nutrition.index');
    Route::get('sleep', [SleepController::class, 'sleep'])->name('sleep.index');


});

//---------------------------------------------------------------------

# Profile
Route::get('get-profile', [AuthController::class, 'getProfile'])->middleware('auth:sanctum');
Route::post('update-profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');


# Nutrition
Route::get('BreakfastMeals', [NutritionController::class, 'breakfast']);
Route::get('LunchMeals', [NutritionController::class, 'lunch']);
Route::get('DinnerMeals', [NutritionController::class, 'dinner']);
Route::get('Snacks', [NutritionController::class, 'snacks']);
Route::get('Drinks', [NutritionController::class, 'drink']);
Route::get('Fruits', [NutritionController::class, 'fruit']);


# Names
Route::get('/boyNames', [BabyNamesController::class, 'getboyname']);
Route::get('/girlNames', [BabyNamesController::class, 'getgirlname']);


# Pregnancy Home
Route::get('/home/{week}', [PregnancyController::class, 'pregnancy']);


# Exercises
Route::get('/exercise/{tirmester}', [ExerciseController::class, 'exercise']);


# Child
Route::group(['middleware' => 'api'], function () {
    Route::get('child_registration', [ChildController::class, 'showRegistrationForm'])->name('child-registration');
    Route::post('child_registration', [ChildController::class, 'processForm'])->name('child-register');
});


# Gender Type
Route::group(['middleware' => 'api'], function () {
    Route::get('gender-type', [GenderTypeController::class, 'index'])->name('gender.type.index');
    Route::post('gender-type', [GenderTypeController::class, 'update'])->name('gender.type.update');
});
