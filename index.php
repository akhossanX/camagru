<?php
    require_once 'app/autoloader.php';
	
	error_reporting(-1);
	ini_set('display_errors', 'On');
	set_error_handler("var_dump");


	if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|svg)$/', $_SERVER["REQUEST_URI"]))
		return false;
	else
		// Init Core library
		$init = new Core();


?>
