<?php

$router->get('/', 'Apps\Libs\PageController@HomePage');

$router->get('/about', 'Apps\Libs\PageController@AboutPage');

$router->get('/manage', 'Apps\Libs\PageController@ManagePage');

$router->get('favorite/{username}', 'Apps\Libs\PageController@Favorite');

$router->post('add/favorite/{userid}/{destid}', function ($UserID, $DestinationID) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
        global $PDO;
        $fav = new Apps\Models\Favorite($PDO);
        $fav->addFav($UserID, $DestinationID);
        echo 'Thêm thành công';
    } else echo 'Thất bại';
});

$router->post('delete/favorite/{userid}/{destid}', function ($UserID, $DestinationID) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
        global $PDO;
        $fav = new Apps\Models\Favorite($PDO);
        $fav->deleteFav($UserID, $DestinationID);
        echo 'Xóa thành công';
    } else echo 'Thất bại';
});

$router->get('/assets/{type}/{file}', function ($type, $file) {
    $path = __DIR__ . '/../../Admin/assets/' . $type . '/' . $file;
    if (file_exists($path) && $type == 'css') {
        header('Content-Type: text/css');
        include $path;
    } else if (file_exists($path) && $type == 'js') {
        header('Content-Type: application/javascript');
        include $path;
    } else if (file_exists($path) && $type == 'img') {
        $typeFile = mime_content_type($path);
        header('Content-Type: ' . $typeFile);
        readfile($path);
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        echo 'File not found.';
    }
});
