<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'     => 'required|min:4',
            'email'    => 'required|email|unique:customer,email', // Added unique check
            'password' => 'required|min:4',
        ]);

        // This will now work because we added role_id to $fillable in the Model
        Customer::create([
            'role_id'  => 3, 
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Note: showLogin, login, and logout are now handled by LoginController.php
    // as per our previous web.php update.
}