<?php

$objCon = new mysqli(");

if ($objCon->connect - errno) {
    die('kan ikke forbinde(' . $objCon->connect_errno . ')' . $objCon->connect_error);
}
$objCon->set_charset("utf-8");
