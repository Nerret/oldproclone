<?php

class t2rordre extends dbtable {

    protected $tablename = "t2r__ordre";
    protected $fields = ["id", "ordrenr"];

    public function getId() {
        return $this->probs["id"];
    }

    public function setId($id) {
        $this->probs["id"] = $id;
    }

    public function getOrdrenr() {
        return $this->probs["ordrenr"];
    }

    public function setOrdrenr($ordrenr) {
        $this->probs["ordrenr"] = $ordrenr;
    }

}
