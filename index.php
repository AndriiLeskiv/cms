<?php

use core\Core;

include ('core/Core.php');

$core = Core::getInstance();
$core->init();
try {
    $core->run();
} catch (ReflectionException $e) {
}
$core->done();