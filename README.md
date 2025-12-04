# Inventory Management ERP System

A complete Inventory Management + Purchase/Sales/Stock + Accounting + Dashboard ERP system built with Laravel 11, MySQL, React/JS, Tailwind CSS, and jQuery.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Database Schema](#database-schema)
- [Modules](#modules)
- [Contributing](#contributing)
- [License](#license)

## Overview

This ERP system streamlines business operations by managing the complete workflow from purchase to profit/loss calculation:

**Purchase → Product Master → Analysis → Pricing → Sales → P/L → Dashboard**

The system includes modules for inventory management, purchase orders, sales tracking, stock control, financial reporting, and more.

## Features

### Core Modules
- **Purchase Management**: Track all purchase records with supplier information
- **Product Master**: Maintain comprehensive product information with unique codes
- **Cost Analysis**: Calculate costs including staff, shop, transport, and other expenses
- **Sales Management**: Track sales records with customer information
- **Stock Control**: Real-time inventory tracking with automatic updates
- **Profit & Loss**: Automated financial calculations and reporting
- **Dashboard**: KPIs, charts, and reports for business insights

### Additional Features
- **Authentication**: Secure user authentication with Laravel Breeze/Fortify
- **Admin Panel**: Comprehensive administration tools
- **Public Website**: Front-facing website with media gallery and contact forms
- **CSV Import/Export**: Data import and export capabilities for all modules
- **Responsive Design**: Mobile-friendly interface with Tailwind CSS
- **Google Maps Integration**: Location services on the contact page
- **Social Media Links**: Integrated social media presence

## Tech Stack

### Backend
- **PHP 8.1+**
- **Laravel 11**
- **MySQL 5.7+**

### Frontend
- **HTML5**
- **CSS3**
- **Tailwind CSS**
- **JavaScript**
- **jQuery**
- **Chart.js** (for dashboard charts)

### Development Tools
- **Composer** (PHP dependency manager)
- **Node.js/NPM** (Frontend asset compilation)
- **Vite** (Asset bundling)

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL >= 5.7 or MariaDB >= 10.2
- Node.js >= 16.x
- NPM >= 8.x
- Apache or Nginx web server

### Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd inventory-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   Update the `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Run database seeders (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile assets**
   ```bash
   # For development
   npm run dev
   
   # For production
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`.

## Usage

### Default Credentials
After running the database seeders, you can log in with:

- **Admin User**: 
  - Email: `admin@example.com`
  - Password: `password`

- **Regular User**:
  - Email: `user@example.com`
  - Password: `password`

### Navigation
1. Visit `http://localhost:8000` to access the public website
2. Click "Login" to access the admin panel
3. Use the sidebar navigation to access different modules

## API Documentation

Detailed API documentation is available in the [API.md](documentation/API.md) file.

## Testing

Run the test suite with:

```bash
php artisan test
```

## Database Schema

The system includes the following main tables:

- `users` - User accounts and authentication
- `products` - Product master data
- `suppliers` - Supplier information
- `customers` - Customer information
- `purchase_records` - Purchase transaction records
- `sales_records` - Sales transaction records
- `stock` - Current inventory levels
- `profit_loss` - Financial calculations and reports
- `cost_analysis` - Detailed cost breakdowns
- `media` - Uploaded media files
- `dashboard_settings` - Dashboard configuration

## Modules

### 1. Purchase Records
Manage all purchase transactions with detailed supplier and product information.

### 2. Product Master
Central repository for all product information with auto-generated product codes.

### 3. Cost Analysis
Calculate all business costs including staff, shop, transport, and other expenses.

### 4. Sales Records
Track all sales transactions with customer information and payment status.

### 5. Stock Management
Real-time inventory tracking with automatic updates based on purchases and sales.

### 6. Profit & Loss
Automated financial calculations showing revenue, COGS, expenses, and net profit.

### 7. Dashboard
Visual representation of KPIs including:
- Total Stock
- Today's Sales
- Monthly Revenue
- Net Profit
- Fast-moving products
- Low stock alerts

### 8. Admin Panel
Comprehensive administration tools including:
- User management
- System settings
- Logs and backups
- CSV import/export

### 9. Public Website
Front-facing website with:
- Homepage showcasing features
- Media gallery with upload capability
- Contact page with Google Maps integration

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**Note**: This is a demonstration/educational project. For production use, additional security measures and optimizations should be implemented.