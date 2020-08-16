<?php

use App\Libraries\Auth;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Кристиан Василев">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title><?= APP_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">My books</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <?php if (Auth::isAdmin()) { ?>
                    <a class="nav-link text-white " href="/users">Users</a>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Books
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/collection/show">My Collection</a>
                        <?php if (Auth::isAdmin()) { ?>
                            <a class="dropdown-item" href="/books/create">Create</a>
                        <?php } ?>
                    </div>
                </li>
            </ul>
            <?php if (!Auth::user()) { ?>
                <a class="text-white nav-link" href="/login">Login</a>
                <a class="text-white nav-link" href="/register">Register</a>
            <?php } else { ?>
            <div class="dropdown show">
                <a class="nav-link text-white dropdown-toggle" href="#" id="profile-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= Auth::user()->getNames() ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="profile-dropdown">
                    <a class="dropdown-item" href="/profile">Update profile</a>
                </div>
            </div>
                <form class="form-inline my-2 my-lg-0" action="/logout" method="post">
                    <button role="button" class="btn btn-outline-secondary">Logout</button>
                </form>
            <?php } ?>
        </div>
    </div>
</nav>
<body>