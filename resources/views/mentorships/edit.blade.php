@extends('layouts.app')
@section('title', 'Edit Mentorship')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Edit Mentorship</h1>
        <p class="pf-page-sub">Update mentorship availability and status.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('mentorships.update', $mentorship) }}">
            @csrf @method('PUT')
            @include('mentorships.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Update Mentorship</button>
                <a href="{{ route('mentorships.show', $mentorship) }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
