# My books
> Simple app that will help you manage your books collection

#### Database structure
<a href="https://github.com/Christian-Vasilev/Books"><img src="https://i.imgur.com/HDdhYoO.png" alt="database-structure"></a>

## Installation

1. Open your terminal in the project directory and run `composer install`
1. Open `includes/config.inc.php` and change the **DATABASE** array with
the corresponding information for your database.
1. Open `includes/config.inc.php` and change the `APP_NAME` and `APP_URL`
1. Import the `database.sql` file in the `database` folder to your Database.
1. Create a **symlink** on the `uploads` folder pointing to `public/uploads` 
in order to load images properly.

## Users
> The database by default has 2 records in it. One for admin
> and one for user to test the different functionality of the system.
> Credentials:

- Administrator
    * Email - `admin@books.com`
    * Password - `administrator`
- User
    * Email - `user@books.com`
    * Password - `user`

#### TODO:
##### General
- ~~Create flash messages on success and failure for better response~~;
- Add pagination to listing pages;
- ~~Show/Hide buttons, links based on user privileges and session~~
- ~~Restrict routes for unauthorized users~~
- ~~Create a symlink for uploads in order to load images properly~~
##### Users
- ~~Create user session on login~~
- ~~Register new user~~
- ~~Login existing user~~
- ~~Check privileges of a user~~
##### Collection
- ~~Add book to a collection~~
- ~~Remove book from collection~~
- ~~List user books collection~~
##### Books
- ~~Create a book~~;
- ~~Update a book~~;
- ~~Delete a book~~;
- ~~View a book~~;
- ~~List all books~~;
- ~~Added fillable fields~~;
##### CSRF Protection
- ~~Generate csrf token~~;
- ~~Validate csrf token~~;
- ~~Refresh csrf token~~;
#### Validation
- ~~Validate inputs with Class~~;
- ~~Create a class with static validation rules~~;
- ~~Sanitize data when inserting in the database~~;
- ~~Add error response under each invalid field~~;
#### Basic
- ~~Add composer for auto loading files~~;
- ~~Add gitignore in needed directories~~;
- ~~Add database dump in the project~~;
- ~~Create a simple GET / POST route system~~;
- ~~Add helpers file for easy reuse of scripts~~;
- ~~Add bootstrap as frontend framework~~;
- ~~Create a simple extendable view structure~~;
- ~~Create a base model to take care of PDO instance~~;