<?php
require_once '../../includes/config.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

$folder = "../../imgs";

$uploader = new fileuploader($folder);
$uploader->addAllowedFileTypes(["txt", "peter", "pdf"]);
print_r($uploader);
//try{
//$return = $uploader->upload($_FILES['upload']);
//print_r($return);
//echo $uploader->resize($return, 100, 100);
//}
// catch (Exception $e){
//     echo $e->getMessage();
// }
#print_r($return);