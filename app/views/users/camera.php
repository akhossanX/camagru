<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Camera Page</h1>
    <?php
        $stickers = null;
        $ret = null;
        exec('ls -1 ' . ROOT . '/public/img/*.png | xargs basename -a', $stickers, $ret);
    ?>
    <div class="stickers" id="stickers">
        <?php foreach ($stickers as $png): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="" id="{$png}"/>
                <label class="form-check-label" for="{$png}"> <img src='<?=URLROOT . "/public/img/${png}"?>'></label>
            </div>
        <?endforeach;?>
    </div>
    <br><br>
    <div class="video-container">
        <video id="video"></video>
        <!-- <img id="sticker" src=""> -->
    </div>
    <div>
        <canvas id="canvas"></canvas>
    </div>
    <script src="<?=URLROOT?>/public/js/camera.js"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
