<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

<div class="container form-container">
	<form action="<?=URLROOT.'/users/forgot-password';?>" method="get" class="auth-form">
		<h3 class="text-center">RESET PASSWORD</h3>
		<br>
        <div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
			<span id="email" class="form-error"></span>
		</div>
		<div class="form-group">
			<button type="submit" style="width:100%;" name="forgot" class="btn btn-success btn-lg">
				Submit
			</button>
		</div>
	</form>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>