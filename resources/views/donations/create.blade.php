@extends('layouts.app')
@section('title', 'Log Donation')
@section('content')
<div class="pf-page">
    <div class="pf-page-header">
        <h1 class="pf-page-title">Log Donation</h1>
        <p class="pf-page-sub">Record alumni contributions and fundraising outcomes.</p>
    </div>
    <div class="pf-card">
        <form method="POST" action="{{ route('donations.store') }}">
            @include('donations.partials.form')
            <div class="pf-actions">
                <button type="submit" class="pf-btn-submit">Save Donation</button>
                <a href="{{ route('donations.index') }}" class="pf-btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
