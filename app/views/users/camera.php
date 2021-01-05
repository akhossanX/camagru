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
        <?php endforeach;?>
    </div>

    <br><br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6 editing-area">
                <!-- Camera Video and Capture button -->
                <div class="row mb-3"> <!-- Camera row -->
                    <div class="col-12" id="video-container-id">
                        <video id="video-id"></video>
                    </div>
                </div>
                <div class="row mb-3"> <!-- Capture button row -->
                    <div class="col-6 text-center"> 
                        <input id="capture-btn" type="button" class="btn btn-primary shadow-lg" value="Capture">
                    </div>
                    <div class="col-6 text-center">
                        <input id="upload-btn" type="button" class="btn btn-warning shadow-lg" value="Upload">
                        <!-- <input type="file" id="upload-btn" name="upload" accept="image/png, image/jpeg"> -->
                    </div>
                </div>
                <!-- Live preview Area -->
                <div class="row mb-3"> <!-- live preview Canvas -->
                    <div class="col-12" id="preview-container-id">
                        <canvas id="preview-canvas"></canvas>
                    </div>
                </div>
                <div class="row mb-3"> <!-- save button -->
                    <div class="col-12">
                        <input id="save-btn" type="button" class="btn btn-success mx-auto w-25 shadow-lg" value="Save">
                    </div>
                </div>
                <!-- End of Video Camera & Preview Area -->
            </div>
            <!-- Captured Photos display Area -->
            <div class="col-12 col-lg-6 user-images-area pl-5">
                <img src="https://picsum.photos/200/300" alt="" srcset="">    
            </div>
            <!-- End of User Photos Display Area -->
        </div>
        
    </div>

    <script src="<?=URLROOT?>/public/js/camera.js" type="module"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
