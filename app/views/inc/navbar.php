<?php
    if (isset($_SESSION['logged-in-user'])) {
        $userOrSignIn = [
                0 => $_SESSION['logged-in-user']->username,
                1 => 'fa-user'
            ];
        $logOutOrSingUp = [
            0 => 'Logout', 
            1 => 'fa-sign-out'
        ];
        $url1 = URLROOT . '/users/profile';
        $url2 = URLROOT . '/users/logout';
    }
    else {
        $userOrSignIn = [
            0 => 'Login',
            1 => 'fa-sign-in'
        ];
        $logOutOrSingUp = [
            0 => 'Register',
            1 => 'fa-user-plus'
        ];
        $url1 = URLROOT . '/users/login';
        $url2 = URLROOT . '/users/register';
    }
?>

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=URLROOT.'/home/gallery'?>">
			<span>C</span>
			<img id="camagru-icon" src="<?=URLROOT.'/public/icons/video-camera.svg'?>">
			<span>MAGRU</span>
    </a>
    <div class="right-side">
        <div class="icon" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </div>
        <div class="navbar-toggle" id="navbar-content">
                <ul class="navbar-nav mb-2 mb-lg-0 ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT.'/images/camera'?>">
                            <i class="fa fa-camera" aria-hidden="true"></i>
                            Camera
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$url1;?>">
                            <i class="fa <?= $userOrSignIn[1] ?>" aria-hidden="true"></i>
                            <?=$userOrSignIn[0];?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$url2;?>">
                            <i class="fa <?=$logOutOrSingUp[1];?>" aria-hidden="true"></i>
                            <?=$logOutOrSingUp[0];?>
                        </a>
                    </li>
                </ul>
        </div>
    </div>
  </div>
</nav>


