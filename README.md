# Esports Management System - Laravel Backend

A robust Laravel-based backend for managing eSports centers, including seat bookings, inventory management, match records, and more.

## Key Features

- **Seat Booking System**: Manage and track seat availability and customer bookings.
- **Inventory Management**: Keep track of hardware, peripheral components, and equipment.
- **Price Configuration**: Flexible pricing setup for different seat tiers or services.
- **Match Outcomes & Records**: Record game results and maintain match history.
- **Announcements Management**: Schedule and display banners/announcements for users.
- **Admin Dashboard**: Comprehensive administrative interface powered by Open Admin.

## ExampleScreenshots

<p align="center">
  <img src="docs/screenshots/dashboard.png" width="45%" alt="Dashboard Overview">
  <img src="docs/screenshots/seats.png" width="45%" alt="Seat Management">
</p>
<p align="center">
  <img src="docs/screenshots/inventory.png" width="45%" alt="Inventory List">
  <img src="docs/screenshots/records_list.png" width="45%" alt="Records list">
</p>
<p align="center">
  <img src="docs/screenshots/record_create.png" width="90%" alt="Record Creation">
</p>

## Tech Stack

- **Framework**: [Laravel 10.x](https://laravel.com/)
- **Language**: PHP 8.1+
- **Database**: MySQL
- **Authentication**: Laravel Sanctum (API tokens)
- **Admin Panel**: [Open Admin](https://open-admin.org/)

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Apache or Nginx (XAMPP recommended for local dev)

### Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd back-end-rc
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   ```
   *Configure your database credentials in the `.env` file.*

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

## Admin Access

Once the server is running, the admin dashboard is accessible at:
`http://localhost:8000/admin`

Default credentials (if seeded):
- **Username**: `admin`
- **Password**: `admin`

## API Endpoints

The API routes are defined in `routes/api.php`. Most endpoints require a bearer token obtained via Laravel Sanctum.

---
*Created with ❤️ for Esports Management.*
