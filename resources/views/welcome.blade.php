<x-layout>
    <div class="min-h-screen bg-slate-50 font-sans text-slate-800 selection:bg-indigo-600 selection:text-white">
        
        <!-- Top Navigation Bar -->
        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                
                <!-- Brand Logo & Status -->
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 text-white p-2 rounded-xl shadow-md shadow-indigo-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-black text-2xl tracking-tight text-slate-900">Inventra<span class="text-indigo-600">.</span></span>
                        <span class="hidden sm:inline-block px-2 py-0.5 text-[10px] font-semibold tracking-wider text-indigo-700 bg-indigo-50 rounded-full border border-indigo-200 uppercase">Store System</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition shadow-sm">
                            <span>Open System</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition shadow-sm">
                            Get Started
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative overflow-hidden pt-12 pb-20 lg:pt-16 lg:pb-28">
            <!-- Background Glow Soft FX -->
            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-indigo-100/60 blur-[120px] rounded-full pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Column: Copy & Actions -->
                    <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold tracking-wide">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                            </span>
                            All-in-One Store Management System
                        </div>

                        <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-none">
                            Smart records for inventory, sales, & <span class="text-indigo-600">digital services.</span>
                        </h1>

                        <p class="text-lg text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                            Inventra organizes store stock, daily sales, customer utang credit tracking, GCash cash-in/out logs, and e-load transactions in one seamless platform.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                            @auth
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-7 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                                    <span>Launch Dashboard</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="w-full sm:w-auto px-7 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                                    <span>Access System</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                            @endauth

                            <a href="#modules" class="w-full sm:w-auto px-7 py-3.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl transition text-center shadow-sm">
                                View Modules
                            </a>
                        </div>

                        <!-- System Highlights -->
                        <div class="pt-8 border-t border-slate-200 grid grid-cols-3 gap-6 text-left">
                            <div>
                                <p class="text-2xl font-black text-slate-900">6-in-1</p>
                                <p class="text-xs text-slate-500 mt-0.5">Core Modules</p>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-slate-900">Real-Time</p>
                                <p class="text-xs text-slate-500 mt-0.5">Ledger Sync</p>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-slate-900">Zero-Loss</p>
                                <p class="text-xs text-slate-500 mt-0.5">Digital Logs</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Light Dashboard Mock Card -->
                    <div class="lg:col-span-6 relative">
                        <div class="relative rounded-2xl bg-white border border-slate-200 shadow-2xl overflow-hidden">
                            
                            <!-- Mock UI Window Top -->
                            <div class="px-5 py-3.5 bg-slate-100 border-b border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-rose-400 inline-block"></span>
                                    <span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span>
                                    <span class="w-3 h-3 rounded-full bg-emerald-400 inline-block"></span>
                                    <span class="text-xs text-slate-500 font-mono ml-2">inventra://system-overview</span>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] bg-emerald-100 text-emerald-800 border border-emerald-200 rounded font-semibold font-mono">ALL MODULES ACTIVE</span>
                            </div>

                            <div class="p-6 space-y-5">
                                <!-- Widget Grid -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <p class="text-[11px] text-slate-500 font-medium">Daily Sales</p>
                                        <p class="text-xl font-black text-slate-900 mt-0.5">₱8,450.00</p>
                                        <span class="text-[10px] text-emerald-600 font-medium">↑ Integrated POS</span>
                                    </div>
                                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200">
                                        <p class="text-[11px] text-amber-800 font-medium">Unpaid Utang</p>
                                        <p class="text-xl font-black text-amber-900 mt-0.5">₱1,280.00</p>
                                        <span class="text-[10px] text-amber-700 font-medium">4 Active Receivables</span>
                                    </div>
                                </div>

                                <!-- Live Transaction Feed Mock -->
                                <div class="space-y-2">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Live Activity Stream</p>

                                    <div class="space-y-2 text-xs">
                                        <!-- GCash Transaction -->
                                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-blue-50/70 border border-blue-100">
                                            <div class="flex items-center gap-2.5">
                                                <span class="px-1.5 py-0.5 rounded bg-blue-600 text-white font-bold text-[10px]">GCASH</span>
                                                <div>
                                                    <p class="text-slate-800 font-semibold">Cash-In Transaction</p>
                                                    <p class="text-slate-500 text-[10px]">Fee collected: ₱15.00</p>
                                                </div>
                                            </div>
                                            <span class="text-blue-700 font-mono font-bold">+₱1,000.00</span>
                                        </div>

                                        <!-- E-Load Transaction -->
                                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-purple-50/70 border border-purple-100">
                                            <div class="flex items-center gap-2.5">
                                                <span class="px-1.5 py-0.5 rounded bg-purple-600 text-white font-bold text-[10px]">E-LOAD</span>
                                                <div>
                                                    <p class="text-slate-800 font-semibold">Smart Promo Load</p>
                                                    <p class="text-slate-500 text-[10px]">0999****123 • GIGA99</p>
                                                </div>
                                            </div>
                                            <span class="text-purple-700 font-mono font-bold">₱99.00</span>
                                        </div>

                                        <!-- Utang Recorded -->
                                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                                            <div class="flex items-center gap-2.5">
                                                <span class="px-1.5 py-0.5 rounded bg-amber-500 text-white font-bold text-[10px]">UTANG</span>
                                                <div>
                                                    <p class="text-slate-800 font-semibold">Store Credit Recorded</p>
                                                    <p class="text-slate-500 text-[10px]">Customer: Juan Dela Cruz</p>
                                                </div>
                                            </div>
                                            <span class="text-amber-700 font-mono font-bold">₱240.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Modules Section -->
        <section id="modules" class="py-20 bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                    <h2 class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Complete System Coverage</h2>
                    <p class="text-3xl font-black text-slate-900">Everything your store needs to operate.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- 1. System Overview -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-indigo-500 transition group hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">System Overview</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Centralized dashboard displaying high-level store health, revenue summaries, and quick metric insights at a glance.</p>
                    </div>

                    <!-- 2. Inventory Management -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-indigo-500 transition group hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Inventory Control</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Track physical stock levels, manage item SKUs, set low-stock thresholds, and log stock-in/stock-out movements.</p>
                    </div>

                    <!-- 3. Sales Management -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-emerald-500 transition group hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Sales Records</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Log point-of-sale transactions, calculate daily revenue, track payment methods, and auto-deduct sold inventory.</p>
                    </div>

                    <!-- 4. Utang Tracking -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-amber-500 transition group hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Utang (Credit) Records</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Maintain customer credit logs, record partial or full debt payments, track outstanding balances, and view payment histories.</p>
                    </div>

                    <!-- 5. GCash Cash-In & Cash-Out -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-500 transition group hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">GCash Cash-In / Out</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Log all digital wallet Cash-In and Cash-Out transactions, record convenience fees, and monitor active float balances.</p>
                    </div>

                    <!-- 6. E-Load Records -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-purple-500 transition group hover:shadow-md">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">E-Load Transactions</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Record telco loading logs across networks (Globe, Smart, DITO), track load promo dispatches, and audit retailer profits.</p>
                    </div>

                </div>

            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-slate-200 py-10 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-800">Inventra Management System</span>
                    <span>&copy; {{ date('Y') }} All rights reserved.</span>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-slate-800 transition">System Status</a>
                    <a href="#" class="hover:text-slate-800 transition">Documentation</a>
                    <a href="#" class="hover:text-slate-800 transition">Support</a>
                </div>
            </div>
        </footer>

    </div>
</x-layout>