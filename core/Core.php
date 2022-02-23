<?php

namespace core;

use controllers\Site;

/**
 * Головний клас ядра системи
 * (сингтон)
 * @method setParams(mixed $result)
 * @method display(string $string)
 */
class Core
{
    private static $instance;
    private static $mainTemplate;
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
        }
        return self::$instance;
    }

    /**
     * Ініціалізація системи
    */
    public function init(): void
    {
        session_start();
        spl_autoload_register('\core\Core::spl__autoload');
        self::$mainTemplate = new Template();
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
        if (!empty($className)) {
            $fullClassName = 'controllers\\'.$className;
        } else {
           $fullClassName = Site::class;
//            $fullClassName = 'controllers\\Site';
        }

        $methodName = ucfirst($pathParts[1]);
        if (!empty($methodName)) {
            $fullMethodName = 'action'.$methodName;
        } else {
            $fullMethodName = 'actionIndex';
        }

        if (class_exists($fullClassName)) {
            $controller = new $fullClassName();
            if (method_exists($controller, $fullMethodName)) {
                $method = new \ReflectionMethod($fullClassName, $fullMethodName);
                $paramsArray = [];
                foreach ($method->getParameters() as $parameter) {
//                    array_push($paramsArray, isset($_GET[$parameter->name]) ? $_GET[$parameter->name] : null);
                    $paramsArray[] = $_GET[$parameter->name] ?? null;
                }
                $result = $method->invokeArgs($controller, $paramsArray);
                if (is_array($result)) {
                    self::$mainTemplate->setParams($result);
                }
            } else {
                throw new \RuntimeException('404 Not Found');
            }
        } else {
            throw new \RuntimeException('404 Not Found');
        }
    }

    /**
     * Завершення роботи системита вивід результатів
    */
    public function done(): void
    {
        self::$mainTemplate->display('views/layout/index.php');
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