<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1 style="text-align:center;">Profile Page</h1>
    <form action="<?=URLROOT . '/users/profile';?>" method="post">
        <label for="username">Username:</label>
        <input id="username" type="text" name="username" value="<?=$_SESSION['logged-in-user']->username;?>">
        <span class="form-error"><?=!empty($_SESSION['username_error']) ? $_SESSION['username_error'] . " " . $_SESSION['username'] : "";?></span>
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" value="<?=$_SESSION['logged-in-user']->email;?>">
        <span class="form-error"><?=!empty($_SESSION['email_error']) ? $_SESSION['email_error'] : "";?></span>
        <label for="password">Password:</label>
        <input id="password" type="password" name="password" value="">
        <span class="form-error"><?php echo !empty($_SESSION['password_error']) ? $_SESSION['password_error'] : "";?></span>
        <label for="confirm_password">Confirm Password:</label>
        <input id="confirm_password" type="password" name="confirm_password" value="">
        <span class="form-error"><?=!empty($_SESSION['confirm_password_error']) ? $_SESSION['confirm_password_error'] : "";?></span>
        <input type="submit" style="width: auto;display:inline" name="save" value="Save">
        <input type="submit" style="width: auto;display:inline" name="cancel" value="Cancel">
    </form>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
