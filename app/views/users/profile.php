<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>
	<div class="container form-container">
		<form action="<?=URLROOT.'/users/profile';?>" method="post" class="auth-form">
			<h1 style="text-align:center;">PROFILE</h1>
			<div class="form-group">
				<label for="username">Username:</label>
				<input class="form-control" id="username" type="text" name="username" value="<?=$_SESSION['logged-in-user']->username;?>">
				<span id="username" class="form-error"><?=$_SESSION['username_error'];?></span>
			</div>
			<div class="form-group">
				<label for="email">Emai</label>
				<input class="form-control" id="email" type="email" name="email" value="<?=$_SESSION['logged-in-user']->email;?>">
				<span id="email" class="form-error"><?=$_SESSION['email_error'];?></span>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input class="form-control" id="password" type="password" name="password" value="">
				<span id="password" class="form-error"><?=$_SESSION['password_error'];?></span>
			</div>
			<div class="form-group">
				<label for="confirm-password">Confirm Password</label>
				<input class="form-control" id="confirm-password" type="password" name="confirm-password" value="">
				<span id="confirm-password" class="form-error"><?=$_SESSION['confirm_password_error'];?></span>
			</div>
			<div class="form-check" style="margin-bottom: 8px;">
				<input type="checkbox" class="form-check-input" name="notify" id="notify">
				<label class="form-check-label" for="notify">Enable notifications</label>
			</div>
			<input type="submit" class="btn btn-success btn-lg" name="save" value="Save" style="width: 100%">
		</form>
	</div>
<script src="<?=URLROOT.'/public/js/form.js'?>"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
