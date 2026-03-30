<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In – MediVault</title>
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
            .flex-col { flex-direction: column; }
            .items-center { align-items: center; }
            .justify-center { justify-content: center; }
            .w-full { width: 100%; }
            .max-w-md { max-width: 28rem; }
            .mx-auto { margin-left: auto; margin-right: auto; }
            .mt-1 { margin-top: .25rem; }
            .mt-2 { margin-top: .5rem; }
            .mt-4 { margin-top: 1rem; }
            .mt-6 { margin-top: 1.5rem; }
            .mt-8 { margin-top: 2rem; }
            .mb-1 { margin-bottom: .25rem; }
            .px-4 { padding-left: 1rem; padding-right: 1rem; }
            .py-2 { padding-top: .5rem; padding-bottom: .5rem; }
            .py-3 { padding-top: .75rem; padding-bottom: .75rem; }
            .p-8 { padding: 2rem; }
            .gap-1 { gap: .25rem; }
            .gap-2 { gap: .5rem; }
            .text-sm { font-size: .875rem; line-height: 1.25rem; }
            .text-base { font-size: 1rem; line-height: 1.5rem; }
            .text-2xl { font-size: 1.5rem; line-height: 2rem; }
            .font-medium { font-weight: 500; }
            .font-semibold { font-weight: 600; }
            .font-bold { font-weight: 700; }
            .text-center { text-align: center; }
            .text-white { color: #fff; }
            .text-gray-500 { color: #6b7280; }
            .text-gray-700 { color: #374151; }
            .text-blue-600 { color: #2563eb; }
            .text-red-600 { color: #dc2626; }
            .bg-white { background-color: #fff; }
            .bg-blue-600 { background-color: #2563eb; }
            .border { border-width: 1px; }
            .border-gray-300 { border-color: #d1d5db; }
            .border-red-300 { border-color: #fca5a5; }
            .rounded-lg { border-radius: .5rem; }
            .rounded-md { border-radius: .375rem; }
            .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1); }
            .ring-1 { box-shadow: 0 0 0 1px rgb(0 0 0 / .05); }
            .block { display: block; }
            .transition { transition-property: color, background-color, border-color; transition-duration: .15s; }
            .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
            .hover\:text-blue-700:hover { color: #1d4ed8; }
            .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
            .focus\:ring-2:focus { box-shadow: 0 0 0 2px #93c5fd; }
            input, select { width: 100%; padding: .5rem .75rem; border: 1px solid #d1d5db; border-radius: .375rem; font-size: .875rem; line-height: 1.25rem; color: #111827; background-color: #fff; outline: none; }
            input:focus { border-color: #2563eb; box-shadow: 0 0 0 2px #bfdbfe; }
            label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .25rem; }
            .size-10 { width: 2.5rem; height: 2.5rem; }
        </style>
    @endif
</head>
<body>
    <div class="min-h-screen flex flex-col items-center justify-center" style="background-color:#f9fafb; padding: 2rem 1rem;">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 mb-8" style="display:flex;align-items:center;gap:.5rem;margin-bottom:2rem;">
            <svg class="size-10" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="10" fill="#2563eb"/>
                <path d="M20 8v24M8 20h24" stroke="white" stroke-width="4" stroke-linecap="round"/>
                <circle cx="20" cy="20" r="7" stroke="white" stroke-width="2.5" fill="none"/>
            </svg>
            <span class="text-2xl font-bold text-blue-600" style="letter-spacing:-.025em;">MediVault</span>
        </a>

        <!-- Card -->
        <div class="bg-white rounded-lg shadow ring-1 p-8 w-full max-w-md" style="border:1px solid #e5e7eb;">
            <h1 class="text-2xl font-bold text-center" style="color:#111827;margin-bottom:1.5rem;">Log In to Your Account</h1>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div style="background-color:#fef2f2;border:1px solid #fca5a5;border-radius:.375rem;padding:.75rem 1rem;margin-bottom:1rem;">
                    <ul style="margin:0;padding-left:1.25rem;color:#dc2626;font-size:.875rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>

                <!-- Remember Me -->
                <div class="mt-4" style="display:flex;align-items:center;gap:.5rem;">
                    <input id="remember" type="checkbox" name="remember" style="width:1rem;height:1rem;padding:0;">
                    <label for="remember" style="margin:0;font-weight:400;color:#374151;">Remember me</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="mt-6 w-full rounded-md py-3 font-semibold text-white bg-blue-600 transition hover:bg-blue-700 focus:outline-none"
                    style="width:100%;margin-top:1.5rem;padding:.75rem;border:none;border-radius:.375rem;font-weight:600;color:#fff;background-color:#2563eb;cursor:pointer;font-size:1rem;">
                    Log In
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 transition hover:text-blue-700">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>
