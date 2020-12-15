<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <?php if (isset($_SESSION['active'])) : ?>
        <?php if ($_SESSION['active'] === true) : ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong>Success! </strong> Your account has been successfully activated, you can 
                <a href="<?=URLROOT;?>/users/login">Login</a> now.
            </div>
        <?php else: ?>
            <h1><?=$_SESSION['active'];?></h1>
        <?php endif;?>
    <?php endif; ?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
