<?php


namespace App\Controllers;


use App\Libraries\Auth;
use App\Libraries\FlashMessage;
use App\Libraries\ValidateRequest;
use App\Libraries\ValidationRules;
use App\Models\User;

class UserController
{
    public function index()
    {
        if (!Auth::isAdmin()) {
            return redirect('/');
        }

        view('users/index', ['users' => (new User())->list()]);
    }
    public function register()
    {
        if (Auth::user()) {
            return redirect('/');
        }

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
            'active' => 0,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        redirect('/login');
    }

    public function update()
    {
        if(!$this->validateUpdate($_POST)) {
            return redirect('/profile');
        }

        $currentEmail = Auth::user()->email;

        (new User())->update([
            'email' => sanitize($_POST['email']),
            'first_name' => sanitize($_POST['first_name']),
            'last_name' => sanitize($_POST['last_name']),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ], Auth::user()->id);


        if ($currentEmail !== $_POST['email']) {
            Auth::logout();
        }

        redirect('/profile');
    }

    public function changePassword()
    {
        if(!$this->validatePasswordChange($_POST)) {
            return redirect('/profile');
        }

        (new User())->update([
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ], Auth::user()->id);

        Auth::logout();

        redirect('/');
    }

    public function login()
    {
        if (Auth::user()) {
            return redirect('/');
        }

        return view('users/login');
    }

    public function activate()
    {
        $validRequest = ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($_POST['token']),
            ]
        ]);

        if ($validRequest) {
            $active = (new User())->activate($_POST['user_id']);

            if ($active) {
                FlashMessage::create('success', 'User is activate successfully');

                return redirect('/users');
            }
        }

        FlashMessage::create('failure', 'Your token expired! User was not activated');

        return redirect('/users');
    }

    public function deactivate()
    {
        $validRequest = ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($_POST['token']),
            ]
        ]);

        if ($validRequest) {
            $deactivated = (new User())->deactivate($_POST['user_id']);

            if ($deactivated) {
                FlashMessage::create('success', 'User is deactivated successfully');

                return redirect('/users');
            }
        }

        FlashMessage::create('failure', 'Your token expired! User was not deactivated');

        return redirect('/users');
    }

    public function signin()
    {
        if ($this->validateLogin($_POST)) {
            $user = (new User())->login($_POST['email']);

            if (is_null($user) || !password_verify($_POST['password'], $user->password)) {
                FlashMessage::create('email', 'Credentials do not match');
                return redirect('/login');
            }

            if (!$user->isActive()) {
                FlashMessage::create('failure', 'Your account is not active.');

                return redirect('/login');
            }

            $_SESSION['user'] = $user->id;

            return redirect('/');
        }

        return redirect('/login');
    }

    public function profile()
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        return view('users/profile', ['user' => Auth::user()]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    private function validatePasswordChange($fields)
    {
        $token = $fields['token'];
        $password = $fields['password'];
        $confirmPassword = $fields['confirmation_password'];

        return ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($token)
            ],
            'password' => [
                ValidationRules::password($password, $confirmPassword),
                ValidationRules::min($password, 5)
            ],
        ]);
    }

    private function validateUpdate($fields)
    {
        $token = $fields['token'];
        $email = $fields['email'];
        $firstName = $fields['first_name'];
        $lastName = $fields['last_name'];

        return ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($token)
            ],
            'email' => [
                ValidationRules::email($email)
            ],
            'first_name' => [
                ValidationRules::required($firstName)
            ],
            'last_name' => [
                ValidationRules::required($lastName)
            ]
        ]);
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
            ],
        ]);
    }
}