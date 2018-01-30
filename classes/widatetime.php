<?php

class WiDateTime extends DateTime {

private $year, $month, $day, $hour, $minute, $second;
private $MDY, $DMY, $SQL;

public function __construct($timezone = NULL) {
    if($timezone){
parent::__construct(NULL, new DateTimeZone($timezone));
    }
    else{
        parent::__construct();
    }
$this->year = $this->format("Y");
$this->month = $this->format("m");
$this->day = $this->format("d");
$this->hour = $this->format("H");
$this->minute = $this->format("i");
$this->second = $this->format("s");
}

public function setTime($hour, $minute, $second = NULL) {
if ($hour >= 24 || $minute >= 60 || $second >= 60) {
throw new Exception("Fejl i tids inputtet");
} else {
$this->hour = $hour;
$this->minute = $minute;
$this->second = $second;
}
}

public function setDate($year, $month, $day) {
if ($month > 12 || $day > 31 || $day < 0 || $year < 0 || !is_numeric($year)) {
throw new Exception("Fejl i dato inputtet");
} else {
$this->year = $year;
$this->month = $month;
$this->date = $day;
}
}

public function modify($modify) {
throw new Exception("Denne metode er disabled");
}

public function setMDY() {
$this->MDY = $this->format("m-d-Y");
}

public function setFromMySql($timeStampfromDb) {
   $this->createFromFormat("d-m-Y", $timeStampfromDb);
}

public function setDMY() {
  $this->DMY = $this->format("d-m-Y");
}

public function GetMDY() {
return $this->MDY;
}

public function getDMY() {
return $this->DMY;
}

public function getMySqlFormat() {
return $this->SQL;
}

public function getFullYear() {
    return $this->format("Y");
}

public function getYear() {
    return $this->format("y");
}

public function getMonth(){
    return $this->format("n");
}

public function getMonthName(){
    return $this->format("F");
}

public function getMonthAbbr(){
    return $this->format("M");
}

public function getDay(){
    return $this->format("j");
}

public function getDayName(){
    return $this->format("l");
}

public function getDayAbbr(){
    return $this->format("D");
}

public function __toString() {
    $this->setDMY();
    return $this->getDMY();
}

}
