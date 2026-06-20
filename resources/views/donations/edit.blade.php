@extends('layouts.app')
@section('title', 'Edit Donation')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Edit Donation</h1>
        <p class="pf-page-sub">Update donation details and pledge status.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('donations.update', $donation) }}">
            @csrf @method('PUT')
            @include('donations.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Update Donation</button>
                <a href="{{ route('donations.show', $donation) }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
