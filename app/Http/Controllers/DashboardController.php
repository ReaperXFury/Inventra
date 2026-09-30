<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Utang;
use App\Models\Product;
use App\Models\Gcash;
use App\Models\Eload;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Key Metrics
        $todaysSalesTotal = Sale::whereDate('created_at', $today)->sum('total_amount');
        $todaysSalesCount = Sale::whereDate('created_at', $today)->count();

        $activeUtangTotal = Utang::whereIn('status', ['pending', 'overdue'])->sum('amount');
        $activeUtangCount = Utang::whereIn('status', ['pending', 'overdue'])->count();

        $lowStockCount = Product::where('is_active', true)
            ->whereColumn('stock_quantity', '<=', 'min_stock_level')
            ->count();

        $gcashTodayVolume = Gcash::whereDate('created_at', $today)->where('status', 'completed')->sum('amount');
        $eloadTodayVolume = Eload::whereDate('created_at', $today)->where('status', 'completed')->sum('amount');
        $digitalServicesVolumeToday = $gcashTodayVolume + $eloadTodayVolume;

        // --- MERGE ALL RECENT TRANSACTIONS ---
        $recentSales = Sale::latest()->take(5)->get()->map(function ($item) {
            return (object) [
                'ref_no' => $item->invoice_number,
                'payment' => $item->payment_method ?? 'Cash',
                'amount' => $item->total_amount,
                'status' => 'Completed',
                'created_at' => $item->created_at,
            ];
        });

        $recentUtangs = Utang::latest()->take(5)->get()->map(function ($item) {
            return (object) [
                'ref_no' => $item->reference_number ?? 'UTG-' . $item->id,
                'payment' => 'Utang',
                'amount' => $item->amount,
                'status' => ucfirst($item->status ?? 'Pending'),
                'created_at' => $item->created_at,
            ];
        });

        $recentGcash = Gcash::latest()->take(5)->get()->map(function ($item) {
            return (object) [
                'ref_no' => $item->reference_number ?? $item->ref_no ?? 'GCS-' . $item->id,
                'payment' => 'GCash',
                'amount' => $item->amount,
                'status' => ucfirst($item->status ?? 'Completed'),
                'created_at' => $item->created_at,
            ];
        });

        $recentEload = Eload::latest()->take(5)->get()->map(function ($item) {
            return (object) [
                'ref_no' => $item->reference_number ?? $item->ref_no ?? 'ELD-' . $item->id,
                'payment' => 'E-Load',
                'amount' => $item->amount,
                'status' => ucfirst($item->status ?? 'Completed'),
                'created_at' => $item->created_at,
            ];
        });

        // Combine all and take the 5 most recent overall
        $recentTransactions = $recentSales
            ->concat($recentUtangs)
            ->concat($recentGcash)
            ->concat($recentEload)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('dashboard.index', compact(
            'todaysSalesTotal',
            'todaysSalesCount',
            'activeUtangTotal',
            'activeUtangCount',
            'lowStockCount',
            'digitalServicesVolumeToday',
            'recentTransactions'
        ));
    }
}