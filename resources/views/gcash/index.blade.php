<x-sidebar>
    <div class="flex-1 flex flex-col gap-5 min-w-0 px-5 pb-5">
        <!-- Flash Messages -->
        <x-flash-alert />

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-wide">GCash Management</h1>
                <p class="text-xs text-slate-500 mt-1">Track Cash In, Cash Out, service fees, and GCash transaction records.</p>
            </div>
            <button type="button" id="openBtn"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold shadow-md transition flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Transaction
            </button>
        </div>

        <!-- Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <!-- Total Cash In -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
                    <i data-lucide="arrow-down-left" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Cash In</p>
                    <p class="text-lg font-bold text-slate-900">
                        ₱{{ number_format($gcashes->where('type', 'cash_in')->sum('amount'), 2) }}
                    </p>
                </div>
            </div>

            <!-- Total Cash Out -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <i data-lucide="arrow-up-right" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Cash Out</p>
                    <p class="text-lg font-bold text-slate-900">
                        ₱{{ number_format($gcashes->where('type', 'cash_out')->sum('amount'), 2) }}
                    </p>
                </div>
            </div>

            <!-- Total Earnings / Service Fees -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
                    <i data-lucide="coins" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Fee Earnings</p>
                    <p class="text-lg font-bold text-amber-600">
                        ₱{{ number_format($gcashes->sum('fee'), 2) }}
                    </p>
                </div>
            </div>

            <!-- Total Transactions Count -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium font-medium">Total Count</p>
                    <p class="text-lg font-bold text-slate-900">
                        {{ $gcashes->count() }}
                    </p>
                </div>
            </div>
        </div>

        <!-- GCash Transaction Table -->
        <div class="w-full bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900 tracking-wide">Transaction Records</h2>
                <p class="text-xs text-slate-500 mt-1">Audit trail for all store GCash transactions and service charges.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase text-xs tracking-wider">
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">GCash No.</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Fee</th>
                            <th class="py-3 px-4">Ref No.</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($gcashes as $gcash)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-4 font-semibold">
                                    @if ($gcash->type === 'cash_in')
                                        <span class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-xs">
                                            <i data-lucide="arrow-down-left" class="w-3 h-3"></i> Cash In
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded text-xs">
                                            <i data-lucide="arrow-up-right" class="w-3 h-3"></i> Cash Out
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-900">{{ $gcash->customer_name }}</td>
                                <td class="py-3.5 px-4 text-slate-600">{{ $gcash->phone_number }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">₱{{ number_format($gcash->amount, 2) }}</td>
                                <td class="py-3.5 px-4 text-amber-600 font-medium">₱{{ number_format($gcash->fee, 2) }}</td>
                                <td class="py-3.5 px-4 text-slate-500 text-xs font-mono">{{ $gcash->reference_number ?? '-' }}</td>
                                <td class="py-3.5 px-4">
                                    @php
                                        $statusClasses = [
                                            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'failed'    => 'bg-rose-50 text-rose-700 border-rose-200',
                                        ][$gcash->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full border {{ $statusClasses }}">
                                        {{ ucfirst($gcash->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <!-- Edit Button -->
                                        <button type="button"
                                            class="editBtn inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-blue-200 hover:text-blue-800 rounded-lg transition-colors border border-slate-200/60 focus:outline-none"
                                            title="Edit Record"
                                            data-id="{{ $gcash->id }}"
                                            data-type="{{ $gcash->type }}"
                                            data-customer_name="{{ $gcash->customer_name }}"
                                            data-phone_number="{{ $gcash->phone_number }}"
                                            data-amount="{{ $gcash->amount }}"
                                            data-fee="{{ $gcash->fee }}"
                                            data-reference_number="{{ $gcash->reference_number }}"
                                            data-status="{{ $gcash->status }}"
                                            data-notes="{{ $gcash->notes }}"
                                            data-update-url="{{ route('gcash.update', $gcash->id) }}">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            <span>Edit</span>
                                        </button>

                                        <!-- Delete Form / Button -->
                                        <form action="{{ route('gcash.destroy', $gcash->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this GCash record? This cannot be undone.')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors border border-slate-200/60 focus:outline-none"
                                                title="Delete Record">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 px-4 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                                        <p class="text-sm font-medium">No GCash records found.</p>
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
            <div id="modalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-200 opacity-0"></div>

            <!-- Modal Center Container -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div id="modalPanel" class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all duration-200 opacity-0 scale-95 z-10">

                    <form id="modalForm" action="{{ route('gcash.store') }}" method="POST">
                        @csrf
                        <div id="methodContainer"></div>

                        <!-- Modal Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">
                                New GCash Transaction
                            </h3>
                            <button type="button" class="closeModalBtn text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-4">
                            <!-- Transaction Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Type</label>
                                <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                    <option value="cash_in" {{ old('type') == 'cash_in' ? 'selected' : '' }}>Cash In (Customer buys GCash)</option>
                                    <option value="cash_out" {{ old('type') == 'cash_out' ? 'selected' : '' }}>Cash Out (Customer withdraws Cash)</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Name -->
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                                    placeholder="e.g. Juan Dela Cruz"
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                @error('customer_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">GCash Mobile Number</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                                    placeholder="09123456789" maxlength="11"
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                @error('phone_number')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount & Fee (Grid) -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 text-sm">₱</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="0.00"
                                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white pl-7 pr-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                    </div>
                                    @error('amount')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="fee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service Fee</label>
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 text-sm">₱</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="fee" id="fee" value="{{ old('fee', 0) }}" required placeholder="0.00"
                                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white pl-7 pr-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                    </div>
                                    @error('fee')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Reference Number & Status (Grid) -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ref. Number</label>
                                    <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}"
                                        placeholder="13-digit Ref No."
                                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                    @error('reference_number')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Notes Field -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes / Remarks</label>
                                <textarea name="notes" id="notes" rows="2"
                                    placeholder="Optional notes..."
                                    class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" class="closeModalBtn px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg transition">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                Save Transaction
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
            const modalForm = document.getElementById('modalForm');
            const modalTitle = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('submitBtn');
            const methodContainer = document.getElementById('methodContainer');

            const openBtn = document.getElementById('openBtn');
            const closeBtns = document.querySelectorAll('.closeModalBtn');
            const editBtns = document.querySelectorAll('.editBtn');

            const storeUrl = "{{ route('gcash.store') }}";

            function openModal() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalBackdrop.classList.remove('opacity-0');
                    modalPanel.classList.remove('opacity-0', 'scale-95');
                    modalPanel.classList.add('opacity-100', 'scale-100');
                }, 10);
            }

            function closeModal() {
                modalBackdrop.classList.add('opacity-0');
                modalPanel.classList.remove('opacity-100', 'scale-100');
                modalPanel.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }

            // Open for Create Mode
            openBtn.addEventListener('click', () => {
                modalForm.action = storeUrl;
                modalTitle.textContent = 'New GCash Transaction';
                submitBtn.textContent = 'Save Transaction';
                methodContainer.innerHTML = '';

                modalForm.reset();
                openModal();
            });

            // Open for Edit Mode
            editBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const updateUrl = btn.dataset.updateUrl;

                    modalForm.action = updateUrl;
                    modalTitle.textContent = 'Edit GCash Transaction';
                    submitBtn.textContent = 'Update Transaction';

                    methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';

                    // Populate fields
                    document.getElementById('type').value = btn.dataset.type || 'cash_in';
                    document.getElementById('customer_name').value = btn.dataset.customer_name || '';
                    document.getElementById('phone_number').value = btn.dataset.phone_number || '';
                    document.getElementById('amount').value = btn.dataset.amount || '';
                    document.getElementById('fee').value = btn.dataset.fee || '0';
                    document.getElementById('reference_number').value = btn.dataset.reference_number || '';
                    document.getElementById('status').value = btn.dataset.status || 'completed';
                    document.getElementById('notes').value = btn.dataset.notes || '';

                    openModal();
                });
            });

            closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
            modalBackdrop.addEventListener('click', closeModal);

            @if ($errors->any())
                openModal();
            @endif
        });
    </script>
</x-sidebar>