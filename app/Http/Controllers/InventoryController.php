<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(10);

        // Summary Metrics
        $totalItems = Product::count();
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'min_stock_level')->count();
        $totalInventoryValue = Product::selectRaw('SUM(stock_quantity * selling_price) as value')->value('value') ?? 0;

        return view('inventory.index', compact('products', 'totalItems', 'lowStockCount', 'totalInventoryValue'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        unset($validated['image']); // don't pass the UploadedFile to create()

        if ($request->hasFile('image')) {
            $validated['photo_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => ['required', Rule::unique('products', 'sku')->ignore($product->id)],
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        unset($validated['image']); // don't pass the UploadedFile to create()

        if ($request->hasFile('image')) {
            if ($product->photo_path) {
                Storage::disk('public')->delete($product->photo_path);
            }
        }

        $product->update($validated);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->photo_path) {
            Storage::disk('public')->delete($product->photo_path);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
