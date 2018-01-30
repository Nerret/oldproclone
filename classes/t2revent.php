<?php

class t2revent extends dbtable {

    protected $tablename = "t2r__event";
    protected $fields = ["id", "title", "antal", "dato", "tid", "sum", "location", "image", "eventtype", "pop"];

    public function getId() {
        return $this->probs["id"];
    }

    public function setId($id) {
        $this->probs["id"] = $id;
    }

    public function getTitle() {
        return $this->probs["title"];
    }

    public function setTitle($title) {
        $this->probs["title"] = $title;
    }

    public function getAntal() {
        return $this->probs["antal"];
    }

    public function setAntal($antal) {
        $this->probs["antal"] = $antal;
    }

    public function getDato() {
        return $this->probs["dato"];
    }

    public function setDato($dato) {
        $this->probs["dato"] = $dato;
    }

    public function getTid() {
        return $this->probs["tid"];
    }

    public function setTid($tid) {
        $this->probs["tid"] = $tid;
    }

    public function getSum() {
        return $this->probs["sum"];
    }

    public function setSum($sum) {
        $this->probs["sum"] = $sum;
    }

    public function getLocation() {
        return $this->probs["location"];
    }

    public function setLocation($location) {
        $this->probs["location"] = $location;
    }

    public function getImage() {
        return $this->probs["image"];
    }

    public function setImage($image) {
        $this->probs["image"] = $image;
    }

    public function getEventtype() {
        return $this->probs["eventtype"];
    }

    public function setEventtype($eventtype) {
        $this->probs["eventtype"] = $eventtype;
    }

    public function getPop() {
        return $this->probs["pop"];
    }

    public function setPop($pop) {
        $this->probs["pop"] = $pop;
    }

}
