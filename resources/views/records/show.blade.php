@extends('layouts.app')

@section('title', $record->title)

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('records.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="text-2xl font-bold text-gray-900">{{ $record->title }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main details -->
    <div class="lg:grid-cols-3" style="grid-column: span 2;">
        <div class="bg-white rounded-xl shadow-sm p-6" style="border:1px solid #e5e7eb;">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Record Details</h2>

            <dl class="space-y-4">
                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">Type</dt>
                    <dd>
                        <span class="badge" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;">
                            {{ ucfirst($record->document_type) }}
                        </span>
                    </dd>
                </div>

                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">Tags</dt>
                    <dd>
                        <div class="flex flex-wrap gap-1">
                            @forelse ($record->tags ?? [] as $tag)
                                <a href="{{ route('records.index', ['tag' => $tag]) }}"
                                   class="badge"
                                   style="background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;">{{ $tag }}</a>
                            @empty
                                <span class="text-gray-400 text-sm">No tags</span>
                            @endforelse
                        </div>
                    </dd>
                </div>

                @if ($record->doctor_name)
                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">Doctor</dt>
                    <dd class="text-sm text-gray-900">{{ $record->doctor_name }}</dd>
                </div>
                @endif

                @if ($record->hospital_name)
                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">Hospital</dt>
                    <dd class="text-sm text-gray-900">{{ $record->hospital_name }}</dd>
                </div>
                @endif

                @if ($record->visit_date)
                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">Visit Date</dt>
                    <dd class="text-sm text-gray-900">{{ $record->visit_date->format('d M Y') }}</dd>
                </div>
                @endif

                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">Patient</dt>
                    <dd class="text-sm text-gray-900">{{ $record->familyMember?->name ?? 'Self (' . Auth::user()->name . ')' }}</dd>
                </div>

                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">File</dt>
                    <dd class="text-sm text-gray-900">
                        {{ basename($record->file_path) }}
                        <span class="text-gray-400">({{ $record->file_mime }}, {{ round($record->file_size / 1024) }} KB)</span>
                    </dd>
                </div>

                <div class="flex items-start gap-4">
                    <dt class="text-sm font-medium text-gray-500" style="width:8rem;flex-shrink:0;">OCR Status</dt>
                    <dd>
                        @php
                            $ocr = $record->ocr_status;
                            $colors = ['pending'=>'#fef9c3|#854d0e|#fef08a','processing'=>'#eff6ff|#1d4ed8|#bfdbfe','completed'=>'#f0fdf4|#15803d|#bbf7d0','failed'=>'#fef2f2|#b91c1c|#fecaca'];
                            [$bg,$text,$border] = explode('|', $colors[$ocr] ?? '#f9fafb|#374151|#e5e7eb');
                        @endphp
                        <span class="badge" style="background:{{ $bg }};color:{{ $text }};border:1px solid {{ $border }};">
                            {{ ucfirst($ocr) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Extracted text -->
        @if ($record->extracted_text)
        <div class="bg-white rounded-xl shadow-sm p-6 mt-4" style="border:1px solid #e5e7eb;">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Extracted Text (OCR)</h2>
            <pre class="text-sm text-gray-700 whitespace-pre-wrap" style="background:#f9fafb;padding:1rem;border-radius:.5rem;overflow:auto;max-height:20rem;">{{ $record->extracted_text }}</pre>
        </div>
        @endif

        <!-- Prescriptions -->
        @if ($record->prescriptions->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 mt-4" style="border:1px solid #e5e7eb;">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Prescriptions</h2>
            <div class="space-y-4">
                @foreach ($record->prescriptions as $rx)
                <div style="padding:1rem;background:#f9fafb;border-radius:.5rem;border:1px solid #f3f4f6;">
                    <p class="font-medium text-gray-900">{{ $rx->medicine_name }}</p>
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-600">
                        @if ($rx->dosage) <span><strong>Dosage:</strong> {{ $rx->dosage }}</span> @endif
                        @if ($rx->frequency) <span><strong>Frequency:</strong> {{ $rx->frequency }}</span> @endif
                        @if ($rx->duration) <span><strong>Duration:</strong> {{ $rx->duration }}</span> @endif
                        @if ($rx->instructions) <span class="sm:col-span-2"><strong>Instructions:</strong> {{ $rx->instructions }}</span> @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar: actions & sharing -->
    <div class="space-y-4">
        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm p-4" style="border:1px solid #e5e7eb;">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Actions</h3>
            <div class="space-y-2">
                <form method="POST" action="{{ route('records.destroy', $record) }}"
                      onsubmit="return confirm('Permanently delete this record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full" style="justify-content:center;">
                        Delete Record
                    </button>
                </form>
            </div>
        </div>

        <!-- Share -->
        <div class="bg-white rounded-xl shadow-sm p-4" style="border:1px solid #e5e7eb;">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Share Record</h3>
            <form method="POST" action="{{ route('records.share', $record) }}" class="space-y-3">
                @csrf
                <div>
                    <label for="expires_in_hours" style="font-size:.8rem;">Expires in (hours)</label>
                    <input type="number" id="expires_in_hours" name="expires_in_hours"
                           placeholder="Leave blank for no expiry" min="1" style="font-size:.875rem;">
                    <p class="text-xs text-gray-400 mt-1">Leave blank for a permanent link.</p>
                </div>
                <button type="submit" class="btn btn-success w-full" style="justify-content:center;">Generate Share Link</button>
            </form>

            @if (session('share_url'))
                <div class="mt-3 p-3 rounded-lg" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <p class="text-xs font-medium text-green-700 mb-1">Share link created:</p>
                    <div class="flex gap-2">
                        <input type="text" id="share-url" value="{{ session('share_url') }}"
                               readonly style="font-size:.75rem;color:#374151;background:#fff;">
                        <button type="button" onclick="copyShare()" class="btn btn-secondary btn-sm" style="flex-shrink:0;">Copy</button>
                    </div>
                    @if (session('share_expires'))
                        <p class="text-xs text-gray-500 mt-1">Expires: {{ session('share_expires') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function copyShare() {
    var el = document.getElementById('share-url');
    el.select();
    document.execCommand('copy');
    var btn = el.nextElementSibling;
    btn.textContent = 'Copied!';
    setTimeout(function() { btn.textContent = 'Copy'; }, 2000);
}
</script>
@endsection
