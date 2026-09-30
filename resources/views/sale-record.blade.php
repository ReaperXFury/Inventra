<x-sidebar>
    <x-flash-alert />

    <div class="px-5 pb-5 space-y-6">
        <!-- Header -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Sales Record</h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Monitor transaction histories, completed orders, and revenue insights.
                </p>
            </div>
        </header>

        <!-- Summary Cards (values update with the filters) -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Total Sales</p>
                    <p id="stat-total" class="text-2xl font-bold text-slate-900 mt-1">₱{{ number_format($stats['total'], 2)}}</p>
                </div>
                <span class="p-2 rounded-lg bg-emerald-50 text-emerald-600">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </span>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Transactions</p>
                    <p id="stat-count" class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['count'])}}</p>
                </div>
                <span class="p-2 rounded-lg bg-blue-50 text-blue-600">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </span>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Items Sold</p>
                    <p id="stat-items" class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['items']) }}</p>
                </div>
                <span class="p-2 rounded-lg bg-amber-50 text-amber-600">
                    <i data-lucide="package" class="w-5 h-5"></i>
                </span>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                <p class="text-xs font-medium text-slate-500 mb-2">By Payment Method</p>
                <dl class="space-y-1 text-xs">
                    <div class="flex justify-between">
                        <dt class="text-slate-600">Cash</dt>
                        <dd id="stat-cash" class="font-semibold text-slate-900">₱{{number_format($stats['by_method']['cash'] ?? 0, 2)}}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-600">GCash</dt>
                        <dd id="stat-gcash" class="font-semibold text-slate-900">₱{{number_format($stats['by_method']['gcash'] ?? 0, 2)}}</dd>
                    </div>
                </dl>
            </div>
        </section>

        <!-- Filters + Table -->
        <section class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <!-- Filter bar -->
            <form method="GET" action="{{ route('sale-record') }}" 
                class="p-4 border-b border-slate-200 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3 items-center">

                <!-- Search Input -->
                <div class="relative lg:col-span-2">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input id="filter-search" name="search" type="text" placeholder="Search invoice number..."
                        value="{{ request('search') }}"
                        class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300">
                </div>

                <!-- Payment Select -->
                <select id="filter-payment" name="payment"
                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    <option value="">All payment methods</option>
                    <option value="cash" {{ request('payment') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="gcash" {{ request('payment') === 'gcash' ? 'selected' : '' }}>GCash</option>
                    <option value="card" {{ request('payment') === 'card' ? 'selected' : '' }}>Card</option>
                </select>

                <!-- From Date -->
                <input id="filter-from" name="from" type="date" aria-label="From date"
                    value="{{ request('from') }}"
                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300">

                <!-- To Date -->
                <input id="filter-to" name="to" type="date" aria-label="To date"
                    value="{{ request('to') }}"
                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-300">

                <!-- Action Buttons (Filter + Reset) -->
                <div class="flex gap-2">
                    <button type="submit"
                        class="w-full px-3 py-2 text-xs font-semibold text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition text-center">
                        Filter
                    </button>
                    
                    <a href="{{ route('sale-record') }}"
                        class="w-full px-3 py-2 text-xs font-semibold text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 transition text-center whitespace-nowrap">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Invoice</th>
                            <th class="px-4 py-3 font-semibold">Date &amp; Time</th>
                            <th class="px-4 py-3 font-semibold text-right">Items</th>
                            <th class="px-4 py-3 font-semibold text-right">Total</th>
                            <th class="px-4 py-3 font-semibold">Payment</th>
                            <th class="px-4 py-3 font-semibold text-right">Amount Paid</th>
                            <th class="px-4 py-3 font-semibold text-right">Change</th>
                            <th class="px-4 py-3 font-semibold text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody id="sales-body" class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($sales as $sale)
                            <tr data-sale-row
                                data-invoice="{{ $sale->invoice_number }}"
                                data-datetime="{{ $sale->created_at->format('M d, Y g:i A') }}"
                                data-method="{{ $sale->payment_method }}"
                                data-subtotal="{{ $sale->subtotal }}"
                                data-total="{{ $sale->total_amount }}"
                                data-paid="{{ $sale->amount_paid }}"
                                data-change="{{ $sale->change_amount }}"
                                data-qty="{{ $sale->items->sum('quantity') }}"
                                data-date="{{ $sale->created_at->format('Y-m-d') }}"
                                data-items="{{ json_encode($sale->items->map(fn ($i) => [
                                    'name'  => $i->product->name ?? 'Deleted product',
                                    'photo' => $i->product?->photo_path ? asset('storage/' . $i->product->photo_path) : null,
                                    'qty'   => $i->quantity,
                                    'price' => $i->unit_price,
                                ])) }}">

                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $sale->invoice_number }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $sale->created_at->format('M d, Y g:i A')}}</td>
                                <td class="px-4 py-3 text-right">{{ $sale->items->sum('quantity') }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-900">
                                    ₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">{{ ucfirst($sale->payment_method) }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">₱{{ number_format($sale->amount_paid, 2) }}</td>
                                <td class="px-4 py-3 text-right">₱{{ number_format($sale->change_amount, 2) }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button type="button" data-view-sale
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 border border-slate-200 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 transition">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="p-3 bg-slate-100 rounded-full text-slate-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm font-semibold text-slate-700">No sales records found</p>
                                            <p class="text-xs text-slate-500">Try adjusting your filters or search terms.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Empty state -->
                <div id="sales-empty" class="hidden px-4 py-12 text-center">
                    <i data-lucide="receipt-text" class="w-8 h-8 text-slate-300 mx-auto"></i>
                    <p class="text-sm font-semibold text-slate-700 mt-2">No sales found</p>
                    <p class="text-xs text-slate-500 mt-0.5">Try a different invoice number, date range, or payment method.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-500">
                <p>Showing <span class="font-semibold text-slate-700">{{ $sales->count() }}</span> of
                    <span class="font-semibold text-slate-700">{{ $sales->total() }}</span> sales</p>
                <div class="flex gap-2">
                    {{ $sales->links() }}
                </div>
            </div>
        </section>
        
    </div>

    <div id="sale-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
        role="dialog" aria-modal="true" aria-labelledby="modal-invoice">

        <!-- Backdrop -->
        <div data-modal-close class="absolute inset-0 bg-slate-900/50"></div>

        <!-- Panel -->
        <div class="relative w-full max-w-lg bg-white rounded-xl shadow-xl border border-slate-200 max-h-[90vh] flex flex-col">

            <div class="flex items-start justify-between p-4 border-b border-slate-200">
                <div>
                    <h2 id="modal-invoice" class="text-sm font-bold text-slate-900"></h2>
                    <p id="modal-datetime" class="text-xs text-slate-500 mt-0.5"></p>
                </div>
                <button type="button" data-modal-close aria-label="Close"
                        class="p-1 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <div class="p-4 overflow-y-auto space-y-4">
                <table class="w-full text-xs text-left">
                    <thead class="text-slate-500">
                        <tr>
                            <th class="py-2 font-semibold">Image</th>
                            <th class="py-2 font-semibold">Item</th>
                            <th class="py-2 font-semibold text-right">Qty</th>
                            <th class="py-2 font-semibold text-right">Price</th>
                            <th class="py-2 font-semibold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modal-items" class="divide-y divide-slate-100 text-slate-700"></tbody>
                </table>

                <dl class="space-y-1 text-xs border-t border-slate-200 pt-3">
                    <div class="flex justify-between"><dt class="text-slate-500">Payment method</dt><dd id="modal-method" class="font-semibold text-slate-900"></dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Subtotal</dt><dd id="modal-subtotal" class="font-semibold text-slate-900"></dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Total</dt><dd id="modal-total" class="font-bold text-slate-900"></dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Amount paid</dt><dd id="modal-paid" class="font-semibold text-slate-900"></dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Change</dt><dd id="modal-change" class="font-semibold text-slate-900"></dd></div>
                </dl>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('sale-modal');
            const itemsBody = document.getElementById('modal-items');

            const peso = (n) =>
                '₱' + Number(n).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                
            const placeholder = () => {
                const div = document.createElement('div');
                div.className = 'w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300 text-[10px]';
                div.textContent = 'N/A';
                return div;
            };

            const setText = (id, value) => (document.getElementById(id).textContent = value);

            function openModal(row) {
                const d = row.dataset; // data-invoice -> d.invoice, data-datetime -> d.datetime, ...

                setText('modal-invoice', d.invoice);
                setText('modal-datetime', d.datetime);
                setText('modal-method', d.method.charAt(0).toUpperCase() + d.method.slice(1));
                setText('modal-subtotal', peso(d.subtotal));
                setText('modal-total', peso(d.total));
                setText('modal-paid', peso(d.paid));
                setText('modal-change', peso(d.change));

                // Build the item rows
                itemsBody.innerHTML = '';
                JSON.parse(d.items).forEach((item) => {
                    const tr = document.createElement('tr');

                    // Image cell
                    const imgTd = document.createElement('td');
                    imgTd.className = 'py-2 pr-2';
                    if (item.photo) {
                        const img = document.createElement('img');
                        img.src = item.photo;
                        img.alt = item.name;
                        img.className = 'w-10 h-10 rounded-lg object-cover border border-slate-200';
                        img.onerror = () => img.replaceWith(placeholder()); // broken link fallback
                        imgTd.appendChild(img);
                    } else {
                        imgTd.appendChild(placeholder());
                    }
                    tr.appendChild(imgTd);

                    // The remaining cells
                    [
                        [item.name, 'py-2'],
                        [item.qty, 'py-2 text-right'],
                        [peso(item.price), 'py-2 text-right'],
                        [peso(item.qty * item.price), 'py-2 text-right font-semibold text-slate-900'],
                    ].forEach(([value, classes]) => {
                        const td = document.createElement('td');
                        td.className = classes;
                        td.textContent = value;
                        tr.appendChild(td);
                    });

                    itemsBody.appendChild(tr);
                });

                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden'); // stop background scroll
                lucide.createIcons();
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }

            // Open: one listener on the table body (event delegation)
            document.getElementById('sales-body').addEventListener('click', (e) => {
                const btn = e.target.closest('[data-view-sale]');
                if (!btn) return;
                openModal(btn.closest('[data-sale-row]'));
            });

            // Close: X button or backdrop
            modal.addEventListener('click', (e) => {
                if (e.target.closest('[data-modal-close]')) closeModal();
            });

            // Close: Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });
        });
    </script>
</x-sidebar>