# Alumni Nexus - Deployment Guide

This guide covers deploying the Alumni Nexus application to different environments.

## Development Environment (XAMPP)

### Prerequisites
- XAMPP installed with PHP 8.2+ and MySQL 8.0+
- Composer installed
- Node.js and npm (optional, for asset compilation)

### Setup Steps

1. **Clone/Copy Project**
   ```bash
   # Project should be in: c:\xampp\htdocs\Alumni-project\Alumni-project
   ```

2. **Install Dependencies**
   ```bash
   cd c:\xampp\htdocs\Alumni-project\Alumni-project
   composer install
   npm install  # Optional, for Tailwind compilation
   ```

3. **Configure Environment**
   - Edit `.env` file
   - Set database credentials (default: root with no password)
   - Verify `DB_DATABASE=alumni_db`

4. **Start Services**
   - Open XAMPP Control Panel
   - Start Apache
   - Start MySQL

5. **Create Database**
   ```bash
   c:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS alumni_db;"
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Sample Data (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Start Application**
   ```bash
   php artisan serve
   ```
   Access at: `http://localhost:8000`

## Production Deployment

### Shared Hosting (cPanel)

1. **Upload Files**
   - Upload all files to your hosting account
   - Place Laravel files in a folder (e.g., `laravel`)
   - Point your domain's document root to `laravel/public`

2. **Database Setup**
   - Create MySQL database via cPanel
   - Note database name, username, and password
   - Update `.env` file with these credentials

3. **Configure .env**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

4. **Install Dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

5. **Optimize Application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate --force
   ```

7. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

### VPS/Cloud Server (Ubuntu)

1. **System Requirements**
   ```bash
   # Update system
   sudo apt update && sudo apt upgrade -y
   
   # Install PHP 8.2
   sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip -y
   
   # Install MySQL
   sudo apt install mysql-server -y
   
   # Install Composer
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   
   # Install Nginx
   sudo apt install nginx -y
   ```

2. **Clone Project**
   ```bash
   cd /var/www
   # Upload or git clone your project
   sudo chown -R www-data:www-data alumni-nexus
   ```

3. **Configure Nginx**
   ```nginx
   server {
       listen 80;
       server_name yourdomain.com;
       root /var/www/alumni-nexus/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;

       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

4. **MySQL Setup**
   ```bash
   sudo mysql
   CREATE DATABASE alumni_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'alumni_user'@'localhost' IDENTIFIED BY 'strong_password';
   GRANT ALL PRIVILEGES ON alumni_db.* TO 'alumni_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

5. **Application Setup**
   ```bash
   cd /var/www/alumni-nexus
   composer install --optimize-autoloader --no-dev
   php artisan key:generate
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/alumni-nexus
   sudo chmod -R 755 /var/www/alumni-nexus
   sudo chmod -R 775 /var/www/alumni-nexus/storage
   sudo chmod -R 775 /var/www/alumni-nexus/bootstrap/cache
   ```

7. **Configure SSL (Let's Encrypt)**
   ```bash
   sudo apt install certbot python3-certbot-nginx -y
   sudo certbot --nginx -d yourdomain.com
   ```

## Docker Deployment

### Dockerfile

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

### docker-compose.yml

```yaml
version: '3.8'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: alumni-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - alumni-network

  nginx:
    image: nginx:alpine
    container_name: alumni-nginx
    restart: unless-stopped
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/conf.d/:/etc/nginx/conf.d/
    networks:
      - alumni-network

  mysql:
    image: mysql:8.0
    container_name: alumni-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: alumni_db
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_PASSWORD: secret
      MYSQL_USER: alumni
    volumes:
      - mysql-data:/var/lib/mysql
    networks:
      - alumni-network

networks:
  alumni-network:
    driver: bridge

volumes:
  mysql-data:
    driver: local
```

## Security Checklist

### Before Deployment

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate new `APP_KEY` with `php artisan key:generate`
- [ ] Update `APP_URL` to your domain
- [ ] Set strong database passwords
- [ ] Review and update CORS settings if needed
- [ ] Enable HTTPS/SSL certificate
- [ ] Configure firewall rules
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Restrict access to `.env` file
- [ ] Configure backup strategy

### Post-Deployment

- [ ] Test all CRUD operations
- [ ] Verify email functionality (if configured)
- [ ] Test database connections
- [ ] Monitor error logs
- [ ] Set up monitoring (e.g., Laravel Telescope, Sentry)
- [ ] Configure automated backups
- [ ] Set up SSL auto-renewal (if using Let's Encrypt)

## Performance Optimization

### Cache Configuration

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Clear all caches (if needed)
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Optimization

```sql
-- Add indexes for frequently searched fields
CREATE INDEX idx_alumni_email ON alumni(email);
CREATE INDEX idx_alumni_graduation_year ON alumni(graduation_year);
CREATE INDEX idx_events_starts_at ON events(starts_at);
CREATE INDEX idx_donations_donated_at ON donations(donated_at);
```

### Asset Optimization

```bash
# Build production assets
npm run build

# Optimize images before upload
# Use tools like ImageOptim, TinyPNG, or Squoosh
```

## Backup Strategy

### Database Backup

```bash
# Manual backup
mysqldump -u username -p alumni_db > backup_$(date +%Y%m%d_%H%M%S).sql

# Automated daily backup (add to crontab)
0 2 * * * mysqldump -u username -p'password' alumni_db > /path/to/backups/alumni_db_$(date +\%Y\%m\%d).sql
```

### File Backup

```bash
# Backup entire application
tar -czf alumni_backup_$(date +%Y%m%d).tar.gz /path/to/alumni-nexus

# Backup only storage folder
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/
```

## Monitoring

### Log Files

```bash
# Application logs
tail -f storage/logs/laravel.log

# Nginx access logs
tail -f /var/log/nginx/access.log

# Nginx error logs
tail -f /var/log/nginx/error.log

# MySQL logs
tail -f /var/log/mysql/error.log
```

### Health Checks

Create a simple health check endpoint:

```php
// routes/web.php
Route::get('/health', function () {
    try {
        \DB::connection()->getPdo();
        return response()->json([
            'status' => 'healthy',
            'database' => 'connected',
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'unhealthy',
            'database' => 'disconnected',
            'error' => $e->getMessage()
        ], 500);
    }
});
```

## Troubleshooting

### Common Issues

**500 Internal Server Error**
- Check PHP error logs
- Verify `.env` configuration
- Run `php artisan cache:clear`
- Check file permissions

**Database Connection Failed**
- Verify database credentials in `.env`
- Ensure MySQL is running
- Check firewall rules

**Assets Not Loading**
- Run `npm run build`
- Check public/build directory exists
- Verify Vite configuration

**Slow Performance**
- Enable caching (config, route, view)
- Add database indexes
- Consider Redis for caching
- Optimize database queries

## Support

For production deployment assistance:
- Laravel Forge: https://forge.laravel.com
- Laravel Vapor: https://vapor.laravel.com
- DigitalOcean App Platform
- AWS Elastic Beanstalk
- Heroku
