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
            <a href="<?=$url1;?>">
                <?=$userOrSignIn;?>
            </a>
        </li>
        <li class="nav-link">
            <a href="<?=$url2;?>">
                <?=$logOutOrSingUp;?>
            </a>
        </li>
    </ul>
</nav>