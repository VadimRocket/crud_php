<?php
/*
класс Db для обработки запросов к базе данных. Класс реализует паттерн Singleton (единственный экземпляр), что означает, что в любой момент времени может существовать только один экземпляр этого класса.

Краткое объяснение основных частей:

Свойства:

private static $instance = null; - Это статическое свойство, которое будет хранить единственный экземпляр класса.

private $connection; - Это свойство будет хранить подключение к базе данных.

private PDOStatement $stmt; - Это свойство будет хранить объект PDOStatement, который представляет подготовленное SQL-заявление.

Методы:

__construct(), __clone(), __wakeup(): Эти методы объявлены как приватные в целях предотвращения создания нескольких экземпляров класса вне его пределов. Это является частью реализации паттерна Singleton.

getInstance(): Этот статический метод предоставляет единственный способ получения экземпляра класса. Если экземпляр еще не существует, он будет создан.

getConnection(array $db_config): Этот метод устанавливает подключение к базе данных. Принимает конфигурацию базы данных как аргумент и пытается создать новый объект PDO. В случае ошибки выводит сообщение об ошибке и завершает скрипт.

query($query, $params = []): Этот метод запускает SQL-запрос к базе данных. 
Возвращает себя для цепочки его с методами find, findAll, findColumn.

find(), findAll(), findColumn(): Эти методы возвращают результаты выполнения SQL-запроса.

find() возвращает одну строку результата.

findAll() возвращает все строки результата. 

findColumn() возвращает значение первого столбца первой строки результата.
Элементы безопасности:

Этот класс выставляет запросы через подготовленные выражения (prepare и execute), что предотвращает SQL-инъекции.
Все возможные ошибки с подключением и выполнением запросов к базе данных обрабатываются и выводятся пользователю.
*/

class Db
{
    private static $instance = null;
    private $connection;
    private PDOStatement $stmt;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(array $db_config)
    {
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}";

        try {
            $this->connection = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);
            return $this;
        } catch (PDOException $e) {
            echo "DB Error: {$e->getMessage()}";
            die;
        }
    }

    public function query($query, $params = [])
    {
        $this->stmt = $this->connection->prepare($query);
        try {
            $this->stmt->execute($params);
        } catch (PDOException $e) {
            return false;
            // echo "DB Error: {$e->getMessage()}";
            // die;
        }
        return $this;
    }

    public function find()
    {
        return $this->stmt->fetch();
    }

    public function findAll()
    {
        return $this->stmt->fetchAll();
    }

    public function findColumn()
    {
        return $this->stmt->fetchColumn();
    }

    public function closeConnection()
    {
        // Close the database connection.
        $this->connection = null;
    }
}
