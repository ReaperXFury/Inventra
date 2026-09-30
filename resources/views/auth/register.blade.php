<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full bg-white p-6 rounded-2xl border border-slate-200 shadow-lg relative">
            
            <!-- Back to Home Button -->
            <a href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Home</span>
            </a>

            <!-- Header -->
            <div class="text-center">
                <div class="inline-flex bg-indigo-600 text-white p-2.5 rounded-xl shadow-md mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Create Inventra Account</h2>
                <p class="mt-0.5 text-xs text-slate-500">Set up your store account</p>
            </div>

            <!-- Registration Form -->
            <form class="mt-4 space-y-3" action="{{ route('register') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700">Full Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="mt-1 block w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-slate-900 text-xs shadow-sm">
                    @error('name')
                        <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-slate-900 text-xs shadow-sm">
                    @error('email')
                        <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-slate-900 text-xs shadow-sm">
                    @error('password')
                        <p class="mt-1 text-[11px] text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-slate-900 text-xs shadow-sm">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-lg shadow-md shadow-indigo-100 transition mt-1">
                    Register Account
                </button>

                <p class="text-center text-xs text-slate-500 pt-1">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Log in here</a>
                </p>
            </form>

        </div>
    </div>
</x-layout>