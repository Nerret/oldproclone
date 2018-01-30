<?php

class fileuploader {

    protected $folder;
    protected $allowed_mime_types = array(
        "image/jpeg", // jpg billede	
        "image/pjpeg", // jpg billede
        "image/gif", // gif billede
        "image/png" // png billede
    );
    // Maks tilladte filstørrelse - angives i MB
    protected $allowed_file_size = 5.5;

    public function __construct($hvilken_mappe_skal_filen_gemmes_i) {
        if (substr($hvilken_mappe_skal_filen_gemmes_i, -1) != "/") {
            $hvilken_mappe_skal_filen_gemmes_i .= "/";
        }
        $this->folder = $hvilken_mappe_skal_filen_gemmes_i;
    }

    public function addAllowedFileTypes($ArrayAfFiltyper, $overwrite = FALSE) {
        if($overwrite){
            $this->allowed_mime_types = [];
        }
        $mimetypes = ["txt" => "text/plain", "pdf" => "application/pdf", "png"=> "image/png", "jpg"=> "image/pjpeg", "gif"=> "image/gif"];
        
        foreach ($ArrayAfFiltyper as $mime) {
            if (array_key_exists($mime, $mimetypes)) {
                $this->allowed_mime_types[] = $mimetypes[$mime];
            }
        }
    }

    /**
     * 
     * @param type $files $_FILES['file_input_name']
     * @param bool $timestamp true hvis man vil ha time stamp på fil navn, undgår samme navn
     * @return type  array af "filename",
      "type" ,
      "save_folder"
     * @throws Exception
     */
    public function upload($files, $timestamp = false) {

        // Navnet på den fil du er ved at uploade
        $filename = $files["name"];
        // Stien til serveren, hvor filen ligger indtil scriptet er kørt færdigt
        $tmp_filename = $files["tmp_name"];
        // Størrelsen på den fil du har uploadet
        $size = $files["size"];
        // Typen på den fil du har uploadet
        $mimetype = $files["type"];
        // Er der sket nogen fejl under upload?
        $error = $files["error"];


        // Så kontrollerer vi...
        if ($error != 0) {
            throw new Exception("Filen kunne ikke uploades, der er sket en fejl! $error");
        }
        if ($this->allowed_file_size < ($size / 1000000)) {
            throw new Exception("Filen kunne ikke uploades, den er for stor! $error");
        }
        if (!in_array($mimetype, $this->allowed_mime_types)) {
            throw new Exception("Filen kunne ikke uploades, forkert fil type! $error");
        }

        // Sæt det nye filnavn, hvor vi renser for æøå, mellemrum og andre ugyldige tegn.
        // laver hele filnavnet til små bogstaver
        $new_filename = strtolower($filename);
        // Erstatter æ ø å mellemrum og komma (,) til ae oe aa bindestreg (-) og punktum (.)
        $new_filename = str_replace(
                array("æ", "ø", "å", " ", ","), array("ae", "oe", "aa", "-", "."),
                // Skal pakkes ind i utf8_encode, for at kunne finde æøå
                utf8_encode($new_filename)
        );
        // fjern alle "forstyrrende karakterer såsom /
        $new_filename = preg_replace("/[^A-Z0-9._-]/i", "_", $new_filename);

        // Vi sætter et timestamp foran, så vi ikke overskriver filer der findes i forvejen
        if ($timestamp == true) {
            $new_filename = time() . "_" . $new_filename;
        }

        // Check om filen vil komme til at overskrive allerede eksisterende filer med samme navn
        $i = 0;
        $parts = pathinfo($new_filename);
        while (file_exists($this->folder . $new_filename)) {
            $i++;
            $new_filename = $parts['filename'] . '-' . $i . '.' . $parts['extension'];
        }
        // Så kopierer vi filen med det ønskede navn til den ønskede mappe
        // Hvis alt går godt returneres TRUE til variablen success, ellers FALSE
        //$success = copy($tmp_filename, $hvilken_mappe_skal_filen_gemmes_i . $new_filename);
        $success = move_uploaded_file($tmp_filename, $this->folder . $new_filename);

        // lad funktionen returnere info om den "nye" fil 
        if ($success == true) {
            return array(
                "filename" => $new_filename,
                "type" => $mimetype,
                "save_folder" => $this->folder
            );
        } else {
            throw new Exception("Filen kunne ikke kopieres");
        }
    }

    /**
     * * @param array $upload_array (filename, folder)  
     * * @param integer $maks_hojde  
     * * @param integer $maks_bredde  
     * * @param string $thumb_prefix  
     * * @return boolean   
     */
    public function resize($upload_array, $maks_hojde, $maks_bredde, $thumb_prefix = "thumb_") {
        // Mappen, hvor det originale billede er blevet gemt
        $save_folder = $upload_array["save_folder"];
        // Navnet på filen
        $filename = $upload_array["filename"];
        $mime_type = $upload_array["type"];



        // getimagesize returnerer et array med højde, brede, højde som attribut, bredde som attribute, antal bits, antal kanaler, mime_typen,
        // men vi bruger kun de 2 første i array'et. Lav en print_r på array, for at se hele array'et.
        // print_r(getimagesize($save_folder.$filename)); die();
        // Højde og bredde og type på original-billedet aflæses vha. getimagesize
        $image_info = getimagesize($save_folder . $filename);
        print_r($image_info);
        $width = $image_info[0];
        $height = $image_info[1];
        if (!$mime_type) {
            $mime_type = $image_info["mime"];
        }

        // Laver den største side af billedet til maks tilladte størrelse og holde proportionerne for den anden side.
        // Hvis billedet er bredere end det er højt.
        if ($width > $height) {
            $ratio = $height / $width;
            $new_width = $maks_bredde;
            $new_height = round($new_width * $ratio);
        }
        // Hvis billedet er højere end det er bredt.
        elseif ($width < $height) {
            $ratio = $width / $height;
            $new_height = $maks_hojde;
            $new_width = round($new_height * $ratio);
        }
        // Hvis begge sider af billedet er lige lange.
        else {
            $new_width = $maks_bredde;
            $new_height = $maks_bredde;
        }

        // Vi skal have fat i originalbilledet og oprette det i Memory
        $source = imagecreatefromstring(file_get_contents($save_folder . $filename));

        if ($source === false) {
            throw new Exception("Fejl i filen");
        }

        // Opretter det nye billede med størrelsen fra $new_width og $new_height
        $destination = imagecreatetruecolor($new_width, $new_height);
        // png-billeder med transparens skal have lidt ekstra omsorg
        if ($mime_type == "image/png") {
            // opret  billedet uden truecolor
            $destination = imagecreate($new_width, $new_height);
            // Giver det nye png-billede en gennemsigtig baggrund (0,0,0 = sort, 127 = 100% transparent)
            $color = imagecolorallocatealpha($destination, 0, 0, 0, 127);
            // tilføj den oprettede farve til billedet
            imagefill($destination, 0, 0, $color);
        }

        // Nu tager vi det originale billede og skrumper til det nye størrelse og bestemmer, hvorhenne på lærredet vi gerne vil starte med at sætte billedet ind.
        // De 4 nuller bestyder koordinater for x og y på henholdsvis det originale billede og det nye billede.
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        $save_name = $save_folder . $thumb_prefix . $filename;

        if ($mime_type == "image/jpeg" || $mime_type == "image/pjpeg") {  // Hvis det uploadede billede er et jpg
            $success = imagejpeg($destination, $save_name); // Vi gemmer billedet som jpg
        } elseif ($mime_type == "image/gif") { // Hvis det uploadede billede er et gif
            $success = imagegif($destination, $save_name); // Vi gemmer billedet som gif
        } elseif ($mime_type == "image/png") { // Hvis det uploadede billede er et png
            $success = imagepng($destination, $save_name); // Vi gemmer billedet som png
        }


        return $success;
    }

}
