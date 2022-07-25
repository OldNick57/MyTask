<?php

  if(isset($_REQUEST['email'])) {
   include_once('../model/Baza.php');

     $to = $_REQUEST['email'];

     $db = new Baza;
     $inserted = $db->mailbox($to);

  $mail = new Mail;
  $mail->from('info@nickgood.eu', 'Cool site');
  $mail->to($to, '');
  $mail->subject = 'Confirm your new email';
  $mail->body = '
	<h3>Hello!</h3>
    <p>Confirm your changed Email: <a href="https://task.nickgood.eu/change?id=' . $inserted . '">link</a></p>
    ';
  $mail->send();

  }

 // <h3>Hello,' . $_SESSION['username'] . '!</h3>

  ?>
 <section class="signup"><div class="container"><div class="signup-content">  <div class="signin-image">
    <figure><img src="/images/postman.png" alt="sing up image"></figure>
  </div>

  <h4>Check your new mailbox, please. </h4>

</div></div></div>;

