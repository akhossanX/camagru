<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <div class="container">
        <div class="jumbotron">
            <p>Select stickers and shot your picture !</p>
        </div>
    </div>
    <?php
        $stickers = null;
        $ret = null;
        exec('ls -1 ' . ROOT . '/public/img/*.png | xargs basename -a', $stickers, $ret);
    ?>
    <div class="stickers" id="stickers">
        <?php foreach ($stickers as $png): ?>
            <img src='<?=URLROOT . "/public/img/${png}"?>'>
        <?endforeach;?>
    </div>

    <br><br>

    <div class="video-container" id="video-container-id">
        <video id="video-id"></video>
    </div>

    <div>
        <canvas id="canvas"></canvas>
    </div>

    <script src="<?=URLROOT?>/public/js/camera.js"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
