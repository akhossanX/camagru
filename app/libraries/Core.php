<?php

	require_once(APPROOT . '/helpers/isAuthentified.php');
	require_once(APPROOT . '/helpers/validator.php');
	require_once(APPROOT . '/helpers/csrf_init.php');
	require_once(APPROOT . '/helpers/formHelper.php');

	/*
	 *	App core Class
	 *	Creates URL & Loads core controller
	 *	URL FORMAT - /controller/method/params
	 */

	class Core
	{
		protected $currentController = 'Home';
		protected $currentMethod = 'index';
		protected $params = [];

		public function __construct() {
			$url = $this->getUrl();
			if ($url && $url[0] == '') {
				unset($url[0]);
				$url = array_values($url);
			}
			$flag = $this->getController($url);
			require_once 'app/controllers/' . $this->currentController . '.php';
			$this->currentController = new $this->currentController();
			if ($flag == true)
				$flag = $this->getMethod($url);
			if ($flag == true)
				$this->getParams($url);
			call_user_func_array(
				[$this->currentController, $this->currentMethod],
				$this->params
			);
		}
	
		private function getUrl()
		{
			if (isset($_SERVER['REQUEST_URI']))
			{
				$url = rtrim($_SERVER['REQUEST_URI'], '/');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('/', $url);
				return $url;
			}
			return null;
		}

		private function getController(&$url)
		{
			if (isset($url) && isset($url[0])) {
				if (file_exists(
					'app/controllers/'
					 . ucwords($url[0])
					 . '.php'
					)) {
				    $this->currentController = ucwords($url[0]);
					unset($url[0]);
					$url = array_values($url);
					return true;
				}
			}
			return false;
		}

		private function getMethod(&$url) {
			if (isset($url) && isset($url[0])) {
				$url[0] = $this->urlToMethodName($url[0]);
				if (method_exists($this->currentController, $url[0])) {
					$reflection = new ReflectionMethod($this->currentController, $url[0]);
					if ($reflection->isPublic())
						$this->currentMethod = $url[0];
				}
				unset($url[0]);
				$url = array_values($url);
				return true;
			}
			return false;
		}

		private function urlToMethodName($url) {
			$arr = preg_split('/-/', $url);
			$len = count($arr);
			$method = $arr[0];
			for ($i = 1; $i < $len; $i++) {
				$method .= ucfirst($arr[$i]);
			}
			return $method;
		}

		private function getParams($url) {
			if ($url != null) {
				$this->params = $url;
				return true;
			}
			return false;
		}
	}
