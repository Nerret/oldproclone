<?php 
include 'mpdf/mpdf.php';
require_once 'includes/objCon.php';
include 'includes/config.php';
spl_autoload_register(function ($class) {
    include 'classes/' . strtolower($class) . '.php';
});
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div style="background-color: #39C965;
        color: #fff;
        border-bottom: 3px solid #497C59;

        font-weight: 300;
        padding: 5px 20px;
        display: inline-block;
        line-height: 29px;
        border-radius: 4px;
        height: 40px;">
            
        </div>
        <?php
//        $handle = new t2rordre($objCon);
//        $handle->makeSettersAndGetters();
        ?>
    </body>
</html>
