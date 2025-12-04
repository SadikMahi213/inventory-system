# Inventory Management ERP System - Installation Guide

## System Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or MariaDB >= 10.2
- Node.js >= 16.x
- NPM >= 8.x
- Apache or Nginx web server

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url>
cd inventory-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Database Configuration

Update the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Run Database Seeders (Optional)

```bash
php artisan db:seed
```

### 8. Compile Assets

```bash
npm run dev
```

Or for production:

```bash
npm run build
```

### 9. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Additional Configuration

### Google Maps API Key

To enable Google Maps functionality, add your Google Maps API key to the `.env` file:

```env
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```

### Mail Configuration

Update the mail settings in the `.env` file for email notifications:

```env
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Troubleshooting

### Common Issues

1. **Permission denied errors**: Ensure the `storage` and `bootstrap/cache` directories are writable:

   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

2. **Missing extensions**: Make sure you have the required PHP extensions installed:
   - OpenSSL
   - PDO
   - Mbstring
   - Tokenizer
   - XML
   - Ctype
   - JSON

3. **Database connection errors**: Verify your database credentials in the `.env` file.

### Clearing Cache

If you encounter issues, try clearing the cache:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Deployment

For production deployment, make sure to:

1. Set `APP_ENV=production` in the `.env` file
2. Set `APP_DEBUG=false` in the `.env` file
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Ensure proper file permissions for production

## Support

For support, please contact the development team or refer to the Laravel documentation at https://laravel.com/docs.