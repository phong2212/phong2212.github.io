<?php

if (!defined('BASE_URL_PATH')) {
    define('BASE_URL_PATH', '/');
}

require __DIR__ .'/../vendor/autoload.php';

try {
    $PDO = (new Apps\Libs\PDOFactory)->create([
        'dbhost' => 'localhost',
        'dbname' => 'travelhubdb',
        'dbuser' => 'root',
        'dbpass' => ''
    ]);
} catch (Exception $ex) {
    echo 'Không Thể kết nối đến MySQL, kiểm tra lại username/passowrd đến MySQL .<br>';
    exit("<pre>${ex}</pre>");
}
?>