# Tattoo Shop Management System

A full-stack web application for managing a tattoo shop with Angular frontend and Lumen backend.

## Features

- User authentication with JWT
- Role-based access (Customer/Artist)
- Service management
- Appointment booking
- User profile management

## Tech Stack

**Backend:** Lumen 10 (PHP 8.1+), MySQL, JWT Auth  
**Frontend:** Angular 19, Tailwind CSS

## Quick Start

### Backend Setup
```bash
cd tattooBack
composer install
cp .env.example .env
# Configure database in .env
php artisan migrate
php artisan db:seed
php -S localhost:8000 -t public
```

Default artist login:
- Email: `artist@example.com`
- Password: `password`

### Frontend Setup
```bash
cd tattooFront
npm install
ng serve
```

Visit `http://localhost:4200`

## API Endpoints

**Auth:**
- POST `/auth/register` - Register
- POST `/auth/login` - Login
- POST `/auth/logout` - Logout

**Services:**
- GET `/service/allServices` - List services
- POST `/service/create` - Create service (artist)

**Appointments:**
- GET `/appointment` - List appointments
- POST `/appointment` - Book appointment

## License

MIT
