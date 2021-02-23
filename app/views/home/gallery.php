<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <section class="img-post">
        <div class="usr-pseudo"><?$_SESSION['images'][0]->username?></div>
        <div class="ca-border" style="width:100%"></div>
        <div class="post">
            <img src="data:image/png;base64, <?= $_SESSION['images'][0]->data; ?>" alt="">
        </div>
        <section class="post-infos">
            <img src="<?= URLROOT . '/public/icons/like.svg'; ?>" style="width: 1.7em; height:1.7em;" />
            <img src="<?= URLROOT . '/public/icons/heart.svg'; ?>" style="width: 1.7em; height:1.7em;" />
            <span class="likes-count"> <?=$_SESSION['images'][0]->likes;?></span>
        </section>
    </section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
