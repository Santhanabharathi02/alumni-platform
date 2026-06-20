# Quick Start Guide - Alumni Nexus

Get your Alumni Nexus system up and running in minutes!

## ⚡ Quick Setup (5 Minutes)

### Step 1: Start XAMPP
1. Open **XAMPP Control Panel**
2. Click **Start** for **Apache**
3. Click **Start** for **MySQL**

### Step 2: Create Database

**Option A: Using Command Line**
```bash
c:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS alumni_db;"
```

**Option B: Using phpMyAdmin**
1. Go to `http://localhost/phpmyadmin`
2. Click "New" in the left sidebar
3. Database name: `alumni_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

### Step 3: Run Migrations
```bash
cd c:\xampp\htdocs\Alumni-project\Alumni-project
php artisan migrate
```

### Step 4: Start the Server
```bash
php artisan serve
```

### Step 5: Access the Application
Open your browser and go to:
```
http://localhost:8000
```

✅ **You're done!** The Alumni Nexus system is ready to use.

## 📝 First Steps

### 1. Add Your First Alumni
- Click **"Add Alumni"** on the dashboard
- Fill in the required fields (First Name, Last Name, Email)
- Click **"Save Alumni"**

### 2. Create an Event
- Navigate to **Events** in the menu
- Click **"Create Event"**
- Enter event details
- Click **"Save Event"**

### 3. Log a Mentorship
- Navigate to **Mentorships**
- Click **"New Mentorship"**
- Select an alumni and enter details
- Click **"Save Mentorship"**

### 4. Record a Donation
- Navigate to **Donations**
- Click **"Log Donation"**
- Enter donor information and amount
- Click **"Save Donation"**

## 🔧 Troubleshooting

### "Can't connect to MySQL"
- Make sure MySQL is running in XAMPP Control Panel
- Green indicator should be showing next to MySQL

### "Database 'alumni_db' doesn't exist"
- Follow Step 2 above to create the database

### "Class not found" errors
- Run: `composer install`
- Wait for all dependencies to download

### "Page not found" or routing issues
- Make sure you're using: `http://localhost:8000`
- Or ensure Apache is pointing to the `public/` directory

### CSS not showing/broken layout
- The app includes fallback CSS and will work without building
- To build assets: `npm install && npm run build`

## 📊 Sample Data (Optional)

To quickly populate your database with sample data for testing:

### Create Sample Alumni
Use the "Add Alumni" form with:
- John Doe, john@example.com, Class of 2020
- Jane Smith, jane@example.com, Class of 2019
- Bob Johnson, bob@example.com, Class of 2021

### Create Sample Events
- Alumni Reunion 2026 - Scheduled for next month
- Career Networking Night - Monthly event
- Annual Fundraising Gala - Annual event

## ⌨️ Keyboard Shortcuts & Tips

- **Search Alumni**: Use Ctrl+F on the alumni page, then type in the search box
- **Quick Navigation**: Use the top menu bar to switch between sections
- **Edit Quickly**: Click "View" on any record, then "Edit" button
- **Filter Results**: Use dropdown filters on list pages

## 🚀 Next Steps

1. **Customize Settings**: Edit `.env` file for your specific needs
2. **Add More Alumni**: Import your existing alumni database
3. **Plan Events**: Create upcoming events for better engagement
4. **Track Mentorships**: Link mentors with mentees
5. **Record Donations**: Keep track of all contributions

## 📱 Using on Different Devices

### Access from Other Devices on Your Network
1. Find your computer's IP address:
   ```bash
   ipconfig
   ```
   Look for "IPv4 Address" (e.g., 192.168.1.100)

2. Access from other devices:
   ```
   http://192.168.1.100:8000
   ```

### Note on Security
- This is a development setup
- For production use, implement proper authentication
- Never expose your development server directly to the internet

## 🆘 Need Help?

- Check the main [README.md](README.md) for detailed documentation
- Review Laravel documentation: https://laravel.com/docs/11.x
- Check XAMPP documentation: https://www.apachefriends.org/

## ✅ Checklist

- [ ] XAMPP Apache started
- [ ] XAMPP MySQL started
- [ ] Database `alumni_db` created
- [ ] Migrations run successfully (`php artisan migrate`)
- [ ] Server running (`php artisan serve`)
- [ ] Accessed `http://localhost:8000` successfully
- [ ] Dashboard loads with statistics
- [ ] Created at least one alumni record
- [ ] Created at least one event

Once all items are checked, you're ready to use the full system!
