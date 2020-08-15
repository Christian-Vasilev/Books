<?php

use App\Libraries\FlashInputValues;
use App\Libraries\FlashMessage;

require APP_ROOT . 'views/partials/header.php';
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-signin flex-row my-5">
                <div class="card-img-left d-none d-md-flex">
                    <!-- Background image for card set in CSS! -->
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Update</h5>
                    <form method="post" action="/profile">
                        <input type="hidden" value="<?= csrf() ?>" name="token">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email"
                                   value="<?= FlashInputValues::exists('email') ? FlashInputValues::read('email') : $user->email ?>"
                                   class="form-control" placeholder="Enter in your cool email address">
                            <?php if (FlashMessage::exists('email')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('email') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="first-name">First name</label>
                            <input type="text" id="first-name" name="first_name"
                                   value="<?= FlashInputValues::exists('first_name') ? FlashInputValues::read('first_name') : $user->first_name ?>"
                                   class="form-control">
                            <?php if (FlashMessage::exists('first_name')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('first_name') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last name</label>
                            <input type="text" id="last-name" name="last_name"
                                   value="<?= FlashInputValues::exists('last_name') ? FlashInputValues::read('last_name') : $user->last_name ?>"
                                   class="form-control">
                            <?php if (FlashMessage::exists('last_name')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('last_name') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-signin flex-row my-5">
                <div class="card-img-left d-none d-md-flex">
                    <!-- Background image for card set in CSS! -->
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Change password</h5>
                    <form method="post" action="/password-change">
                        <input type="hidden" value="<?= csrf() ?>" name="token">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control">
                            <?php if (FlashMessage::exists('password')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('password') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="confirmation-password">Repeat password</label>
                            <input type="password" id="confirmation-password" name="confirmation_password"
                                   class="form-control">
                            <?php if (FlashMessage::exists('confirmation_password')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('confirmation_password') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Change password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>