@extends('layouts.app')
@section('title', 'Edit Announcement')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Edit Announcement</h1>
        <p class="pf-page-sub">Update content, schedule, and publication status.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('announcements.update', $announcement) }}">
            @csrf @method('PUT')
            @include('announcements.partials.form', ['announcement' => $announcement])
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Save Changes</button>
                <a href="{{ route('announcements.show', $announcement) }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
