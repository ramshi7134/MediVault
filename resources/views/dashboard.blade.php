@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div>
    <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}!</h1>
    <p class="mt-1 text-gray-500">Manage your medical records, family members, and more.</p>
</div>

<!-- Stats -->
<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-xl shadow-sm p-6" style="border:1px solid #e5e7eb;">
        <div class="flex items-center gap-3">
            <div style="width:2.5rem;height:2.5rem;border-radius:.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                <svg style="width:1.25rem;height:1.25rem;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Records</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalRecords }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6" style="border:1px solid #e5e7eb;">
        <div class="flex items-center gap-3">
            <div style="width:2.5rem;height:2.5rem;border-radius:.5rem;background:#f0fdf4;display:flex;align-items:center;justify-content:center;">
                <svg style="width:1.25rem;height:1.25rem;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Family Members</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalFamily }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6" style="border:1px solid #e5e7eb;">
        <div class="flex items-center gap-3">
            <div style="width:2.5rem;height:2.5rem;border-radius:.5rem;background:#faf5ff;display:flex;align-items:center;justify-content:center;">
                <svg style="width:1.25rem;height:1.25rem;color:#9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Unique Tags</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalTags }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6" style="border:1px solid #e5e7eb;">
        <div class="flex items-center gap-3">
            <div style="width:2.5rem;height:2.5rem;border-radius:.5rem;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                <svg style="width:1.25rem;height:1.25rem;color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Shared Records</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalShared }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick actions -->
<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <a href="{{ route('records.create') }}"
       class="bg-white rounded-xl shadow-sm p-6 flex items-start gap-4 transition hover:shadow"
       style="border:1px solid #e5e7eb;">
        <div style="width:3rem;height:3rem;border-radius:.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg style="width:1.5rem;height:1.5rem;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Upload Record</p>
            <p class="mt-1 text-sm text-gray-500">Add a new medical document with tags</p>
        </div>
    </a>

    <a href="{{ route('records.index') }}"
       class="bg-white rounded-xl shadow-sm p-6 flex items-start gap-4 transition hover:shadow"
       style="border:1px solid #e5e7eb;">
        <div style="width:3rem;height:3rem;border-radius:.5rem;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg style="width:1.5rem;height:1.5rem;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">View Records</p>
            <p class="mt-1 text-sm text-gray-500">Browse, filter, and search all records</p>
        </div>
    </a>

    <a href="{{ route('family.create') }}"
       class="bg-white rounded-xl shadow-sm p-6 flex items-start gap-4 transition hover:shadow"
       style="border:1px solid #e5e7eb;">
        <div style="width:3rem;height:3rem;border-radius:.5rem;background:#faf5ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg style="width:1.5rem;height:1.5rem;color:#9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Add Family Member</p>
            <p class="mt-1 text-sm text-gray-500">Track health records per family member</p>
        </div>
    </a>

    <a href="{{ route('timeline') }}"
       class="bg-white rounded-xl shadow-sm p-6 flex items-start gap-4 transition hover:shadow"
       style="border:1px solid #e5e7eb;">
        <div style="width:3rem;height:3rem;border-radius:.5rem;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg style="width:1.5rem;height:1.5rem;color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">Timeline</p>
            <p class="mt-1 text-sm text-gray-500">Chronological view of your health history</p>
        </div>
    </a>

    <a href="{{ url('/api/documentation') }}" target="_blank"
       class="bg-white rounded-xl shadow-sm p-6 flex items-start gap-4 transition hover:shadow"
       style="border:1px solid #e5e7eb;">
        <div style="width:3rem;height:3rem;border-radius:.5rem;background:#f9fafb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg style="width:1.5rem;height:1.5rem;color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-900">API Documentation</p>
            <p class="mt-1 text-sm text-gray-500">Explore REST endpoints via Swagger</p>
        </div>
    </a>
</div>

<!-- Recent records -->
@if ($recentRecords->isNotEmpty())
<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Recent Records</h2>
        <a href="{{ route('records.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all →</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden" style="border:1px solid #e5e7eb;">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Tags</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentRecords as $record)
                <tr>
                    <td class="font-medium text-gray-900">{{ $record->title }}</td>
                    <td>
                        <span class="badge" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                            {{ ucfirst($record->document_type) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex flex-wrap gap-1">
                            @forelse ($record->tags ?? [] as $tag)
                                <span class="badge" style="background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;">{{ $tag }}</span>
                            @empty
                                <span class="text-gray-400 text-xs">—</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="text-gray-500">{{ $record->visit_date?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <a href="{{ route('records.show', $record) }}" class="text-sm text-blue-600 hover:text-blue-700">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- All tags -->
@if ($allTags->isNotEmpty())
<div class="mt-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-3">All Tags</h2>
    <div class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-2" style="border:1px solid #e5e7eb;">
        @foreach ($allTags as $tag => $count)
            <a href="{{ route('records.index', ['tag' => $tag]) }}"
               class="badge transition"
               style="background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;font-size:.8rem;padding:.25rem .625rem;">
                {{ $tag }} <span style="margin-left:.25rem;color:#9ca3af;">({{ $count }})</span>
            </a>
        @endforeach
    </div>
</div>
@endif
@endsection
