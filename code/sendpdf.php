<?php
require_once '../includes/config.php';
require_once DIR_BASE . 'mpdf/mpdf.php';
require_once DIR_BASE . 'includes/objCon.php';
spl_autoload_register(function ($class) {
    include DIR_BASE . 'classes/' . strtolower($class) . '.php';
});

$stylesheet = file_get_contents('../style/pdf.css'); // Get css content
$html = <<<TICKETPDF
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
// Setup PDF
$mpdf = new mPDF('utf-8', 'A4-L'); // New PDF object with encoding & page size
$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
$mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
// PDF header content
 
$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
$mpdf->WriteHTML($html); // Writing html to pdf
// FOR EMAIL
$content = $mpdf->Output('', 'S'); // Saving pdf to attach to email 
$content = chunk_split(base64_encode($content));
// Email settings
$mailto = "peter.uffel@gmail.com";
$from_name = 'PDF MAIL TEST';
$from_mail = 'email@domain.com';
$replyto = 'email@domain.com';
$uid = md5(uniqid(time())); 
$subject = 'mdpf email with PDF';
$message = 'Download the attached pdf';
$filename = 'mpdfmail.pdf';
$header = "From: ".$from_name." <".$from_mail.">\r\n";
$header .= "Reply-To: ".$replyto."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$header .= "This is a multi-part message in MIME format.\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header .= $message."\r\n\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$header .= $content."\r\n\r\n";
$header .= "--".$uid."--";
$is_sent = @mail($mailto, $subject, "", $header);
//$mpdf->Output(); // For sending Output to browser
$mpdf->Output('lubus_mdpf_demo.pdf','D'); // For Download