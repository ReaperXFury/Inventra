<x-sidebar>
    <x-flash-alert/>

    <div class="px-5 pb-5">
        <header class="">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Point of Sale</h1>
                <p class="text-xs text-slate-500 mt-0.5">Select products to add to card and process checkout.</p>
            </div>
        </header>

        <div class="flex gap-5 mt-5">
            <!-- Product Section -->
            <section
                class="w-full h-screen border border-slate-300 rounded-2xl p-3 flex flex-col gap-3 overflow-hidden bg-slate-50/50">

                <!-- Search and Filtering Header -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 space-y-3 shrink-0">
                    <div class="flex items-center gap-3">
                        <!-- Search Input with Search Icon & Keyboard Shortcut -->
                        <div class="relative flex-1">
                            <i data-lucide="search"
                                class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                            <input id="pos-search" type="text" autocomplete="off"
                                placeholder="Search name or SKU, or scan a barcode..."
                                class="w-full pl-9 pr-10 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all outline-none">
                            <kbd id="search-hint"
                                class="absolute right-3 top-1/2 -translate-y-1/2 px-1.5 py-0.5 rounded border border-slate-200 bg-white text-[10px] font-semibold text-slate-400 shadow-2xs pointer-events-none">/</kbd>
                        </div>

                        <!-- Filter Dropdown with Icon -->
                        <div class="relative min-w-[140px]">
                            <i data-lucide="filter"
                                class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                            <select id="pos-filter"
                                class="w-full pl-8 pr-8 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all appearance-none outline-none cursor-pointer text-slate-600 font-medium">
                                <option value="all">All Categories</option>
                                <option value="sku">By SKU</option>
                                <option value="name">By Name</option>
                            </select>
                            <i data-lucide="chevron-down"
                                class="w-3.5 h-3.5 absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                        </div>

                        <!-- Search Result Counter -->
                        <span id="result-count"
                            class="text-xs font-medium text-slate-500 whitespace-nowrap bg-slate-100 px-2.5 py-1 rounded-lg">
                            {{ $products->count() }} items
                        </span>
                    </div>
                </div>

                <!-- Scrollable Product Grid Container -->
                <div class="flex-1 overflow-y-auto pr-1 custom-scrollbar">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($products as $product)
                            <div class="product-item group relative bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-indigo-200 transition-all duration-200 p-4 flex flex-col justify-between"
                                data-name="{{ $product->name }}" data-sku="{{ $product->sku ?? '' }}"
                                data-barcode="{{ $product->barcode ?? '' }}">

                                <div>
                                    <!-- Image Wrapper with Stock Badge -->
                                    <div
                                        class="relative w-full aspect-square bg-slate-50 rounded-xl overflow-hidden border border-slate-100 mb-3 flex items-center justify-center">
                                        <img src="{{ $product->photo_path ? asset('storage/' . $product->photo_path) : asset('images/placeholder.png') }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                        @if(isset($product->stock))
                                            <span
                                                class="absolute top-2 right-2 text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-200/60' : 'bg-rose-50 text-rose-600 border border-rose-200/60' }}">
                                                {{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="space-y-1">
                                        <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider block">
                                            {{ $product->category->name ?? $product->category ?? 'General' }}
                                        </span>
                                        <h3 class="text-sm font-semibold text-slate-800 line-clamp-1 group-hover:text-indigo-600 transition-colors"
                                            title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </h3>
                                    </div>
                                </div>

                                <!-- Price & Action Button -->
                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-400 block font-medium">Price</span>
                                        <span class="text-base font-bold text-slate-900">
                                            ₱{{ number_format($product->selling_price, 2) }}
                                        </span>
                                    </div>

                                    <button type="button"
                                        class="add-to-cart-btn p-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-indigo-600 hover:text-white transition-all active:scale-95 cursor-pointer"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-price="{{ $product->selling_price }}"
                                        data-stock="{{ $product->stock_quantity }}"
                                        data-photo="{{ $product->photo_path ? asset('storage/' . $product->photo_path) : '' }}"
                                        title="Add to Cart">

                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </section>

            <!-- Cart Section -->
            <section
                class="w-[50%] min-w-[340px] h-screen border border-slate-300 rounded-2xl bg-white flex flex-col overflow-hidden shadow-sm">

                <!-- Header -->
                <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-indigo-600"></i>
                        <h2 class="font-bold text-slate-800 text-sm">Current Order</h2>
                        <span id="cart-count"
                            class="hidden px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold">0</span>
                    </div>
                    <button type="button" id="clear-cart"
                        class="hidden text-xs font-medium text-rose-600 hover:underline">Clear All</button>
                </div>

                <!-- Items -->
                <div class="flex-1 min-h-0 overflow-y-auto">
                    <div id="cart-empty"
                        class="h-full min-h-[200px] flex flex-col items-center justify-center text-center p-8 space-y-2">
                        <div class="p-3 bg-slate-100 rounded-full">
                            <i data-lucide="shopping-bag" class="w-7 h-7 text-slate-400"></i>
                        </div>
                        <p class="text-xs font-medium text-slate-600">Your cart is empty</p>
                        <p class="text-[11px] text-slate-400">Click + on a product to add it to the order.</p>
                    </div>
                    <div id="cart-items"></div>
                </div>

                <!-- Checkout -->
                <div class="border-t border-slate-200 bg-slate-50/70 p-4 shrink-0 space-y-3">

                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Due</p>
                            <p id="cart-summary" class="text-[11px] text-slate-400">0 items</p>
                        </div>
                        <span id="cart-total" class="text-3xl font-black text-slate-900 tracking-tight">₱0.00</span>
                    </div>

                    <form id="order-form" action="{{ route('pos') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="cart_data" id="cart-data-input">

                        <!-- Payment method -->
                        <div>
                            <label for="payment-method"
                                class="block text-[11px] font-semibold text-slate-500 mb-1">Payment Method</label>
                            <div class="relative">
                                <select name="payment_method" id="payment-method"
                                    class="w-full appearance-none pl-3 pr-9 py-2.5 text-xs font-medium rounded-xl border border-slate-200 bg-white text-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none cursor-pointer">
                                    <option value="cash">Cash</option>
                                    <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash
                                    </option>
                                </select>
                                <i data-lucide="chevron-down"
                                    class="w-3.5 h-3.5 absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- Cash -->
                        <div id="cash-fields" class="space-y-2">
                            <div>
                                <label for="amount-paid"
                                    class="block text-[11px] font-semibold text-slate-500 mb-1">Amount Received</label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-semibold">₱</span>
                                    <input type="number" name="amount_paid" id="amount-paid" min="0" step="0.01"
                                        inputmode="decimal" placeholder="0.00"
                                        class="w-full pl-7 pr-3 py-2.5 text-sm font-semibold rounded-xl border border-slate-200 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none">
                                </div>
                            </div>

                            <div id="quick-cash" class="flex flex-wrap gap-1.5">
                                <button type="button" id="exact-btn" data-cash="exact"
                                    class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-600 disabled:opacity-40 transition">Exact</button>
                                <button type="button" data-cash="50"
                                    class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-600 transition">₱50</button>
                                <button type="button" data-cash="100"
                                    class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-600 transition">₱100</button>
                                <button type="button" data-cash="200"
                                    class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-600 transition">₱200</button>
                                <button type="button" data-cash="500"
                                    class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-600 transition">₱500</button>
                                <button type="button" data-cash="1000"
                                    class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-600 transition">₱1000</button>
                            </div>

                            <div
                                class="flex justify-between items-center bg-white border border-slate-200 rounded-xl px-3 py-2.5">
                                <span id="change-label" class="text-xs font-medium text-slate-600">Change</span>
                                <span id="change-amount" class="text-sm font-bold text-emerald-600">₱0.00</span>
                            </div>
                        </div>

                        <!-- GCash -->
                        <div id="gcash-note"
                            class="hidden items-start gap-2 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl px-3 py-2.5">
                            <i data-lucide="smartphone" class="w-4 h-4 mt-0.5 shrink-0"></i>
                            <p class="text-xs">The customer pays the exact total through GCash. Confirm the payment
                                arrived before
                                placing the order.</p>
                        </div>

                        <button type="submit" id="place-order-btn" disabled
                            class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:bg-slate-300 disabled:text-slate-500 disabled:shadow-none disabled:cursor-not-allowed">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                            <span id="place-order-label">Place Order</span>
                        </button>
                    </form>
                </div>
            </section>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('pos-search');
            const filterSelect = document.getElementById('pos-filter');
            const searchHint = document.getElementById('search-hint');
            const resultCount = document.getElementById('result-count');

            // Select all product card elements (adjust selector to match your product items HTML)
            const productItems = document.querySelectorAll('.product-item');

            // Function to filter products
            function filterProducts() {
                const query = searchInput.value.trim().toLowerCase();
                const filterType = filterSelect.value;
                let visibleCount = 0;

                productItems.forEach(item => {
                    // Retrieve data attributes from product card elements
                    const name = (item.dataset.name || '').toLowerCase();
                    const sku = (item.dataset.sku || '').toLowerCase();
                    const barcode = (item.dataset.barcode || '').toLowerCase();

                    let isMatch = false;

                    if (filterType === 'all') {
                        isMatch = name.includes(query) || sku.includes(query) || barcode.includes(query);
                    } else if (filterType === 'sku') {
                        isMatch = sku.includes(query);
                    } else if (filterType === 'barcode') {
                        isMatch = barcode.includes(query);
                    } else if (filterType === 'name') {
                        isMatch = name.includes(query);
                    }

                    // Toggle visibility
                    if (isMatch) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Update item count badge
                resultCount.textContent = `${visibleCount} item${visibleCount === 1 ? '' : 's'}`;
            }

            // Input & Filter Event Listeners
            searchInput.addEventListener('input', filterProducts);
            filterSelect.addEventListener('change', filterProducts);

            // Keyboard Shortcut: Press '/' to focus search
            document.addEventListener('keydown', (e) => {
                if (e.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                    e.preventDefault();
                    searchInput.focus();
                }
            });

            // Hide/Show keyboard shortcut indicator on focus/blur
            searchInput.addEventListener('focus', () => searchHint.classList.add('hidden'));
            searchInput.addEventListener('blur', () => searchHint.classList.remove('hidden'));


            const money = n => '₱' + Number(n).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const esc = s => String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
            const cents = n => Math.round((Number(n) || 0) * 100);

            // ---------- Elements (all const first, so nothing is used before it exists) ----------
            const cartItemsEl = document.getElementById('cart-items');
            const cartEmptyEl = document.getElementById('cart-empty');
            const cartTotalEl = document.getElementById('cart-total');
            const cartCountEl = document.getElementById('cart-count');
            const cartSummaryEl = document.getElementById('cart-summary');
            const clearBtn = document.getElementById('clear-cart');

            const orderForm = document.getElementById('order-form');
            const cartDataInput = document.getElementById('cart-data-input');
            const placeOrderBtn = document.getElementById('place-order-btn');
            const placeOrderLabel = document.getElementById('place-order-label');

            const paymentSelect = document.getElementById('payment-method');
            const cashFields = document.getElementById('cash-fields');
            const gcashNote = document.getElementById('gcash-note');
            const amountInput = document.getElementById('amount-paid');
            const changeLabel = document.getElementById('change-label');
            const changeAmount = document.getElementById('change-amount');
            const exactBtn = document.getElementById('exact-btn');

            // ---------- State (restored if the server sent you back with an error) ----------
            let cart = @json(json_decode(old('cart_data', '[]'), true) ?: []);

            const cartTotal = () => cart.reduce((sum, i) => sum + cents(i.price) * i.qty, 0) / 100;

            // ---------- Cart actions ----------
            function addToCart(product) {
                const existingItem = cart.find(item => item.id === product.id);

                if (existingItem) {
                    if (existingItem.qty >= product.stock) {
                        alert('Stock limit reached for this item.');
                        return;
                    }
                    existingItem.qty += 1;
                } else {
                    if (product.stock <= 0) {
                        alert('Product is out of stock.');
                        return;
                    }
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        stock: product.stock,
                        photo: product.photo,
                        qty: 1
                    });
                }
                renderCart();
            }

            // ---------- Drawing ----------
            function renderCart() {
                const isEmpty = cart.length === 0;
                cartEmptyEl.classList.toggle('hidden', !isEmpty);

                cartItemsEl.innerHTML = isEmpty ? '' : cart.map(line => `
        <div class="flex items-center gap-3 px-4 py-3 border-b border-slate-100">
            ${line.photo
                        ? `<img src="${esc(line.photo)}" alt="" class="w-11 h-11 rounded-lg object-cover border border-slate-200 shrink-0">`
                        : `<div class="w-11 h-11 rounded-lg bg-slate-100 border border-slate-200 shrink-0 flex items-center justify-center font-bold text-slate-400">${esc(line.name.charAt(0))}</div>`}
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold text-slate-800 truncate">${esc(line.name)}</p>
                <p class="text-[11px] text-slate-500">${money(line.price)} each</p>
                <div class="mt-1.5 inline-flex items-center rounded-lg border border-slate-200 overflow-hidden">
                    <button type="button" data-action="dec" data-id="${line.id}" aria-label="Decrease quantity"
                        class="w-7 h-7 hover:bg-slate-100 font-bold">−</button>
                    <span class="w-8 text-center text-xs font-bold">${line.qty}</span>
                    <button type="button" data-action="inc" data-id="${line.id}" aria-label="Increase quantity"
                        ${line.qty >= line.stock ? 'disabled' : ''}
                        class="w-7 h-7 hover:bg-slate-100 font-bold disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:bg-transparent">+</button>
                </div>
            </div>
            <div class="text-right shrink-0">
                <p class="text-sm font-bold text-slate-900">${money(line.price * line.qty)}</p>
                <button type="button" data-action="remove" data-id="${line.id}"
                    class="mt-1 text-[11px] text-slate-400 hover:text-rose-600">Remove</button>
            </div>
        </div>`).join('');

                const count = cart.reduce((n, i) => n + i.qty, 0);
                cartTotalEl.textContent = money(cartTotal());
                cartSummaryEl.textContent = count + (count === 1 ? ' item' : ' items');
                cartCountEl.textContent = count;
                cartCountEl.classList.toggle('hidden', count === 0);
                clearBtn.classList.toggle('hidden', isEmpty);

                updatePayment();
            }

            function updatePayment() {
                const isCash = paymentSelect.value === 'cash';
                cashFields.classList.toggle('hidden', !isCash);
                gcashNote.classList.toggle('hidden', isCash);
                gcashNote.classList.toggle('flex', !isCash);

                const total = cartTotal();
                const diff = (cents(amountInput.value) - cents(total)) / 100;

                changeLabel.textContent = diff >= 0 ? 'Change' : 'Short by';
                changeAmount.textContent = money(Math.abs(diff));
                changeAmount.className = 'text-sm font-bold ' + (diff >= 0 ? 'text-emerald-600' : 'text-rose-500');

                exactBtn.disabled = total === 0;
                placeOrderBtn.disabled = !(cart.length > 0 && (!isCash || diff >= 0));
                placeOrderLabel.textContent = 'Place Order' + (cart.length ? ' · ' + money(total) : '');
            }

            // ---------- Events ----------
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', () => {
                    addToCart({
                        id: parseInt(button.dataset.id, 10),
                        name: button.dataset.name,
                        price: parseFloat(button.dataset.price),
                        stock: parseInt(button.dataset.stock || 0, 10),
                        photo: button.dataset.photo
                    });
                });
            });

            // One listener for every +, − and Remove button in the cart
            cartItemsEl.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-action]');
                if (!btn) return;

                const id = parseInt(btn.dataset.id, 10);
                const line = cart.find(item => item.id === id);
                if (!line) return;

                if (btn.dataset.action === 'inc') {
                    if (line.qty >= line.stock) return alert('Stock limit reached for this item.');
                    line.qty++;
                } else if (btn.dataset.action === 'dec') {
                    line.qty--;
                    if (line.qty <= 0) cart = cart.filter(item => item.id !== id);
                } else if (btn.dataset.action === 'remove') {
                    cart = cart.filter(item => item.id !== id);
                }
                renderCart();
            });

            clearBtn.addEventListener('click', () => {
                if (!confirm('Remove all items from the order?')) return;
                cart = [];
                amountInput.value = '';
                renderCart();
            });

            paymentSelect.addEventListener('change', updatePayment);
            amountInput.addEventListener('input', updatePayment);

            document.getElementById('quick-cash').addEventListener('click', (e) => {
                const btn = e.target.closest('[data-cash]');
                if (!btn) return;
                amountInput.value = btn.dataset.cash === 'exact' ? cartTotal().toFixed(2) : btn.dataset.cash;
                updatePayment();
            });

            orderForm.addEventListener('submit', (e) => {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Your cart is empty');
                    return;
                }
                if (paymentSelect.value === 'cash' && cents(amountInput.value) < cents(cartTotal())) {
                    e.preventDefault();
                    alert('Amount received is less than the total due.');
                    return;
                }

                cartDataInput.value = JSON.stringify(cart);
                placeOrderBtn.disabled = true;            // stops double-clicks creating two sales
                placeOrderLabel.textContent = 'Processing…';
            });

            renderCart(); // last line: everything above now exists

        });
    </script>
</x-sidebar>