<?php

$router->get('/blogs', 'Apps\Libs\PageController@BlogsPage');

$router->get('/blogDetails/{id}', 'Apps\Libs\PageController@BlogDetails');

$router->get('blog/searchTitle/{title}', function($title) {
    global $PDO;
    $blog = new Apps\Models\blog($PDO);
    $blogs = array();
    $blogs = $blog->searchTitle($title);
    echo json_encode($blogs, JSON_UNESCAPED_UNICODE);
});

$router->delete('blog/delete/{id}', function ($id) {
    global $PDO;
    $user = new Apps\Models\User($PDO);
    $blog = new Apps\Models\Blog($PDO);
    $blogs = $blog->findBlog($id);
    $userName = $user->findUser($blogs->getUserID());
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_SESSION['user'])) {
        if ($_SESSION['admin'] == 1 || $_SESSION['user'] == $userName->getUsername()) {
            $target_dir = __DIR__ . '/../../Admin/assets/img/';
            $target_file = $target_dir . "Blog_" . $id . ".jpg";
            if (file_exists($target_file)) {
                unlink($target_file);
            }

            $blog->delete($id);
        }
    }
});

$router->post('add/blog', function () {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
        if (isset($_POST['UserID']) && isset($_POST['Title']) && isset($_POST['Content']) && isset($_FILES['Img']['tmp_name'])) {
            if (isset($_FILES['Img'])) {
                $errors = array();
                $file_name = $_FILES['Img']['name'];
                $file_size = $_FILES['Img']['size'];
                $file_tmp = $_FILES['Img']['tmp_name'];
                $file_type = $_FILES['Img']['type'];

                $file_ext_arr = explode('.', $_FILES['Img']['name']);
                $file_ext = strtolower(end($file_ext_arr));

                $extensions = array("jpeg", "jpg");

                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "Chỉ hỗ trợ upload file JPG, JPEG.";
                }

                if ($file_size > 10485760) {
                    $errors[] = 'Kích thước file không được vượt quá 10MB';
                }

                if (empty($errors) == true) {
                    global $PDO;
                    $Blog = new Apps\Models\Blog($PDO);

                    $id = $Blog->add($_POST['UserID'], $_POST['Title'], $_POST['Content']);

                    $target_dir = __DIR__ . '/../../Admin/assets/img/';
                    $target_file = $target_dir . "Blog_" . $id . ".jpg";
                    move_uploaded_file($file_tmp, $target_file);
                    echo "success";
                } else {
                    echo implode("\n", $errors);
                }
            } else {
                echo "<h6 class='text-danger'>Vui lòng kiểm tra lại thông tin</h6>";
            }
        }
    }
});

$router->post('edit/blog', function () {
    global $PDO;
    $user = new Apps\Models\User($PDO);
    $blog = new Apps\Models\Blog($PDO);
    $blogs = $blog->findBlog($_POST['UserID']);
    $userName = $user->findUser($blogs->getUserID());

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) &&  $_SESSION['user'] == $userName->getUsername()) {
        if (isset($_POST['Title']) && isset($_POST['Content']) && isset($_FILES['Img']['tmp_name']) && isset($_POST['BlogID'])) {

            $target_dir = __DIR__ . '/../../Admin/assets/img/';
            $target_file = $target_dir . "Blog_" .   $_POST['BlogID']  . ".jpg";
            if (file_exists($target_file)) {
                unlink($target_file);
            }

            $errors = array();
            $file_name = $_FILES['Img']['name'];
            $file_size = $_FILES['Img']['size'];
            $file_tmp = $_FILES['Img']['tmp_name'];
            $file_type = $_FILES['Img']['type'];

            $file_ext_arr = explode('.', $_FILES['Img']['name']);
            $file_ext = strtolower(end($file_ext_arr));

            $extensions = array("jpeg", "jpg");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "Chỉ hỗ trợ upload file JPG, JPEG.";
            }

            if ($file_size > 10485760) {
                $errors[] = 'Kích thước file không được vượt quá 10MB';
            }

            if (empty($errors) == true) {
                $target_dir = __DIR__ . '/../../Admin/assets/img/';
                $target_file = $target_dir . "Blog_" . $_POST['BlogID'] . ".jpg";
                move_uploaded_file($file_tmp, $target_file);

                global $PDO;
                $blog = new Apps\Models\Blog($PDO);
                $blog->edit($_POST['Title'], $_POST['Content'], $_POST['BlogID']);
                echo "success";
            } else {
                echo implode("\n", $errors);
            }
        }
    }
});
