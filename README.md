# Alumni Nexus

A comprehensive alumni management system built with Laravel 11. Alumni Nexus provides a centralized platform for managing alumni data, tracking engagements, organizing events, facilitating mentorships, and recording donations.

## Features

### 📋 Alumni Directory
- Complete alumni profile management with personal and professional information
- Advanced search and filtering capabilities
- Graduation year, degree, department tracking
- Current employment information (company, job title, location)
- LinkedIn profile integration
- Mentor availability tracking
- Internship opportunity flags

### 📅 Event Management
- Create and manage alumni events (reunions, networking sessions, workshops)
- Event scheduling with start/end times
- Location and organizer tracking
- Registration URL integration
- Event status management (planned, completed, cancelled)
- Search and filter by status

### 🤝 Mentorship Program
- Track mentorship opportunities and relationships
- Alumni-mentee matching
- Area of interest categorization
- Availability scheduling
- Status tracking (open, active, closed)
- Start and end date management
- Notes and progress tracking

### 💰 Donation Tracking
- Record alumni and external donations
- Pledge vs. received status
- Multi-currency support
- Purpose and notes documentation
- Donor contact information
- Integration with alumni profiles
- Comprehensive reporting

### 📊 Dashboard
- Real-time statistics overview
- Total alumni count
- Event tracking
- Active mentorship count
- Donation metrics and total amounts
- Recently added alumni
- Upcoming events feed

## Technology Stack

- **Framework:** Laravel 11.x
- **PHP:** 8.2+
- **Database:** MySQL 8.0
- **Frontend:** Blade Templates with Tailwind CSS v4
- **Server:** Apache (XAMPP)

## Prerequisites

- XAMPP (or separate PHP 8.2+, MySQL 8.0+, Apache)
- Composer
- Node.js & npm (for asset compilation)

## Installation

### 1. Clone or Download the Project

The project is located in: `c:\xampp\htdocs\Alumni-project\Alumni-project`

### 2. Install PHP Dependencies

```bash
cd c:\xampp\htdocs\Alumni-project\Alumni-project
composer install
```

### 3. Environment Configuration

The `.env` file is already configured. Verify these settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alumni_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Start XAMPP Services

1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services

### 5. Create Database

Open Command Prompt or PowerShell and run:

```bash
c:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS alumni_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Or use phpMyAdmin:
1. Navigate to `http://localhost/phpmyadmin`
2. Create a new database named `alumni_db`
3. Set collation to `utf8mb4_unicode_ci`

### 6. Run Database Migrations

```bash
cd c:\xampp\htdocs\Alumni-project\Alumni-project
php artisan migrate
```

This will create the following tables:
- `users`
- `alumni`
- `events`
- `mentorships`
- `donations`
- `cache`, `jobs`, `sessions` (framework tables)

### 7. Seed Sample Data (Optional)

To populate the database with sample alumni, events, mentorships, and donations for testing:

```bash
php artisan db:seed
```

This will create:
- 3 sample alumni profiles with complete information
- 2 upcoming events
- 2 active mentorships
- 2 donation records

**Note:** You can skip this step if you want to start with an empty database.

### 8. Install Node Dependencies (Optional)

For asset compilation with Vite:

```bash
npm install
```

### 8. Compile Assets (Optional)

If you want to compile Tailwind CSS:

```bash
npm run build
```

Or for development with hot reload:

```bash
npm run dev
```

**Note:** The application includes a fallback CSS file (`public/css/app-fallback.css`), so it will work without running Vite.

### 9. Start the Application

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

Or use XAMPP's Apache server by accessing: `http://localhost/Alumni-project/Alumni-project/public`

## Usage Guide

### Dashboard
- Access at `/` or the home route
- View statistics and recent activities
- Quick access to create alumni profiles and events

### Alumni Management
- **List Alumni:** Navigate to "Alumni" in the navigation
- **Add Alumni:** Click "Add Alumni" button
- **Search:** Use the search box to find alumni by name, email, or company
- **View Profile:** Click "View" on any alumni record
- **Edit/Delete:** Available on the alumni detail page

### Event Management
- **List Events:** Navigate to "Events"
- **Create Event:** Click "Create Event"
- **Filter:** Filter events by status (planned, completed, cancelled)
- **Search:** Search events by title

### Mentorship Tracking
- **List Mentorships:** Navigate to "Mentorships"
- **Create Mentorship:** Click "New Mentorship"
- **Filter:** Filter by status (open, active, closed)
- **Link to Alumni:** Each mentorship is linked to an alumni profile

### Donation Recording
- **List Donations:** Navigate to "Donations"
- **Log Donation:** Click "Log Donation"
- **Filter:** Filter by status (received, pledged)
- **Track:** Link donations to alumni profiles or record external donations

## Database Schema

### Alumni Table
- Personal info (first name, last name, email, phone)
- Academic info (graduation year, degree, department)
- Professional info (company, job title, location)
- Social (LinkedIn URL, bio)
- Engagement flags (is_mentor, available_for_internships)
- Last contacted date

### Events Table
- Title, description, location
- Start and end datetime
- Organizer, registration URL
- Status (planned, completed, cancelled)

### Mentorships Table
- Foreign key to alumni
- Area of interest, availability
- Status (open, active, closed)
- Start and end dates, notes

### Donations Table
- Optional foreign key to alumni
- Donor details (name, email)
- Amount, currency
- Donation date, purpose
- Status (received, pledged), notes

## Project Structure

```
Alumni-project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AlumniController.php
│   │       ├── DashboardController.php
│   │       ├── DonationController.php
│   │       ├── EventController.php
│   │       └── MentorshipController.php
│   └── Models/
│       ├── Alumni.php
│       ├── Donation.php
│       ├── Event.php
│       └── Mentorship.php
├── database/
│   └── migrations/
│       ├── 2026_02_01_000003_create_alumni_table.php
│       ├── 2026_02_01_000004_create_events_table.php
│       ├── 2026_02_01_000005_create_mentorships_table.php
│       └── 2026_02_01_000006_create_donations_table.php
├── resources/
│   ├── css/
│   │   └── app.css (Tailwind CSS v4)
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── alumni/ (index, create, edit, show)
│       ├── events/ (index, create, edit, show)
│       ├── mentorships/ (index, create, edit, show)
│       ├── donations/ (index, create, edit, show)
│       └── dashboard.blade.php
└── routes/
    └── web.php
```

## Features Breakdown

### Alumni Controller
- Full CRUD operations
- Search functionality (name, email, company, job title)
- Pagination (10 per page)
- Data validation
- Relationship loading (mentorships, donations)

### Event Controller
- Full CRUD operations
- Search by title
- Filter by status
- Date/time validation
- Pagination

### Mentorship Controller
- Full CRUD operations
- Alumni relationship
- Status filtering
- Date range validation
- Pagination

### Donation Controller
- Full CRUD operations
- Optional alumni linking
- Status filtering
- Currency support
- Amount calculations
- Pagination

## Customization

### Pagination
Change the number of items per page in controllers:
```php
->paginate(20) // Change from 10 to 20
```

### Currency
Default currency is USD. Modify in:
- `DonationController::validateDonation()`
- `resources/views/donations/partials/form.blade.php`

### Status Options
Modify status enums in respective controllers:
- Events: `planned`, `completed`, `cancelled`
- Mentorships: `open`, `active`, `closed`
- Donations: `received`, `pledged`

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running in XAMPP
- Verify credentials in `.env`
- Check database `alumni_db` exists

### Page Not Found (404)
- Ensure you're accessing `public/` directory
- Check Apache is running
- Verify `.htaccess` exists in `public/`

### CSS Not Loading
- The fallback CSS is included at `public/css/app-fallback.css`
- To use compiled Tailwind, run `npm run build`
- Ensure `public/build/` directory has the compiled assets

### Migration Errors
- Drop all tables and re-run: `php artisan migrate:fresh`
- Check foreign key constraints
- Ensure MySQL version is 8.0+

## Development

### Adding New Migrations

```bash
php artisan make:migration create_table_name
```

### Creating Controllers

```bash
php artisan make:controller ControllerName --resource
```

### Creating Models

```bash
php artisan make:model ModelName -m
```

## Security

- CSRF protection enabled on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Email validation
- URL validation

## Future Enhancements

- [ ] User authentication and roles
- [ ] Email notifications
- [ ] Export to CSV/PDF
- [ ] Advanced reporting and analytics
- [ ] Event RSVP management
- [ ] Photo uploads for alumni
- [ ] Social media integration
- [ ] API endpoints
- [ ] Mobile responsive improvements

## License

This project is open-source and available for educational purposes.

## Support

For issues or questions, please review the Laravel documentation:
- [Laravel 11.x Documentation](https://laravel.com/docs/11.x)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)
- [Blade Templates](https://laravel.com/docs/11.x/blade)
- [Tailwind CSS](https://tailwindcss.com/docs)
