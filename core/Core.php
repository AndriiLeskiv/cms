<?php

namespace core;

use controllers\Site;

/**
 * Головний клас ядра системи
 * (сингтон)
 */
class Core
{
    private static  $instance;
    private function __construct()
    {

    }

    /**
     * Повертає екземпляр ядра системи
     * @return Core|null
     */
    public static function getInstance(): ?Core
    {
        if (empty(self::$instance)) {
            self::$instance = new Core();
            return self::getInstance();
        } else
            return self::$instance;
    }

    /**
     * Ініціалізація системи
    */
    public function init(): void
    {
        session_start();
        spl_autoload_register('\core\Core::spl__autoload');
    }

    /**
     * Виконує основний порцес роботи CMS-системи
     * @throws \ReflectionException
     */
    public function run(): void
    {
        $path = $_GET['path'];
        $pathParts = explode('/', $path);
        $className = ucfirst($pathParts[0]);
        if (empty($className)) {
            $fullClassName = Site::class;
        } else {
            $fullClassName = 'controllers\\'.$className;
        }
        $methodName = ucfirst($pathParts[1]);
        if (empty($methodName)){
            $fullMethodName = 'actionIndex';
        }else {
            $fullMethodName = 'action'.$methodName;
        }
        if (class_exists($fullClassName)) {
            $controller = new $fullClassName();
            if (method_exists($controller,$fullMethodName)) {
                $method = new \ReflectionMethod($fullClassName, $fullMethodName);
                $paramsArray = [];
                foreach ($method->getParameters() as $parameter){
                    $paramsArray[] = $_GET[$parameter->name] ?? null;
                }
                $method->invokeArgs($controller,$paramsArray);
            }else {
                throw new \RuntimeException('404 Not Found');
            }
        } else {
            throw new \RuntimeException('404 Not Found');
        }
    }


    /**
     * Автозавантажувач класів
     * @param $className string Назва класу
    */
    public static function spl__autoload(string $className): void
    {
        $fileName = $className.'.php';
        if (is_file($fileName)){
            include($fileName);
        }
    }
}