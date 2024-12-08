<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of vouchers.
     */
    public function index()
    {
        $vouchers = Voucher::all();
        return response()->json($vouchers);
    }

    /**
     * Store a newly created voucher in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vourcher_code' => 'required|string|unique:vouchers,vourcher_code|max:255',
            'status' => 'required|in:active,inactive',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'discount_type' => 'required|in:percent,fixed',
            'discount_amount' => 'required_if:discount_type,fixed|numeric|min:0',
            'discount_percent' => 'required_if:discount_type,percent|numeric|min:0|max:100',
            'limit' => 'required|integer|min:1',
            'config' => 'required|json',
            'team_id' => 'required|uuid|exists:teams,id',
            'created_by' => 'required|uuid|exists:users,id',
        ]);

        $voucher = Voucher::create($validated);

        return response()->json(['message' => 'Voucher created successfully.', 'data' => $voucher], 201);
    }

    /**
     * Display the specified voucher.
     */
    public function show(string $id)
    {
        $voucher = Voucher::findOrFail($id);

        return response()->json($voucher);
    }

    /**
     * Update the specified voucher in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'vourcher_code' => 'nullable|string|unique:vouchers,vourcher_code,' . $id . '|max:255',
            'status' => 'nullable|in:active,inactive',
            'start_date' => 'nullable|date|before:end_date',
            'end_date' => 'nullable|date|after:start_date',
            'discount_type' => 'nullable|in:percent,fixed',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'limit' => 'nullable|integer|min:1',
            'config' => 'nullable|json',
            'team_id' => 'nullable|uuid|exists:teams,id',
            'created_by' => 'nullable|uuid|exists:users,id',
        ]);

        $voucher = Voucher::findOrFail($id);
        $voucher->update($validated);

        return response()->json(['message' => 'Voucher updated successfully.', 'data' => $voucher]);
    }

    /**
     * Remove the specified voucher from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return response()->json(['message' => 'Voucher deleted successfully.']);
    }
}
