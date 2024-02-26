# Furniture E-Commerce

Furniture e-commerce is an online business that offers furniture and household products online. The concept allows customers to purchase furniture from online stores and access a wider range of product choices, price comparisons, and shopping convenience from home. The furniture e-commerce typically has an extensive product catalog, which includes various types of furniture such as sofas, tables, chairs, cabinets, beds, and other accessories. The e-commerce website usually provides detailed product descriptions, photos, and pricing information, as well as offering various payment methods and product delivery options to customers., and the purpose of creating this system is for learning purposes on Laravel version 10. This application was created using Laravel v10 and requires a minimum of PHP v8.1, so if during the installation or usage process there are errors or bugs, it is possible that it is due to an unsupported PHP version.

## Tech Stack

-   **Client :** Tailwind, Blade Template
-   **Server :** PHP with Laravel

## Run Locally

Clone the project

```bash
  git clone https://github.com/khalilannbiya/luxspace.git
```

Or Download ZIP

[Link](https://github.com/khalilannbiya/luxspace/archive/refs/heads/main.zip)

Go to the project directory

```bash
  cd luxspace
```

Run the command

```bash
  composer update
```

Or

```bash
  composer install
```

Copy the .env file from .env.example.

```bash
  cp .env.example .env
```

Please don't forget to create the 'luxspace' database in phpMyAdmin.

Configure the .env file

```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=luxspace
  DB_USERNAME=root
  DB_PASSWORD=
```

Setup Midtrans for payment gateway in file .env

```bash
  MIDTRANS_SERVER_KEY="get key from web midtrans, check your midtrans account"
  MIDTRANS_CLIENT_KEY="get key from web midtrans, check your midtrans account"
  MIDTRANS_IS_PRODUCTION=false
  MIDTRANS_IS_SANITIZED=true
  MIDTRANS_IS_3DS=true
```

Setup Mailtrap for email testing in file .env

```bash
  MAIL_MAILER="check conguration at mailtrap account"
  MAIL_HOST="check conguration at mailtrap account"
  MAIL_PORT="check conguration at mailtrap account"
  MAIL_USERNAME="check conguration at mailtrap account"
  MAIL_PASSWORD="check conguration at mailtrap account"
  MAIL_ENCRYPTION="check conguration at mailtrap account"

  MAIL_FROM_ADDRESS="hello@example.com"
  MAIL_FROM_NAME="${APP_NAME}"
```

Generate key

```bash
  php artisan key:generate
```

Create symlink
```bash
  php artisan storage:link
```

Migrate database

```bash
  php artisan migrate
```

Run User Seeder

```bash
  php artisan db:seed --class=UserSeeder
```

Install node_modules

```bash
  npm i
```

Run npm run dev

```bash
  npm run dev
```

Run serve

```bash
  php artisan serve
```

## Documentation

-   [Tailwind](https://tailwindcss.com/docs/installation)
-   [Blade Template](https://laravel.com/docs/9.x/blade)
-   [Laravel](https://laravel.com/docs/9.x)

## Features

-   Product Management
-   Transaction Management
-   Login
-   Register
-   Checkout Product

## Feedback

If you have any feedback, please reach out to us at syeichkhalil@gmail.com
