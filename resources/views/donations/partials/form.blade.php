@csrf

{{-- Donor Information --}}
<div class="pf-section">
    <div class="pf-section-title">Donor Information</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Linked Alumni <span class="pf-hint" style="font-weight:400;color:#94a3b8;">(optional)</span></label>
            <select name="alumni_id" class="pf-input">
                <option value="">— External donor (not an alumni) —</option>
                @foreach ($alumni as $person)
                    <option value="{{ $person->id }}" {{ (int) old('alumni_id', $donation->alumni_id ?? '') === $person->id ? 'selected' : '' }}>
                        {{ $person->full_name }} ({{ $person->email }})
                    </option>
                @endforeach
            </select>
            @error('alumni_id')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Donor Name <span class="pf-req">*</span></label>
            <input type="text" name="donor_name" value="{{ old('donor_name', $donation->donor_name ?? '') }}" class="pf-input" placeholder="Full name" required>
            @error('donor_name')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Donor Email</label>
            <input type="email" name="donor_email" value="{{ old('donor_email', $donation->donor_email ?? '') }}" class="pf-input" placeholder="donor@example.com">
            @error('donor_email')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- Donation Details --}}
<div class="pf-section">
    <div class="pf-section-title">Donation Details</div>
    <div class="pf-grid">
        <div class="pf-field">
            <label class="pf-label">Amount <span class="pf-req">*</span></label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount', $donation->amount ?? '') }}" class="pf-input" placeholder="0.00" required>
            @error('amount')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Currency <span class="pf-req">*</span></label>
            <input type="text" name="currency" value="{{ old('currency', $donation->currency ?? 'INR') }}" class="pf-input" placeholder="INR" required>
            @error('currency')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Donation Date <span class="pf-req">*</span></label>
            <input type="date" name="donated_at" value="{{ old('donated_at', optional($donation->donated_at ?? null)->format('Y-m-d')) }}" class="pf-input" required>
            @error('donated_at')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Purpose</label>
            <input type="text" name="purpose" value="{{ old('purpose', $donation->purpose ?? '') }}" class="pf-input" placeholder="e.g. Library Fund">
            @error('purpose')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Status <span class="pf-req">*</span></label>
            <select name="status" class="pf-input" required>
                @foreach (['received' => 'Received', 'pledged' => 'Pledged'] as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $donation->status ?? 'received') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Notes</label>
            <textarea name="notes" class="pf-textarea" placeholder="Any additional notes...">{{ old('notes', $donation->notes ?? '') }}</textarea>
            @error('notes')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
