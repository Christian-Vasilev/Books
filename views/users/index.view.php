<?php

use App\Libraries\FlashInputValues;
use App\Libraries\FlashMessage;
require APP_ROOT . 'views/partials/header.php';
?>
<div class="container">
    <?php require APP_ROOT . 'views/includes/messages.php'; ?>
    <div class="row pt-5">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Names</th>
                    <th scope="col">Active</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <th><?= $user->email ?></th>
                        <th><?= $user->getNames() ?></th>
                        <th>
                            <?= $user->isActive()
                                ? '<span class="badge badge-success">YES</span>'
                                : '<span class="badge badge-danger">NO</span>'
                            ?>
                        </th>
                        <th>
                            <?php if(!$user->isActive()) { ?>
                                    <form method="post" action="/users/activate">
                                        <input type="hidden" name="token" value="<?= csrf() ?>">
                                        <input type="hidden" name="user_id" value="<?= $user->id ?>">
                                        <button name="activate" class="btn btn-success btn-sm">Activate</button>
                                    </form>
                            <?php } else { ?>
                                <form method="post" action="/users/deactivate">
                                    <input type="hidden" name="token" value="<?= csrf() ?>">
                                    <input type="hidden" name="user_id" value="<?= $user->id ?>">
                                    <button name="deactivate" class="btn btn-danger btn-sm">Deactivate</button>
                                </form>
                            <?php } ?>
                        </th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>