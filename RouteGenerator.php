<?php

namespace Framework;

class RouteGenerator
{

    private $controller_cache = array();
    private $app;

    function __construct($app)
    {
        $this->app = $app;
    }

    private function action($controller_name, $method)
    {
        if (!isset($this->controller_cache[$controller_name])) {
            $class_name = '\\App\\Controllers\\' . $controller_name;
            $this->controller_cache[$controller_name] = new $class_name($this->app);
        }
        $controller = $this->controller_cache[$controller_name];
        return array($controller, $method);
    }

    private function get($url, $controller, $action)
    {
        return $this->app->get($url, $this->action($controller, $action));
    }

    private function post($url, $controller, $action)
    {
        return $this->app->post($url, $this->action($controller, $action));
    }

    private function delete($url, $controller, $action)
    {
        return $this->app->delete($url, $this->action($controller, $action));
    }

    private function default_conditions($conditions)
    {
        \Slim\Route::setDefaultConditions($conditions);
    }

    public function load_routes()
    {
        include 'config/routes.php';
    }
}
