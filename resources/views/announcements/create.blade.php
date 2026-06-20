@extends('layouts.app')
@section('title', 'New Announcement')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">New Announcement</h1>
        <p class="pf-page-sub">Publish important updates with clear scheduling and expiry settings.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('announcements.store') }}">
            @csrf
            @include('announcements.partials.form', ['announcement' => $announcement])
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Publish Announcement</button>
                <a href="{{ route('announcements.index') }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
