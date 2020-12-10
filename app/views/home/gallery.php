<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Gallery</h1>

        <?php foreach ($_SESSION['images'] as $image): ?>
           <img src="data:image/png;base64,<?=$image->data ?>" style="width: 200px; heigth:200px"/>
           <span><?=$image->username;?></span>
        <?php endforeach;?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
