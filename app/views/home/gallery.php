<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
<?php 
    $galleryData = $_SESSION['gallery'];
    // var_dump($_SESSION['logged-in-user']);
?>
<?php foreach ($galleryData as $data): ?>
    <section class="img-post">
        <div class="user-pseudo"><?= $data['image']->owner ?></div>
        <div class="ca-border" style="width:100%"></div>
        <div class="post">
            <img src="data:image/png;base64, <?= $data['image']->data ?>" class="main-image">
            <input type="hidden" name="db-id" value="<?=$data['image']->imageid?>">
        </div>
        <section class="post-infos">
            <?php if ($data['likedOrNot'] === true): ?>
                <i class="bi bi-heart-fill"></i>
            <?php else : ?>
                <i class="bi bi-heart"></i>
            <?php endif; ?>
            <span class="likes-count"> <?=$data['likes']->likes;?> likes.</span>
        </section>
        <section class="post-comments">
            <?php foreach ($data['comments'] as $comment) : ?>
                <div class="comment-area">
                    <h5 class="comment-pseudo"><?= $comment->username ?></h5>
                    <p class="comment-text">
                        <?= $comment->text ?>
                    </p>
                </div>
            <?php endforeach; ?>
            <div class="add-comment-area">
                <textarea name="comment" id="" placeholder="add comment..." aria-label="add comment..." style="height: 18px !important; color:black;">
                </textarea>
                <input type="button" name="comment" value="comment">
            </div>
        </section>
    </section>
<?php endforeach ;?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
