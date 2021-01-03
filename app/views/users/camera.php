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
        <div class="editing-area">
            <!-- Video Camera & Preview Area (2 columns) -->
            <div class="row">
                <!-- Camera Video and Capture button (2 separated rows) -->
                <div class="col-12 col-sm-12 col-lg-6 mt-1 pb-1 full-height"> <!-- Camera and capture button -->
                    <div class="row"> <!-- Camera row -->
                        <div class="col" id="video-container-id">
                            <video id="video-id"></video>
                        </div>
                    </div>
                    <div class="row"> <!-- Capture button row -->
                        <div class="text-center col"> 
                            <input id="capture-btn" type="button" class="btn btn-danger shot-btn" value="Capture">
                        </div>
                    </div>
                </div>
                <!-- Live preview Area -->
                <div class="col-12 col-sm-12 col-lg-6 mt-1 
                pb-1 full-height preview-area" id="preview-area">
                    <div class="row"> <!-- live preview Canvas -->
                        <div class="col">
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                    <div class="row"> <!-- save butto -->
                        <div class="col  text-center">
                            <input id="save-btn" type="button" class="btn btn-success shot-btn" value="Save">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Video Camera & Preview Area -->
        </div>

        <!-- Captured Photos display Area -->
        <div class="user-photos-area">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-6 mt-1 pb-1" id="pictures-list">
                    <h1>here the list of saved photos</h1>
                </div>
            </div>
        </div>
        <!-- End of Photos Display Area -->

    </div>

    <script src="<?=URLROOT?>/public/js/camera.js" type="module"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
