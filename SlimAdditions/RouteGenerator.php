<?php

namespace SlimAdditions;

class RouteGenerator
{
    private $controller_cache = array();
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    private function permissions($controller_name, $method)
    {
        if (!isset($this->permissions_cache[$controller_name])) {
            $class_name = "\\App\\Permissions\\" . $controller_name;
            $this->permissions_cache[$controller_name] = new $class_name($this->app);
        }

        return array($this->permissions_cache[$controller_name], "check");
    }

    private function action($controller_name, $method)
    {
        if (!isset($this->controller_cache[$controller_name])) {
            $class_name = '\\App\\Controllers\\' . $controller_name;
            $this->controller_cache[$controller_name] = new $class_name($this->app);
        }

        return array($this->controller_cache[$controller_name], $method);
    }

    private function get($url, $controller, $action)
    {
        return $this->app->get($url, $this->permissions($controller, $action), $this->action($controller, $action));
    }

    private function patch($url, $controller, $action)
    {
        return $this->app->patch($url, $this->permissions($controller, $action), $this->action($controller, $action));
    }

    private function post($url, $controller, $action)
    {
        return $this->app->post($url, $this->permissions($controller, $action), $this->action($controller, $action));
    }

    private function put($url, $controller, $action)
    {
        return $this->app->put($url, $this->permissions($controller, $action), $this->action($controller, $action));
    }

    private function delete($url, $controller, $action)
    {
        return $this->app->delete($url, $this->permissions($controller, $action), $this->action($controller, $action));
    }

    private function options($url, $controller, $action)
    {
        return $this->app->options($url, $this->action($controller, $action));
    }

    private function defaultConditions($conditions)
    {
        \Slim\Route::setDefaultConditions($conditions);
    }

    public function loadRoutes()
    {
        include 'config/routes.php';
    }
}
