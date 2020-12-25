<?php
    $stickers = null;
    $ret = null;
    exec('ls -1 ' . ROOT . '/public/img/*.png | xargs basename -a', $stickers, $ret);
?>

<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

    <div class="container">
        <h1 class="display-4 text-center heading">Select stickers and shot your picture !</h1>
    </div>
    <div class="stickers" id="stickers">
        <?php foreach ($stickers as $png): ?>
            <img src='<?=URLROOT . "/public/img/${png}"?>'>
        <?endforeach;?>
    </div>

    <br><br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="video-container" id="video-container-id">
                    <video id="video-id" class="border border-danger rounded border-5"></video>
                </div>
                <div class="text-center">
                    <input id="capture-id" type="button" class="btn btn-danger shot-btn" value="Capture">
                </div>
            </div>
            <div class="col-md-6">
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>

    <script src="<?=URLROOT?>/public/js/camera.js"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
