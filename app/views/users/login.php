<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

<div class="container form-container">
	<form action="<?=URLROOT.'/users/login';?>" method="post" class="auth-form">
		<h3 class="text-center">LOGIN</h3>
		<br>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
			value="<?=$_SESSION['username']?>">
			<span id="username" class="form-error"><?=$_SESSION['username_error'];?></span>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			<span id="password" class="form-error"><?=$_SESSION['password_error'];?></span>
		</div>
		<div style="display: flex; justify-content: space-between; align-items:center">
			<button type="submit" name="login" class="btn btn-success btn-lg">Sign In</button>
			<span><a href="<?=URLROOT.'/users/forgotpass'?>">Forgot password?</a></span>
		</div>
		<hr>
		<div style="display: flex; justify-content: flex-end; align-items:center">
			<span style="margin-right: 5px;">Don't have account? </span>
			<a href="<?=URLROOT.'/users/register';?>">Sign Up</a>
		</div>
	</form>
</div>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>
