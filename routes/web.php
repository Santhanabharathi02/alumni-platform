<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnnouncementCommentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\MentorshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// ─── Guest routes (not logged in) ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ─── Authenticated routes ──────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Alumni – directory visible to all; create/delete admin only
    Route::resource('alumni', AlumniController::class);
    Route::get('alumni-export', [AlumniController::class, 'export'])->name('alumni.export');
    Route::post('alumni/{alumnus}/create-account', [AlumniController::class, 'createAccount'])->name('alumni.create-account');

    // Events
    Route::resource('events', EventController::class);
    Route::get('events/{event}/registrations', [EventRegistrationController::class, 'index'])->name('events.registrations');
    Route::post('events/{event}/register', [EventRegistrationController::class, 'store'])->name('events.rsvp');
    Route::delete('events/{event}/register', [EventRegistrationController::class, 'destroy'])->name('events.cancel-rsvp');

    // Mentorships & Donations
    Route::resource('mentorships', MentorshipController::class);
    Route::resource('donations', DonationController::class);

    // Job Board
    Route::resource('jobs', JobListingController::class);

    // Announcements
    Route::resource('announcements', AnnouncementController::class);

    // Announcement Comments
    Route::post('announcements/{announcement}/comments', [AnnouncementCommentController::class, 'store'])->name('announcement.comments.store');
    Route::delete('announcement-comments/{comment}', [AnnouncementCommentController::class, 'destroy'])->name('announcement.comments.destroy');

    // Messages (Alumni ↔ Admin)
    Route::resource('messages', MessageController::class)->except(['edit', 'update']);
    Route::post('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::post('messages/{message}/alumni-reply', [MessageController::class, 'alumniReply'])->name('messages.alumni-reply');

    // Notifications
    Route::get('notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
});
