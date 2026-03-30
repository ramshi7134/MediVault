<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MediVault') – MediVault</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <style>
        *, :before, :after { box-sizing: border-box; border: 0 solid #e5e7eb; }
        body { margin: 0; font-family: Figtree, ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; background-color: #f9fafb; color: #111827; }
        a { color: inherit; text-decoration: inherit; }
        /* layout */
        .min-h-screen { min-height: 100vh; }
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .flex-wrap { flex-wrap: wrap; }
        .flex-1 { flex: 1 1 0%; }
        .flex-shrink-0 { flex-shrink: 0; }
        .items-start { align-items: flex-start; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .justify-center { justify-content: center; }
        .w-full { width: 100%; }
        .max-w-7xl { max-width: 80rem; }
        .max-w-3xl { max-width: 48rem; }
        .max-w-sm { max-width: 24rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        /* spacing */
        .mt-1 { margin-top: .25rem; }
        .mt-2 { margin-top: .5rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        .mb-1 { margin-bottom: .25rem; }
        .mb-2 { margin-bottom: .5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mr-2 { margin-right: .5rem; }
        .ml-2 { margin-left: .5rem; }
        .mx-2 { margin-left: .5rem; margin-right: .5rem; }
        .px-2 { padding-left: .5rem; padding-right: .5rem; }
        .px-3 { padding-left: .75rem; padding-right: .75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-1 { padding-top: .25rem; padding-bottom: .25rem; }
        .py-2 { padding-top: .5rem; padding-bottom: .5rem; }
        .py-3 { padding-top: .75rem; padding-bottom: .75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        /* text */
        .text-xs { font-size: .75rem; line-height: 1rem; }
        .text-sm { font-size: .875rem; line-height: 1.25rem; }
        .text-base { font-size: 1rem; line-height: 1.5rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .uppercase { text-transform: uppercase; }
        .tracking-wider { letter-spacing: .05em; }
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .whitespace-pre-wrap { white-space: pre-wrap; }
        /* colors */
        .text-white { color: #fff; }
        .text-gray-400 { color: #9ca3af; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-900 { color: #111827; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-700 { color: #1d4ed8; }
        .text-green-600 { color: #16a34a; }
        .text-green-700 { color: #15803d; }
        .text-red-600 { color: #dc2626; }
        .text-yellow-600 { color: #ca8a04; }
        .text-purple-600 { color: #9333ea; }
        .text-indigo-600 { color: #4f46e5; }
        .bg-white { background-color: #fff; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-blue-600 { background-color: #2563eb; }
        .bg-blue-50 { background-color: #eff6ff; }
        .bg-green-50 { background-color: #f0fdf4; }
        .bg-red-50 { background-color: #fef2f2; }
        .bg-yellow-50 { background-color: #fefce8; }
        .bg-purple-50 { background-color: #faf5ff; }
        .bg-indigo-50 { background-color: #eef2ff; }
        .bg-indigo-600 { background-color: #4f46e5; }
        /* borders */
        .border { border-width: 1px; }
        .border-b { border-bottom-width: 1px; }
        .border-t { border-top-width: 1px; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        .border-blue-200 { border-color: #bfdbfe; }
        .border-green-200 { border-color: #bbf7d0; }
        .border-red-200 { border-color: #fecaca; }
        .border-yellow-200 { border-color: #fef08a; }
        .border-purple-200 { border-color: #e9d5ff; }
        .border-indigo-200 { border-color: #c7d2fe; }
        /* shapes */
        .rounded { border-radius: .25rem; }
        .rounded-md { border-radius: .375rem; }
        .rounded-lg { border-radius: .5rem; }
        .rounded-xl { border-radius: .75rem; }
        .rounded-full { border-radius: 9999px; }
        /* shadows */
        .shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / .05); }
        .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1); }
        /* misc */
        .overflow-hidden { overflow: hidden; }
        .divide-y > * + * { border-top-width: 1px; border-color: #e5e7eb; }
        .gap-1 { gap: .25rem; }
        .gap-2 { gap: .5rem; }
        .gap-3 { gap: .75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .size-5 { width: 1.25rem; height: 1.25rem; }
        .size-6 { width: 1.5rem; height: 1.5rem; }
        .size-8 { width: 2rem; height: 2rem; }
        .size-10 { width: 2.5rem; height: 2.5rem; }
        .size-12 { width: 3rem; height: 3rem; }
        .inline-block { display: inline-block; }
        .inline-flex { display: inline-flex; }
        .block { display: block; }
        .hidden { display: none; }
        .space-y-1 > * + * { margin-top: .25rem; }
        .space-y-2 > * + * { margin-top: .5rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-x-2 > * + * { margin-left: .5rem; }
        /* transitions / interactions */
        .transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; transition-duration: .15s; }
        .cursor-pointer { cursor: pointer; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:bg-red-700:hover { background-color: #b91c1c; }
        .hover\:bg-gray-100:hover { background-color: #f3f4f6; }
        .hover\:bg-gray-200:hover { background-color: #e5e7eb; }
        .hover\:text-blue-700:hover { color: #1d4ed8; }
        .hover\:text-red-600:hover { color: #dc2626; }
        .hover\:bg-indigo-700:hover { background-color: #4338ca; }
        .hover\:bg-green-700:hover { background-color: #15803d; }
        .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
        .focus\:ring-2:focus { box-shadow: 0 0 0 2px #93c5fd; }
        .focus\:border-blue-500:focus { border-color: #3b82f6; }
        /* form controls */
        input[type="text"], input[type="email"], input[type="date"], input[type="tel"],
        input[type="password"], input[type="number"], select, textarea {
            width: 100%; padding: .5rem .75rem; border: 1px solid #d1d5db; border-radius: .375rem;
            font-size: .875rem; line-height: 1.25rem; color: #111827; background-color: #fff;
            outline: none; transition: border-color .15s;
        }
        input:focus, select:focus, textarea:focus { border-color: #3b82f6; box-shadow: 0 0 0 2px #bfdbfe; }
        label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .25rem; }
        /* nav active state */
        .nav-link { display: flex; align-items: center; gap: .5rem; padding: .5rem .75rem; border-radius: .375rem;
                    font-size: .875rem; font-weight: 500; color: #4b5563; transition: background-color .15s, color .15s; }
        .nav-link:hover { background-color: #f3f4f6; color: #111827; }
        .nav-link.active { background-color: #eff6ff; color: #2563eb; }
        /* badges */
        .badge { display: inline-flex; align-items: center; padding: .125rem .5rem; border-radius: 9999px;
                 font-size: .75rem; font-weight: 500; }
        /* table */
        table { width: 100%; border-collapse: collapse; }
        th { padding: .75rem 1rem; text-align: left; font-size: .75rem; font-weight: 600;
             color: #6b7280; text-transform: uppercase; letter-spacing: .05em; background-color: #f9fafb;
             border-bottom: 1px solid #e5e7eb; }
        td { padding: .875rem 1rem; font-size: .875rem; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f9fafb; }
        /* btn helpers */
        .btn { display: inline-flex; align-items: center; gap: .375rem; padding: .5rem 1rem;
               border-radius: .375rem; font-size: .875rem; font-weight: 500; border: none; cursor: pointer;
               transition: background-color .15s; text-decoration: none; }
        .btn-primary { background-color: #2563eb; color: #fff; }
        .btn-primary:hover { background-color: #1d4ed8; }
        .btn-danger { background-color: #dc2626; color: #fff; }
        .btn-danger:hover { background-color: #b91c1c; }
        .btn-secondary { background-color: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
        .btn-secondary:hover { background-color: #e5e7eb; }
        .btn-success { background-color: #16a34a; color: #fff; }
        .btn-success:hover { background-color: #15803d; }
        .btn-sm { padding: .375rem .75rem; font-size: .8125rem; }
        /* alert */
        .alert { padding: .875rem 1rem; border-radius: .375rem; font-size: .875rem; margin-bottom: 1rem; }
        .alert-success { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-error { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        /* sidebar width */
        .sidebar { width: 14rem; flex-shrink: 0; }
        /* responsive grid */
        @media (min-width: 640px) { .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (min-width: 1024px) { .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
                                     .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                                     .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; } }
    </style>
    @endif
</head>
<body style="background-color:#f9fafb; min-height:100vh;">

    <!-- Top nav -->
    <nav style="background:#fff; border-bottom:1px solid #e5e7eb; box-shadow:0 1px 2px 0 rgb(0 0 0/.05);">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <svg class="size-8" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="40" height="40" rx="10" fill="#2563eb"/>
                        <path d="M20 8v24M8 20h24" stroke="white" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="20" cy="20" r="7" stroke="white" stroke-width="2.5" fill="none"/>
                    </svg>
                    <span class="text-xl font-bold text-blue-600" style="letter-spacing:-.025em;">MediVault</span>
                </a>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Sidebar -->
            <aside class="sidebar">
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('records.index') }}"
                       class="nav-link {{ request()->routeIs('records.*') ? 'active' : '' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Medical Records
                    </a>
                    <a href="{{ route('family.index') }}"
                       class="nav-link {{ request()->routeIs('family.*') ? 'active' : '' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Family Members
                    </a>
                    <a href="{{ route('timeline') }}"
                       class="nav-link {{ request()->routeIs('timeline') ? 'active' : '' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Timeline
                    </a>
                    <a href="{{ url('/api/documentation') }}"
                       class="nav-link" target="_blank">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        API Docs
                    </a>
                </nav>
            </aside>

            <!-- Main content -->
            <main class="flex-1" style="min-width:0;">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
