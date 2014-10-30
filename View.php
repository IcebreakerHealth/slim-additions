<?php

namespace Framework;

class View extends \Slim\View {

	public function setLayout($layout) {
		$this->layout = $layout;
	}

	protected function render($template, $data = null) {
		$content = parent::render($template, $data);
		$data['content'] = $content;
		$layout = (isset($this->layout)) ? $this->layout : "layouts/default.php";
		return parent::render($layout, $data);
	}

	protected function h($text) {
		return htmlspecialchars($text);
	}

	protected function urlFor($url, $params) {
		return \Slim\Slim::getInstance()->urlFor($url, $params);
	}

	protected function render_element($name, $params=array()) {
		extract($params);
		$_template_names = explode('/', $name, 2);
		include(DOC_ROOT . "/App/templates/{$_template_names[0]}/elements/{$_template_names[1]}.php");
	}

}
