<?php

namespace controllers;

use core\Controller;

/**
 * Контролер для модуля News
 * @package controllers
*/
class News extends Controller
{
    /**
     * Відображення початкової сторінки модуля
    */
    public function actionIndex()
    {
        return $this->render('index', null, ['Title'=>'Новини']);
    }

    /**
     * Відображення списку новин
     */
    public function actionList(): void
    {
        echo "actionList";
    }
}