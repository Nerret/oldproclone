<?php //

require_once '../../includes/config.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

#print_r($_POST);

$upbtn = $_POST['upbtn'];
$delbtn = $_POST['delbtn'];

if($upbtn){
    $name = $_POST["name"][$upbtn];
    $antal = $_POST["antal"][$upbtn];
    $dato = $_POST["dato"][$upbtn];
    $tid = $_POST["tid"][$upbtn];
    $loc = $_POST["loc"][$upbtn];
    $sum = $_POST["sum"][$upbtn];
    $type = $_POST["type"][$upbtn];
    $pop = $_POST['pop'][$upbtn];
    
    $handle = new t2revent($objCon, $upbtn);
    
    $handle->setAntal($antal);
    $handle->setDato($dato);
    $handle->setTid($tid);
    $handle->setTitle($name);
    $handle->setSum($sum);
    $handle->setLocation($loc);
    $handle->setEventtype($type);
    $handle->setPop($pop);
    
    $handle->update();
    
    header('Location: admin.php');
}
elseif($delbtn){
    $delete = new t2revent($objCon, $delbtn);
    $delete->delete();
    header('Location: admin.php');
}
else{
    echo 'something has gone horribly wrong, best prepare yourself...';
}
