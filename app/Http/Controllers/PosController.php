<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('min_price'), function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                $query->orderBy($request->sort, $request->get('direction', 'asc'));
            })
            ->paginate(100);

        return view('pos', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart_data' => 'required|json',
            'payment_method' => 'required|in:cash,gcash',
            'amount_paid' => 'required_if:payment_method,cash|nullable|numeric|min:0',
        ]);

        $cartItems = json_decode($request->cart_data, true);

        if (empty($cartItems)) {
            return back()->with('error', 'Cart is empty.');
        }

        // 2. Calculate Order Totals
        $subtotal = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['qty']);
        }, 0);

        $totalAmount = $subtotal;
        $amountPaid = $request->payment_method === 'cash'
            ? (float) $request->amount_paid
            : $totalAmount; // GCash is paid exactly

        if ($amountPaid < $totalAmount) {
            return back()->with('error', 'Amount paid is less than the total due.');
        }

        $changeAmount = $amountPaid - $totalAmount;

        // 3. Database Transaction
        DB::transaction(function () use ($cartItems, $subtotal, $totalAmount, $amountPaid, $changeAmount, $request) {

            // Create Sale Record
            $sale = Sale::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'amount_paid' => $amountPaid,
                'change_amount' => $changeAmount,
            ]);

            // Create SaleItems & Deduct Stock
            foreach ($cartItems as $item) {
                $lineSubtotal = $item['price'] * $item['qty'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal' => $lineSubtotal,
                ]);

                // Deduct inventory
                Product::where('id', $item['id'])->decrement('stock_quantity', $item['qty']);
            }
        });

        return redirect()->route('pos')->with('success', 'Sale completed successfully!');
    }
}
