@extends('layouts.app')
@section('title', 'Edit Alumni')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Edit Alumni</h1>
        <p class="pf-page-sub">Update alumni contact and engagement details.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('alumni.update', ['alumnus' => $alumni->id]) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('alumni.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Update Alumni</button>
                <a href="{{ route('alumni.show', ['alumnus' => $alumni->id]) }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
