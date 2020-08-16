<?php

use App\Libraries\FlashInputValues;
use App\Libraries\FlashMessage;
require APP_ROOT . 'views/partials/header.php';
?>
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card card-signin flex-row my-5">
                <div class="card-img-left d-none d-md-flex">
                    <!-- Background image for card set in CSS! -->
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Login form</h5>
                    <form method="post" action="/login">
                        <input type="hidden" value="<?= csrf() ?>" name="token">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email"
                                   value="<?php FlashInputValues::exists('email') ? FlashInputValues::read('email') : '' ?>"
                                   class="form-control" placeholder="Enter in your cool email address">
                            <?php if (FlashMessage::exists('email')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('email') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control">
                            <?php if (FlashMessage::exists('password')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('password') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <?php require APP_ROOT . 'views/includes/messages.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>