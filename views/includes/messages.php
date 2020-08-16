<?php use App\Libraries\FlashMessage;

if (FlashMessage::exists('success')) { ?>
    <div class="row pb-5">
        <div class="col-md-12 text-center">
            <small class="form-text text-dark alert-success p-2"><?= FlashMessage::read('success') ?></small>
        </div>
    </div>
<?php } ?>

<?php if (FlashMessage::exists('failure')) { ?>
    <div class="row pb-5">
        <div class="col-md-12 text-center">
            <small class="form-text text-dark alert-danger p-2"><?= FlashMessage::read('failure') ?></small>
        </div>
    </div>
<?php } ?>
