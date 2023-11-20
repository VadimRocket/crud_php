<?php
// Подключить файлы. $config содержит массив
$config = require_once 'config.php';
require_once 'functions.php';
require_once 'classes/Db.php';
require_once 'classes/Pagination.php';

// The Db::getInstance() returns object.  The method getConnection()  connect us with DB
$db = (Db::getInstance())->getConnection($config['db']);
$page = $_GET['page'] ?? 1;          // текущий номер стр-цы
$per_page = $config['per_page'];     // кол-во записей на стр-це 10
$total = getCount('city');           // получить общее кол-во городов. int 4079
$pagination = new Pagination($page, $per_page, $total); // create object Pagination
/*
 $start  - с какой записи начинать выборку. Нач-ся с 0. 
 Например: http://localhost/crud_php/?page=3  Тогда  $start = int 20 
*/
$start = $pagination->get_start();        
$cities = get_cities($start, $per_page);  // получить города как массив 10 records
// Подключить файл
require_once 'views/index.tpl.php';
?>

