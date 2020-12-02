<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Login Page</h1>
    <form action="<?= URLROOT . '/users/login';?>" method="post">
        <input type="text" name="username" placeholder="username" value="<?= $data['username'];?>">
        <span class="form-error"><?php echo !empty($data['username_error']) ? $data['username_error'] : "";?></span>
        <input type="email" name="email" placeholder="email" value="<?= $data['email'];?>">
        <span class="form-error"><?php echo !empty($data['email_error']) ? $data['email_error'] : "";?></span>
        <input type="password" name="password" placeholder="password">
        <span class="form-error"><?php echo !empty($data['password_error']) ? $data['password_error'] : "";?></span>
        <input type="submit" name="submit" value="Login">
    </form>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
