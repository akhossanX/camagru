<?php
    require_once 'app/autoloader.php';
	
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	//set_error_handler("var_dump");


	if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|svg|mp4)$/', $_SERVER["REQUEST_URI"]))
		return false;
	else
		// Init Core library
		$init = new Core();


?>
