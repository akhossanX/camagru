<?php
    if (isset($_SESSION['logged-in-user']) && !empty($_SESSION['logged-in-user'])) {
        // print_r($_SESSION);
        $userOrSignIn = $_SESSION['logged-in-user'];
        $logOutOrSingUp = 'Logout';
        $url1 = '';
        $url2 = URLROOT . '/users/logout';
    }
    else {
        $userOrSignIn = 'Sign In';
        $logOutOrSingUp = 'Sign Up';
        $url1 = URLROOT . '/users/login';
        $url2 = URLROOT . '/users/register';
    }
    // print_r(['userOrsignin' => $userOrSignIn, 'logoutorsignup' => $logOutOrSingUp, 'urlsignin' => $url1, 'url2signup' => $url2]);
?>

<nav class="navbar">
    <a class="brand" href="<?php echo URLROOT;?>">
        Cama<span class="gru">gru</span>
    </a>
    <ul class="nav-links" id="nav-links">
        <li class="nav-link icon" onclick="dropDown()"><i>&#9776;</i></li>
        <li class="nav-link">
            <a href="<?php echo URLROOT . '/home/gallery'; ?>">Gallery</a>
        </li>
        <li class="nav-link">
            <?php if (!empty($url1)) : ?>
            <a href="<?=$url1;?>">
                <?=$userOrSignIn;?>
            </a>
            <?php else : ?>
                <a onclick="return false;"><?=$userOrSignIn;?></a>
            <?php endif;?>
        </li>
        <li class="nav-link">
            <a href="<?=$url2;?>">
                <?=$logOutOrSingUp;?>
            </a>
        </li>
    </ul>
</nav>