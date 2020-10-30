<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
<h1><?php echo 'Register page'; ?></h1><br>

<form action="<?php echo URLROOT . '/users/register';?>" method="post">
    <input type="text" name="username" placeholder="username" value="<?php echo $data['user']->getUserName();?>">
    <span class="form-error"><?php echo !empty($data['username_error']) ? $data['username_error'] : "";?></span>
    <input type="email" name="email" placeholder="email" value="<?php echo $data['user']->getEmail();?>">
    <span class="form-error"><?php echo !empty($data['email_error']) ? $data['email_error'] : "";?></span>
    <input type="password" name="password" placeholder="password">
    <span class="form-error"><?php echo !empty($data['password_error']) ? $data['password_error'] : "";?></span>
    <input type="password" name="confirm_password" placeholder="confirm password">
    <span class="form-error"><?php echo !empty($data['confirm_password_error']) ? $data['confirm_password_error'] : "";?></span>
    <input type="submit" name="submit" value="Register">
</form>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
