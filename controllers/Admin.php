<?php
  class Admin

  /**
  * Формирует макет административного модуля
  */
{

  public $id, $content;
  private $message, $stuff, $worker, $changed, $lang, $last_login;

  function __construct()
  {
  $this->view = new View;
  }

  function __destruct()
  {

  }


  private function safeStr($str)
  {
	// удаление пробелов, экранирование
	$str = mysql_real_escape_string(trim($str));
	// удаление неразрывных пробелов (баг MySQL)
    $str = str_replace('&nbsp;', '', $str);
    return $str;
	}

// Начальная страницa
  public function home()

  {
  $this->view->admin('admin_home.tpl');

  }

  public function login()
  {
  // Вход в административный модуль
  // Сборка макета
    if (!isset($_POST['login']) && !isset($_POST['passwd']))
    {
    $message = '';
    $content = 'admin/admin_login.tpl';
    $this->view->admin($content);
    } else {
    $db = new ModelAdmin;
  // Проверка пароля
    $login = trim($_POST['login']);
  // Блокировать учётную запись можно, добавив к ней знак "-" (дефис)
    $login = str_replace('-', '', $login);
    $passwd = sha1($_POST['passwd']);
  // Пароль sha1(123) - для демо-версии:  40bd001563085fc35165329ea1ff5c5ecbdbbeef
    $worker = $db->getWorkerByLogin($login);
  // Переменные сеанса
      if (empty($worker->passwd))
      {
      $message = '<span class="red">Такого пользователя нет.</span>';
      $this->view->assign('message', $message);
      $content = 'admin/admin_login.tpl';
      $this->view->admin($content);
      } else {
        if ($worker->passwd !== $passwd)
        {
        $message = '<span class="red">Не тот пароль.</span>';
        $this->view->assign('message', $message);
        $content = 'admin/admin_login.tpl';
        $this->view->admin($content);
        } else {
      // Для меню и сообщения в шапке
        $_SESSION['login'] = $login;
        $_SESSION['name'] = $worker->name;
        $_SESSION['menu'] = $worker->menu;
        $_SESSION['level'] = $worker->stuff_level;
        $_SESSION['firma'] = $worker->firma_code;

       // Регистрация входа в БД
        $last_login = $db->addLogin($worker->id, $login);
        $_SESSION['last_login'] = $last_login;

        $content = 'admin/admin_welcome.tpl';
        $this->view->admin($content);
        }
    }
    unset($db);
    }

  }

  // Выход из административного модуля
  public function quit()
  {
  // Регистрация выхода
  $db = new ModelAdmin;
  $db->addLogout();
    unset($db);
  // Разрушение сеанса
  unset($_SESSION['menu']);
  session_destroy();
  $content = 'admin/admin_goodbye.tpl';
  $this->view->admin($content);
  }

// Список сотрудников
  public function users()
  {
  $db = new ModelAdmin;
  $stuff = $db->getStuff();
  $this->view->assign('stuff', $stuff);

  $content = 'admin/stuff/admin_stuff.tpl';
  $this->view->admin($content);
    unset($db);
  }

  // Отчёт о действиях сотрудников
  // в демо-версию не включён
// ++++++++++++++++++++++++++++++++++++++++++
  public function work()
  {
  $content = 'admin/stuff/admin_work.tpl';
  $this->view->admin($content);
  }

  // Журнал входа и выхода
  public function authlog()
  {
  $db = new ModelAdmin;
  $query = "SELECT * FROM stuff_log";
//  " WHERE id = $id";

//  $authlog = $db->getAuthlog($query);
  $authlog = $db->getAuthlog();
  $this->view->assign('authlog', $authlog);

  $stuff = $db->getStuff();
  $this->view->assign('stuff', $stuff);

  $content = 'admin/stuff/admin_authlog.tpl';
  $this->view->admin($content);
    unset($db);
  }
  // Изменение данных пользователя
  public function userEdit($id)
  {
  $db = new ModelAdmin;
  $worker = $db->getWorkerById($id);
  $this->view->assign('worker', $worker);
// Переключение пункта формы "уровень"
    $level_1 = '';  $level_2 = '';   $level_3 = '';
  	switch ($worker->menu)
  	{
    case '1':$level_1 = "selected";break;
    case '2':$level_2 = "selected";break;
    case '3':$level_3 = "selected";break;
    };
    $this->view->assign('level_1', $level_1);
    $this->view->assign('level_2', $level_2);
    $this->view->assign('level_3', $level_3);

  $content = 'admin/stuff/admin_user_edit.tpl';
  $this->view->admin($content);
    unset($db);
  }

  // Удаление учётной записи пользователя
  public function userDel($id)
  {
  $db = new ModelAdmin;
  $worker = $db->getWorkerById($id);
  $this->view->assign('worker', $worker);
  $content = 'admin/stuff/admin_user_delete.tpl';
  $this->view->admin($content);
    unset($db);
  }

  // Быстрая отсылка сообщения
  public function mailto()
  {
  $db = new ModelAdmin;
  $stuff = $db->getStuff();
  $this->view->assign('stuff', $stuff);

  $content = 'admin/stuff/admin_mailto.tpl';
  $this->view->admin($content);
    unset($db);
  }

  // Смена пароля любого сотрудника суперпользователем
  public function passwdNew($id)
  {

  $db = new ModelAdmin;
    if (!isset($_POST['passwd']))
    {
    $message = 'Будет изменён пароль сотрудника:';
    $this->view->assign('message', $message);
    } else {

       if ($_POST['passwd'] !== $_POST['passwd_confirm'])
       {
       $message = '<span class="red">Введены разные пароли.</span>';
       }

       elseif (strlen($_POST['passwd']) < 6)
       // < 3 - для ввода пароля демо-версии '123'
       {
       $message = '<span class="red">Пароль короче шести символов.</span>';
       } else
       {
    // Записываем в базу данных
       $changed = $db->changePassword($_POST['worker_id'], $_POST['passwd']);
       $message = $changed;
       }
    }

    $this->view->assign('message', $message);

  $worker = $db->getWorkerById($id);
  $this->view->assign('worker', $worker);

  $content = 'admin/stuff/admin_passwd.tpl';
  $this->view->admin($content);

    unset($db);
  }

  // Смена своего пароля рядовым сотрудником
  public function mypass()
  {
//  $db = new ModelAdmin;
    if (!isset($_POST['passwd']))
    {
    $message = '';
    } else {

       if ($_POST['passwd'] !== $_POST['passwd_confirm'])
       {
       $message = '<span class="red">Введены разные пароли.</span>';
       }
       elseif (strlen($_POST['passwd']) < 6)
       //  - для пароля демо-версии '123'
       {
       $message = '<span class="red">Пароль короче шести символов.</span>';
       }
       elseif ($_POST['old_passwd'] !== '123')
       {
       $message = '<span class="red">Не тот старый пароль.</span>';
       } else
       {

// ++++++++++++++++++++++++++++
    // Записываем в базу данных
    //   $changed = $db->changePassword($_POST['worker_id'], $_POST['passwd']);
               // if ($changed == true)
//       $message = $changed;
       $message = '<span class="red">Ваш пароль изменён.</span>';
       }
    }

  //  unset($db);

  $this->view->assign('message', $message);
  $content = 'admin/stuff/admin_mypass.tpl';
  $this->view->admin($content);
  }

  // Создание нового товара
  public function newitem()
  {
  $message = '';
  $firma = $_SESSION['firma'];

  $tableInfo = $firma . '_iteminfo';
  $tableText = $firma . '_itemtext';

    if (isset($_POST['price']))
    {
    $firma_code = $_POST['firma_code'];

// +++++++++++++++++++++++++++++++++++++++++
// Пока нет таблицы поставщиков - делаем так

      if ($firma_code == 'brshop') {
      $firma = 'SIA &bdquo;Brain Shop&ldquo;';
      } if ($firma_code == 'brsuper') {
      $firma = '&bdquo;Super Smadzenes&ldquo;';
      }
// +++++++++++++++++++++++++++++++++++++++++

    $category = $_POST['category'];
    $visible = $_POST['visible'];
    $picture = $_POST['picture'];
    $price = trim($_POST['price']);
    $old_price = trim($_POST['old_price']);
    $simple_discount = trim($_POST['simple_discount']);
    $silver_discount = trim($_POST['silver_discount']);
    $golden_discount = trim($_POST['golden_discount']);
    $tax = $_POST['tax'];
    $warehouse = $_POST['warehouse'];

    $insert = "'$category', '$visible', '$picture', '$firma_code', '$firma', '$price', '$old_price', ";
    $insert .= "'$simple_discount', '$silver_discount', '$golden_discount', '$tax', '$warehouse', now()";

    // На русском языке обязательны к заполнению все 3 текстовых поля!

    $title_ru = $this->safeStr($_POST['title_ru']);
    $description_ru = $this->safeStr($_POST['description_ru']);
    $annotation_ru = $this->safeStr($_POST['annotation_ru']);
    $insert_ru = "'$title_ru', '$description_ru', '$annotation_ru'";

    $title_en = $this->safeStr($_POST['title_en']);
    $description_en_empty = "Sorry, the description isn't translated yet.";
    $description_en = (empty($_POST['description_en'])) ? $description_en_empty : $_POST['description_en'];
    $description_en = $this->safeStr($description_en);
    $annotation_en_empty = "Sorry, the annotation isn't translated yet.";
    $annotation_en = (empty($_POST['annotation_en'])) ? $annotation_en_empty : $_POST['annotation_en'];
    $annotation_en = $this->safeStr($annotation_en);
    $insert_en = "'$title_en', '$description_en', '$annotation_en'";

    $title_lv = $_POST['title_lv'];
    $description_lv_empty = "Atvainojiet, preces apraksts pagaidam nav tulkots.";
    $description_lv = (empty($_POST['description_lv'])) ? $description_lv_empty : $_POST['description_lv'];
    $description_lv = $this->safeStr($description_lv);
    $annotation_lv_empty = "Atvainojiet, preces anotācija pagaidam nav tulkota.";
    $annotation_lv = (empty($_POST['annotation_lv'])) ? $annotation_lv_empty : $_POST['annotation_lv'];
    $annotation_lv = $this->safeStr($annotation_lv);
    $insert_lv = "'$title_lv', '$description_lv', '$annotation_lv'";

  $db = new ModelAdmin;

  $reply = $db->insertItemNew($tableInfo, $insert, $tableText, $insert_ru, $insert_en, $insert_lv);

  if ($reply > 0) $message = 'Новый товар успешно добавлен.<br />';

    unset($db);

    }

  $this->view->assign('message', $message);
  $content = 'admin/shop/item_new.tpl';
  $this->view->admin($content);

  }


}
?>