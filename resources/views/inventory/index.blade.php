<x-sidebar>
    <div class="flex-1 flex flex-col gap-5 min-w-0 px-5 pb-5">
        <!-- Flash Messages -->
        <x-flash-alert/>

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-wide">Inventory Management</h1>
                <p class="text-xs text-slate-500 mt-1">Monitor product stock, track pricing, and manage store catalog.
                </p>
            </div>
            <button type="button" onclick="openModal()"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold shadow-md transition flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add New Item
            </button>
        </div>

        <!-- Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Products</p>
                    <p class="text-lg font-bold text-slate-900">{{ number_format($totalItems) }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="triangle-alert" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Low Stock Alerts</p>
                    <p class="text-lg font-bold text-amber-600">{{ number_format($lowStockCount) }}</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Est. Inventory Value</p>
                    <p class="text-lg font-bold text-slate-900">₱{{ number_format($totalInventoryValue, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <form method="GET" action="{{ route('inventory.index') }}"
            class="bg-slate-50 border border-slate-200 p-4 rounded-xl flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by product name or SKU..." aria-label="Search products"
                    class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit"
                class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-xs font-semibold transition">
                Filter Results
            </button>
            @if(request('search'))
                <a href="{{ route('inventory.index') }}"
                    class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold transition text-center">
                    Clear
                </a>
            @endif
        </form>

        <!-- Inventory Table -->
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead
                        class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Photo</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Product Name</th>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Cost</th>
                            <th class="px-4 py-3">Selling Price</th>
                            <th class="px-4 py-3">Stock Level</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    @if($product->photo_path)
                                        <img src="{{ asset('storage/' . $product->photo_path) }}" alt="{{ $product->name }}"
                                            class="w-9 h-9 rounded-lg object-cover border border-slate-200 shrink-0">
                                    @else
                                        <div
                                            class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 shrink-0 flex items-center justify-center text-slate-400">
                                            <i data-lucide="image" class="w-4 h-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-mono text-indigo-600">{{ $product->sku }}</td>
                                <td class="px-4 py-3 font-bold text-slate-900">{{ $product->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px]">
                                        {{ $product->category }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">₱{{ number_format($product->cost_price, 2) }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    ₱{{ number_format($product->selling_price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($product->stock_quantity <= $product->min_stock_level)
                                        <span
                                            class="px-2 py-0.5 bg-rose-50 text-rose-600 border border-rose-200 rounded font-bold">
                                            {{ $product->stock_quantity }} (Low)
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded font-bold">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <!-- Edit Button -->
                                        <button type="button" onclick="openEditModal(this)"
                                            data-action="{{ route('inventory.update', $product) }}"
                                            data-product="{{ json_encode($product->only(['sku', 'category', 'name', 'cost_price', 'selling_price', 'stock_quantity', 'min_stock_level'])) }}"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-indigo-200 hover:text-indigo-800 rounded-lg transition-colors border border-slate-200/60 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                                            title="Edit Product">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            <span>Edit</span>
                                        </button>

                                        <!-- Delete Form / Button -->
                                        <form action="{{ route('inventory.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Delete this product? This cannot be undone.')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors border border-slate-200/60 focus:outline-none focus:ring-2 focus:ring-rose-500/20"
                                                title="Delete Product">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-slate-400">
                                    No inventory products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-t border-slate-200">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>

        <!-- Add Item Modal -->
        <div id="add-modal" role="dialog" aria-modal="true" aria-labelledby="add-modal-title"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4 z-50">
            <div class="bg-white border border-slate-200 w-full max-w-lg rounded-xl p-6 shadow-xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-200 pb-3">
                    <h3 id="add-modal-title" class="text-base font-bold text-slate-900">Add New Inventory Item</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-700 transition"
                        aria-label="Close">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-3 text-xs">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label class="block text-slate-400">Product Photo</label>
                                <span class="text-[10px] text-slate-500">Max size: 10MB</span>
                            </div>
                            <input type="file" name="image" accept="image/*"
                                class="w-full bg-slate-950 border  border-slate-800 rounded px-3 py-1.5 text-slate-300 text-xs focus:outline-none focus:border-indigo-500 file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Category</label>
                            <input type="text" name="category" value="{{ old('category') }}" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-600 mb-1">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-600 mb-1">Cost Price (₱)</label>
                            <input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price') }}"
                                required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Selling Price (₱)</label>
                            <input type="number" step="0.01" min="0" name="selling_price"
                                value="{{ old('selling_price') }}" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-600 mb-1">Stock Quantity</label>
                            <input type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity') }}"
                                required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Min Stock Alert Level</label>
                            <input type="number" min="0" name="min_stock_level" value="{{ old('min_stock_level', 5) }}"
                                required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-slate-200 pt-3 mt-4">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded font-semibold">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded font-semibold">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div id="edit-modal" role="dialog" aria-modal="true" aria-labelledby="edit-modal-title"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center p-4 z-50">
            <div class="bg-white border border-slate-200 w-full max-w-lg rounded-xl p-6 shadow-xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-200 pb-3">
                    <h3 id="edit-modal-title" class="text-base font-bold text-slate-900">Edit Inventory Item</h3>
                    <button type="button" onclick="closeEditModal()"
                        class="text-slate-400 hover:text-slate-700 transition" aria-label="Close">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form id="edit-form" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-600 mb-1">Replace Photo (optional)</label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full bg-white border border-slate-300 rounded px-3 py-1.5 text-slate-700 text-xs focus:outline-none focus:border-indigo-500 file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">SKU</label>
                            <input type="text" name="sku" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Category</label>
                            <input type="text" name="category" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Product Name</label>
                            <input type="text" name="name" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Cost Price (₱)</label>
                            <input type="number" step="0.01" min="0" name="cost_price" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Selling Price (₱)</label>
                            <input type="number" step="0.01" min="0" name="selling_price" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Stock Quantity</label>
                            <input type="number" min="0" name="stock_quantity" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-slate-600 mb-1">Min Stock Alert Level</label>
                            <input type="number" min="0" name="min_stock_level" required
                                class="w-full bg-white border border-slate-300 rounded px-3 py-2 text-slate-900 focus:outline-none focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-slate-200 pt-3 mt-4">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded font-semibold">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded font-semibold">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        const addModal = document.getElementById('add-modal');

        function openModal() {
            addModal.classList.remove('hidden');
            addModal.classList.add('flex');
        }

        function closeModal() {
            addModal.classList.add('hidden');
            addModal.classList.remove('flex');
        }

        // Close on backdrop click or Escape
        addModal.addEventListener('click', (e) => {
            if (e.target === addModal) closeModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        // Reopen the modal with the user's input if validation failed
        @if($errors->any())
            openModal();
        @endif

        const editModal = document.getElementById('edit-modal');
        const editForm = document.getElementById('edit-form');

        function openEditModal(btn) {
            const p = JSON.parse(btn.dataset.product);
            editForm.action = btn.dataset.action;

            ['sku', 'category', 'name', 'cost_price', 'selling_price', 'stock_quantity', 'min_stock_level']
                .forEach(field => editForm.elements[field].value = p[field]);

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        }

        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) closeEditModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeEditModal();
        });
    </script>
</x-sidebar>