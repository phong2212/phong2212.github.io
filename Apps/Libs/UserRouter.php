<?php
$router->get('/login', 'Apps\Libs\PageController@LoginPage');

$action = $_POST['action'] ?? '';

if ($action === 'checkLogin') {
    $router->post('/login', 'Apps\Libs\PageController@checkLogin');
} elseif ($action === 'createUser') {
    $router->post('/login', 'Apps\Libs\PageController@createUser');
}

$router->get('/logout', 'Apps\Libs\PageController@logout');

$router->get('/user/{username}', 'Apps\Libs\PageController@user');

$router->post('/user/changePwd', function () {
    if (isset($_SESSION['user'])) {
        global $PDO;
        $user = new Apps\Models\user($PDO);
        echo $user->changePassword();
    } else {
        throw new ErrorException("Có lỗi xảy ra");
    }
});

$router->post('/user/changeinfor', function () {
    if (isset($_SESSION['user'])) {
        global $PDO;
        $user = new Apps\Models\UsersInformation($PDO);
        echo $user->changeInfor();
    } else {
        throw new ErrorException("Có lỗi xảy ra");
    }
});

$router->delete('delete/user/{id}', function ($id) {

    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
        global $PDO;
        $user = new Apps\Models\user($PDO);
        echo $user->delete($id);
    } 
});
