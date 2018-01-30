<?php

class t2rticket extends dbtable {

    protected $tablename = "t2r__ticket";
    protected $fields = ["id", "eventid", "status", "tid", "dato"];
    
    

    public function getId() {
        return $this->probs["id"];
    }

    public function setId($id) {
        $this->probs["id"] = $id;
    }

    public function getEventid() {
        return $this->probs["eventid"];
    }

    public function setEventid($eventid) {
        $this->probs["eventid"] = $eventid;
    }

    public function getStatus() {
        return $this->probs["status"];
    }

    public function setStatus($status) {
        $this->probs["status"] = $status;
    }

    public function getTid() {
        return $this->probs["tid"];
    }

    public function setTid($tid) {
        $this->probs["tid"] = $tid;
    }

    public function getDato() {
        return $this->probs["dato"];
    }

    public function setDato($dato) {
        $this->probs["dato"] = $dato;
    }

}
