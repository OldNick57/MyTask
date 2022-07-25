<?php
  class Page

  // Формирует макет страницы

 // error_reporting(E_ERROR | E_PARSE | E_NOTICE);

{

  public $content, $title, $head;

  function __construct()
  {

  }

  function __destruct()
  {

  }

  //  Вывод макета

  public function layout($content, $head)
  {

  $title = $head;
  require_once '../pages/header.php';
  require_once '../pages/' . $content . '.php';
  require_once '../pages/footer.php';

  }


/*
  public function admin($content)
  {
  $this->display('admin/admin_header.tpl');
  $this->display($admin_menu);
  $this->display($content);
  $this->display('admin/admin_footer.tpl');
  }
  */

}
?>