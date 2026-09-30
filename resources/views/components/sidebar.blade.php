@php
    // Shared CSS classes
    $navBase = 'nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition group';
    $navActive = 'bg-indigo-600 text-white shadow-sm';
    $navInactive = 'hover:bg-slate-800 hover:text-white';
    $iconActive = 'text-white';
    $iconInactive = 'text-slate-400 group-hover:text-white';

    // Route checks
    $isDashboard = request()->routeIs('dashboard.*');
    $isInventory = request()->routeIs('inventory.*');
    $isPos = request()->routeIs('pos');
    $isSales = request()->routeIs('sale-record');
    $isUtang = request()->routeIs('utang.*');
    $isGcash = request()->routeIs('gcash.*');
    $isEload = request()->routeIs('eload.*');
@endphp

<x-layout>
    <div class="h-screen w-full bg-slate-50 flex overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800 transition-all duration-300 ease-in-out relative">

            <!-- Collapse / Expand Toggle Button -->
            <button id="sidebar-toggle" onclick="toggleSidebar()"
                class="absolute -right-3 top-6 bg-indigo-600 hover:bg-indigo-500 text-white p-1 rounded-full border-2 border-slate-900 shadow-md transition-transform duration-300 z-10"
                aria-label="Toggle sidebar">
                <i id="toggle-icon" data-lucide="chevron-left"
                    class="w-3.5 h-3.5 transition-transform duration-300"></i>
            </button>

            <!-- Brand Logo -->
            <div id="sidebar-header" class="p-4 border-b border-slate-800/80 flex items-center h-16 gap-3">
                <div class="bg-indigo-600 text-white p-2 rounded-xl shadow-md shrink-0">
                    <i data-lucide="boxes" class="w-5 h-5"></i>
                </div>
                <div class="sidebar-text overflow-hidden whitespace-nowrap">
                    <h1 class="text-base font-black text-white tracking-wide leading-none">INVENTRA</h1>
                    <span class="text-[10px] text-slate-400 font-medium">Store Management</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 p-3 space-y-4 text-xs font-semibold overflow-y-auto overflow-x-hidden">

                <!-- GROUP 1: MAIN -->
                <div>
                    <p class="sidebar-text px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Main</p>
                    <hr class="sidebar-divider hidden border-slate-800 mb-2 my-1" />

                    <a href="{{ route('dashboard.index') }}"
                        class="{{ $navBase }} {{ $isDashboard ? $navActive : $navInactive }}"
                        title="Dashboard" @if($isDashboard) aria-current="page" @endif>
                        <i data-lucide="layout-dashboard"
                            class="w-5 h-5 shrink-0 transition {{ $isDashboard ? $iconActive : $iconInactive }}"></i>
                        <span class="sidebar-text truncate">Dashboard</span>
                    </a>
                </div>

                <!-- GROUP 2: STORE OPERATIONS -->
                <div>
                    <p class="sidebar-text px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Operations</p>
                    <hr class="sidebar-divider hidden border-slate-800 mb-2 my-1" />
                    <div class="space-y-1">
                        <!-- Inventory -->
                        <a href="{{ route('inventory.index') }}"
                            class="{{ $navBase }} {{ $isInventory ? $navActive : $navInactive }}"
                            title="Inventory" @if($isInventory) aria-current="page" @endif>
                            <i data-lucide="package"
                                class="w-5 h-5 shrink-0 transition {{ $isInventory ? $iconActive : $iconInactive }}"></i>
                            <span class="sidebar-text truncate">Inventory</span>
                        </a>

                        <!-- Point of Sale (POS) -->
                        <a href="{{ route('pos') }}"
                            class="{{ $navBase }} {{ $isPos ? $navActive : $navInactive }}"
                            title="Point of Sale (POS)" @if($isPos) aria-current="page" @endif>
                            <i data-lucide="shopping-cart"
                                class="w-5 h-5 shrink-0 transition {{ $isPos ? $iconActive : $iconInactive }}"></i>
                            <span class="sidebar-text truncate">Point of Sale (POS)</span>
                        </a>

                        <!-- Sales Record -->
                        <a href="{{ route('sale-record') }}"
                            class="{{ $navBase }} {{ $isSales ? $navActive : $navInactive }}"
                            title="Sales Record" @if($isSales) aria-current="page" @endif>
                            <i data-lucide="receipt"
                                class="w-5 h-5 shrink-0 transition {{ $isSales ? $iconActive : $iconInactive }}"></i>
                            <span class="sidebar-text truncate">Sales Record</span>
                        </a>

                        <!-- Utang Records -->
                        <a href="{{ route('utang.index') }}"
                            class="{{ $navBase }} {{ $isUtang ? $navActive : $navInactive }}"
                            title="Utang Records" @if($isUtang) aria-current="page" @endif>
                            <i data-lucide="notebook-text"
                                class="w-5 h-5 shrink-0 transition {{ $isUtang ? $iconActive : $iconInactive }}"></i>
                            <span class="sidebar-text truncate">Utang</span>
                        </a>
                    </div>
                </div>

                <!-- GROUP 3: DIGITAL SERVICES -->
                <div>
                    <p class="sidebar-text px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Digital Services</p>
                    <hr class="sidebar-divider hidden border-slate-800 mb-2 my-1" />
                    <div class="space-y-1">
                        <!-- GCash Service -->
                        <a href="{{ route('gcash.index') }}"
                            class="{{ $navBase }} {{ $isGcash ? $navActive : $navInactive }}"
                            title="GCash Service" @if($isGcash) aria-current="page" @endif>
                            <i data-lucide="smartphone"
                                class="w-5 h-5 shrink-0 transition {{ $isGcash ? $iconActive : $iconInactive }}"></i>
                            <span class="sidebar-text truncate">GCash Service</span>
                        </a>

                        <!-- E-Load Express -->
                        <a href="{{ route('eload.index') }}"
                            class="{{ $navBase }} {{ $isEload ? $navActive : $navInactive }}"
                            title="E-Load Express" @if($isEload) aria-current="page" @endif>
                            <i data-lucide="zap"
                                class="w-5 h-5 shrink-0 transition {{ $isEload ? $iconActive : $iconInactive }}"></i>
                            <span class="sidebar-text truncate">E-Load Express</span>
                        </a>
                    </div>
                </div>

            </nav>

            <!-- User Profile / Logout Footer -->
            <div id="sidebar-footer" class="p-3 border-t border-slate-800/80 flex items-center justify-between">
                <div id="user-info" class="flex items-center gap-2.5 overflow-hidden">
                    <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 font-bold text-xs flex items-center justify-center shrink-0"
                        title="{{ Auth::user()->name ?? 'Store Owner' }}">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="sidebar-text truncate">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Store Owner' }}</p>
                        <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@inventra.com' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="flex shrink-0">
                    @csrf
                    <button type="submit"
                        class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-md transition"
                        title="Logout" aria-label="Logout">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 h-screen overflow-y-auto p-6 space-y-6">
            {{ $slot }}
        </main>
    </div>

    <script>
        function applySidebarState(collapse) {
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggle-icon');
            const header = document.getElementById('sidebar-header');
            const footer = document.getElementById('sidebar-footer');
            const userInfo = document.getElementById('user-info');
            const textElements = document.querySelectorAll('.sidebar-text');
            const dividers = document.querySelectorAll('.sidebar-divider');
            const navItems = document.querySelectorAll('.nav-item');

            if (collapse) {
                sidebar.classList.replace('w-64', 'w-20');
                toggleIcon.classList.add('rotate-180');
                header.classList.replace('gap-3', 'justify-center');
                footer.classList.add('flex-col', 'gap-3');
                userInfo.classList.add('justify-center');

                navItems.forEach(item => item.classList.add('justify-center', 'px-0'));
                textElements.forEach(el => el.classList.add('hidden'));
                dividers.forEach(el => el.classList.remove('hidden'));
            } else {
                sidebar.classList.replace('w-20', 'w-64');
                toggleIcon.classList.remove('rotate-180');
                header.classList.replace('justify-center', 'gap-3');
                footer.classList.remove('flex-col', 'gap-3');
                userInfo.classList.remove('justify-center');

                navItems.forEach(item => item.classList.remove('justify-center', 'px-0'));
                textElements.forEach(el => el.classList.remove('hidden'));
                dividers.forEach(el => el.classList.add('hidden'));
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const shouldCollapse = !sidebar.classList.contains('w-20');
            applySidebarState(shouldCollapse);
            localStorage.setItem('sidebar_collapsed', shouldCollapse ? 'true' : 'false');
        }

        // Restore saved preference on load
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('sidebar_collapsed') === 'true') {
                applySidebarState(true);
            }
        });
    </script>
</x-layout>