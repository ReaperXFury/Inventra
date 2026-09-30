<?php

namespace App\Http\Controllers;

use App\Models\GCash; // Replace with your model name
use Illuminate\Http\Request;

class GCashController extends Controller
{
    public function index()
    {
        $gcashes = GCash::latest()->get();

        return view('gcash.index', compact('gcashes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'             => 'required|in:cash_in,cash_out',
            'customer_name'    => 'required|string|max:255',
            'phone_number'     => 'required|string|max:11',
            'amount'           => 'required|numeric|min:0',
            'fee'              => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:255',
            'status'           => 'required|in:completed,pending,failed',
            'notes'            => 'nullable|string',
        ]);

        GCash::create($validated);

        return redirect()->route('gcash.index')->with('success', 'GCash transaction added successfully.');
    }

    public function update(Request $request, GCash $gcash)
    {
        $validated = $request->validate([
            'type'             => 'required|in:cash_in,cash_out',
            'customer_name'    => 'required|string|max:255',
            'phone_number'     => 'required|string|max:11',
            'amount'           => 'required|numeric|min:0',
            'fee'              => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:255',
            'status'           => 'required|in:completed,pending,failed',
            'notes'            => 'nullable|string',
        ]);

        $gcash->update($validated);

        return redirect()->route('gcash.index')->with('success', 'GCash transaction updated successfully.');
    }

    public function destroy(GCash $gcash)
    {
        $gcash->delete();

        return redirect()->route('gcash.index')->with('success', 'GCash record deleted successfully.');
    }
}