<?php

namespace controllers;

/**
 * Контролер для модуля News
 * @package controllers
*/
class News
{
    /**
     * Відображення початкової сторінки модуля
    */
    public function actionIndex($id, $name): void
    {
        echo $id;
        echo $name;
        echo "actionIndex";
    }

    /**
     * Відображення списку новин
     */
    public function actionList(): void
    {
        echo "actionList";
    }
}