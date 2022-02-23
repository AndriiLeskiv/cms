<?php

namespace controllers;

use JetBrains\PhpStorm\ArrayShape;
class Site
{
    #[ArrayShape(['Title' => "string", 'Content' => "string"])] public function actionIndex(): array
    {
        return [
            'Title' => 'Заголовок',
            'Content' => 'Контент'
        ];
    }
}