<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
<!-- 
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
</form> -->

<div class="container signin-form-container">
	<form action="<?=URLROOT.'/users/register';?>" method="post" class="signin-form">
		<h1 class="text-center">REGISTER</h1>
		<br>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
			<span class="form-error"><?=$_SESSION['username_error'];?></span>
        </div>
        <div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
			<span class="form-error"><?=$_SESSION['email_error'];?></span>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			<span class="form-error"><?=$_SESSION['password_error'];?></span>
        </div>
        <div class="form-group">
			<label for="confirm-password">Confirm password</label>
			<input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Confirm password">
			<span class="form-error"><?=$_SESSION['confirm_password_error'];?></span>
		</div>
		<div style="display: flex; justify-content: space-between; align-items:center">
			<button type="submit" name="submit" class="btn btn-success btn-lg">Sign Up</button>
			<!-- <span><a href="<?=URLROOT.'/users/forgotpass'?>">Forgot password?</a></span> -->
		</div>
		<hr>
		<div style="display: flex; justify-content: flex-end; align-items:center">
			<span style="margin-right: 5px;">Already have an account? </span>
			<a href="<?=URLROOT.'/users/login';?>">Sign In</a>
		</div>
	</form>
</div>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>
