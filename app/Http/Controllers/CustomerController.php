<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Store a new customer and create a corresponding user.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone_number',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
        ]);

        // If validation fails, return the error response
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Prepare user data to create a new user
        $userData = [
            'name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'password' => Hash::make(Str::random(10)), // Random password or handle it as needed
            'user_type' => 'customer', // Specify user type as 'customer'
        ];

        try {
            // Start transaction to ensure both operations succeed or fail together
            DB::beginTransaction();

            // Create the User first
            $user = User::create($userData);

            // Assign the customer role to the user
            $user->assignRole('customer'); // Modify role as per your requirement

            // Now create the Customer and associate it with the created User
            $customer = Customer::create([
                'user_id' => $user->id,
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'date_registered' => now(),
            ]);

            // Commit transaction if both operations succeed
            DB::commit();

            return response()->json([
                'message' => 'Customer and User created successfully.',
                'customer' => $customer,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaction if an error occurs
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the details of a customer.
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json($customer, 200);
    }

    /**
     * Update the customer details.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $customer->user_id,
            'phone_number' => 'required|string|unique:users,phone_number,' . $customer->user_id,
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update user details
        $user = User::find($customer->user_id);
        $user->update([
            'name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
        ]);

        // Update customer details
        $customer->update([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
        ]);

        return response()->json([
            'message' => 'Customer updated successfully.',
            'customer' => $customer,
            'user' => $user,
        ], 200);
    }

    /**
     * Delete the customer.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Delete the customer record and the related user
        DB::beginTransaction();

        try {
            $user = User::find($customer->user_id);
            $user->delete();
            $customer->delete();

            DB::commit();

            return response()->json(['message' => 'Customer and User deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
