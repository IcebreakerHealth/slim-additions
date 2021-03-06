<?php

namespace SlimAdditions;

class Controller
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    protected function setHeader($header, $value)
    {
        $this->app->response->headers->set($header, $value);
    }

    protected function setLayout($layout)
    {
        $this->app->view->setLayout($layout);
    }

    protected function render($name, $data = array())
    {
        return $this->app->render($name, $data);
    }

    protected function flash($key, $value)
    {
        $this->app->flash($key, $value);
    }

    protected function flashNow($key, $value)
    {
        $this->app->flashNow($key, $value);
    }

    protected function redirect($url, $params = null)
    {
        if ($params !== null) {
            $url = $this->app->urlFor($url, $params);
        }
        return $this->app->redirect($url);
    }

    protected function params($name = null)
    {
        list($content_type) = explode(";", $this->app->request->getContentType(), 2);

        if ($content_type == "application/json") {
            $body = json_decode($this->app->request()->getBody(), true);
            $body = !is_null($body) ? $body : array();
            $data = array_merge($this->app->request->params(), $body);
            if (is_null($name)) {
                return $data;
            } else {
                return isset($data[$name]) ? $data[$name] : null;
            }
        }

        return $this->app->request->params($name);
    }

    protected function urlFor($name, $params = array())
    {
        return $this->app->router->urlFor($name, $params);
    }

    protected function pass()
    {
        $this->app->pass();
    }
}
