@extends('layouts.app')
@section('title', 'Create Event')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Create Event</h1>
        <p class="pf-page-sub">Capture details for upcoming alumni engagement activities.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('events.store') }}">
            @include('events.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Save Event</button>
                <a href="{{ route('events.index') }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
