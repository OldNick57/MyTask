<?php

if(isset($_GET['hash'])) {
     include_once('../model/Baza.php');

    $db = new Baza;
    $validation = htmlspecialchars($_GET['hash'], ENT_QUOTES);
    $inserted = $db->confirm($validation);

   if($inserted) {

   $_SESSION['confirmed'] = true;
   header("Location: /");
   exit;

  } else {

  echo '<div class="signin-form"><h3 class="form-title">Email not confirmed</h3></div>';

  }

}