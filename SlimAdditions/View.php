<?php

namespace SlimAdditions;

class View extends \Slim\View
{
    public $DEFAULT_THEME_NAME = "default";
    private $CURRENT_THEME;

    function __construct($theme)
    {
        parent::__construct();
        $this->CURRENT_THEME = $theme;
    }

    protected function getCurrentThemeName()
    {
        return $this->CURRENT_THEME;
    }


    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    protected function render($template, $data = null)
    {
        $content = parent::render($template, $data);
        $data['content'] = $content;
        $layout = (isset($this->layout)) ? $this->layout : "layouts/default.php";
        return parent::render($layout, $data);
    }

    protected function h($text)
    {
        return htmlspecialchars($text);
    }

    protected function urlFor($url, $params)
    {
        return \Slim\Slim::getInstance()->urlFor($url, $params);
    }

    protected function render_element($name, $params = array())
    {
        extract($params);

        $elementPath = $this->get_theme_element_path($this->getCurrentThemeName(), $name);
        
        //check if element exists in current theme
        if (!is_file($elementPath))
        {
            //assign element path to use default theme since it doesn't exist in current theme
            $elementPath = $this->get_theme_element_path($this->DEFAULT_THEME_NAME, $name);
        }

        if (!is_file($elementPath)){
            throw new \RuntimeException("View cannot render `$elementPath` because the element file does not exist");
        }
        else{
            include($elementPath);
        }
    }

    /**
     * Override the slim implementation of getTemplatePathname($file); to provide a theme specific path if a file in the theme directory exists.
    */
    public function getTemplatePathname($file)
    {

        $templateDirectory = $this->get_template_directory($this->getCurrentThemeName(), $file);

        //check if template exists in current theme
        if (!is_file($templateDirectory)){
            //assign template path to use default theme since it doesn't exist in current theme
            $templateDirectory = $this->get_template_directory($this->DEFAULT_THEME_NAME, $file);
        }
        return $templateDirectory;
    }

    /**
     * Retrive the file path of an element by supplying a theme name and element name.
     *@param $theme         Name of the theme.
     *@param $element_name  Name of the element you want to retrieve for the given theme.
    */
    protected function get_theme_element_path($theme, $element_name)
    {
        $_template_names = explode('/', $element_name, 2);
        return $this->get_theme_directory($theme) . "/{$_template_names[0]}/elements/{$_template_names[1]}.php";
    }

    /**
     * Retrive the file path to a theme's templates directory by supplying the theme name.
     *@param $theme     Name of the theme.
    */
    protected function get_theme_directory($theme)
    {
        return $this->templatesDirectory . "/{$theme}";
    }

    /**
     * Retrive the file path to a template's directory by supplying the theme name and template file name.
     *@param $theme     Name of the theme.
     *@param $file      File path of the file from its theme's root directory.
    */
    protected function get_template_directory($theme, $file)
    {
        return $this->get_theme_directory($theme) . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);
    }
}
