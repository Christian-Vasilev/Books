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
                    <h4 class="card-title text-center">Edit</h4>
                    <h3 class="card-title text-center"><?= ucfirst($book->name) ?></h3>
                    <hr/>
                    <form method="post" action="/books/update" enctype="multipart/form-data">
                        <input type="hidden" value="<?= csrf() ?>" name="token">
                        <input type="hidden" value="<?= $book->id ?>" name="book_id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name"
                                   value="<?= FlashInputValues::exists('name') ? FlashInputValues::read('name') : $book->name ?>"
                                   class="form-control" placeholder="My cool book name">
                            <?php if (FlashMessage::exists('name')) { ?>
                                <small class="form-text text-muted alert-danger p-1"><?= FlashMessage::read('name') ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control"
                                      name="description"
                                      id="description" rows="3"><?= FlashInputValues::exists('description') ? FlashInputValues::read('description') : $book->description ?></textarea>
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
                        <button type="submit" class="btn btn-primary">Update</button>
                        <?php if (isset($success)) { ?>
                            <small class="form-text text-muted alert-success p-3"><?= $success ?></small>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require APP_ROOT . 'views/includes/messages.php'; ?>

</div>