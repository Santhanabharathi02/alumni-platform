@csrf

{{-- Event Details --}}
<div class="pf-section">
    <div class="pf-section-title">Event Details</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Event Title <span class="pf-req">*</span></label>
            <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" class="pf-input" placeholder="e.g. Annual Alumni Meet 2026" required>
            @error('title')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Start Date & Time <span class="pf-req">*</span></label>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', isset($event) ? $event->starts_at?->format('Y-m-d\TH:i') : '') }}" class="pf-input" required>
            @error('starts_at')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">End Date & Time</label>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', isset($event) ? $event->ends_at?->format('Y-m-d\TH:i') : '') }}" class="pf-input">
            @error('ends_at')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Location</label>
            <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}" class="pf-input" placeholder="e.g. SMTEC Auditorium">
            @error('location')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Organizer</label>
            <input type="text" name="organizer" value="{{ old('organizer', $event->organizer ?? '') }}" class="pf-input" placeholder="e.g. Alumni Association">
            @error('organizer')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Registration URL</label>
            <input type="url" name="registration_url" value="{{ old('registration_url', $event->registration_url ?? '') }}" class="pf-input" placeholder="https://...">
            @error('registration_url')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Status <span class="pf-req">*</span></label>
            <select name="status" class="pf-input" required>
                @foreach (['planned' => 'Planned', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $event->status ?? 'planned') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Description</label>
            <textarea name="description" class="pf-textarea" placeholder="Describe the event...">{{ old('description', $event->description ?? '') }}</textarea>
            @error('description')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
