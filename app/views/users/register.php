<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
<h1><?php echo 'Register page'; ?></h1><br>

<form action="<?php echo URLROOT . '/users/register';?>" method="post">
    <input type="text" name="username" id="username" placeholder="username">
    <input type="email" name="email" id="useremail" placeholder="email">
    <input type="password" name="password" id="userpass" placeholder="password">
    <input type="password" name="confirm_password" id="confirm_password" placeholder="confirm password">
    <input type="submit" value="Register">
</form>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
