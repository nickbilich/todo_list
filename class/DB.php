<?php

class DB {

    private $name = DB_NAME;

    private $user = DB_USER;

    private $pass = DB_PASS;

    private $db;

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        $this->db = new PDO($this->name, $this->user, $this->pass);
    }

    public function queryGet($query){
        $res = $this->db->query($query);
        $res = $res->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    public function querySet($query){
        return $this->db->query($query);
    }

    public function close(){
        $this->db = null;
    }
}