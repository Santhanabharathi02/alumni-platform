@csrf

{{-- ── Personal Information ── --}}
<div class="pf-section">
    <div class="pf-section-title">Personal Information</div>
    <div class="pf-grid">
        <div class="pf-field">
            <label class="pf-label">First Name <span class="pf-req">*</span></label>
            <input type="text" name="first_name" value="{{ old('first_name', $alumni->first_name ?? '') }}" class="pf-input" placeholder="e.g. Arjun" required>
            @error('first_name')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Last Name <span class="pf-req">*</span></label>
            <input type="text" name="last_name" value="{{ old('last_name', $alumni->last_name ?? '') }}" class="pf-input" placeholder="e.g. Kumar" required>
            @error('last_name')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Email Address <span class="pf-req">*</span></label>
            <input type="email" name="email" value="{{ old('email', $alumni->email ?? '') }}" class="pf-input" placeholder="arjun@example.com" required>
            @error('email')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Phone Number</label>
            <input type="tel" name="phone" value="{{ old('phone', $alumni->phone ?? '') }}" class="pf-input" placeholder="+91 9876543210">
            @error('phone')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Bio</label>
            <textarea name="bio" class="pf-textarea" placeholder="A short bio about the alumni...">{{ old('bio', $alumni->bio ?? '') }}</textarea>
            @error('bio')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- ── Academic Details ── --}}
<div class="pf-section">
    <div class="pf-section-title">Academic Details</div>
    <div class="pf-grid">
        <div class="pf-field">
            <label class="pf-label">Graduation Year</label>
            <input type="number" name="graduation_year" value="{{ old('graduation_year', $alumni->graduation_year ?? '') }}" class="pf-input" placeholder="e.g. 2022" min="1980" max="2099">
            @error('graduation_year')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Degree</label>
            <input type="text" name="degree" value="{{ old('degree', $alumni->degree ?? '') }}" class="pf-input" placeholder="e.g. B.E. / B.Tech">
            @error('degree')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Department</label>
            <input type="text" name="department" value="{{ old('department', $alumni->department ?? '') }}" class="pf-input" placeholder="e.g. Computer Science">
            @error('department')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- ── Professional Details ── --}}
<div class="pf-section">
    <div class="pf-section-title">Professional Details</div>
    <div class="pf-grid">
        <div class="pf-field">
            <label class="pf-label">Company</label>
            <input type="text" name="company" value="{{ old('company', $alumni->company ?? '') }}" class="pf-input" placeholder="e.g. Infosys">
            @error('company')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Job Title</label>
            <input type="text" name="job_title" value="{{ old('job_title', $alumni->job_title ?? '') }}" class="pf-input" placeholder="e.g. Software Engineer">
            @error('job_title')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Location</label>
            <input type="text" name="location" value="{{ old('location', $alumni->location ?? '') }}" class="pf-input" placeholder="e.g. Chennai, India">
            @error('location')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">LinkedIn URL</label>
            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $alumni->linkedin_url ?? '') }}" class="pf-input" placeholder="https://linkedin.com/in/username">
            @error('linkedin_url')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Last Contacted</label>
            <input type="date" name="last_contacted_at" value="{{ old('last_contacted_at', optional($alumni->last_contacted_at ?? null)->format('Y-m-d')) }}" class="pf-input">
            @error('last_contacted_at')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- ── Profile Photo & Options ── --}}
<div class="pf-section" style="margin-bottom:0;">
    <div class="pf-section-title">Photo & Preferences</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Profile Photo</label>
            <input type="file" name="photo" accept="image/*" class="pf-input" style="height:auto;padding:10px 14px;">
            @if(!empty($alumni->photo_path))
                <div style="display:flex;align-items:center;gap:10px;margin-top:10px;">
                    <img src="{{ $alumni->photo_url }}" alt="Current photo" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;">
                    <span style="font-size:0.8rem;color:#64748b;">Current photo</span>
                </div>
            @endif
            @error('photo')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Availability</label>
            <div class="pf-check-group">
                <label class="pf-check-label">
                    <input type="checkbox" name="is_mentor" value="1" {{ old('is_mentor', $alumni->is_mentor ?? false) ? 'checked' : '' }}>
                    Available as Mentor
                </label>
                <label class="pf-check-label">
                    <input type="checkbox" name="available_for_internships" value="1" {{ old('available_for_internships', $alumni->available_for_internships ?? false) ? 'checked' : '' }}>
                    Open to Internship Opportunities
                </label>
            </div>
        </div>
    </div>
</div>
