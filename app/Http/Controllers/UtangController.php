<?php

namespace App\Http\Controllers;

use App\Models\Utang;
use Illuminate\Http\Request;

class UtangController extends Controller
{
    public function index()
    {
        Utang::where('status', 'pending')
            ->whereDate('due_date', '<', today())
            ->update(['status' => 'overdue']);

        $total = Utang::count();
        $overdue = Utang::where('status', 'overdue')->count();
        $value = Utang::where('status', '!=', 'paid')->sum('amount');

        $utangs = Utang::latest()->paginate(15);

        return view('utang.index', compact('utangs', 'total', 'overdue', 'value'));
    }

    public function store(Request $request)
    {
        $utang = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        Utang::create($utang);

        return redirect()->back()->with('success', 'Utang added successfully!');
    }

    public function update(Request $request, Utang $utang)
    {
        $utangData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        $utang->update($utangData);

        return redirect()->back()->with('success', 'Utang updated successfully!');
    }

    public function destroy(Utang $utang)
    {
        $utang->delete();

        return redirect()->back()->with('success', 'Utang deleted successfully!');
    }
}
