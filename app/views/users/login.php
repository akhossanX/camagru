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
<div class="container signin-form">
	<form action="<?= URLROOT . '/users/login';?>" method="post">
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" placeholder="Password">
		</div>
		<button type="submit" class="btn btn-primary">Sign In</button>
	</form>
</div>



<?php require_once APPROOT . '/views/inc/footer.php'; ?>
