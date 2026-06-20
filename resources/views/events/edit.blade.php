@extends('layouts.app')
@section('title', 'Edit Event')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Edit Event</h1>
        <p class="pf-page-sub">Update event details and registration information.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf @method('PUT')
            @include('events.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Update Event</button>
                <a href="{{ route('events.show', $event) }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
