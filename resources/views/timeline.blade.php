@extends('layouts.app')

@section('title', 'Timeline')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Health Timeline</h1>
        <p class="mt-1 text-sm text-gray-500">Your medical history in chronological order</p>
    </div>
    <a href="{{ route('records.create') }}" class="btn btn-primary">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Upload Record
    </a>
</div>

@if ($grouped->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-12 text-center" style="border:1px solid #e5e7eb;">
        <svg style="width:3rem;height:3rem;color:#d1d5db;margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="mt-3 text-gray-500">No records yet. <a href="{{ route('records.create') }}" class="text-blue-600">Upload your first record.</a></p>
    </div>
@else
    <div class="space-y-8">
        @foreach ($grouped as $period => $records)
        <div>
            <!-- Period header -->
            <div class="flex items-center gap-3 mb-4">
                <div style="width:3rem;height:3rem;border-radius:9999px;background:#eff6ff;border:2px solid #2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:1.25rem;height:1.25rem;color:#2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $period)->format('F Y') }}
                    <span class="text-sm font-normal text-gray-500 ml-2">{{ count($records) }} record(s)</span>
                </h2>
                <div style="flex:1;height:1px;background:#e5e7eb;"></div>
            </div>

            <!-- Records in this period -->
            <div class="ml-12 space-y-3">
                @foreach ($records as $record)
                <div class="bg-white rounded-xl shadow-sm p-4 flex items-start gap-4" style="border:1px solid #e5e7eb;">
                    <!-- Date dot -->
                    <div style="flex-shrink:0;margin-top:.25rem;">
                        @php
                            $dotColors = ['prescription'=>'#2563eb','lab'=>'#16a34a','invoice'=>'#ca8a04','report'=>'#9333ea','other'=>'#6b7280'];
                            $dotColor = $dotColors[$record->document_type] ?? '#6b7280';
                        @endphp
                        <div style="width:.75rem;height:.75rem;border-radius:9999px;background:{{ $dotColor }};margin-top:.25rem;"></div>
                    </div>

                    <div class="flex-1" style="min-width:0;">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $record->title }}</p>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span class="badge" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;font-size:.75rem;">
                                        {{ ucfirst($record->document_type) }}
                                    </span>
                                    @if ($record->familyMember)
                                        <span class="text-xs text-gray-500">{{ $record->familyMember->name }}</span>
                                    @endif
                                    @if ($record->doctor_name)
                                        <span class="text-xs text-gray-500">Dr. {{ $record->doctor_name }}</span>
                                    @endif
                                    @if ($record->hospital_name)
                                        <span class="text-xs text-gray-500">{{ $record->hospital_name }}</span>
                                    @endif
                                </div>
                                <!-- Tags -->
                                @if (!empty($record->tags))
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach ($record->tags as $tag)
                                        <a href="{{ route('records.index', ['tag' => $tag]) }}"
                                           class="badge"
                                           style="background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;font-size:.75rem;">{{ $tag }}</a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if ($record->visit_date)
                                    <span class="text-xs text-gray-400">{{ $record->visit_date->format('d M') }}</span>
                                @endif
                                <a href="{{ route('records.show', $record) }}" class="btn btn-secondary btn-sm">View</a>
                            </div>
                        </div>

                        @if ($record->prescriptions->isNotEmpty())
                        <div class="mt-2 text-xs text-gray-500">
                            💊 {{ $record->prescriptions->pluck('medicine_name')->join(', ') }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
