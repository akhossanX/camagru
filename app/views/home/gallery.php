<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Gallery</h1>

        <?php foreach ($_SESSION['images'] as $image): ?>
            <div style="display:inline-block;">
                <img src="data:image/png;base64,<?=$image->data ?>" style="width: 200px; heigth:300px;"/>
            </div>
        <?php endforeach;?>
        <?php unset($_SESSION['images']) ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
