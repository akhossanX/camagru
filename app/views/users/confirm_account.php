<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1><?php echo 'Hi ' . $data['user']->getUserName() . ' We sent you a link to your email address, please check it out to activate your account'; ?></h1>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
