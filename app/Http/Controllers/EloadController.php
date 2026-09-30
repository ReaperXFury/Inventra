<?php

namespace App\Http\Controllers;

use App\Models\Eload;
use Illuminate\Http\Request;

class EloadController extends Controller
{
    public function index()
    {
        $eloads = Eload::latest()->get();

        return view('eload.index', compact('eloads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider'         => 'required|string|max:50',
            'customer_name'    => 'required|string|max:255',
            'phone_number'     => 'required|string|max:11',
            'amount'           => 'required|numeric|min:0',
            'fee'              => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:255',
            'status'           => 'required|in:completed,pending,failed',
            'notes'            => 'nullable|string',
        ]);

        Eload::create($validated);

        return redirect()->route('eload.index')->with('success', 'eLoad transaction recorded successfully.');
    }

    public function update(Request $request, Eload $eload)
    {
        $validated = $request->validate([
            'provider'         => 'required|string|max:50',
            'customer_name'    => 'required|string|max:255',
            'phone_number'     => 'required|string|max:11',
            'amount'           => 'required|numeric|min:0',
            'fee'              => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:255',
            'status'           => 'required|in:completed,pending,failed',
            'notes'            => 'nullable|string',
        ]);

        $eload->update($validated);

        return redirect()->route('eload.index')->with('success', 'eLoad record updated successfully.');
    }

    public function destroy(Eload $eload)
    {
        $eload->delete();

        return redirect()->route('eload.index')->with('success', 'eLoad record deleted successfully.');
    }
}