<?php
$projectnavn = "ticket2ride";
define("HOME", "http://".$_SERVER["HTTP_HOST"]."/".$projectnavn."/");
define("DIR_BASE", str_replace("\\", "/", realpath(dirname(__FILE__)."/../"))."/");