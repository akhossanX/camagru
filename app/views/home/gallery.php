<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <section class="img-post">
        <div class="user-pseudo"><?= $_SESSION['data']['images'][0]->username ?></div>
        <div class="ca-border" style="width:100%"></div>
        <div class="post">
            <img src="data:image/png;base64, <?= $_SESSION['data']['images'][0]->data ?>" class="main-image">
        </div>
        <section class="post-infos">
            <img src="<?= URLROOT . '/public/icons/like.svg'; ?>" class="like-icon" style="display: none;"/>
            <img src="<?= URLROOT . '/public/icons/heart.svg' ?>" class="unlike-icon"/>
            <span class="likes-count"> <?=$_SESSION['data']['likes'][0]->likes;?> likes.</span>
        </section>
    </section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
