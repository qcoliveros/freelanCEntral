# About freelanCEntral

freelanCEntral is a job board that uniquely focuses on unpaid short-term remote
work. The model is similar to internships in that the worker will not receive
salaries/allowances, but instead gain relevant experience and
recommendation/certification from the manager. This concept is particularly helpful for
workers who may have little to no relevant job experience: for example, fresh
graduates or even mid-career professionals who need to gain experience for a career
upgrade or switch. This model also eliminates the need to observe legislative
requirements and draft formal employment contracts.

## Installation

1. Clone the repository locally.
```
git clone https://github.com/qcoliveros/freelanCEntral.git freelanCEntral
cd freelanCEntral
```
2. Install PHP dependencies.
```
composer install
```
3. Install NPM dependencies.
```
npm ci
```
4. Build assets.
```
npm run dev
```
5. Setup configuration.
```
cp .env.example .env
```
6. Generate application key.
```
php artisan key:generate
```
7. Update the database username and password in .env file.
```
DB_USERNAME=root
DB_PASSWORD=
```
8. Run database migrations.
```
php artisan make:database
php artisan migrate:fresh --seed
```
9. Create a symbolic link in public directory to allow user profile's images.
```
php artisan storage:link
```
10. Run the dev server (the output will give the address).
```
php artisan serve
```
