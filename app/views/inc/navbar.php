<?php
    if (isset($_SESSION['logged-in-user'])) {
        $userOrSignIn = $_SESSION['logged-in-user']->username;
        $logOutOrSingUp = 'Logout';
        $url1 = URLROOT . '/users/profile';
        $url2 = URLROOT . '/users/logout';
    }
    else {
        $userOrSignIn = 'Sign In';
        $logOutOrSingUp = 'Sign Up';
        $url1 = URLROOT . '/users/login';
        $url2 = URLROOT . '/users/register';
    }
?>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=URLROOT.'/home/index'?>">
			<span>C</span>
			<img id="camagru-icon" src="<?=URLROOT.'/public/icons/video-camera.svg'?>">
			<span>MAGRU</span>
    </a>
    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
        </button> -->
    <div class="right-side">
        <div class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </div>
        <div class="navbar-toggle" id="navbar-content">
                <ul class="navbar-nav mb-2 mb-lg-0 ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=URLROOT.'/home/gallery'?>">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$url1;?>"><?=$userOrSignIn;?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$url2;?>"><?=$logOutOrSingUp;?></a>
                    </li>
                </ul>
        </div>
    </div>
  </div>
</nav>
<div class="bg-image"></div>


