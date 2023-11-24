<?php

namespace Apps\Libs;

use Exception;
use Gregwar\Captcha\PhraseBuilder;

class PageController
{
    public function HomePage()
    {
        require __DIR__ . '/../../Admin/home.php';
    }

    public function AboutPage()
    {
        require __DIR__ . '/../../Admin/about.php';
    }

    public function LoginPage()
    {

        if (isset($_SESSION['user'])) {
            header('location: /');
            exit;
        }

        $builder = new \Gregwar\Captcha\CaptchaBuilder();
        $captcha = $builder->build();

        $_SESSION['phrase'] = $captcha->getPhrase();
        require __DIR__ . '/../../Admin/login.php';
        echo $_SESSION['phrase'];
    }

    public function ManagePage()
    {
        require __DIR__ . '/../../Admin/manage.php';
    }

    public function ToursPage()
    {
        require __DIR__ . '/../../Admin/tours.php';
    }

    public function BlogsPage()
    {
        require __DIR__ . '/../../Admin/blogs.php';
    }

    public function logout()
    {
        if ($_SESSION['user'])
            unset($_SESSION['user']);
        if ($_SESSION['admin'])
            unset($_SESSION['admin']);

        echo "Bạn đã đăng xuất";
        header('location: /');
        exit();
    }

    public function user($name)
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] == $name) {
            require __DIR__ . '/../../Admin/user.php';
        } else {
            require __DIR__ . '/../../Admin/components/header.php';
            echo 'Truy cập bị từ chối!';
            $error_message = 'Trang không tồn tại';
            require __DIR__ . '/../../Admin/components/show_error.php';
            require __DIR__ . '/../../Admin/components/footer.php';
        }
    }

    public function checkLogin()
    {
        global $PDO;
        $user = new \Apps\Models\User($PDO);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (
                !(isset($_SESSION['phrase']) &&
                    PhraseBuilder::comparePhrases(
                        $_SESSION['phrase'],
                        $_POST['captcha']
                    )
                )
            ) {
                $this->LoginPage();
                echo '
                    <div class="alert alert-danger d-flex align-items-center position-absolute p-3 rounded-3 " role="alert" style="z-index: 9999;">
                        <i class="fa-solid fa-triangle-exclamation me-2""></i>
                        <div>
                            Sai mã Captcha!
                        </div>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            } else {
                if (
                    !empty($_POST['username']) &&
                    !empty($_POST['password']) &&
                    isset($_SESSION['phrase']) &&
                    PhraseBuilder::comparePhrases(
                        $_SESSION['phrase'],
                        $_POST['captcha']
                    )
                ) {
                    if ($user->checkUser(strtolower($_POST['username']), $_POST['password'])) {
                        if ($user->checkAdmin(strtolower($_POST['username']))) {
                            $_SESSION['admin'] = true;
                            echo 'ADMIN';
                        }

                        $_SESSION['user'] = strtolower($_POST['username']);
                        header('location: /');
                        exit();
                    } else {
                        $this->LoginPage();
                        echo '<div class="alert alert-danger d-flex align-items-center position-absolute p-3 rounded-3 " role="alert" style="z-index: 9999;">
                                                <i class="fa-solid fa-triangle-exclamation me-2""></i>
                                                <div>
                                                    Tài khoản không tồn tại hoặc mật khẩu không đúng?
                                                </div>
                                                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                    }
                } else {
                    $this->LoginPage();
                    echo '<div class="alert alert-danger d-flex align-items-center position-absolute p-3 rounded-3 " role="alert" style="z-index: 9999;">
                                            <i class="fa-solid fa-triangle-exclamation me-2""></i>
                                            <div>
                                                Hãy đảm bảm cung cấp đầy đủ tài khoản và mật khẩu!
                                            </div>
                                            <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
                }
            }
        }
    }

    public function createUser()
    {
        global $PDO;
        $user = new \Apps\Models\User($PDO);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->LoginPage();
                if ($user->checkUserName(strtolower($_POST['username']))) {
                    echo '
                    <div class="alert alert-danger d-flex align-items-center position-absolute p-3 rounded-3 " role="alert" style="z-index: 9999;">
                        <i class="fa-solid fa-triangle-exclamation me-2""></i>
                        <div>
                            Tài khoản đã tồn tại
                        </div>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    if ($user->register(strtolower($_POST['username']), $_POST['password'], $_POST['email'])) {
                        echo '
                    <div class="alert alert-success d-flex align-items-center position-absolute p-3 rounded-3 " role="alert" style="z-index: 9999;">
                        <i class="fa-solid fa-check me-2"></i>
                        <div>
                            Tài khoản đã đăng ký thành công
                        </div>
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    } else {
                        echo  '<h3 class="text-danger"> Có lỗi xảy ra </h3>';
                    }
                }
        }
    }

    public function editDestination($id)
    {
        if (isset($_SESSION['user']) && $_SESSION['admin'] == 1) {
            require __DIR__ . '/../../Admin/edit.php';
        } else {
            require __DIR__ . '/../../Admin/components/header.php';
            echo 'Truy cập bị từ chối!';
            $error_message = 'Trang không tồn tại';
            require __DIR__ . '/../../Admin/components/show_error.php';
            require __DIR__ . '/../../Admin/components/footer.php';
        }
    }


    public function TourDetails($id)
    {
        global $PDO;
        $tour = new \Apps\Models\Destination($PDO);
        $tours = $tour->getAll();

        $tourExists = false;
        foreach ($tours as $tourItem) {
            if ($tourItem->getDestinationID() == $id) {
                $tourExists = true;
                break;
            }
        }
        if ($tourExists) {
            require __DIR__ . '/../../Admin/tour.php';
        } else {
            require __DIR__ . '/../../Admin/components/header.php';
            echo 'Truy cập bị từ chối!';
            $error_message = 'Blog không tồn tại';
            require __DIR__ . '/../../Admin/components/show_error.php';
            require __DIR__ . '/../../Admin/components/footer.php';
        }
    }

    public function favorite($username)
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] == $username) {
            require __DIR__ . '/../../Admin/favorite.php';
        } else {
            require __DIR__ . '/../../Admin/components/header.php';
            echo 'Truy cập bị từ chối!';
            $error_message = 'Trang không tồn tại';
            require __DIR__ . '/../../Admin/components/show_error.php';
            require __DIR__ . '/../../Admin/components/footer.php';
        }
    }

    public function BlogDetails($id)
    {
        global $PDO;
        $blog = new \Apps\Models\Blog($PDO);
        $blogs = $blog->getAll();

        $blogExists = false;
        foreach ($blogs as $blogItem) {
            if ($blogItem->getBlogID() == $id) {
                $blogExists = true;
                break;
            }
        }

        if ($blogExists) {
            require __DIR__ . '/../../Admin/blog.php';
        } else {
            require __DIR__ . '/../../Admin/components/header.php';
            echo 'Truy cập bị từ chối!';
            $error_message = 'Blog không tồn tại';
            require __DIR__ . '/../../Admin/components/show_error.php';
            require __DIR__ . '/../../Admin/components/footer.php';
        }
    }
}
