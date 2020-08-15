<?php


namespace App\Controllers;


use App\Libraries\FlashMessage;
use App\Libraries\ValidateRequest;
use App\Libraries\ValidationRules;
use App\Models\User;

class UserController
{
    public function register()
    {
        return view('users/register');
    }

    public function store()
    {
        if(!$this->validate($_POST)) {
            return redirect('/register');
        }

        (new User())->create([
            'email' => sanitize($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'first_name' => sanitize($_POST['first_name']),
            'last_name' => sanitize($_POST['last_name']),
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        redirect('/login');
    }

    public function login()
    {
        return view('users/login');
    }

    public function signin()
    {
        if ($this->validateLogin($_POST)) {
            $user = (new User())->login($_POST['email']);

            if (is_null($user) || !password_verify($_POST['password'], $user->password)) {
                FlashMessage::create('email', 'Credentials do not match');
                return redirect('/login');
            }

            $_SESSION['user'] = $user->id;

            return redirect('/');
        }

        return redirect('/login');
    }

    private function validateLogin($fields)
    {
        $token = $fields['token'];
        $email = $fields['email'];
        $password = $fields['password'];

        return ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($token)
            ],
            'email' => [
                ValidationRules::email($email)
            ],
            'password' => [
                ValidationRules::required($password),
                ValidationRules::min($password, 5)
            ],
        ]);
    }

    public function logout()
    {
        logout();

        return redirect('/');
    }

    private function validate($fields)
    {
        $token = $fields['token'];
        $email = $fields['email'];
        $password = $fields['password'];
        $confirmPassword = $fields['confirmation_password'];
        $firstName = $fields['first_name'];
        $lastName = $fields['last_name'];

        return ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($token)
            ],
            'email' => [
                ValidationRules::email($email)
            ],
            'password' => [
                ValidationRules::password($password, $confirmPassword),
                ValidationRules::min($password, 5)
            ],
            'first_name' => [
                ValidationRules::required($firstName)
            ],
            'last_name' => [
                ValidationRules::required($lastName)
            ]
        ]);
    }
}