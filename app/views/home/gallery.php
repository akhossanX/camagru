<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <section class="img-post">
        <div class="post">
            <img src="data:image/png;base64, <?= $_SESSION['images'][0]->data; ?>" alt="">
        </div>
        <section class="post-infos">
            <img src="<?= URLROOT . '/public/icons/like.svg'; ?>" style="width: 1.5em; height:1.5em;" />
            <img src="<?= URLROOT . '/public/icons/like.svg'; ?>" hidden style="width: 1.5em; height:1.5em;" />
        </section>
    </section>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
