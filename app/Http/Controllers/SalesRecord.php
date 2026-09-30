<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class SalesRecord extends Controller
{
    public function index(Request $request){
        $query = Sale::query()
            ->when($request->search, fn ($q, $s) => $q->where('invoice_number', 'like', "%{$s}%"))
            ->when($request->payment, fn ($q, $p) => $q->where('payment_method', $p))
            ->when($request->from, fn ($q, $d) => $q->whereDate('created_at', '>=', $d))
            ->when($request->to, fn ($q, $d) => $q->whereDate('created_at', '<=', $d));

        $stats = [
            'total' =>(clone $query)->sum('total_amount'),
            'count' =>(clone $query)->count(),
            'items' =>SaleItem::whereIn('sale_id', (clone $query)->select('id'))->sum('quantity'),
            'by_method' =>(clone $query)
                ->selectRaw('payment_method, SUM(total_amount) as total')
                ->groupBy('payment_method')
                ->pluck('total', 'payment_method'),
        ];

        $sales = $query
            ->with('items.product')
            ->withSum('items as items_qty', 'quantity')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('sale-record', compact('sales', 'stats'));

    }
}
