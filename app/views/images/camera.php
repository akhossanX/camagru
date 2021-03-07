<?php
    $stickers = null;
    $ret = null;
    exec('ls -1 ' . ROOT . '/public/img/*.png | xargs basename -a', $stickers, $ret);
?>

<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <header class="container camera-header">
        Select stickers and shot a nice photo !
    </header> <!-- END OF SCROLLING WRAPPER -->

    <div class="container scrolling-wrapper" id="stickers">
        <?php foreach ($stickers as $png): ?>
            <img class="img-fluid card" src='<?=URLROOT."/public/img/${png}"?>'>
        <?php endforeach;?>
    </div>

    <div class="container size-slider">
        <input type="range" name="" id="range" min="80" max="200" step="10" value="80" style="width:100%"/>
    </div>
    <div class="container">
        <div class="row main-section">
            <div class="col-12 col-lg-6 editing-area">
                <!-- Camera Video and Capture button -->
                <div class="row mb-3"> <!-- Camera row -->
                    <div class="col-12 video-container" id="video-container-id">
                        <video id="video-id">
                            Your fuckig browser does not support video
                        </video>
                    </div>
                </div>
                <div class="row mb-3 cu-buttons"> <!-- Capture and upload buttons row -->
                    <button id="capture-btn" class="btn btn-sm" ><i class="fas fa-camera-retro"></i></button>
                    <button id="upload-btn" class="btn btn-sm" ><i class="fas fa-upload"></i></button>
                </div>
                <!-- Live preview Area -->
                <div class="row mb-3"> <!-- live preview Canvas -->
                    <div class="col-12 preview-container" id="preview-container-id">
                        <canvas id="preview-canvas"></canvas>
                    </div>
                </div>
                <div class="row mb-3 save-button"> <!-- save button -->
                    <button id="save-btn" class="btn"><i class="fa fa-save"></i></button>
                </div>
                <!-- End of Video Camera & Preview Area -->
            </div>
            <!-- Captured Photos display Area -->
            <div class="col-12 col-lg-6 user-images-area">
                <?php foreach ($_SESSION['user-images'] as $image) :?>
                    <div class="usr-image-container">
                        <img src="data:image/png;base64, <?=$image?>" class="usr-img-preview">
                        <button class="btn delete-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                <?php endforeach;?>
            </div>

            <!-- End of User Photos Display Area -->
        </div>
    </div>
    <script src="<?=URLROOT?>/public/js/camera.js" type="module"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
