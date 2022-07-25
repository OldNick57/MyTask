<?php

 // error_reporting(E_ERROR | E_PARSE | E_NOTICE);

 // Session is already started via .htaccess

  // Controllers autoloading

  function controllers($class)
  {

    include 'controllers/' . $class . '.php';

  }

  spl_autoload_register('controllers');


  // Set BD connection configuration

  include_once('config/base_config.php');

  // Start routing
  include_once('router.php');

?>