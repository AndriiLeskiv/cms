<?php

namespace core;
/**
 * Клас шаблонізатора
 * @package core
*/

class Template
{
    protected $parameters;
    public function __construct()
    {
        $this->parameters = [];
    }
    public function setParam($name): void
    {
        $value = '';
        $this->parameters[$name] = $value;
    }
    public function getParam($name)
    {
        return $this->parameters[$name];
    }
    public function setParams($array): void
    {
        foreach ($array as $key => $value) {
            $this->parameters[$key] = $value;
        }
    }
    public function render($path)
    {
        extract($this->parameters);
        ob_start();
        include($path);
        return ob_get_clean();
    }

    public function display($path): void
    {
        echo $this->render($path);
    }
}