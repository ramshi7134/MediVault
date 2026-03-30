<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard – MediVault</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            *, :before, :after { box-sizing: border-box; border: 0 solid #e5e7eb; }
            body { margin: 0; font-family: Figtree, ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; background-color: #f9fafb; color: #111827; }
            a { color: inherit; text-decoration: inherit; }
            .min-h-screen { min-height: 100vh; }
            .flex { display: flex; }
            .items-center { align-items: center; }
            .justify-between { justify-content: space-between; }
            .justify-center { justify-content: center; }
            .flex-col { flex-direction: column; }
            .w-full { width: 100%; }
            .max-w-7xl { max-width: 80rem; }
            .mx-auto { margin-left: auto; margin-right: auto; }
            .mt-8 { margin-top: 2rem; }
            .px-4 { padding-left: 1rem; padding-right: 1rem; }
            .py-3 { padding-top: .75rem; padding-bottom: .75rem; }
            .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
            .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
            .p-6 { padding: 1.5rem; }
            .text-sm { font-size: .875rem; line-height: 1.25rem; }
            .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
            .text-2xl { font-size: 1.5rem; line-height: 2rem; }
            .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
            .font-semibold { font-weight: 600; }
            .font-bold { font-weight: 700; }
            .text-center { text-align: center; }
            .text-white { color: #fff; }
            .text-gray-500 { color: #6b7280; }
            .text-gray-700 { color: #374151; }
            .text-blue-600 { color: #2563eb; }
            .bg-white { background-color: #fff; }
            .bg-blue-600 { background-color: #2563eb; }
            .border-b { border-bottom-width: 1px; }
            .border-gray-200 { border-color: #e5e7eb; }
            .rounded-lg { border-radius: .5rem; }
            .rounded-md { border-radius: .375rem; }
            .shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / .05); }
            .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1); }
            .transition { transition-property: color, background-color, border-color; transition-duration: .15s; }
            .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
            .hover\:bg-red-700:hover { background-color: #b91c1c; }
            .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
            .gap-2 { gap: .5rem; }
            .size-10 { width: 2.5rem; height: 2.5rem; }
            .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        </style>
    @endif
</head>
<body style="background-color:#f9fafb;">

    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center gap-2">
                    <svg class="size-10" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="10" fill="#2563eb"/>
                        <path d="M20 8v24M8 20h24" stroke="white" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="20" cy="20" r="7" stroke="white" stroke-width="2.5" fill="none"/>
                    </svg>
                    <span class="text-2xl font-bold text-blue-600" style="letter-spacing:-.025em;">MediVault</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit"
                            style="padding:.5rem 1rem;border:none;border-radius:.375rem;font-size:.875rem;font-weight:500;color:#fff;background-color:#dc2626;cursor:pointer;transition:background-color .15s;">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <h1 class="text-3xl font-bold" style="color:#111827;">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="mt-2 text-gray-500">You are logged in to MediVault. Use the API to manage your medical records.</p>

        <div class="mt-8 bg-white rounded-lg shadow p-6" style="border:1px solid #e5e7eb;">
            <h2 class="text-xl font-semibold" style="color:#111827;">API Documentation</h2>
            <p class="mt-2 text-sm text-gray-500">
                MediVault is a REST API application. Explore the available endpoints below.
            </p>
            <a href="{{ url('/api/documentation') }}"
               style="display:inline-block;margin-top:1rem;padding:.5rem 1.25rem;border-radius:.375rem;font-size:.875rem;font-weight:500;color:#fff;background-color:#2563eb;text-decoration:none;transition:background-color .15s;">
                Open API Docs
            </a>
        </div>
    </main>

</body>
</html>
