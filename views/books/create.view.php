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
                    <h5 class="card-title text-center">Create Book</h5>
                    <form method="post" action="/books/store" enctype="multipart/form-data">
                        <input type="hidden" value="<?= csrf() ?>" name="token">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name"
                                   value="<?php FlashInputValues::exists('name') ? FlashInputValues::read('name') : '' ?>"
                                   class="form-control" placeholder="My cool book name">
                            <?php if (FlashMessage::exists('name')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('name') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control"
                                      name="description"
                                      id="description" rows="3"><?php FlashInputValues::exists('description') ? FlashInputValues::read('description') : '' ?></textarea>
                            <?php if (FlashMessage::exists('description')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('description') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Image</label>
                            <input type="file" name="image" class="form-control" id="image"/>
                            <?php if (FlashMessage::exists('image')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('image') ?></small>
                            <?php } ?>

                        </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>