<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Login Page</h1>
    <form action="<?= URLROOT . '/users/login';?>" method="post">
        <input type="text" name="username" placeholder="username" value="<?= $_SESSION['username'];?>">
        <span class="form-error"><?= $_SESSION['username_error'];?></span>
        <input type="password" name="password" placeholder="password">
        <span class="form-error"><?= $_SESSION['password_error'];?></span>
        <input type="submit" name="submit" value="Login">
    </form>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
