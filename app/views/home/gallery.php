<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <div class="container" style="border:2px solid black;">
        <?php foreach ($_SESSION['images'] as $image): ?>
            <div class="row">
                <img class="column col-6" src="data:image/png;base64,<?=$image->data ?>"/>
                <div class="column col-6">
                    <?php var_dump(get_object_vars($_SESSION['images'][0])); ?>
                </div>
            </div>
        <?php endforeach; unset($_SESSION['images']); ?>
    </div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
