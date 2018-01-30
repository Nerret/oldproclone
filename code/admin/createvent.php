<?php
require_once '../../includes/config.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

$handle = new t2revent($objCon);

$folder = "../../imgs";
$uploader = new fileuploader($folder);


$title = $_POST['title'];
$guests = $_POST['guests'];
$date = $_POST['dato'];
$tod = $_POST['tod'];
$loc = $_POST['loc'];
$sum = $_POST['sum'];
$file = $_FILES['upload'];

$fileinfo = $uploader->upload($file);
$handle->setTitle($title);
$handle->setAntal($guests);
$handle->setDato($date);
$handle->setLocation($loc);
$handle->setSum($sum);
$handle->setTid($tod);
$handle->setImage($fileinfo['filename']);

$handle->create();

//header('Location: admin.php');
