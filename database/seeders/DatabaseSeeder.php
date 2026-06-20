<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\JobListing;
use App\Models\Mentorship;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@smtec.edu',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create sample alumni
        $alumni1 = Alumni::create([
            'first_name' => 'John',
            'last_name' => 'Anderson',
            'email' => 'john.anderson@example.com',
            'phone' => '+1 (555) 123-4567',
            'graduation_year' => 2015,
            'degree' => 'Bachelor of Science in Computer Science',
            'department' => 'Computer Science',
            'company' => 'Tech Innovations Inc.',
            'job_title' => 'Senior Software Engineer',
            'location' => 'San Francisco, CA',
            'linkedin_url' => 'https://linkedin.com/in/johnanderson',
            'bio' => 'Passionate software engineer with 8+ years of experience in full-stack development.',
            'is_mentor' => true,
            'available_for_internships' => true,
        ]);

        $alumni2 = Alumni::create([
            'first_name' => 'Sarah',
            'last_name' => 'Mitchell',
            'email' => 'sarah.mitchell@example.com',
            'phone' => '+1 (555) 234-5678',
            'graduation_year' => 2018,
            'degree' => 'Bachelor of Business Administration',
            'department' => 'Business Administration',
            'company' => 'Global Consulting Partners',
            'job_title' => 'Management Consultant',
            'location' => 'New York, NY',
            'linkedin_url' => 'https://linkedin.com/in/sarahmitchell',
            'bio' => 'Experienced consultant specializing in digital transformation.',
            'is_mentor' => true,
            'available_for_internships' => false,
        ]);

        $alumni3 = Alumni::create([
            'first_name' => 'Emily',
            'last_name' => 'Rodriguez',
            'email' => 'emily.rodriguez@example.com',
            'graduation_year' => 2017,
            'degree' => 'Master of Science in Data Science',
            'department' => 'Data Science',
            'company' => 'Analytics Corp',
            'job_title' => 'Lead Data Scientist',
            'location' => 'Seattle, WA',
            'bio' => 'Data scientist passionate about machine learning.',
            'is_mentor' => true,
            'available_for_internships' => true,
        ]);

        User::create([
            'name' => 'John Anderson',
            'email' => 'john.anderson@example.com',
            'password' => Hash::make('password123'),
            'role' => 'alumni',
            'alumni_id' => $alumni1->id,
        ]);

        User::create([
            'name' => 'Sarah Mitchell',
            'email' => 'sarah.mitchell@example.com',
            'password' => Hash::make('password123'),
            'role' => 'alumni',
            'alumni_id' => $alumni2->id,
        ]);

        User::create([
            'name' => 'Emily Rodriguez',
            'email' => 'emily.rodriguez@example.com',
            'password' => Hash::make('password123'),
            'role' => 'alumni',
            'alumni_id' => $alumni3->id,
        ]);

        // Create sample events
        $event1 = Event::create([
            'title' => 'Annual Alumni Reunion 2026',
            'description' => 'Join us for networking, dinner, and special guest speakers.',
            'location' => 'University Main Campus, Grand Hall',
            'starts_at' => now()->addMonths(2),
            'ends_at' => now()->addMonths(2)->addHours(4),
            'organizer' => 'Alumni Relations Office',
            'status' => 'planned',
        ]);

        $event2 = Event::create([
            'title' => 'Career Networking Night',
            'description' => 'Connect with fellow alumni and industry professionals.',
            'location' => 'Downtown Conference Center',
            'starts_at' => now()->addWeeks(3),
            'ends_at' => now()->addWeeks(3)->addHours(3),
            'status' => 'planned',
        ]);

        Announcement::create([
            'title' => 'Welcome to the Centralized Alumni Engagement Platform',
            'body' => 'This platform helps alumni, students, faculty, and administrators stay connected through events, mentorships, career opportunities, and institutional updates.',
            'category' => 'general',
            'is_published' => true,
            'created_by' => $admin->id,
        ]);

        Announcement::create([
            'title' => 'Career Opportunities Now Open for Alumni and Students',
            'body' => 'The new career board includes internships, full-time roles, and collaboration opportunities contributed by alumni and the institution.',
            'category' => 'career',
            'is_published' => true,
            'created_by' => $admin->id,
        ]);

        JobListing::create([
            'title' => 'Software Engineering Intern',
            'company' => 'Tech Innovations Inc.',
            'location' => 'Remote',
            'type' => 'internship',
            'department' => 'Computer Science',
            'description' => 'Work with the product engineering team on modern web development projects and alumni community tools.',
            'requirements' => 'Knowledge of Laravel, JavaScript, and SQL preferred.',
            'contact_email' => 'careers@techinnovations.example',
            'salary_min' => 1500,
            'salary_max' => 2500,
            'expires_at' => now()->addMonth(),
            'status' => 'open',
            'posted_by' => $admin->id,
        ]);

        JobListing::create([
            'title' => 'Management Trainee',
            'company' => 'Global Consulting Partners',
            'location' => 'New York, NY',
            'type' => 'full-time',
            'department' => 'Business Administration',
            'description' => 'Support business transformation projects while learning consulting frameworks and client delivery.',
            'requirements' => 'Strong communication and analytical skills.',
            'contact_email' => 'talent@gcp.example',
            'salary_min' => 42000,
            'salary_max' => 52000,
            'expires_at' => now()->addWeeks(6),
            'status' => 'open',
            'posted_by' => $admin->id,
        ]);

        // Create sample mentorships
        Mentorship::create([
            'alumni_id' => $alumni1->id,
            'area_of_interest' => 'Software Development & Career Guidance',
            'availability' => 'Bi-weekly virtual meetings',
            'status' => 'active',
            'started_at' => now()->subMonths(2),
        ]);

        Mentorship::create([
            'alumni_id' => $alumni2->id,
            'area_of_interest' => 'Business Strategy & Consulting',
            'availability' => 'Monthly meetings',
            'status' => 'active',
            'started_at' => now()->subMonth(),
        ]);

        // Create sample donations
        Donation::create([
            'alumni_id' => $alumni1->id,
            'donor_name' => 'John Anderson',
            'donor_email' => 'john.anderson@example.com',
            'amount' => 5000.00,
            'currency' => 'USD',
            'donated_at' => now()->subMonths(1),
            'purpose' => 'Scholarship Fund',
            'status' => 'received',
        ]);

        Donation::create([
            'alumni_id' => $alumni3->id,
            'donor_name' => 'Emily Rodriguez',
            'donor_email' => 'emily.rodriguez@example.com',
            'amount' => 10000.00,
            'currency' => 'USD',
            'donated_at' => now()->addMonth(),
            'purpose' => 'Data Science Lab Equipment',
            'status' => 'pledged',
        ]);

        EventRegistration::create([
            'event_id' => $event1->id,
            'alumni_id' => $alumni1->id,
            'status' => 'registered',
        ]);

        EventRegistration::create([
            'event_id' => $event2->id,
            'alumni_id' => $alumni2->id,
            'status' => 'registered',
        ]);
    }
}

