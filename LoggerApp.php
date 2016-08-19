<?php

require 'vendor/autoload.php';

// Вывод в stdout
$logger = Lgr\LoggerCreator::create();

// Запись в MySQL
//$logger = Lgr\LoggerCreator::create('mysql', 'hostname user password db_name table_name');

// Запись в файл
//$logger = Lgr\LoggerCreator::create('file', 'path_to_file');





//test
$array = array(
    array(1, 2, 3, 4, 5),
    array('key1' => 'value1', 'key2' => 'value2')
);

$logger->warning('Строка');
$logger->log('debug', $array);

try {
    throw new Exception('Some exception');
}
catch (Exception $e) {
    $logger->alert($e);
}
