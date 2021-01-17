<?php require_once APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/navbar.php'; ?>

<div class="container form-container">
	<form action="<?=URLROOT.'/users/forgot-password';?>" method="post" class="auth-form">
		<h3 class="text-center">RESET PASSWORD</h3>
		<br>
        <div class="form-group">
			<label for="email">Email</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
			<span id="email" class="form-error"><?=$_SESSION['email_error'];?></span>
		</div>
		<div class="form-group">
			<button type="submit" style="width:100%;" name="forgot" value="ok" class="btn btn-success btn-lg">
				Send
			</button>
		</div>
	</form>
</div>
<script src="<?=URLROOT.'/public/js/form.js'?>"></script>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>