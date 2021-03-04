<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
<?php 
    $galleryData = $_SESSION['gallery'];
    foreach ($galleryData as $data): 
        $imageid = $data['image']->imageid;
        $imageowner = $data['image']->owner;
        $imagedata = $data['image']->data;
        $likes = $data['likes']->count;
        $comments = $data['comments'];
        $liked = $data['liked'];
?>
    <section class="img-post">
        <div class="user-pseudo"><?= $imageowner ?></div>
        <div class="ca-border" style="width:100%"></div>
        <div class="post">
            <img src="data:image/png;base64, <?= $imagedata ?>" class="main-image">
            <input type="hidden" name="db-id" value="<?=$imageid?>">
        </div>
        <section class="post-infos"  id="id_<?= $imageid ?>">
            <?php if ($liked === true): ?>
                <!-- <i class="fas fa-heart like-icon"></i> -->
                <i class="bi bi-heart-fill like-icon" id="<?= $imageid ?>"></i>
            <?php else : ?>
                <!-- <i class="far fa-heart unlike-icon"></i> -->
                <i class="bi bi-heart like-icon" id="<?= $imageid ?>"></i>
            <?php endif; ?>
            <span class="likes-count"> <?= $likes;?> likes.</span>
        </section>
        <section class="post-comments">
            <?php foreach ($comments as $comment) : ?>
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
