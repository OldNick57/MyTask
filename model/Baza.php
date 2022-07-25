<?php
/**
* Simple MySQLi Database class for PHP5.*, PHP7.* & PHP8.*

*/

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

 class Baza {

  private $host, $database, $user, $passwd, $connection, $filtered_email, $session_id;
  public $id, $username, $email, $password, $created, $validation, $uid, $now;

  /**
  * Sets the connection credentials to connect to your database.
  *
  * @param string $host - the host of your database
  * @param string $username - the username of your database
  * @param string $password - the password of your database
  * @param string $database - your database name

  */

  function __construct() {

  //  $this->host = "localhost";

    $this->database = DB_NAME;
    $this->user = DB_USER;
    $this->passwd = DB_PASSWORD;

   try {
   $this->db = new PDO("mysql:host=localhost;dbname=$this->database;", $this->user, $this->passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
     } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
     }
  }

  public function login($username){

    $stmt = $this->db->prepare("SELECT * FROM `members` WHERE username = ?");

       try {
    $stmt->execute([$username]);
    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
       } catch (PDOException $e) {
    echo 'Member not found: ' . $e->getMessage();
       }

     return $arr;

   }




  public function member($id){

    $this->safeId = $this->filterInt($id);

    $stmt = $this->db->prepare("SELECT * FROM `members` WHERE `id` = ?");
           try {
    $stmt->execute([$this->safeId]);
    $arr = $stmt->fetch(PDO::FETCH_LAZY);
       } catch (PDOException $e) {
    echo 'Member not selected: ' . $e->getMessage();
       }

    return $arr;

    }


   private function filterInt($int){

  // Although placeholders are used, let's add filtering too.
  $intSanitized = filter_var($int, FILTER_SANITIZE_NUMBER_INT);

      return $intSanitized;

  }


  public function confirm($validation){

    //Although placeholders are used, let's add filtering too.
    $validation = htmlspecialchars($validation, ENT_QUOTES);

    $data = [
    'validation' => $validation,
    'confirmed' => "Y",
    ];

  $sql = "UPDATE `members` SET confirmed=:confirmed WHERE validation=:validation";

       try {
  $affectedRowsNumber = $this->db->prepare($sql)->execute($data);

       } catch (PDOException $e) {
    echo 'Confirmation failed: ' . $e->getMessage();
       }
        return $affectedRowsNumber;

  }

 public function addUser($username, $email, $password, $validation) {

    $created = date("Y-m-d H:i:s");

    $data = [
    'username' => $username,
    'email' => $email,
    'password' => $password,
    'created' => $created,
    'validation' => $validation,
    ];

   $sql = "INSERT INTO `members` (username, email, password, created, validation) VALUES (:username, :email, :password, :created, :validation)";

       try {
   $affectedRowsNumber = $this->db->prepare($sql)->execute($data);
       } catch (PDOException $e) {
    echo 'Data not inserted: ' . $e->getMessage();
       }

        return $affectedRowsNumber;

  }

  public function session($uid){
    $session_id = session_id();
    $now = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];

     $sql = "INSERT INTO `sessions` (user_id, ip, session_id, start) VALUES (?,?,?,?)";

       try {
       $affectedRowsNumber = $this->db->prepare($sql)->execute([$uid, $ip, $session_id, $now]);
       } catch (PDOException $e) {
    echo 'Session record failed: ' . $e->getMessage();
       }

        return $affectedRowsNumber;
  }

  public function failed(){

     $now = date("Y-m-d H:i:s");
     $ip = $_SERVER['REMOTE_ADDR'];

  $sql = "INSERT INTO `failed` (created, ip) VALUES (?, ?)";

       try {
        $affectedRowsNumber = $this->db->prepare($sql)->execute([$now, $ip]);
       } catch (PDOException $e) {
    echo 'Attempt record failed: ' . $e->getMessage();
       }

        return $affectedRowsNumber;

  }


  public function mailbox($email){

     $username = $_SESSION['username'];
     $filtered_email = filter_var($email, FILTER_SANITIZE_EMAIL);

   $sql = "INSERT INTO `changed` (username, email) VALUES (?, ?)";

       try {
       $this->db->prepare($sql)->execute([$username, $filtered_email]);
       } catch (PDOException $e) {
    echo 'Attempt record failed: ' . $e->getMessage();
       }

        return  $this->db->lastInsertId();

  }


    public function chmail($id){

    //$this->safeId = filterInt($id);

        $stmt = $this->db->prepare("SELECT * FROM `changed` WHERE `id` = ?");
           try {
    $stmt->execute([$id]);

    $arr = $stmt->fetch(PDO::FETCH_LAZY);
       } catch (PDOException $e) {
    echo 'Email not found: ' . $e->getMessage();
       }

      $modified = date("Y-m-d H:i:s");

    $data = [
    'username' => $arr['username'],
    'email' =>    $arr['email'],
    'modified' => $modified,
    ];

    $sql = "UPDATE `members` SET email=:email, modified=:modified  WHERE username=:username";

       try {
    $affectedRowsNumber = $this->db->prepare($sql)->execute($data);
       } catch (PDOException $e) {
    echo 'Record failed: ' . $e->getMessage();
       }
        return $affectedRowsNumber;

  }


  public function logout(){

      $session_id = session_id();
      $now = date("Y-m-d H:i:s");

    $data = [
    'session_id' => $session_id,
    'logout' => $now,
    ];

  $sql = "UPDATE `sessions` SET logout=:logout WHERE session_id=:session_id";

       try {
  $affectedRowsNumber = $this->db->prepare($sql)->execute($data);

       } catch (PDOException $e) {
    echo 'Logout failed: ' . $e->getMessage();
       }

       session_destroy();
    }

  public function members() {
       try {
    $stmt = $this->db->prepare("SELECT * FROM `members`");
    $stmt->execute();
    $result = $stmt->fetchAll();
       } catch (PDOException $e) {
    echo 'DB error: ' . $e->getMessage();
       }

    return $result;

  }


  public function sessions(){
               try {
    $stmt = $this->db->prepare("SELECT * FROM `sessions` LEFT JOIN `members` ON sessions.user_id=members.id ORDER BY sessions.id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
       } catch (PDOException $e) {
    echo 'DB error: ' . $e->getMessage();
       }

    return $result;

  }

  public function fail(){
               try {
    $stmt = $this->db->prepare("SELECT * FROM `failed`");
    $stmt->execute();
    $result = $stmt->fetchAll();
       } catch (PDOException $e) {
    echo 'DB error: ' . $e->getMessage();
       }

    return $result;

  }


    public function restore($name, $password){

    $password = password_hash($password, PASSWORD_DEFAULT);

    $data = [
    'username' => $name,
    'password' => $password,
    ];

       $sql = "UPDATE `members` SET password=:password WHERE username=:username";

       try {

       $this->db->prepare($sql)->execute($data);

       } catch (PDOException $e) {
       echo 'Password change failed: ' . $e->getMessage();
       }

    $data = [
    'username' => $name,
    ];

       try {

    $stmt = $this->db->prepare("SELECT * FROM `members` WHERE username=:username");
    $stmt->execute($data);
    $result = $result = $stmt->fetch(PDO::FETCH_ASSOC);

       } catch (PDOException $e) {
    echo 'DB error: ' . $e->getMessage();
       }

    return $result;

    }

 }

?>