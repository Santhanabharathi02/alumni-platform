@csrf

{{-- Mentorship Details --}}
<div class="pf-section">
    <div class="pf-section-title">Mentorship Details</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Alumni <span class="pf-req">*</span></label>
            <select name="alumni_id" class="pf-input" required>
                <option value="">— Select alumni —</option>
                @foreach ($alumni as $person)
                    <option value="{{ $person->id }}" {{ (int) old('alumni_id', $mentorship->alumni_id ?? '') === $person->id ? 'selected' : '' }}>
                        {{ $person->full_name }} ({{ $person->email }})
                    </option>
                @endforeach
            </select>
            @error('alumni_id')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Area of Interest <span class="pf-req">*</span></label>
            <input type="text" name="area_of_interest" value="{{ old('area_of_interest', $mentorship->area_of_interest ?? '') }}" class="pf-input" placeholder="e.g. Web Development, Data Science" required>
            @error('area_of_interest')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Availability</label>
            <input type="text" name="availability" value="{{ old('availability', $mentorship->availability ?? '') }}" class="pf-input" placeholder="e.g. Weekly, Monthly">
            @error('availability')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Status <span class="pf-req">*</span></label>
            <select name="status" class="pf-input" required>
                @foreach (['open' => 'Open', 'active' => 'Active', 'closed' => 'Closed'] as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $mentorship->status ?? 'open') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Start Date</label>
            <input type="date" name="started_at" value="{{ old('started_at', optional($mentorship->started_at ?? null)->format('Y-m-d')) }}" class="pf-input">
            @error('started_at')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">End Date</label>
            <input type="date" name="ended_at" value="{{ old('ended_at', optional($mentorship->ended_at ?? null)->format('Y-m-d')) }}" class="pf-input">
            @error('ended_at')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Notes</label>
            <textarea name="notes" class="pf-textarea" placeholder="Any notes about this mentorship...">{{ old('notes', $mentorship->notes ?? '') }}</textarea>
            @error('notes')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
