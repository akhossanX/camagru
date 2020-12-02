<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <?php if (isset($data['user'])) : ?>
        <h1>
            Hi <?= $data['user']->getUserName()?> 
            a link has been sent to your email address, please check it out to activate your account.
        </h1>
    <?else: ?>
        <?php if (isset($data['active']) && $data['active'] === true) : ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong>Success! </strong> Your account has been successfully activated, you can 
                <a href="<?=URLROOT;?>/users/login">Login</a> now.
            </div>
        <?php endif; ?>
    <?endif;?>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
