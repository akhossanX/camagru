<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=SITENAME?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=URLROOT;?>/public/css/index.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col col-md-6">
				<img src="<?= URLROOT ?>/public/img/4.jpg" id="index-image" class="img-fluid rounded">
			</div>
			<div class="col col-md-6">
				<header class="h1 text-center">Camagru</header>
				<p class="text">Sign up to see your friends' photos.</p>
				<a href="<?= URLROOT ?>/users/register" class="btn">Create a new account</a>
				<p class="text">You have an account?</p>
				<a href="<?= URLROOT ?>/users/login" class="btn">Already have account? Sign In</a>
				<p class="text">Explore the gallery of photos</p>
				<a href="<?= URLROOT ?>/home/gallery" class="btn">Checkout gallery</a>
			</div>
		</div>
	</div>
	<script>
		'use strict';
		let images = [
			'1.jpg', 
			'2.jpg',
			'3.jpg',
			'4.jpg'
		];
		var img = document.querySelector('#index-image');
		var count = images.length;
		var index = 0;
		let changeImage = function () {
			img.src = '<?=URLROOT?>/public/img/' + images[index];
			index = (index + 1) % count; 
		}
		setInterval(changeImage, 5000);
	</script>
</body>
</html>