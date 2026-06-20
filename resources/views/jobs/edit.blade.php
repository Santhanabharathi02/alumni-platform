@extends('layouts.app')
@section('title', 'Edit Job Listing')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Edit Job Listing</h1>
        <p class="pf-page-sub">Refine role details, status, and candidate application options.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('jobs.update', $job) }}">
            @csrf @method('PUT')
            @include('jobs.partials.form', ['job' => $job])
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Save Changes</button>
                <a href="{{ route('jobs.show', $job) }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
