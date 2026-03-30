<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MediVault – Your Personal Medical Records Manager</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                *, :before, :after { box-sizing: border-box; border: 0 solid #e5e7eb; }
                body { margin: 0; font-family: Figtree, ui-sans-serif, system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
                a { color: inherit; text-decoration: inherit; }
                .min-h-screen { min-height: 100vh; }
                .flex { display: flex; }
                .grid { display: grid; }
                .hidden { display: none; }
                .items-center { align-items: center; }
                .justify-between { justify-content: space-between; }
                .justify-center { justify-content: center; }
                .justify-end { justify-content: flex-end; }
                .flex-col { flex-direction: column; }
                .flex-1 { flex: 1 1 0%; }
                .shrink-0 { flex-shrink: 0; }
                .gap-2 { gap: .5rem; }
                .gap-4 { gap: 1rem; }
                .gap-6 { gap: 1.5rem; }
                .gap-8 { gap: 2rem; }
                .relative { position: relative; }
                .absolute { position: absolute; }
                .w-full { width: 100%; }
                .max-w-7xl { max-width: 80rem; }
                .mx-auto { margin-left: auto; margin-right: auto; }
                .mt-2 { margin-top: .5rem; }
                .mt-4 { margin-top: 1rem; }
                .mt-6 { margin-top: 1.5rem; }
                .mt-8 { margin-top: 2rem; }
                .mt-10 { margin-top: 2.5rem; }
                .mt-12 { margin-top: 3rem; }
                .mb-2 { margin-bottom: .5rem; }
                .px-4 { padding-left: 1rem; padding-right: 1rem; }
                .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
                .py-2 { padding-top: .5rem; padding-bottom: .5rem; }
                .py-3 { padding-top: .75rem; padding-bottom: .75rem; }
                .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
                .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
                .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
                .py-16 { padding-top: 4rem; padding-bottom: 4rem; }
                .py-20 { padding-top: 5rem; padding-bottom: 5rem; }
                .p-6 { padding: 1.5rem; }
                .p-8 { padding: 2rem; }
                .text-center { text-align: center; }
                .text-sm { font-size: .875rem; line-height: 1.25rem; }
                .text-base { font-size: 1rem; line-height: 1.5rem; }
                .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
                .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
                .text-2xl { font-size: 1.5rem; line-height: 2rem; }
                .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
                .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
                .text-5xl { font-size: 3rem; line-height: 1; }
                .font-medium { font-weight: 500; }
                .font-semibold { font-weight: 600; }
                .font-bold { font-weight: 700; }
                .leading-relaxed { line-height: 1.625; }
                .leading-tight { line-height: 1.25; }
                .tracking-tight { letter-spacing: -.025em; }
                .rounded-md { border-radius: .375rem; }
                .rounded-lg { border-radius: .5rem; }
                .rounded-xl { border-radius: .75rem; }
                .rounded-full { border-radius: 9999px; }
                .border { border-width: 1px; }
                .border-gray-200 { border-color: #e5e7eb; }
                .bg-white { background-color: #fff; }
                .bg-gray-50 { background-color: #f9fafb; }
                .bg-blue-600 { background-color: #2563eb; }
                .bg-blue-50 { background-color: #eff6ff; }
                .bg-green-50 { background-color: #f0fdf4; }
                .bg-purple-50 { background-color: #faf5ff; }
                .bg-orange-50 { background-color: #fff7ed; }
                .text-white { color: #fff; }
                .text-gray-500 { color: #6b7280; }
                .text-gray-600 { color: #4b5563; }
                .text-gray-700 { color: #374151; }
                .text-gray-900 { color: #111827; }
                .text-blue-600 { color: #2563eb; }
                .text-blue-700 { color: #1d4ed8; }
                .text-green-600 { color: #16a34a; }
                .text-purple-600 { color: #9333ea; }
                .text-orange-600 { color: #ea580c; }
                .shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / .05); }
                .shadow { box-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1); }
                .shadow-lg { box-shadow: 0 10px 15px -3px rgb(0 0 0 / .1), 0 4px 6px -4px rgb(0 0 0 / .1); }
                .ring-1 { box-shadow: 0 0 0 1px rgb(0 0 0 / .05); }
                .overflow-hidden { overflow: hidden; }
                .transition { transition-property: color, background-color, border-color, box-shadow; transition-duration: .15s; transition-timing-function: cubic-bezier(.4,0,.2,1); }
                .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
                .hover\:text-blue-700:hover { color: #1d4ed8; }
                .hover\:shadow-md:hover { box-shadow: 0 4px 6px -1px rgb(0 0 0 / .1), 0 2px 4px -2px rgb(0 0 0 / .1); }
                .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
                .size-10 { width: 2.5rem; height: 2.5rem; }
                .size-12 { width: 3rem; height: 3rem; }
                .h-1 { height: .25rem; }
                .w-16 { width: 4rem; }
                .items-start { align-items: flex-start; }
                .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
                @media (min-width: 640px) {
                    .sm\:flex { display: flex; }
                    .sm\:hidden { display: none; }
                    .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                    .sm\:text-5xl { font-size: 3rem; line-height: 1; }
                }
                @media (min-width: 768px) {
                    .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                    .md\:flex-row { flex-direction: row; }
                }
                @media (min-width: 1024px) {
                    .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                    .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
                    .lg\:text-6xl { font-size: 3.75rem; line-height: 1; }
                }
                @media (prefers-color-scheme: dark) {
                    .dark\:bg-gray-900 { background-color: #111827; }
                    .dark\:bg-gray-800 { background-color: #1f2937; }
                    .dark\:text-white { color: #fff; }
                    .dark\:text-gray-300 { color: #d1d5db; }
                    .dark\:text-gray-400 { color: #9ca3af; }
                    .dark\:border-gray-700 { border-color: #374151; }
                    .dark\:hover\:bg-gray-700:hover { background-color: #374151; }
                    .dark\:bg-blue-900 { background-color: #1e3a5f; }
                    .dark\:bg-green-900 { background-color: #14532d; }
                    .dark\:bg-purple-900 { background-color: #3b0764; }
                    .dark\:bg-orange-900 { background-color: #431407; }
                    .dark\:text-blue-400 { color: #60a5fa; }
                    .dark\:text-green-400 { color: #4ade80; }
                    .dark\:text-purple-400 { color: #c084fc; }
                    .dark\:text-orange-400 { color: #fb923c; }
                }
            </style>
        @endif
    </head>
    <body class="font-sans" style="background-color: #f9fafb; color: #111827;">
        <div class="min-h-screen flex flex-col" style="background-color: #f9fafb;">

            <!-- Navigation -->
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 lg:px-8">
                    <div class="flex items-center justify-between py-4">
                        <!-- Logo / Brand -->
                        <div class="flex items-center gap-2">
                            <svg class="size-10 text-blue-600" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="10" fill="#2563eb"/>
                                <path d="M20 8v24M8 20h24" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <circle cx="20" cy="20" r="7" stroke="white" stroke-width="2.5" fill="none"/>
                            </svg>
                            <span class="text-2xl font-bold text-blue-600" style="letter-spacing: -.025em;">MediVault</span>
                        </div>

                        <!-- Auth Links -->
                        @if (Route::has('login'))
                            <div class="flex items-center gap-2">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                       class="rounded-md px-4 py-2 text-sm font-medium bg-blue-600 text-white transition hover:bg-blue-700 focus:outline-none">
                                        Go to Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="rounded-md px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 transition hover:bg-blue-50 focus:outline-none">
                                        Log In
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                           class="rounded-md px-4 py-2 text-sm font-medium bg-blue-600 text-white transition hover:bg-blue-700 focus:outline-none">
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="flex-1">
                <section class="py-20 px-4 lg:px-8 text-center" style="background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex justify-center mb-6">
                            <svg style="width:64px;height:64px;" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="10" fill="#2563eb"/>
                                <path d="M20 8v24M8 20h24" stroke="white" stroke-width="4" stroke-linecap="round"/>
                                <circle cx="20" cy="20" r="7" stroke="white" stroke-width="2.5" fill="none"/>
                            </svg>
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight tracking-tight">
                            MediVault
                        </h1>
                        <p class="mt-4 text-xl text-blue-600 font-semibold">Your Personal Medical Records Manager</p>
                        <p class="mt-6 text-lg text-gray-600 leading-relaxed" style="max-width:42rem;margin-left:auto;margin-right:auto;">
                            MediVault is a secure platform to store, organize, and share your medical records and prescriptions.
                            Keep your health history — and your family's — in one safe, accessible place.
                        </p>

                        @if (Route::has('login'))
                            <div class="mt-10 flex justify-center gap-4 flex-col md:flex-row" style="align-items:center;">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                       class="rounded-lg px-8 py-3 text-base font-semibold bg-blue-600 text-white shadow transition hover:bg-blue-700 focus:outline-none">
                                        Go to Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('register') }}"
                                       class="rounded-lg px-8 py-3 text-base font-semibold bg-blue-600 text-white shadow transition hover:bg-blue-700 focus:outline-none">
                                        Get Started — Register Free
                                    </a>
                                    <a href="{{ route('login') }}"
                                       class="rounded-lg px-8 py-3 text-base font-semibold text-blue-600 border border-blue-600 transition hover:bg-blue-50 focus:outline-none" style="background:#fff;">
                                        Log In to Your Account
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </section>

                <!-- About Section -->
                <section class="py-16 px-4 lg:px-8 bg-white">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-3xl font-bold text-gray-900 text-center">What is MediVault?</h2>
                        <div class="mt-2 flex justify-center">
                            <div class="h-1 w-16 rounded-full" style="background-color:#2563eb;"></div>
                        </div>
                        <p class="mt-6 text-base text-gray-600 leading-relaxed text-center" style="max-width:56rem;margin-left:auto;margin-right:auto;">
                            MediVault is a comprehensive medical records management system designed for individuals and families.
                            It lets you upload and organize medical documents, track prescriptions and medicines, manage records
                            for family members, and securely share records with healthcare providers or trusted contacts — all
                            from one intuitive dashboard.
                        </p>
                    </div>
                </section>

                <!-- Features Section -->
                <section class="py-16 px-4 lg:px-8" style="background-color:#f9fafb;">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-3xl font-bold text-gray-900 text-center">Key Features</h2>
                        <div class="mt-2 flex justify-center">
                            <div class="h-1 w-16 rounded-full" style="background-color:#2563eb;"></div>
                        </div>

                        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                            <!-- Feature 1 -->
                            <div class="bg-white rounded-xl p-6 shadow ring-1 border border-gray-200 transition hover:shadow-md">
                                <div class="flex items-center justify-center size-12 rounded-full" style="background-color:#eff6ff;">
                                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 12h6m-3-3v6M5 8V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-2" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Medical Records Storage</h3>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    Upload and organize your medical documents — visit summaries, lab results, imaging reports,
                                    and more — tagged by date, hospital, doctor, and document type.
                                </p>
                            </div>

                            <!-- Feature 2 -->
                            <div class="bg-white rounded-xl p-6 shadow ring-1 border border-gray-200 transition hover:shadow-md">
                                <div class="flex items-center justify-center size-12 rounded-full" style="background-color:#f0fdf4;">
                                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Prescription Tracking</h3>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    Keep track of all your prescriptions and medicines. Store dosages, frequencies, and
                                    associated medical records in one structured place.
                                </p>
                            </div>

                            <!-- Feature 3 -->
                            <div class="bg-white rounded-xl p-6 shadow ring-1 border border-gray-200 transition hover:shadow-md">
                                <div class="flex items-center justify-center size-12 rounded-full" style="background-color:#faf5ff;">
                                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 0 1 5.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 0 1 9.288 0M15 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Family Member Profiles</h3>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    Manage health records for your entire family under a single account. Create profiles for
                                    family members and keep their medical histories separate and organized.
                                </p>
                            </div>

                            <!-- Feature 4 -->
                            <div class="bg-white rounded-xl p-6 shadow ring-1 border border-gray-200 transition hover:shadow-md">
                                <div class="flex items-center justify-center size-12 rounded-full" style="background-color:#fff7ed;">
                                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 1 1 0-2.684m0 2.684 6.632 3.316m-6.632-6 6.632-3.316m0 0a3 3 0 1 0 5.367-2.684 3 3 0 0 0-5.367 2.684Zm0 9.316a3 3 0 1 0 5.367 2.684 3 3 0 0 0-5.367-2.684Z" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Secure Record Sharing</h3>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    Share specific medical records securely with doctors, specialists, or family members.
                                    Control who has access and revoke permissions at any time.
                                </p>
                            </div>

                            <!-- Feature 5 -->
                            <div class="bg-white rounded-xl p-6 shadow ring-1 border border-gray-200 transition hover:shadow-md">
                                <div class="flex items-center justify-center size-12 rounded-full" style="background-color:#eff6ff;">
                                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">OCR Text Extraction</h3>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    Automatically extract text from uploaded documents using OCR technology, making your
                                    medical records fully searchable and easy to retrieve.
                                </p>
                            </div>

                            <!-- Feature 6 -->
                            <div class="bg-white rounded-xl p-6 shadow ring-1 border border-gray-200 transition hover:shadow-md">
                                <div class="flex items-center justify-center size-12 rounded-full" style="background-color:#f0fdf4;">
                                    <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900">Privacy & Security</h3>
                                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                    Your health data is protected with robust authentication and access controls.
                                    Only you and the people you choose can view your sensitive medical information.
                                </p>
                            </div>

                        </div>
                    </div>
                </section>

                <!-- Call to Action -->
                <section class="py-20 px-4 lg:px-8 text-center" style="background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-3xl font-bold text-white">Take Control of Your Health Records</h2>
                        <p class="mt-4 text-lg leading-relaxed" style="color: #bfdbfe; max-width: 36rem; margin-left: auto; margin-right: auto;">
                            Join MediVault today and keep your medical history organized, accessible, and secure.
                        </p>
                        @if (Route::has('login'))
                            <div class="mt-8 flex justify-center gap-4 flex-col md:flex-row" style="align-items:center;">
                                @guest
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                           class="rounded-lg px-8 py-3 text-base font-semibold text-blue-700 transition focus:outline-none"
                                           style="background:#fff;">
                                            Create a Free Account
                                        </a>
                                    @endif
                                    <a href="{{ route('login') }}"
                                       class="rounded-lg px-8 py-3 text-base font-semibold text-white border transition focus:outline-none"
                                       style="border-color: rgba(255,255,255,0.6);">
                                        Log In
                                    </a>
                                @else
                                    <a href="{{ url('/dashboard') }}"
                                       class="rounded-lg px-8 py-3 text-base font-semibold text-blue-700 transition focus:outline-none"
                                       style="background:#fff;">
                                        Go to Dashboard
                                    </a>
                                @endguest
                            </div>
                        @endif
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <footer class="py-6 text-center text-sm text-gray-500 bg-white border-t border-gray-200">
                &copy; {{ date('Y') }} MediVault. All rights reserved.
            </footer>

        </div>
    </body>
</html>
