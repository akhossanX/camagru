<?php
    require_once 'app/autoloader.php';
	

	if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"]))
		return false;
	else
		// Init Core library
		$init = new Core();

?>
