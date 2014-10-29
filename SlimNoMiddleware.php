<?php

namespace Framework;

class SlimNoMiddleware extends \Slim\Slim {

	public function __construct(array $userSettings = array()) {
		parent::__construct($userSettings);
		$this->middleware = array($this);
	}

}
