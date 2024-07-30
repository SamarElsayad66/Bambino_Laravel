<?php

namespace App\Http\Controllers;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('registration');
    }

    public function store(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:registrations',
            'password' => 'required|string|min:8',
            'role' => 'required|in:pregnant,mom',
        ]);

//        return [
//            'validatedData' => $validatedData
//        ];




        // Redirect the user after successful registration
        return redirect('/')->with('success', 'Registration successful!');
    }
}
