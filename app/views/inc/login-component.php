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
		<div class="form-group submit-group">
			<button type="submit" name="login" class="btn btn-success btn-lg">Sign In</button>
			<small><a href="<?=URLROOT.'/users/forgot-password'?>">Forgot password?</a></small>
		</div>
		<div class="form-group signup-group">
			<small>Don't have account? </small>
			<a href="<?=URLROOT.'/users/register';?>">Sign Up</a>
		</div>
	</form>
</div>