<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

<div class="container gallery-container" id="gallery-container"> <!-- POSTS CONTAINER -->

    <?php 
        $galleryData = $_SESSION['gallery'];
        if (count($galleryData) !== 0) :
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
                <?php if ($liked == true): ?>
                    <i class="bi bi-heart-fill like-icon" id="<?= $imageid ?>"></i>
                <?php else : ?>
                    <i class="bi bi-heart like-icon" id="<?= $imageid ?>"></i>
                <?php endif; ?>
                <span class="likes-count"> <?= $likes;?> likes.</span>
            </section>
            <section class="post-comments">
                <div class="comment-display-area" id="comment-display-area-<?= $imageid ?>">
                    <?php foreach ($comments as $comment) : ?>
                        <div class="comment-area">
                            <h6 class="comment-pseudo"><?= $comment->username ?></h6>
                            <p class="comment-text"><?= $comment->text ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="add-comment-area">
                    <textarea name="comment" id="id_<?= $imageid ?>" placeholder="add comment..."></textarea>
                    <button 
                        type="submit" 
                        id="<?= $imageid ?>" 
                        class="btn btn-publish" 
                    >
                        publish
                    </button>
                </div>
            </section>
        </section>
    <?php 
            endforeach ;
        else : 
    ?>
        <div class="empty-gallery">
            <h1>No available posts.</h1>
        </div>
    <?php
        endif ;
            
    ;?>
   

</div> <!-- END OF CONTAINER -->

<div class="loading">
    <div class="ball"></div>
    <div class="ball"></div>
    <div class="ball"></div>
</div>

<script src="<?= URLROOT . "/public/js/scroll.js" ?>"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
