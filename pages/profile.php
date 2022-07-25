
<?php

  include_once('../model/Baza.php');

 //  include_once('../model/Bazasqli.php');

    //Although placeholders are used, let's add filtering too.
     $username = htmlspecialchars(trim($_REQUEST['your_name']), ENT_QUOTES);

     $db = new Baza;

     $arr = $db->login($username);

   // $obj = $db->login($username);          unset($db);



     if($arr['confirmed'] == 'N') {

     $_SESSION['repeat'] = 1;

     echo '<h3>Your email is not confirmed!</h3>';

         exit;

    }

     if(count($arr) < 1) {

     echo '<h3>No such user.</h3>';

     exit;

    }


    $password = hash('sha3-512' , trim($_REQUEST['your_pass']));

     $_SESSION['username'] =$username;

     $_SESSION['uid'] = $arr['id'];

    if(password_verify($_REQUEST['your_pass'], $arr['password'])) {

//    if($password == $arr['password']) {


            if(!empty($_REQUEST['remember-me'])) {
				setcookie ('member_login',$_REQUEST['your_name'],time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ('memberpassword',$_REQUEST['your_pass'],time()+ (10 * 365 * 24 * 60 * 60));

			} else {
				if(isset($_COOKIE["member_login"])) {
					setcookie ("member_login","");
					if(isset($_COOKIE["memberpassword"])) {
					setcookie ("memberpassword","");
				    }

			   }

			}


      $upd = $db->session($_SESSION['uid']);

      require_once('profilinc.php');


    } else {

    $_SESSION['nopasswd'] = 1;
    $db->failed();

      echo '<h3>Wrong password.</h3><br />';
      echo '<h4><a href="forgot">Forgot password?</a></h4><br />';

    exit;
    }


    if(!empty($_POST["remember"])) {
//COOKIES for username
  setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
//COOKIES for password
  setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
  } else {

  if(isset($_COOKIE["user_login"])) {
  setcookie ("user_login","");
  }
  if(isset($_COOKIE["userpassword"])) {
  setcookie ("userpassword","");
  }

 }


?>

