@extends('layouts.app')

@section('title', 'Medical Records')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Medical Records</h1>
        <p class="mt-1 text-sm text-gray-500">{{ $records->total() }} record(s) found</p>
    </div>
    <a href="{{ route('records.create') }}" class="btn btn-primary">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Upload Record
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6" style="border:1px solid #e5e7eb;">
    <form method="GET" action="{{ route('records.index') }}" class="flex flex-wrap gap-3 items-end">
        <div>
            <label>Document Type</label>
            <select name="document_type" style="width:auto;">
                <option value="">All Types</option>
                @foreach (['prescription','lab','invoice','report','other'] as $type)
                    <option value="{{ $type }}" {{ request('document_type') === $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Doctor</label>
            <input type="text" name="doctor_name" value="{{ request('doctor_name') }}" placeholder="Doctor name" style="width:auto;">
        </div>
        <div>
            <label>Hospital</label>
            <input type="text" name="hospital_name" value="{{ request('hospital_name') }}" placeholder="Hospital name" style="width:auto;">
        </div>
        <div>
            <label>From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" style="width:auto;">
        </div>
        <div>
            <label>To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" style="width:auto;">
        </div>
        <div>
            <label>Tag</label>
            <input type="text" name="tag" value="{{ request('tag') }}" placeholder="Filter by tag" style="width:auto;">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('records.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

@if ($records->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-12 text-center" style="border:1px solid #e5e7eb;">
        <svg style="width:3rem;height:3rem;color:#d1d5db;margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="mt-3 text-gray-500">No records found. <a href="{{ route('records.create') }}" class="text-blue-600">Upload one now.</a></p>
    </div>
@else
    <div class="bg-white rounded-xl shadow-sm overflow-hidden" style="border:1px solid #e5e7eb;">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Tags</th>
                    <th>Doctor / Hospital</th>
                    <th>Family Member</th>
                    <th>Visit Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
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
                                <a href="{{ route('records.index', ['tag' => $tag]) }}"
                                   class="badge"
                                   style="background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;">{{ $tag }}</a>
                            @empty
                                <span class="text-gray-400 text-xs">—</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="text-gray-600">
                        {{ $record->doctor_name ?? '' }}
                        @if ($record->doctor_name && $record->hospital_name) / @endif
                        {{ $record->hospital_name ?? '' }}
                        @if (!$record->doctor_name && !$record->hospital_name) — @endif
                    </td>
                    <td class="text-gray-600">{{ $record->familyMember?->name ?? 'Self' }}</td>
                    <td class="text-gray-500">{{ $record->visit_date?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('records.show', $record) }}" class="btn btn-secondary btn-sm">View</a>
                            <form method="POST" action="{{ route('records.destroy', $record) }}"
                                  onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($records->hasPages())
        <div class="mt-4 flex justify-center gap-2">
            @if ($records->onFirstPage())
                <span class="btn btn-secondary btn-sm" style="opacity:.5;cursor:not-allowed;">‹ Prev</span>
            @else
                <a href="{{ $records->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="btn btn-secondary btn-sm">‹ Prev</a>
            @endif
            <span class="btn btn-secondary btn-sm">Page {{ $records->currentPage() }} / {{ $records->lastPage() }}</span>
            @if ($records->hasMorePages())
                <a href="{{ $records->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}" class="btn btn-secondary btn-sm">Next ›</a>
            @else
                <span class="btn btn-secondary btn-sm" style="opacity:.5;cursor:not-allowed;">Next ›</span>
            @endif
        </div>
    @endif
@endif
@endsection
