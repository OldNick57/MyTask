<?php
/**
 * Routing (class, method, parameter) using URI.
 * @author N. Goodanetz
 *
 */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

  $main = new Main;

 $request = $_SERVER['REQUEST_URI'];

 $length = strlen($request);

 if($length > 15) {
 // if isset($_GET['hash'])
  $main->confirm();


 } elseif ($length > 10 && $length < 15) {
  // with GET id=...
  $main->change();

 } else {

   switch ($request) {

  // Choice of Main->method

    case '':
    case '/':
  		  $main->login();
    	  break;

    case '/register':
         $main->register();
         break;

    case '/add':
          $main->add();
          break;

    case '/profile':
          $main->profile();
          break;

    case '/email':
          $main->email();
          break;

    case '/logout':
          $main->logout();
          break;

    case '/members':
          $main->members();
          break;

    case '/sessions':
          $main->sessions();
          break;

    case '/failed':
          $main->failed();
          break;

    case '/proba':
          $main->proba();
          break;

    case '/about':
          $main->about();
          break;

    case '/restore':
          $main->restore();
          break;

    case '/forgot':
          $main->forgot();
          break;

  // If URI is incorrect
    default:
    $main->error();
        break;

   }

 }


?>