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
		public function	view($view, $data = []) {
			// Check for the view file
			if (file_exists('app/views/' . $view . '.php')) {
				require_once('app/views/' . $view . '.php');
			}
			else {
				$this->error_404();
			}
		}

		public function error_404() {
			die('<h2>Error 404: Page not found.</h2>');
		}
	}
