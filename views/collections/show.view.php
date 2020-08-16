<?php

use App\Libraries\Auth;

require APP_ROOT . 'views/partials/header.php';
?>

<body class="text-center" cz-shortcut-listen="true" style="">
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>My Collection</h3>
                <hr/>
            </div>
        </div>
        <?php require APP_ROOT . 'views/includes/messages.php'; ?>
        <div class="row">
            <?php if (empty($books)) { ?>
                <div class="col-md-12">
                    <span class="form-text text-dark alert-danger p-2">There are no books added to your collection yet</span>
                </div>
            <?php } else { ?>

            <?php foreach ($books as $book) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <div class="card-img-top" style="height: 225px; width: 100%; display: block; background-image: url(<?= $book->getImage() ?>);"></div>
                        <div class="card-body">
                            <h3><?= sanitize($book->name) ?></h3>
                            <p class="card-text"><?= mb_strimwidth(sanitize($book->description), 0, 41,  '...') ?? 'No description provided' ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <?php if (Auth::isAdmin()) { ?>
                                        <a href="/books/edit?book_id=<?= $book->id ?>" role="button" class="btn btn-sm btn-outline-secondary ml-1">Edit</a>
                                    <?php } ?>
                                    <a href="/books/show?book_id=<?= $book->id ?>" role="button" type="button" class="btn btn-sm btn-outline-info ml-1">View</a>
                                </div>
                                <?php if (Auth::isAdmin()) { ?>
                                    <form method="post" action="/books/destroy" >
                                        <button type="submit" class="btn btn-sm btn-outline-danger ml-1 float-right">Remove</button>
                                        <input type="hidden" value="<?= csrf() ?>" name="token">
                                        <input type="hidden" value="<?= $book->id ?>" name="book_id" />
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } }?>
        </div>
    </div>
</body>
</html>
