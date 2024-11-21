<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    public function showRegisterForm()
    {        
        return view('pages/register');
    }
    public function showLoginForm()
    {        
        return view('pages/login');
    }
    
    public function register(Request $request)
    {
        // Validation for the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'There were validation errors.'
            ], 422);  // 422 Unprocessable Entity
        }

        // Create the user
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user -> user_type = 'User';
            $user -> status = 'Active';
            $user->save();

            // Log the user in after registration
            Auth::login($user);

            // Return success message
            return response()->json([
                'success' => true,
                'message' => 'Registration successful. You are now logged in.'
            ], 200);
        } catch (\Exception $e) {
            // Return error message if user creation fails
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the account.'
            ], 500);  // 500 Internal Server Error
        }
    }
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();       
            if ($user->user_type === "Admin") {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful as Admin',
                    'redirectUrl' => route('admin.dashboard'), 
                ]);
            }else if ($user->user_type === "User") {      
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful as User',
                    'redirectUrl' => route('home'), 
                ]);
            }   
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized user type',
            ], 403);
        }

        // Invalid credentials
        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password',
        ], 401);
    }

public function logout()
    {
        // Log out the user
        Auth::logout();       
        return redirect()->route('login');  
    }
}
