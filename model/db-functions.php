<?php

require_once ('/home/beshegre/config.php');

function connect(){
    try{
        $dbh = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
        return $dbh;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}