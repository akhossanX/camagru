<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

	<div class="container form-container">
		<form action="<?= URLROOT . '/users/profile';?>" method="post" class="auth-form">
			<h3 class="header">Account Settings</h3>
			<div class="form-group">
				<label for="username">Username</label>
				<input class="form-control" id="username" type="text" name="username" value="<?=$_SESSION['logged-in-user']->username;?>">
				<span id="username" class="form-error"><?=$_SESSION['username_error'];?></span>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input class="form-control" id="email" type="email" name="email" value="<?=$_SESSION['logged-in-user']->email;?>">
				<span id="email" class="form-error"><?=$_SESSION['email_error'];?></span>
			</div>
			<div class="form-group">
				<label for="current-password">Current Password</label>
				<input class="form-control" id="current-password" type="password" name="current_password" value="">
				<span id="current-password" class="form-error"><?= $_SESSION['current_password_error'];?></span>
			</div>
			<div class="form-group">
				<label for="new-password">New Password</label>
				<input class="form-control" id="new-password" type="password" name="new_password" value="">
				<span id="new-password" class="form-error"><?= $_SESSION['new_password_error'];?></span>
			</div>
			<div class="form-group">
				<label for="confirm-new-password">Repeat New Password</label>
				<input class="form-control" id="confirm-new-password" type="password" name="confirm_new_password" value="">
				<span id="confirm-new-password" class="form-error"><?= $_SESSION['confirm_new_password_error'];?></span>
			</div>
			<div class="form-check" style="margin-bottom: 8px;">
				<input 
					type="checkbox" 
					class="form-check-input" 
					name="notify" id="notify" 
					<?=$_SESSION['logged-in-user']->notify ? "checked" : ""?>
				>
				<label class="form-check-label" for="notify">Enable notifications</label>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-success btn-lg" name="save" value="Save" style="width: 100%">
			</div>
		</form>
	</div>
	
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
