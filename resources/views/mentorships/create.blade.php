@extends('layouts.app')
@section('title', 'New Mentorship')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">New Mentorship</h1>
        <p class="pf-page-sub">Connect alumni mentors with students and engagement programs.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('mentorships.store') }}">
            @include('mentorships.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Save Mentorship</button>
                <a href="{{ route('mentorships.index') }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
