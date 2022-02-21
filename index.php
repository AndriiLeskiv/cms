<?php
include ('core/Core.php');

$core = \core\Core::getInstance();
$core->init();
try {
    $core->run();
} catch (ReflectionException $e) {
}