<?php
require 'partials/header.php';
?>


<body class="text-center" cz-shortcut-listen="true" style="">
    <div class="container pt-5">
        <div class="row">
            <?php foreach ($books as $book) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <div class="card-img-top" style="height: 225px; width: 100%; display: block; background-image: url(<?= $book->getImage() ?>);"></div>
                        <div class="card-body">
                            <h3><?= $book->name ?></h3>
                            <p class="card-text"><?= $book->description ?? 'No description provided' ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button type="button" class="btn btn-sm btn-outline-info">View</button>
                                    <form method="post" action="/books/destroy" >
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                        <input type="hidden" value="<?= csrf() ?>" name="token">
                                        <input type="hidden" value="<?= $book->id ?>" name="book_id" />
                                    </form>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
