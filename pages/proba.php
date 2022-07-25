<?php

    $this->database = DB_NAME;
    $this->user = DB_USER;
    $this->passwd = DB_PASSWORD;

    $this->db = new PDO("mysql:host=localhost;dbname=$this->database;", $this->user, $this->passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $username = 'admin';

    $stmt = $this->db->prepare("SELECT * FROM `members` WHERE username = ?");

       try {
    $stmt->execute([$username]);
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
       } catch (PDOException $e) {
    echo 'Member not found: ' . $e->getMessage();
       }

       print_r($arr);

?>

