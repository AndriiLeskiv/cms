<?php

namespace core;

/**
 * Головний клас ядра системи
 * (сингтон)
 */
class Core
{
    private static $instance;
    private function __construct()
    {

    }

    /**
     * Повертає екземпляр ядра системи
     * @return Core
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
     * Автозавантажувач класів
     * @param $className string Назва класу
    */
    public static function spl__autoload($className): void
    {
        $fileName = $className.'.php';
        if (is_file($fileName))
            include($fileName);
    }
}