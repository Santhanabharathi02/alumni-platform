@extends('layouts.app')
@section('title', 'Post a Job')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Post a Job / Internship</h1>
        <p class="pf-page-sub">Share career opportunities with the alumni community.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('jobs.store') }}">
            @csrf
            @include('jobs.partials.form', ['job' => $job])
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Post Listing</button>
                <a href="{{ route('jobs.index') }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
