<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=SITENAME?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<link rel="stylesheet" href="<?=URLROOT;?>/public/css/landing.css">
</head>
<body>
	<header class="v-header container">
		<div class="video-wrapper">
			<video class="video" autoplay loop muted>
				<source src="<?=URLROOT.'/public/intro.mp4'?>" type="video/mp4">
			</video>
		</div>
		<div class="header-overlay"></div>
		<div class="header-content">
			<h1>WELCOME TO CAMAGRU</h1>
			<p>TAKE pictures and ENJOY adding awsome stickers on top of them</p>
		</div>
	</header>
  <section class="section section-a">
    <div class="container">
      <h2>What's next</h2>
      <p></p>
	</div>
	<div class="buttons">
		<a href="<?=URLROOT?>/users/register" class="btn btn-danger btn-lg">
			REGISTER
		</a>
		<a href="<?=URLROOT?>/home/gallery" class="btn btn-danger btn-lg">
			PUBLIC GALLERY
		</a>
		<a href="<?=URLROOT?>/users/login" class="btn btn-danger btn-lg">
			LOGIN
		</a>
	</div>
  </section>
</body>
</html>