<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone_number',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'team_id' => 'required|exists:teams,id',
            'level' => 'required|in:Manager,Receptionist,Waiter',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Handle the image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store the image in 'public/employees' folder
            $imagePath = $request->file('image')->store('employees', 'public');
        }

        // Prepare data to create the user
        $userData = [
            'name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'password' => Hash::make(Str::random(10)), // Random password or handle it as needed
            'user_type' => 'user', // Specify user type as 'user'
        ];

        try {
            // Start transaction to ensure both operations succeed or fail together
            DB::beginTransaction();

            // Create the User first
            $user = User::create($userData);

            // Assign a role to the user
            $user->assignRole('employee'); // Modify role as per your requirement

            // Now create the Employee and associate it with the created User
            $employee = Employee::create([
                'user_id' => $user->id,
                'team_id' => $request->input('team_id'),
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'level' => $request->input('level'),
                'date_registered' => now(),
                'image' => $imagePath, // Save the image path in the employee record
            ]);

            // Commit transaction if both operations succeed
            DB::commit();

            return response()->json([
                'message' => 'Employee and User created successfully.',
                'employee' => $employee,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaction if an error occurs
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
