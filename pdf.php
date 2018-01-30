<?php

include 'mpdf/mpdf.php';
require_once 'includes/objCon.php';
include 'includes/config.php';
spl_autoload_register(function ($class) {
    include 'classes/' . strtolower($class) . '.php';
});



$handle = new t2revent($objCon, 1);
$ticket = new t2rticket($objCon, 1);
$id = $ticket->getId();
$title = $handle->getTitle();
$tid = $handle->getTid();
$dato = $handle->getDato();
$sum = $handle->getSum();
$antal = $handle->getAntal();
$loc = $handle->getLocation();


$text = <<<TICKETPDF
   <html>
   <head>
   <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
   <link href="style/bootstrap.css" rel="stylesheet" type="text/css"/>
   <link href="style/pdf.css" rel="stylesheet" type="text/css"/>     
   </head>
   <body id="pdfbody">
   <h1>$title</h1>
   <div id="mainpdfbox">
   <p class="infopdfp">Dato: $dato</p>
   <p class="infopdfp">Kl: $tid</p>
   <p class="infopdfp">Sted: $loc</p>
   <img id="phimg" src="http://placekitten.com/320/180">
   </div>
   <div id="qrbox">
   <img src="http://open.visualead.com/?data=http://peter.wigf6.sde.dk/ticket2ride/code/scanticket.php?=$id%2F&size=110&type=png">
   </div>
   <div id="txtbox">
   <p class="sump">$sum</p>
   </div>
   </body>
   </html>
TICKETPDF;
$mpdf = new mPDF();
$mpdf->WriteHTML($text);
$mpdf->Output();

