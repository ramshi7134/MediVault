@extends('layouts.app')

@section('title', 'Upload Record')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('records.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Upload Medical Record</h1>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl" style="border:1px solid #e5e7eb;">
    <form method="POST" action="{{ route('records.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Title & Type -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="title">Title <span style="color:#ef4444;">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                       placeholder="e.g. Blood Test Results" required>
            </div>
            <div>
                <label for="document_type">Document Type <span style="color:#ef4444;">*</span></label>
                <select id="document_type" name="document_type" required>
                    <option value="">Select type…</option>
                    @foreach (['prescription','lab','invoice','report','other'] as $type)
                        <option value="{{ $type }}" {{ old('document_type') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Doctor & Hospital -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="doctor_name">Doctor Name</label>
                <input type="text" id="doctor_name" name="doctor_name" value="{{ old('doctor_name') }}"
                       placeholder="e.g. Dr. Smith">
            </div>
            <div>
                <label for="hospital_name">Hospital / Clinic</label>
                <input type="text" id="hospital_name" name="hospital_name" value="{{ old('hospital_name') }}"
                       placeholder="e.g. City Hospital">
            </div>
        </div>

        <!-- Visit Date & Family Member -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="visit_date">Visit Date</label>
                <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date') }}">
            </div>
            <div>
                <label for="family_member_id">Family Member</label>
                <select id="family_member_id" name="family_member_id">
                    <option value="">Self (You)</option>
                    @foreach ($familyMembers as $member)
                        <option value="{{ $member->id }}" {{ old('family_member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }} ({{ $member->relationship }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tags -->
        <div>
            <label for="tags-input">Tags</label>
            <p class="text-xs text-gray-500 mb-2">Type a tag and press <kbd style="background:#f3f4f6;padding:.1rem .35rem;border-radius:.25rem;font-size:.75rem;border:1px solid #d1d5db;">Enter</kbd> or <kbd style="background:#f3f4f6;padding:.1rem .35rem;border-radius:.25rem;font-size:.75rem;border:1px solid #d1d5db;">comma</kbd> to add it.</p>

            <!-- Tag display area -->
            <div id="tags-container"
                 style="display:flex;flex-wrap:wrap;gap:.375rem;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:.375rem;background:#fff;min-height:2.5rem;cursor:text;"
                 onclick="document.getElementById('tags-input').focus()">
                <!-- existing tags on validation fail -->
                @foreach (old('tags', []) as $tag)
                    <span class="tag-chip" data-tag="{{ $tag }}"
                          style="display:inline-flex;align-items:center;gap:.25rem;background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;padding:.125rem .5rem;border-radius:9999px;font-size:.8rem;">
                        {{ $tag }}
                        <button type="button" onclick="removeTag('{{ $tag }}')"
                                style="border:none;background:none;cursor:pointer;color:#9ca3af;line-height:1;padding:0;font-size:.9rem;">×</button>
                    </span>
                @endforeach
                <input type="text" id="tags-input"
                       placeholder="{{ count(old('tags', [])) ? '' : 'e.g. diabetes, checkup, annual…' }}"
                       style="border:none;outline:none;padding:0;flex:1;min-width:8rem;font-size:.875rem;background:transparent;">
            </div>

            <!-- Hidden inputs for actual form submission -->
            <div id="tags-hidden">
                @foreach (old('tags', []) as $tag)
                    <input type="hidden" name="tags[]" value="{{ $tag }}">
                @endforeach
            </div>
        </div>

        <!-- File Upload -->
        <div>
            <label for="file">Document File <span style="color:#ef4444;">*</span></label>
            <p class="text-xs text-gray-500 mb-2">Accepted: PDF, JPG, PNG, GIF, WEBP (max 20 MB)</p>
            <input type="file" id="file" name="file" required
                   accept=".pdf,.jpg,.jpeg,.png,.gif,.webp"
                   style="padding:.375rem .5rem;">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary">Upload Record</button>
            <a href="{{ route('records.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    const input = document.getElementById('tags-input');
    const container = document.getElementById('tags-container');
    const hiddenContainer = document.getElementById('tags-hidden');
    const tags = new Set(@json(old('tags', [])));

    function renderChips() {
        // Remove existing chips
        container.querySelectorAll('.tag-chip').forEach(el => el.remove());
        hiddenContainer.innerHTML = '';
        tags.forEach(tag => {
            // Add chip to visible area using createElement (avoids innerHTML XSS)
            const chip = document.createElement('span');
            chip.className = 'tag-chip';
            chip.dataset.tag = tag;
            chip.style.cssText = 'display:inline-flex;align-items:center;gap:.25rem;background:#faf5ff;color:#7c3aed;border:1px solid #ddd6fe;padding:.125rem .5rem;border-radius:9999px;font-size:.8rem;';
            const label = document.createTextNode(tag);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.style.cssText = 'border:none;background:none;cursor:pointer;color:#9ca3af;line-height:1;padding:0;font-size:.9rem;';
            btn.textContent = '×';
            btn.addEventListener('click', function () { window.removeTag(tag); });
            chip.appendChild(label);
            chip.appendChild(btn);
            container.insertBefore(chip, input);
            // Add hidden input
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'tags[]';
            hidden.value = tag;
            hiddenContainer.appendChild(hidden);
        });
        input.placeholder = tags.size ? '' : 'e.g. diabetes, checkup, annual…';
    }

    function addTag(raw) {
        const tag = raw.trim().toLowerCase().replace(/[^a-z0-9\-_\s]/g, '').trim();
        if (tag && tag.length <= 50 && !tags.has(tag)) {
            tags.add(tag);
            renderChips();
        }
    }

    window.removeTag = function (tag) {
        tags.delete(tag);
        renderChips();
    };

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(input.value.replace(',', ''));
            input.value = '';
        } else if (e.key === 'Backspace' && input.value === '' && tags.size) {
            const last = Array.from(tags).pop();
            tags.delete(last);
            renderChips();
        }
    });

    input.addEventListener('blur', function () {
        if (input.value.trim()) {
            addTag(input.value);
            input.value = '';
        }
    });
})();
</script>
@endsection
