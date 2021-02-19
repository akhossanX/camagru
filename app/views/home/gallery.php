<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <div class="container">
        <?php foreach ($_SESSION['images'] as $image): ?>
            <div class="post-image">
                <img class="img-fluid rounded my-3" src="data:image/png;base64,<?=$image->data ?>"/>
                <div class="">
                    <h5 class=""><?=$image->name;?></h5>
                </div>
            </div>
        <?php endforeach; unset($_SESSION['images']); ?>
    </div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
