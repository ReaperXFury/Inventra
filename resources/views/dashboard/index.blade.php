<x-sidebar>
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Header Bar -->
        <header class="px-6 py-3.5 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Dashboard Overview</h2>
                <p class="text-xs text-slate-500">
                    Welcome back, {{ Auth::user()->name ?? 'Owner' }}! Here is what is happening today.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="#"
                    class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>New Sale</span>
                </a>
                <a href="#"
                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition border border-slate-300">
                    + Add Stock
                </a>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6 space-y-6 overflow-y-auto">

            <!-- Key Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Stat Card 1: Today's Sales -->
                <div
                    class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium text-slate-500">Today's Sales</span>
                        <h3 class="text-xl font-black text-slate-800 mt-1">₱ {{ number_format($todaysSalesTotal, 2) }}
                        </h3>
                        <span class="text-[10px] text-emerald-600 font-semibold">{{ $todaysSalesCount }}
                            {{ Str::plural('transaction', $todaysSalesCount) }}</span>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Stat Card 2: Active Utang Balance -->
                <div
                    class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium text-slate-500">Active Utang Balance</span>
                        <h3 class="text-xl font-black text-slate-800 mt-1">₱ {{ number_format($activeUtangTotal, 2) }}
                        </h3>
                        <span class="text-[10px] text-amber-600 font-semibold">{{ $activeUtangCount }}
                            {{ Str::plural('unpaid record', $activeUtangCount) }}</span>
                    </div>
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Stat Card 3: Low Stock Alert -->
                <div
                    class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium text-slate-500">Low Stock Alert</span>
                        <h3 class="text-xl font-black text-slate-800 mt-1">{{ $lowStockCount }}
                            {{ Str::plural('Item', $lowStockCount) }}
                        </h3>
                        <span class="text-[10px] text-rose-500 font-semibold">Needs restock</span>
                    </div>
                    <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <!-- Stat Card 4: GCash / Load Volume -->
                <div
                    class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium text-slate-500">GCash / Load Volume</span>
                        <h3 class="text-xl font-black text-slate-800 mt-1">₱
                            {{ number_format($digitalServicesVolumeToday, 2) }}
                        </h3>
                        <span class="text-[10px] text-blue-600 font-semibold">Today's activity</span>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Section Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Recent Transactions Table -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-800">Recent Transactions</h3>
                        <a href="#" class="text-xs font-semibold text-indigo-600 hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
                                <tr>
                                    <th class="px-3 py-2 font-semibold">Ref No.</th>
                                    <th class="px-3 py-2 font-semibold">Payment</th>
                                    <th class="px-3 py-2 font-semibold">Amount</th>
                                    <th class="px-3 py-2 font-semibold">Time</th>
                                    <th class="px-3 py-2 font-semibold text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($recentTransactions as $tx)
                                    <tr>
                                        <td class="px-3 py-2.5 font-medium text-slate-800">{{ $tx->ref_no }}</td>
                                        <td class="px-3 py-2.5">
                                            @php
                                                $paymentLower = strtolower($tx->payment);
                                                $badgeClasses = match ($paymentLower) {
                                                    'gcash' => 'bg-blue-100 text-blue-700',
                                                    'utang' => 'bg-amber-100 text-amber-700',
                                                    'e-load', 'eload' => 'bg-purple-100 text-purple-700',
                                                    default => 'bg-emerald-100 text-emerald-700',
                                                };
                                            @endphp
                                            <span
                                                class="px-2 py-0.5 rounded-md text-[10px] font-semibold capitalize {{ $badgeClasses }}">
                                                {{ $tx->payment }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2.5 font-bold text-slate-800">₱
                                            {{ number_format($tx->amount, 2) }}</td>
                                        <td class="px-3 py-2.5 text-slate-500">{{ $tx->created_at->format('h:i A') }}</td>
                                        <td
                                            class="px-3 py-2.5 text-right font-medium {{ strtolower($tx->status) === 'pending' ? 'text-amber-600' : 'text-emerald-600' }}">
                                            {{ $tx->status }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-slate-400 italic">
                                            No recent transactions logged yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Quick Module Actions Panel -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 flex flex-col">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Quick Actions</h3>
                    <div class="space-y-2 flex-1">
                        <a href="{{ route('inventory.index') }}"
                            class="w-full text-left px-3.5 py-2.5 rounded-lg border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50/50 transition flex items-center justify-between group block">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-indigo-600">Add New
                                    Product</span>
                            </div>
                            <span class="text-slate-400 text-xs">+</span>
                        </a>

                        <a href="{{ route('utang.index') }}"
                            class="w-full text-left px-3.5 py-2.5 rounded-lg border border-slate-200 hover:border-amber-500 hover:bg-amber-50/50 transition flex items-center justify-between group block">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-amber-600">Record
                                    Utang</span>
                            </div>
                            <span class="text-slate-400 text-xs">+</span>
                        </a>

                        <a href="{{ route('gcash.index') }}"
                            class="w-full text-left px-3.5 py-2.5 rounded-lg border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 transition flex items-center justify-between group block">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-blue-600">GCash
                                    Cash-In / Out</span>
                            </div>
                            <span class="text-slate-400 text-xs">+</span>
                        </a>

                        <a href="{{ route('eload.index') }}"
                            class="w-full text-left px-3.5 py-2.5 rounded-lg border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/50 transition flex items-center justify-between group block">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-emerald-600">Process
                                    E-Load</span>
                            </div>
                            <span class="text-slate-400 text-xs">+</span>
                        </a>
                    </div>
                </div>

            </div>

        </main>
    </div>
</x-sidebar>