{{-- Job Details --}}
<div class="pf-section">
    <div class="pf-section-title">Job Details</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Job Title <span class="pf-req">*</span></label>
            <input type="text" name="title" value="{{ old('title', $job->title) }}" class="pf-input" placeholder="e.g. Software Engineer" required>
            @error('title')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Company <span class="pf-req">*</span></label>
            <input type="text" name="company" value="{{ old('company', $job->company) }}" class="pf-input" placeholder="e.g. Infosys" required>
            @error('company')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Location</label>
            <input type="text" name="location" value="{{ old('location', $job->location) }}" class="pf-input" placeholder="e.g. Chennai, India">
        </div>
        <div class="pf-field">
            <label class="pf-label">Job Type <span class="pf-req">*</span></label>
            <select name="type" class="pf-input" required>
                @foreach(['full-time','part-time','internship','contract'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $job->type) === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="pf-field">
            <label class="pf-label">Department</label>
            <input type="text" name="department" value="{{ old('department', $job->department) }}" class="pf-input" placeholder="e.g. Engineering">
        </div>
        <div class="pf-field">
            <label class="pf-label">Status <span class="pf-req">*</span></label>
            <select name="status" class="pf-input" required>
                @foreach(['open','closed','filled'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $job->status) === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- Compensation & Application --}}
<div class="pf-section">
    <div class="pf-section-title">Compensation & Application</div>
    <div class="pf-grid">
        <div class="pf-field">
            <label class="pf-label">Min Salary (&#8377;)</label>
            <input type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" class="pf-input" placeholder="0" min="0" step="1000">
        </div>
        <div class="pf-field">
            <label class="pf-label">Max Salary (&#8377;)</label>
            <input type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" class="pf-input" placeholder="0" min="0" step="1000">
        </div>
        <div class="pf-field">
            <label class="pf-label">Contact Email</label>
            <input type="email" name="contact_email" value="{{ old('contact_email', $job->contact_email) }}" class="pf-input" placeholder="hr@company.com">
        </div>
        <div class="pf-field">
            <label class="pf-label">Application URL</label>
            <input type="url" name="apply_url" value="{{ old('apply_url', $job->apply_url) }}" class="pf-input" placeholder="https://">
        </div>
        <div class="pf-field">
            <label class="pf-label">Application Deadline</label>
            <input type="date" name="expires_at" value="{{ old('expires_at', $job->expires_at?->format('Y-m-d')) }}" class="pf-input">
        </div>
    </div>
</div>

{{-- Description --}}
<div class="pf-section">
    <div class="pf-section-title">Description & Requirements</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Job Description <span class="pf-req">*</span></label>
            <textarea name="description" class="pf-textarea" style="min-height:130px;" placeholder="Describe the role and responsibilities..." required>{{ old('description', $job->description) }}</textarea>
            @error('description')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Requirements</label>
            <textarea name="requirements" class="pf-textarea" placeholder="List required skills and qualifications...">{{ old('requirements', $job->requirements) }}</textarea>
        </div>
    </div>
</div>
