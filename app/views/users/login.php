<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
    <h1>Login Page</h1>
    <!-- <form action="<?= URLROOT . '/users/login';?>" method="post">
        <input type="text" name="username" placeholder="username" value="<?= $_SESSION['username'];?>">
        <span class="form-error"><?= $_SESSION['username_error'];?></span>
        <input type="password" name="password" placeholder="password">
        <span class="form-error"><?= $_SESSION['password_error'];?></span>
        <input type="submit" name="submit" value="Login">
    </form> -->
<div class="container signin-form-container">
	<form action="<?= URLROOT . '/users/login';?>" method="post" class="signin-form">
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
			<span class="form-error"><?=$_SESSION['username_error'];?></span>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			<span class="form-error"><?=$_SESSION['password_error'];?></span>
		</div>
		<button type="submit" name="submit" class="btn btn-success ">Sign In</button>
		<span><a href="">Forgot password?</a></span>
		<hr>
		<span>Don't have account?</span><br>
		<a href="<?=URLROOT.'/users/register';?>" class="btn btn-primary text-center">Sign Up</a>
	</form>
</div>



<?php require_once APPROOT . '/views/inc/footer.php'; ?>
