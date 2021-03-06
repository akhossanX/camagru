<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

<div class="container form-container">
	<form action="<?=URLROOT.'/users/register';?>" method="post" class="auth-form">
		<h3 class="text-center">Register</h3>
		<br>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?=$_SESSION['username']?>">
			<span id="username" class="form-error"><?=$_SESSION['username_error'];?></span>
        </div>
        <div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
			<span id="email" class="form-error"><?=$_SESSION['email_error'];?></span>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			<span id="password" class="form-error"><?=$_SESSION['password_error'];?></span>
        </div>
        <div class="form-group">
			<label for="confirm-password">Confirm password</label>
			<input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Confirm password">
			<span id="confirm-password" class="form-error"><?=$_SESSION['confirm_password_error'];?></span>
		</div>
		<div class="form-group submit-group">
			<button type="submit" name="register" class="btn btn-success btn-lg">Sign Up</button>
			<input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
		</div>
		<hr>
		<div class="signup-group">
			<a href="<?=URLROOT.'/users/login';?>">Sign In</a>
			<span>Already have an account? </span>
		</div>
	</form>
</div>

<script src="<?=URLROOT.'/public/js/form.js'?>"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
