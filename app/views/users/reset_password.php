<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

<div class="container form-container">
	<form action="<?=URLROOT.'/users/reset-password';?>" method="post" class="auth-form">
		<h3 class="text-center">Enter New Password</h3>
		<br>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			<span id="password" class="form-error"><?=$_SESSION['password_error'];?></span>
		</div>
        <div class="form-group">
			<label for="confirm-password">Confirm Password</label>
			<input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Confirm Password">
			<span id="confirm-password" class="form-error"><?=$_SESSION['confirm_password_error'];?></span>
        </div>
        <input hidden type="text" name="id" value="<?=$_SESSION['id'];?>">
		<div style="display: flex; justify-content: space-between; align-items:center">
			<button type="submit" name="reset" class="btn btn-success btn-lg">Reset</button>
		</div>
	</form>
</div>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>
