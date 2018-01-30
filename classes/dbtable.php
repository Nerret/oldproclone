<?php

class dbtable {

    protected $objCon;
    protected $tablename = "";
    protected $pkey = "id";
    protected $fields = [];
    protected $probs = [];

    public function __construct($objCon, $id = NULL) {
        $this->probs = array_fill_keys($this->fields, NULL);
        $this->objCon = $objCon;
        if ($id) {
            $this->findById($id);
        }
    }

    protected function findById($id) {
//        if(!is_numeric($this->id)){
//            throw new Exception('ID er altid et tal');
//        }
        // $this->fields[$this->pkey] = $id;
        $sql = "SELECT " . implode(", ", $this->fields)
                . " FROM $this->tablename "
                . "WHERE $this->pkey = $id";
        $result = $this->objCon->query($sql);
        $row = $result->fetch_object();
        foreach ($this->fields as $field) {
            $this->probs[$field] = $row->$field;
        }
    }
/**
 * Denne metode indsætter data i DB
 * 
 * @return int //id'et på det indsatte
 */
    public function create() {
        foreach ($this->fields as $field) {
            $array[] = $this->probs[$field];
        }

        echo $sql = "INSERT INTO $this->tablename (" . implode(", ", $this->fields)
        . ") VALUES ('" . implode("', '", $array) . "')";
        $this->objCon->query($sql);
        return $this->probs[$this->pkey] = $this->objCon->insert_id;
    }

    public function delete() {
      echo  $sql = "DELETE FROM $this->tablename WHERE $this->pkey = '" . $this->probs[$this->pkey] . "'";
        return $this->objCon->query($sql);
    }
    
        public function update() {
            foreach ($this->fields as $field) {
            $array[] = $field ."= '". $this->probs[$field]."'";
        }
            
        $sql = "UPDATE $this->tablename SET "
        . implode(", ", $array)
                . " WHERE $this->pkey ='". $this->probs[$this->pkey]."'";

        return $this->objCon->query($sql);
    }

    public function findAllPkey($condition = "") {
        $all = [];
        $key = $this->pkey;
        $sql = "SELECT $key "
                . "FROM $this->tablename $condition";
        $result = $this->objCon->query($sql);
        while ($row = $result->fetch_object()) {
            $all[] = $row->$key;
        }
        return $all;
    }
    
        public function findByFields($condition = "") {
        $all = [];
        $key = $this->fields;
        $sql = "SELECT $key "
                . "FROM $this->tablename $condition";
        $result = $this->objCon->query($sql);
        while ($row = $result->fetch_object()) {
            $all[] = $row->$key;
        }
        return $all;
    }
    
    public function getAll($condition=NULL){

        $sql = "SELECT id FROM $this->tablename";
        
        if($condition){
            $sql.=" ". $condition;
        }
        
    $result = $this->objCon->query($sql);
        $all = [];
        while($row = $result->fetch_object()){
            $all[] = $row->id;
        }
        return $all;
    }
    
    public function makeSettersAndGetters(){
        foreach ($this->fields as $field) {
            echo 'public function get' . ucfirst($field) . '() { <br>'
                    . 'return $this->probs["' . $field . '"];<br>'
                    . '}<br><br>'
                    . 'public function set' . ucfirst($field) . '($' . $field . ') { <br>'
                    . '$this->probs["' . $field . '"] = $' . $field . '; <br>'
                    . '}<br><br>';
        }
    }

}
