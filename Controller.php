<?php

namespace Framework;

class Controller {

	private $app;
	private $api;

	function __construct($app){
		$this->app = $app;
	}

	protected function setLayout($layout) {
		$this->app->view->setLayout($layout);
	}

	protected function render($name, $data=array()) {
		return $this->app->render($name, $data);
	}

	protected function redirect($url, $params=null) {
		if ($params !== null) $url = $this->app->urlFor($url, $params);
		return $this->app->redirect($url);
	}

	protected function params($name = null) {
		return $this->app->request->params($name);
	}


	protected function urlFor($name, $params=array()) {
		return $this->app->router->urlFor($name, $params);
	}

	protected function current_user() {
		return $this->app->current_user;
	}

	protected function api() {
		if (!isset($this->api)) {
			$this->api = new \App\Lib\Api($_COOKIE['Token']);
		}
		return $this->api;
	}

}
