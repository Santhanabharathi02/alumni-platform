{{-- Announcement Content --}}
<div class="pf-section">
    <div class="pf-section-title">Announcement Content</div>
    <div class="pf-grid">
        <div class="pf-field pf-full">
            <label class="pf-label">Title <span class="pf-req">*</span></label>
            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="pf-input" placeholder="e.g. Convocation 2026 Invitations Open" required>
            @error('title')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Category <span class="pf-req">*</span></label>
            <select name="category" class="pf-input" required>
                @foreach(['general','event','career','urgent'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $announcement->category) === $cat)>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
            @error('category')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field">
            <label class="pf-label">Publish Date</label>
            <input type="date" name="publish_at" value="{{ old('publish_at', $announcement->publish_at?->format('Y-m-d')) }}" class="pf-input">
        </div>
        <div class="pf-field">
            <label class="pf-label">Expiry Date</label>
            <input type="date" name="expires_at" value="{{ old('expires_at', $announcement->expires_at?->format('Y-m-d')) }}" class="pf-input">
        </div>
        <div class="pf-field pf-full">
            <label class="pf-label">Body / Message <span class="pf-req">*</span></label>
            <textarea name="body" class="pf-textarea" style="min-height:160px;" placeholder="Write the announcement details here..." required>{{ old('body', $announcement->body) }}</textarea>
            @error('body')<div class="pf-error">{{ $message }}</div>@enderror
        </div>
        <div class="pf-field pf-full">
            <label class="pf-check-label">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" id="is_published" value="1" @checked(old('is_published', $announcement->is_published ?? true))>
                Publish immediately
            </label>
        </div>
    </div>
</div>
