<?php
// Подключить файлы.
$config = require_once 'config.php';
require_once 'functions.php';
require_once 'classes/Db.php';
require_once 'classes/Pagination.php';
require_once 'classes/Validator.php';

// The Db::getInstance() returns object.  The method getConnection()  connect us with DB
$db = (Db::getInstance())->getConnection($config['db']);


// RESPONSE on AJAX request
// get JSON string from server as assoc array
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


