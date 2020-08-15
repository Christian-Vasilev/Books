# My books
> Simple app that will help you manage your book collections

#### Database structure
<a href="https://github.com/Christian-Vasilev/Books"><img src="https://i.imgur.com/HDdhYoO.png" alt="database-structure"></a>

## Installation

1. Open your terminal in the project directory and run `composer install`
1. Open `includes/config.inc.php` and change the **DATABASE** array with
the corresponding information for your database.
1. Open `includes/config.inc.php` and change the `APP_NAME` and `APP_URL`
1. Import the `database.sql` file in the `database` folder to your Database.

#### TODO:
##### General
- Create flash messages on success and failure for better response;
- Add pagination to listing pages;
- ~~Show/Hide buttons, links based on user privileges and session~~
- ~~Restrict routes for unauthorized users~~
##### Users
- ~~Create user session on login~~
- ~~Register new user~~
- ~~Login existing user~~
- ~~Check privileges of a user~~
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