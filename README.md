# Laravel POS — TFA7

Developer: Vance Uriele Parido  
Course: IT0049 — Web System Technologies

This project extends the TFA6 Laravel POS application with customer
and user forms, validation, and user avatar uploads.

## Features

- View customer and user accounts.
- Create and edit customers.
- Validate customer names, email addresses, and phone numbers.
- Create and edit users with unique usernames.
- Show validation errors and preserve entered text.
- Upload an optional avatar when editing a user.
- Display user avatars or a default placeholder image.

## Technologies

- Laravel 12
- PHP 8.2.12 or a compatible newer version
- MySQL
- Blade templates and Eloquent
- Intervention Image 3 with the GD driver

## Local Setup

1. Download or clone the repository and open a terminal in the
   folder containing `artisan` and `composer.json`.

2. Install dependencies:

   ```bash
   composer install
   ```

3. Copy `.env.example` to `.env`.

4. Create an empty MySQL database named `laravel_pos_tfa7`.

5. Configure `.env` for your local database:

   ```env
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_pos_tfa7
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Adjust the username and password if your MySQL setup differs.

6. Enable the GD extension in your PHP configuration.
   For XAMPP, open `C:\xampp\php\php.ini` and make sure this
   line has no leading semicolon:

   ```ini
   extension=gd
   ```

   Restart any running PHP development server after changing it.

7. Generate the application key and clear cached configuration:

   ```bash
   php artisan key:generate
   php artisan config:clear
   ```

8. Create the tables and seed sample accounts:

   ```bash
   php artisan migrate --seed
   ```

9. Create the public storage link:

   ```bash
   php artisan storage:link
   ```

10. Start MySQL, then start the development server:

    ```bash
    php artisan serve
    ```

11. Open the address displayed in the terminal.

On Windows with XAMPP, replace `php` with
`C:\xampp\php\php.exe` if necessary.

## Pages

- `/` — Home
- `/about` — About
- `/customers` — Customer Accounts
- `/customers/create` — Create Customer
- `/customers/{customer}/edit` — Edit Customer
- `/users` — User Accounts
- `/users/create` — Create User
- `/users/{user}/edit` — Edit User

Replace the values in braces with an existing record ID.

## Avatar Uploads

Upload an avatar through a user's Edit page.

- Accepted formats: JPG, JPEG, PNG, and WebP.
- Maximum file size: 2 MB.
- Maximum input dimensions: 4096 × 4096 pixels.
- Intervention Image prepares a 200 × 200 JPEG thumbnail.
- Files are stored through `Storage::disk('public')`.
- Only the relative file path is saved in the `avatar` column.
- Uploads use generated filenames.
- Editing without a new upload preserves the current avatar.
- Replacing an avatar removes the previous image after the
  database update succeeds.
- Users without an avatar display a placeholder image.

Uploaded avatars are stored in `storage/app/public/avatars`.
The local storage link makes them available through `/storage`.

Browsers require users to select the image again after a
validation error. Text fields retain their entered values.

## Validation Checks

- Required fields cannot be empty.
- Customer email addresses must be valid.
- Duplicate usernames are rejected.
- Users can keep their current username when editing.
- Invalid or oversized avatar uploads are rejected.

PHP also applies its own upload limits. To let Laravel show its
2 MB validation message, configure PHP's `upload_max_filesize`
above 2 MB and `post_max_size` above that upload limit.

## Deployment Notes

- Set production database credentials in the server's `.env`.
- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Set `APP_URL` to the hosted website address.
- Keep `.env` and credentials out of GitHub.
- Include production Composer dependencies on the server.
- Ensure the server supports GD and can write to Laravel's
  storage directories.
- Configure the web server to serve Laravel's `public` folder.
- Hosts without symbolic-link support need an alternative
  configuration for serving public-disk avatar files.

Migrations and seeders are included in the repository.
Uploaded avatar files must be transferred separately when
moving a populated database to another server.