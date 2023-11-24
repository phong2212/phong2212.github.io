<?php

$router->get('/editDestination/{id}', 'Apps\Libs\PageController@editDestination');

$router->get('/tours', 'Apps\Libs\PageController@ToursPage');

$router->get('/tourDetails/{id}', 'Apps\Libs\PageController@tourDetails');

$router->get('tour/searchName/{name}', function($name) {
    global $PDO;
    $dest = new Apps\Models\Destination($PDO);
    $dests = array();
    $dests = $dest->searchName($name);
    echo json_encode($dests, JSON_UNESCAPED_UNICODE);
});

$router->delete('dest/delete/{id}', function ($id) {

    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
        $target_dir = __DIR__ . '/../../Admin/assets/img/';
        $target_file = $target_dir . "Dest_" .   $id  . ".jpg";
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        global $PDO;
        $dest = new Apps\Models\Destination($PDO);
        $dest->delete($id);
    }
});

$router->post('add/destination', function () {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
        if (isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['Location']) && isset($_FILES['Img']['tmp_name']) && isset($_POST['ContinentID'])) {
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
                    $destination = new Apps\Models\Destination($PDO);

                    $id = $destination->add($_POST['Name'], $_POST['Description'], $_POST['Location'], $_POST['ContinentID']);

                    $target_dir = __DIR__ . '/../../Admin/assets/img/';
                    $target_file = $target_dir . "Dest_" . $id . ".jpg";
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

$router->post('edit/destination', function () {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
        if (isset($_POST['Name']) && isset($_POST['Description']) && isset($_POST['Location']) && isset($_FILES['Img']['tmp_name']) && isset($_POST['ContinentID'])) {

            $target_dir = __DIR__ . '/../../Admin/assets/img/';
            $target_file = $target_dir . "Dest_" .   $_POST['DestinationID']  . ".jpg";
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
                $errors[] = "Chỉ hỗ trợ upload file JPG,  JPEG.";
            }

            if ($file_size > 10485760) {
                $errors[] = 'Kích thước file không được vượt quá 10MB';
            }

            if (empty($errors) == true) {
                $target_dir = __DIR__ . '/../../Admin/assets/img/';
                $target_file = $target_dir . "Dest_" . $_POST['DestinationID'] . ".jpg";
                move_uploaded_file($file_tmp, $target_file);

                global $PDO;
                $dest = new Apps\Models\Destination($PDO);
                $dest->edit($_POST['Name'], $_POST['Description'], $_POST['Location'], $_POST['ContinentID'], $_POST['DestinationID']);
                echo "success";
            } else {
                echo implode("\n", $errors);
            }
        }
    }
});
