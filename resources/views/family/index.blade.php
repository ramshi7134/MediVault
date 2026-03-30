@extends('layouts.app')

@section('title', 'Family Members')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Family Members</h1>
        <p class="mt-1 text-sm text-gray-500">Manage health records for your family</p>
    </div>
    <a href="{{ route('family.create') }}" class="btn btn-primary">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Member
    </a>
</div>

@if ($members->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-12 text-center" style="border:1px solid #e5e7eb;">
        <svg style="width:3rem;height:3rem;color:#d1d5db;margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p class="mt-3 text-gray-500">No family members yet. <a href="{{ route('family.create') }}" class="text-blue-600">Add one now.</a></p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($members as $member)
        <div class="bg-white rounded-xl shadow-sm p-5" style="border:1px solid #e5e7eb;">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div style="width:2.5rem;height:2.5rem;border-radius:9999px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-weight:700;color:#2563eb;font-size:1.1rem;">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $member->name }}</p>
                        <p class="text-sm text-gray-500">{{ $member->relationship }}</p>
                    </div>
                </div>
            </div>

            <dl class="mt-4 space-y-1 text-sm text-gray-600">
                @if ($member->date_of_birth)
                    <div class="flex gap-2"><dt class="text-gray-400" style="width:5.5rem;flex-shrink:0;">Born</dt><dd>{{ $member->date_of_birth->format('d M Y') }}</dd></div>
                @endif
                @if ($member->blood_group)
                    <div class="flex gap-2"><dt class="text-gray-400" style="width:5.5rem;flex-shrink:0;">Blood Group</dt><dd>{{ $member->blood_group }}</dd></div>
                @endif
                @if ($member->gender)
                    <div class="flex gap-2"><dt class="text-gray-400" style="width:5.5rem;flex-shrink:0;">Gender</dt><dd>{{ ucfirst($member->gender) }}</dd></div>
                @endif
                @if ($member->phone)
                    <div class="flex gap-2"><dt class="text-gray-400" style="width:5.5rem;flex-shrink:0;">Phone</dt><dd>{{ $member->phone }}</dd></div>
                @endif
                <div class="flex gap-2"><dt class="text-gray-400" style="width:5.5rem;flex-shrink:0;">Records</dt>
                    <dd>
                        <a href="{{ route('records.index', ['family_member_id' => $member->id]) }}"
                           class="text-blue-600 hover:text-blue-700">
                            {{ $member->medicalRecords()->count() }} record(s)
                        </a>
                    </dd>
                </div>
            </dl>

            <div class="mt-4 flex gap-2">
                <a href="{{ route('family.edit', $member) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form method="POST" action="{{ route('family.destroy', $member) }}"
                      onsubmit="return confirm('Delete {{ $member->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
