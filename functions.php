<?php
/*
функция принимает один аргумент $data. Затем она выводит содержимое переменной $data в удобочитаемом формате c помощью функции print_r(). Результат оборачивается в теги <pre> для форматирования вывода в браузере.
*/
function print_arr($data): void
{
    echo "<pre>" . print_r($data, 1) . "</pre>";
}

/*
функция Использует подготовленный SQL запрос для получения общего количества записей (строк) в указанной таблице
*/ 
function get_count(string $table): int
{
    global $db;
    return $db->query("SELECT COUNT(*) FROM {$table}")->findColumn();
}
/*
функция принимает два аргумента - целые числа $start и $per_page, которые, используются для организации пагинации (ожидается, что $start - это начальная страница, а $per_page - количество элементов на странице). Функция возвращает все строки из таблицы city, ограничив выборку заданными параметрами пагинации.
*/
function get_cities(int $start, int $per_page): array
{
    global $db;
    return $db->query("SELECT * FROM city LIMIT $start, $per_page")->findAll();
}

/*
функция search_cities осуществляет поиск городов в базе данных по подстроке. Она возвращает массив со всеми строками, которые соответствуют критерию поиска.
Проценты вокруг ${search} означают, что мы ищем любое количество любых символов до и после нашей подстроки поиска.
метод findAll(), который возвращает все найденные записи в виде ассоциативного массива.
*/
function search_cities(string $search): array
{
    global $db;
    return $db->query("SELECT * FROM city WHERE name LIKE ?", ["%{$search}%"])->findAll();
}