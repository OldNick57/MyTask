<?php

   if(isset($_GET['id'])) {
     include_once('../model/Baza.php');

    $db = new Baza;
    echo $_GET['id'] . "\n";
    $inserted = $db->chmail($_GET['id']);


   if($inserted) {   $_SESSION['chmail'] = true;
   header("Location: /");
   exit;

  } else {

  echo '<div class="signin-form"><h3 class="form-title">Email not confirmed</h3></div>';

  }


}