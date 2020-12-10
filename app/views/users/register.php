<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
<h1><?php echo 'Register page'; ?></h1><br>

<form action="<?php echo URLROOT . '/users/register';?>" method="post">
    <input type="text" name="username" placeholder="username" value="<?= isset($_SESSION['username']) ? $_SESSION['username'] : '';?>">
    <span class="form-error"><?=!empty($_SESSION['username_error']) ? $_SESSION['username_error'] : "";?></span>
    <input type="email" name="email" placeholder="email" value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : '';?>">
    <span class="form-error"><?=!empty($_SESSION['email_error']) ? $_SESSION['email_error'] : "";?></span>
    <input type="password" name="password" placeholder="password">
    <span class="form-error"><?php echo !empty($_SESSION['password_error']) ? $_SESSION['password_error'] : "";?></span>
    <input type="password" name="confirm_password" placeholder="confirm password">
    <span class="form-error"><?=!empty($_SESSION['confirm_password_error']) ? $_SESSION['confirm_password_error'] : "";?></span>
    <input type="submit" name="submit" value="Register">
</form>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
