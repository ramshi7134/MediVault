@extends('layouts.app')

@section('title', 'Add Family Member')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('family.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Add Family Member</h1>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl" style="border:1px solid #e5e7eb;">
    <form method="POST" action="{{ route('family.store') }}" class="space-y-6">
        @csrf

        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="name">Full Name <span style="color:#ef4444;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe">
            </div>
            <div>
                <label for="relationship">Relationship <span style="color:#ef4444;">*</span></label>
                <input type="text" id="relationship" name="relationship" value="{{ old('relationship') }}" required placeholder="e.g. Spouse, Child, Parent">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Optional">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="gender">Gender</label>
                <select id="gender" name="gender">
                    <option value="">Select…</option>
                    @foreach (['male','female','other'] as $g)
                        <option value="{{ $g }}" {{ old('gender') === $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="blood_group">Blood Group</label>
                <select id="blood_group" name="blood_group">
                    <option value="">Select…</option>
                    @foreach (['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                        <option value="{{ $bg }}" {{ old('blood_group') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary">Add Member</button>
            <a href="{{ route('family.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
