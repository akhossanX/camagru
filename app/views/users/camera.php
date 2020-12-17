<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Camera Page</h1>
    <div class="video-container">
        <video id="video"></video>
        <canvas id="canvas"></canvas>
    </div>

    <script src="<?=URLROOT?>/public/js/camera.js"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
