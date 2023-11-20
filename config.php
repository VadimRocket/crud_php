<?php
// The Config contains:
// db - db connection
// per_page - count records on a page
// PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC - get array(ассоциативный) always
// for php 7 use  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION - show errors
return [
    'db' => [
        'host' => 'localhost',
        'dbname' => 'world',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8', // utf8mb4
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
    'per_page' => 10,
];
