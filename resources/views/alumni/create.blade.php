@extends('layouts.app')

@section('title', 'Add Alumni')

@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Add New Alumni</h1>
        <p class="pf-page-sub">Fill in the details below to register a new alumni member.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('alumni.store') }}" enctype="multipart/form-data">
            @include('alumni.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Save Alumni</button>
                <a href="{{ route('alumni.index') }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
