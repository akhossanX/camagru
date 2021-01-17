<?php

	/*
	** Base Controller
	** Loads the models and views
	*/

	class Controller
	{
		// Load model
		public function	model($model) {
			// Require model file
			require_once('app/models/' . $model . '.php');
			// Instanciate model
			return new $model();
		}
		// Load view
		public function	view($view) {
			// Check for the view file
			if (file_exists('app/views/' . $view . '.php')) {
				require_once ('app/views/' . $view . '.php');
			}
			else {
				return header("Location: " . URLROOT . '/users/error_404');
			}
		}

		public static function	redirect($url) {
			return header("Location: " . URLROOT . '/' . $url);
		}

		public function error_404() {
			die('<h2>Error 404: Page not found.</h2>');
		}

		public static function session_init() {
			session_start();
		}

		protected function sanitizeArray(&$array) {
			foreach ($array as $str) {
				$str = filter_var($str, FILTER_SANITIZE_STRING);
			}
		}
	}
