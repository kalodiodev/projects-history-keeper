# Projects History Keeper
Projects History Keeper is a web application built on Laravel Framework, that helps you keep a history log of your projects changes

## Installation

### Step 1.
Clone this repository and install all Composer dependencies.
```
git clone git@github.com:kalodiodev/projects-history-keeper.git
cd projects-history-keeper
composer install
```

### Step 2.
Rename or Copy .env.example file to .env and generate application key.
```
cp .env.example .env
php artisan key:generate
```

### Step 3.
Create a new database and reference its name and username/password within the project's `.env` file. Like the example below
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=history_keeper
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4.
Migrate database
```
php artisan migrate --seed
```

### Step 5.
Create admin user
```
php artisan make:admin
```