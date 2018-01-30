<?php

$objCon = new mysqli("localhost", "peter.wigf6", "pete373e", "peter_wigf6_sde_dk");

if ($objCon->connect - errno) {
    die('kan ikke forbinde(' . $objCon->connect_errno . ')' . $objCon->connect_error);
}
$objCon->set_charset("utf-8");

