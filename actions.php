<?php
// Actions.php отв-т за получение данных с сервера.
// Подключить файлы.
$config = require_once 'config.php';
require_once 'functions.php';
require_once 'classes/Db.php';
require_once 'classes/Pagination.php';
require_once 'classes/Validator.php';

// The Db::getInstance() returns object.  The method getConnection()  connect us with DB
$db = (Db::getInstance())->getConnection($config['db']);


// GET RESPONSE on AJAX request as JSON string from server as assoc array
$data  = json_decode(file_get_contents('php://input'), true);

// pagination if contains page element
if(isset($data['page'])){
    $page = (int)$data['page']; 
    $per_page = $config['per_page'];      // кол-во записей на стр-це 10
    $total = get_count('city');           // получить общее кол-во городов
    // get new pagination for current page
    $pagination = new Pagination((int)$page, $per_page, $total);
    $start = $pagination->get_start();  
    $cities = get_cities($start, $per_page);  // получить города как массив 10 records
    // return a new view with pagination and city data
    require_once 'views/index-content.tpl.php';
    die;
}


// Create(Insert) city to DB (доступны поля name, population, addCity)
// если в массиве есть поле addCity
if(isset($_POST['addCity']))  {
    // json_encode Возвращает строку, содержащую JSON-представление value.
    // GET Response as {"name":"Minsk","population":"33","addCity":""}
    // echo json_encode($_POST);
    // get array. get data from post
    $data = $_POST;   /* $data Это Array([name] => dqdq [population] => 222  [addCity] => ) */
    // get instance Validator class
    $validator = new Validator();
    // validate data, validate($data as Array, rules for validation)
    // rules ['required', 'min', 'max', 'email', 'match', 'minNum'];
    // Добавляю правила для валидации полей name и population 
    $validation = $validator->validate($data, [
        'name' => [
          'required' => true,
        ],
        'population' => [
          'minNum' => 1,
        ],
        
     ]);
    // если есть ошибки
    if($validation->hasErrors()) {
      $errors = '<ul class="list-unstyled text-start text-danger">';
        foreach($validation->getErrors() as $v) {
            foreach($v as $error) {
               $errors .= "<li>{$error}</li>";
            }
        }
      $errors .= '</ul>';
      // Формируем ответ 
      $res = ['answer' => 'error', 'errors' => $errors];
    }else {
      // Save data to db
      $db->query("INSERT INTO city (`name`, `population`) VALUES (?, ?)", [$data['name'], $data['population']]);
      // Response Формируем ответ
      $res = ['answer' => 'success'];
    }
    // отправляем на клиент. json_encode Возвращает строку, содержащую JSON-представление value.
    echo json_encode($res);
    die;
}

/*
При отправке данных без заполнения полей получаем RESPONSE:
{"answer":"error","errors":"<ul class=\"list-unstyled text-start text-danger\"><li>The name field is required<\/li><li>The population field must be a number with a minimum value 1<\/li><\/ul>"}

При заполнении ВСЕХ полей и отправке данных получаем RESPONSE: {"answer":"success"}
*/ 

