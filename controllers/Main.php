<?php
  class Main

  /**
  * Формирует вывод содержимого в макет главной страницы
  */

{

 // error_reporting(E_ERROR | E_PARSE | E_NOTICE);

  public $id;
//  private $lang;

  function __construct()
  {

  $this->view = new Page;
  }

  function __destruct()
  {

  }

// Начальная страницa

  public function login()
  {

  $this->view->layout('login', 'Login');

  }


  public function register()
  {

  $this->view->layout('register', 'Registration form');

  }


  public function add()
  {

  $this->view->layout('add', 'Registration');

  }


  public function confirm()
  {

  $this->view->layout('confirm', 'Confirmation');

  }

  public function profile()
  {

  $this->view->layout('profile', 'Profile');

  }


  public function email()
  {

  $this->view->layout('email', 'Change email');

  }

  public function change()
  {

  $this->view->layout('change', 'New email');

  }

  public function logout()
  {

  $this->view->layout('logout', 'Logout');

  }

   public function members()
  {

  $this->view->layout('members', 'Members');

  }

  public function sessions()
  {

  $this->view->layout('sessions', 'Sessions');

  }

  public function failed()
  {

  $this->view->layout('failed', 'Failed logons');

  }

  public function proba()
  {

  $this->view->layout('proba', 'Proba');

  }

  public function about()
  {

  $this->view->layout('about', 'About this project');

  }

  public function restore()
  {

  $this->view->layout('restore', 'Reset passvord');

  }

  public function forgot()
  {

  $this->view->layout('forgot', 'Forgot password reset');

  }


  // for Error 404

  public function error()
  {

  $this->view->layout('error', 'Error');

  }

}

?>