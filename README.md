<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Visitor Management

 This Visitor Management System has been developed in Laravel framework, MySQL Database, Bootstrap 5 Library and jQuery. This Visitor Management System has been develop in Laravel Framework and This System is a simple mini project which help us to keeping records of data of Visitors who has visit in our premises, building or office space. This Visitor Management System project has mainly two user, one is an Admin User and and second one is a Sub User.

 These are the following features of Laravel based Online Visitor Management System Project:

 
- Keep & Track Visitor Data
- Simple & Clean Visitor Analytics Data with different filter
- Export Visitor Data to CSV file format based on different filter
- Admin User can view and track all User data in single dashboard
- Sub User can view only their data which they has entered
- Registration form for set up Admin Account
- Common Login page for Admin and Sub User for Log in into Visitor Management - System
- Admin can Add, Edit and Delete Sub User Data
- Admin can Add, Edit, remove and manage department and person data
- Admin can change their profile details like name, email and change password
- Sub User can Add, Edit, View and Remove Visitor Data
- Sub User can enter visitor outing remarks

## Installation
### please make sure you have [composer]('https://getcomposer.org/download/') installed and configured to use php v8.1
Clone this repo

`git clone https://github.com/edwardmuss/visitor-management.git`

cd into the project and run

`composer install` or `composer update`

Copy `.env.example` and rename it as `.env`

replace database details with yours `from line 11-16`
```
DB_CONNECTION=mysql ## leave as default
DB_HOST=127.0.0.1 ## leave as default
DB_PORT=3306 ## leave as default
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
Run `php artisan migrate`
## Running locally
To test the application, run the follwing command

`php artisan serve`

if successful you will given a link to view the application. normally

`127.0.0.1:8080`

## Deploy on Cpanel
To deploy on a CPanel shared server
1. Create a database
2. Create user
3. Grant the user permision to the database
4. Upload the script to your server, extract the script to the desired location
5. Open `.env` file and replace database credentials with yours
6. Go to `phpmyadmin` and import the sql file in the project folder
7. Visit your domain/subdomain

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [edwardmuss5@gmail.com](mailto:edwardmuss5@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
