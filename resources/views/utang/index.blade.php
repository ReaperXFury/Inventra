<x-sidebar>
    <div class="flex-1 flex flex-col gap-5 min-w-0 px-5 pb-5">
        <!-- Flash Messages -->
        <x-flash-alert />

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-wide">Utang Management</h1>
                <p class="text-xs text-slate-500 mt-1">Track debts, monitor passed due date debts, and manage your store
                    debts.</p>
            </div>
            <button type="button" id="openBtn"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold shadow-md transition flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add New Utang
            </button>
        </div>

        <!-- Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Total Utang -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="receipt-text" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Utang</p>
                    <p class="text-lg font-bold text-slate-900">{{$total}}</p>
                </div>
            </div>

            <!-- Overdue / Passed Due Date -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="triangle-alert" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Overdue</p>
                    <p class="text-lg font-bold text-amber-600">{{$overdue}}</p>
                </div>
            </div>

            <!-- Total Debt Value -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Est. Utang Value</p>
                    <p class="text-lg font-bold text-slate-900">₱{{$value}}</p>
                </div>
            </div>
        </div>

        <!-- Utang Table -->
        <div class="w-full bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900 tracking-wide">Utang Details</h2>
                <p class="text-xs text-slate-500 mt-1">Track debts, monitor pricing, and manage your store catalog.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Description</th>
                            <th class="py-3 px-4">Due Date</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($utangs as $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-4 font-medium text-slate-900">{{ $item->name }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">₱{{ $item->amount }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $item->description }}</td>
                                <td class="py-3.5 px-4">{{ $item->due_date }}</td>
                                <td class="py-3.5 px-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <!-- Edit Button -->
                                        <button type="button"
                                            class="editBtn inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-indigo-200 hover:text-indigo-800 rounded-lg transition-colors border border-slate-200/60 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                                            title="Edit Utang" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                            data-amount="{{ $item->amount }}" data-due_date="{{ $item->due_date }}"
                                            data-status="{{ $item->status }}" data-description="{{ $item->description }}">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            <span>Edit</span>
                                        </button>

                                        <!-- Delete Form / Button -->
                                        <form action="{{ route('utang.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this Utang? This cannot be undone.')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors border border-slate-200/60 focus:outline-none focus:ring-2 focus:ring-rose-500/20"
                                                title="Delete Utang">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                                        <p class="text-sm font-medium">No Utang records found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <!-- Dark Overlay Backdrop -->
            <div id="modalBackdrop"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-200 opacity-0"></div>

            <!-- Modal Center Container -->
            <div class="flex min-h-full items-center justify-center p-4">
                <!-- Modal Card Panel -->
                <div id="modalPanel"
                    class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all duration-200 opacity-0 scale-95 z-10">

                    <!-- Wrap everything in the form -->
                    <form id="modalForm" action="{{ route('utang.store') }}" method="POST">
                        @csrf
                        <!-- Container for dynamic @method('PUT') injection -->
                        <div id="methodContainer"></div>

                        <!-- Modal Header -->
                        <div
                            class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">
                                Modal Title
                            </h3>
                            <button type="button"
                                class="closeModalBtn text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-4">
                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    placeholder="Enter item name"
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount Field -->
                            <div>
                                <label for="amount"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                          <span class="text-gray-500 dark:text-gray-400 text-sm">₱</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" name="amount" id="amount"
                                        value="{{ old('amount') }}" required placeholder="0.00"
                                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white pl-7 pr-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Due Date Field -->
                            <div>
                                <label for="due_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                @error('due_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Field -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Select status
                                    </option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description Field -->
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    placeholder="Optional description..."
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div
                            class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                            <button type="button"
                                class="closeModalBtn px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg transition">
                                Cancel
                            </button>
                            <!-- Type set to submit -->
                            <button type="submit" id="submitBtn"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                Save Item
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modal');
            const modalBackdrop = document.getElementById('modalBackdrop');
            const modalPanel = document.getElementById('modalPanel');
            const modalTitle = document.getElementById('modalTitle');
            const modalForm = document.getElementById('modalForm');
            const methodContainer = document.getElementById('methodContainer');
            const submitBtn = document.getElementById('submitBtn');

            // Form input references
            const inputName = document.getElementById('name');
            const inputAmount = document.getElementById('amount');
            const inputDueDate = document.getElementById('due_date');
            const inputStatus = document.getElementById('status');
            const inputDescription = document.getElementById('description');

            const openAddBtn = document.getElementById('openBtn');
            const editBtns = document.querySelectorAll('.editBtn');
            const closeModalBtns = document.querySelectorAll('.closeModalBtn');

            // Base routes
            const storeRoute = "{{ route('utang.store') }}";
            // Place a placeholder string to replace dynamically with JS
            const updateRouteTemplate = "{{ route('utang.update', ':id') }}";

            function openModal() {
                modal.classList.remove('hidden');
                requestAnimationFrame(() => {
                    modalBackdrop.classList.remove('opacity-0');
                    modalBackdrop.classList.add('opacity-100');
                    modalPanel.classList.remove('opacity-0', 'scale-95');
                    modalPanel.classList.add('opacity-100', 'scale-100');
                });
            }

            function closeModal() {
                modalBackdrop.classList.remove('opacity-100');
                modalBackdrop.classList.add('opacity-0');
                modalPanel.classList.remove('opacity-100', 'scale-100');
                modalPanel.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }

            // --- MODE 1: Setup for ADD ---
            if (openAddBtn) {
                openAddBtn.addEventListener('click', () => {
                    modalTitle.textContent = "Add New Item";
                    submitBtn.textContent = "Save Item";

                    // Set POST route & remove Laravel @method('PUT') input
                    modalForm.action = storeRoute;
                    methodContainer.innerHTML = '';

                    // Clear all fields
                    modalForm.reset();

                    openModal();
                });
            }

            // --- MODE 2: Setup for EDIT ---
            editBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const target = e.currentTarget;

                    modalTitle.textContent = "Edit Item";
                    submitBtn.textContent = "Update Item";

                    // Build dynamic update URL: replace :id placeholder with actual ID
                    const itemId = target.getAttribute('data-id');
                    modalForm.action = updateRouteTemplate.replace(':id', itemId);

                    // Inject Laravel's @method('PUT') spoofing field
                    methodContainer.innerHTML = `<input type="hidden" name="_method" value="PUT">`;

                    // Populate form input values from data attributes
                    inputName.value = target.getAttribute('data-name') || '';
                    inputAmount.value = target.getAttribute('data-amount') || '';
                    inputDueDate.value = target.getAttribute('data-due_date') || '';
                    inputStatus.value = target.getAttribute('data-status') || '';
                    inputDescription.value = target.getAttribute('data-description') || '';

                    openModal();
                });
            });

            // Close handlers
            closeModalBtns.forEach(btn => btn.addEventListener('click', closeModal));
            if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
</x-sidebar>