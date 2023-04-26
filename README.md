# Content Management

This project is created using [Laravel Framework](https://laravel.com/).

## Downloading

Follow the instructions below on how to download the project and get started.

### Clone the repo.

Download the project by cloning the repo or download the zip file.

```bash
git clone https://github.com/Jovi9/content-management.git
```

```bash
cd content-management
```

After downloading, go inside the directory and run the following commands.

### Install packages and dependencies.

```bash
composer install
```

```bash
npm install && npm run build
```

### Configure the project

Copy the env example to create the env file and generate the app key.

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

Configure the env file database connection and mail host, change the values of the admin seeder class then run the following commands to create and seed the database.

```bash
php artisan migrate && php artisan db:seed
```

Create public storage link.

```bash
php artisan storage:link
```

### Run the project.

```bash
php artisan serve
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
