<?php

use App\Libraries\Auth;

require APP_ROOT . 'views/partials/header.php';
?>

<body class="text-center" cz-shortcut-listen="true" style="">
    <div class="container-fluid pt-5 text-center">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card mb-4 box-shadow">
                    <div class="card-img-top" style="height: 225px; width: 100%; display: block; background-image: url(<?= $book->getImage() ?>);"></div>
                    <div class="card-body">
                        <h3><?= $book->name ?></h3>
                        <hr/>
                        <p class="card-text"><?= $book->description ?? 'No description provided' ?></p>
                        <?php if (!is_null(Auth::user())) { ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-success ml-1">Add to collection</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
