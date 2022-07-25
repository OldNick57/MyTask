<?php

  if(isset($_POST['signup'])) {
  $errors = array();

// $_REQUEST['email'] has validation via HTML5!

  if(strlen($_REQUEST['name']) < 1) {

  $errors[] = "Enter your name!";

  }

  $number = preg_match('@[0-9]@', $_REQUEST['pass']);
  $uppercase = preg_match('@[A-Z]@', $_REQUEST['pass']);
  $lowercase = preg_match('@[a-z]@', $_REQUEST['pass']);
  $specialChars = preg_match('@[^\w]@', $_REQUEST['pass']);

  if(strlen($_REQUEST['pass']) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {

  $errors[] =  "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";

  }

  if ($_REQUEST['pass'] !== $_REQUEST['re_pass']) {

   $errors[] = "Passwords not match!";

  }

  if (!$_REQUEST['re_pass']) {
     $errors[] = 'Repeat your password!';
  }

  if(!isset($_REQUEST['agree-term'])) {

   $errors[] = "You must agree all statements in Terms of service.";

  }


  if(count($errors) > 0) {

  echo '<section class="signup"><div class="container"><div class="signup-content">';

  echo '<div class="signin-image">
  <figure><img src="/images/signin-image.jpg" alt="sing up image"></figure>
  <div class="red">';

     foreach ($errors as &$value) {
    echo '&nbsp;<b>' . $value . "</b><br />\n";
    }

   unset($value);

  echo '</div><br /><a href="register" class="signup-image-link">Create an account</a></div></div></div></div>';

  }  else {

      //  $login = $_REQUEST['name'];
        $login = htmlspecialchars(trim($_REQUEST['name']), ENT_QUOTES);
        $to = $_REQUEST['email'];

        $hash = md5($login . time());

  $mail = new Mail;
  $mail->from('info@nickgood.eu', 'Cool site');
  $mail->to($to, $login);
  $mail->subject = 'Confirm your email';
  $mail->body = '
	<h3>Hello!</h3>
    <p>Confirm your Email: <a href="https://task.nickgood.eu/confirm?hash=' . $hash . '">link</a></p>
    ';
  $mail->send();


     include_once('../model/Baza.php');

     $password = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);
//     $password = hash('sha3-512', trim($_REQUEST['pass']));
     $db = new Baza;
     $inserted = $db->addUser($login, $to, $password, $hash);

     if(!$inserted) echo "Query to database failed\n";

  ?>
 <section class="signup"><div class="container"><div class="signup-content">  <div class="signin-image">
    <figure><img src="/images/postman.png" alt="sing up image"></figure>
  </div>


  <h4>Check your mailbox, please. </h4>

</div></div></div>;

 <?php

  }


}
?>