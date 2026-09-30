@if (session('success'))
    <div class="alert-message mt-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-medium transition-opacity duration-500 ease-out">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-message mt-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-medium transition-opacity duration-500 ease-out">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-message mt-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs font-medium transition-opacity duration-500 ease-out">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alerts = document.querySelectorAll('.alert-message');

        if (alerts.length > 0) {
            // Wait 3 seconds (3000ms) before starting fade out
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.classList.add('opacity-0'); // Fades out via Tailwind transition

                    // Remove from DOM after fade completes (500ms)
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                });
            }, 3000);
        }
    });
</script>