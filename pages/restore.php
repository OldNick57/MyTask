<?php

  if(isset($_REQUEST['submit'])) {

  $errors = array();

   function warning($errors) {
  echo '<section class="signup"><div class="container"><div class="signup-content">';
  echo '<div class="signin-image">
  <figure><img src="/images/error.png" alt="error image"></figure>
  <div class="red">';

    foreach ($errors as &$value) {
    echo '&nbsp;<b>' . $value . "</b><br />\n";
    }

   unset($value);

   echo '</div><br /><a href="forgot" class="signup-image-link">Try again, please.</a></div></div></div></div>';
   }

  if(strlen($_REQUEST['name']) < 1) {

  $errors[] = "Enter your name!";

  }


  if(count($errors) > 0) {

   warning($errors);

  }  else {

   $name = htmlspecialchars(trim($_REQUEST['name']), ENT_QUOTES);

     include_once('../model/Baza.php');
     $db = new Baza;

    function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz=+-ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

     $password = randomPassword();

     $inserted = $db->restore($name, $password);

     if(sizeof($inserted) < 1) {

     $errors[] = 'No such user';

     }

     $to = $inserted['email'];

 // print_r($inserted);
   //  $username = $inserted['username'];

  $mail = new Mail;
  $mail->from('info@nickgood.eu', 'Cool site');
  $mail->to($to, $name);
  $mail->subject = 'Restored password';
  $mail->body = '
	<h3>Hello!</h3>
    <p>Your changed password: ' . $password . '</p>
    ';
  $mail->send();

  // May be, it's dangerous - sent changed password via email? User already know his new password.

  }

  echo '<section class="signup"><div class="container"><div class="signup-content"><div class="signin-image">
    <figure><img src="/images/postman.png" alt="sing up image"></figure></div>
    <h4>Your password was changed. Check your mailbox, please.</h4></div></div></div>';

 }

   ?>

