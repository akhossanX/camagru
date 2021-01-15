<?php
    $stickers = null;
    $ret = null;
    exec('ls -1 ' . ROOT . '/public/img/*.png | xargs basename -a', $stickers, $ret);
?>

<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

    <header class="container jumbotron">
        <h3 class="text-center">Select stickers and shot your picture !</h3>
    </header>
    <div class="container scrolling-wrapper" id="stickers">
        <?php foreach ($stickers as $png): ?>
            <img class="card" width="80" height="80" src='<?=URLROOT."/public/img/${png}"?>'>
        <?php endforeach;?>
    </div>
    <div class="container size-slider">
        <input type="range" name="" id="range" min="80" max="150" step="5" value="80" style="width:100%"/>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 editing-area">
                <!-- Camera Video and Capture button -->
                <div class="row mb-3"> <!-- Camera row -->
                    <div class="col-12 text-center" id="video-container-id">
                        <video id="video-id"></video>
                    </div>
                </div>
                <div class="row mb-3"> <!-- Capture button row -->
                    <div class="col-6 text-center"> 
                        <input id="capture-btn" type="button" class="btn btn-primary shadow-lg" value="Capture">
                    </div>
                    <div class="col-6 text-center">
                        <input id="upload-btn" type="button" class="btn btn-warning shadow-lg" value="Upload">
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
            <div class="col-12 col-lg-6 user-images-area pl-5 border border-red">
                <!-- <img src="https://picsum.photos/200/300" alt="" srcset="">     -->
            </div>
            <!-- End of User Photos Display Area -->
        </div>
        
    </div>

    <script src="<?=URLROOT?>/public/js/camera.js" type="module"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
