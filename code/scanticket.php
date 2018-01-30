<?php

require_once '../includes/config.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

$handle = new t2rticket($objCon, 1);
$handle2 = new t2revent($objCon, 1);

$status = $handle->getStatus();
$title = $handle2->getTitle();
if($status == 0){
    $handle->setStatus(1);
    $handle->update();
    echo '<p style="font-size: 60px; color: green; font-weight: bold;">';
    echo 'APPROVED FOR ' . $title . ' ';
    echo '</p>';
}
 else {
    echo '<p style="font-size: 60px; color: red; font-weight: bold;">';
    echo 'ALREADY USED!';
    echo '</p>';
}