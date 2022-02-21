<?php
include ('core/Core.php');

$core = \core\Core::getInstance();
$core->init();

$news = new controllers\News();
$news->display();

$page = new models\Page();
$page->display();

