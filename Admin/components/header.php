<?php
include __DIR__ . '/../../Apps/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title><?php
            if (isset($page)) {
                switch ($page) {
                    case "home":
                        echo "Trang chủ";
                        break;
                    case "about":
                        echo "Về chúng tôi";
                        break;
                    case "login":
                        echo "Đăng nhập";
                        break;
                    case "user":
                        echo "Thông tin cá nhân";
                        break;
                    case "manage":
                        echo "Quản lý";
                        break;
                    case "edit":
                        echo "Chỉnh sửa địa điểm";
                        break;
                    case "tour":
                        echo "Chuyến du lịch";
                        break;
                    case "tours":
                        echo "Các chuyến du lịch";
                        break;
                    case "favorite":
                        echo "Yêu thích";
                        break;
                    case "blogs":
                        echo "Blogs";
                        break;
                    case "blog":
                        echo "Blog";
                        break;
                    default:
                        echo "Lỗi";
                        break;
                }
            } else {
                echo "Lỗi";
            }
            ?></title>
    <link rel="shortcut icon" type="image/png" href="/assets/img/logo.png" />
    <link rel="stylesheet" href="/assets/css/animate.css" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&amp;family=Playfair+Display:ital,wght@0,400;0,700;1,400&amp;display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="/assets/js/jquery-3.6.1.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/youtube.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body>
    <div id="loader" style="position: fixed; left: 0; top: 0; width: 100%; height: 100%; z-index: 9999; background: #fff">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="spinner-border" role="status">
            </div>
        </div>
    </div>
    <header id="header">
        <nav class="navbar navbar-expand-lg bg-transparent mt-4 z-3 position-absolute w-100" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand fw-bold fs-4" href="/">Travel Hub</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item ms-4">
                            <a class="nav-link <?php if (isset($page) && $page == 'home') echo 'active';  ?>" aria-current="'. <?php if (isset($page) && $page == 'home') echo 'page'; ?> . ' " href="/">
                                Trang chủ
                            </a>
                        </li>

                        <li class="nav-item ms-4">
                            <a class="nav-link <?php if (isset($page) && $page == 'about') echo 'active'; ?> " aria-current="<?php if (isset($page) && $page == 'about') echo 'page'; ?>" href="/about">
                                Về chúng tôi
                            </a>
                        </li>

                        <li class="nav-item dropdown ms-4">
                            <a class="nav-link dropdown-toggle <?php if (isset($page) && $page == 'tours') echo 'active'; ?> " aria-current="<?php if (isset($page) && $page == 'tours') echo 'page'; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dịch vụ
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/tours">Các chuyến du lịch</a>
                                </li>
                                <li>
                                    <a class="dropdown-item disabled" aria-disabled="true">Đặt máy bay</a>
                                </li>
                                <li>
                                    <a class="dropdown-item disabled" aria-disabled="true">Đặt khách sạn</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item ms-4">
                            <a class="nav-link <?php if (isset($page) && $page == 'blogs') echo 'active'; ?> " aria-current=" <?php if (isset($page) && $page == 'blogs') echo 'page'; ?>" href="/blogs">
                                Blog
                            </a>
                        </li>
                        <?php


                        ?>


                    </ul>
                    <?php
                    if (!isset($_SESSION['user'])) {
                        echo    '
                <a class="btn btn-outline-dark rounded-pill text-white px-4" role="button" href="/login" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"><i class="fa-solid fa-user"></i></a>
                ';
                    } else {
                        $username = $_SESSION['user'];
                        echo    '
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-dark rounded-pill text-white px-4" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                            <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/user/' . $username . '">Thông tin cá nhân</a></li>';
                        if (isset($_SESSION['user']) && isset($_SESSION['admin'])) {
                            echo '     
                            <li><a class="dropdown-item" href="/manage">Quản lí</a></li>';
                        }
                        echo '
                            <li><a class="dropdown-item" href="/favorite/' . $username . '">Yêu thích</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">Đăng xuất</a></li>
                            </ul>
                        </div>

                ';
                    }
                    ?>
                </div>
            </div>
        </nav>
        <?php
        if (isset($page) && $page == 'home') {
        ?>
            <!-- Youtube -->
            <div id="Overlay" class="z-4" style="display: none;">
                <div class="video position-absolute top-50 start-50 translate-middle" id="youtubeVideo"></div>
            </div>

            <!-- header-background -->

            <div class="background" style="background-image: url(/assets/img/background_3.jpg);">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-6 animate__animated animate__fadeInUp">
                            <h1 class="heading mb-5">Sự Trải Nghiệm quan trọng hơn Điểm Đến.</h1>
                            <div class="d-flex align-items-center">
                                <a href="https://www.youtube.com/watch?v=IuTDuvYr7f0" id="youtubeLink" class="d-flex align-items-center">
                                    <span class="fs-1 me-3 text-white">
                                        <i class="fa-regular fa-circle-play"></i>
                                    </span>
                                    <span class="fs-5 text-white">Xem Video</span>
                                </a>
                            </div>
                        </div>
                        <div class="photo-info animate__animated animate__fadeInLeft">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-location-dot"></i>
                                <span id="location">HongKong — $720.00 / night</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="background" style="background-image: url(/assets/img/background_3.jpg);">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="text-center animate__animated animate__fadeInUp">
                            <h1 class="heading mb-5"> <?php if (isset($page)) {
                                                            switch ($page) {
                                                                case "about":
                                                                    echo "Về chúng tôi";
                                                                    break;
                                                                case "user":
                                                                    echo "Thông tin cá nhân";
                                                                    break;
                                                                case "manage":
                                                                    echo "Quản lý";
                                                                    break;
                                                                case "edit":
                                                                    echo "Chỉnh sửa địa điểm";
                                                                    break;
                                                                case "tour":
                                                                    echo "Chuyến du lịch";
                                                                    break;
                                                                case "tours":
                                                                    echo "Các chuyến du lịch";
                                                                    break;
                                                                case "favorite":
                                                                    echo "Yêu thích";
                                                                    break;
                                                                case "blogs":
                                                                    echo "Các bài Blog";
                                                                    break;
                                                                case "blog":
                                                                    echo "Blog";
                                                                    break;
                                                                default:
                                                                    echo "Lỗi";
                                                                    break;
                                                            }
                                                        } else {
                                                            echo "Lỗi";
                                                        } ?></h1>
                        </div>
                        <div class="photo-info animate__animated animate__fadeInLeft">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-location-dot"></i>
                                <span id="location">HongKong — $720.00 / night</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <?php

        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (isset($_SESSION['user'])) {
            // Kiểm tra xem đã hiển thị toast chưa
            if (!isset($_SESSION['toastShown']) || !$_SESSION['toastShown']) {
                // Hiển thị toast
                echo '<div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header d-flex justify-content-between">
                        <a class="navbar-brand fw-bold fs-6 txtshd-none" href="/">Travel Hub</a>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body txtshd-none">
                            Xin chào, ' . $_SESSION['user'] . ' !
                        </div>
                    </div>
                </div>';

                // Đặt biến session thành true để đánh dấu đã hiển thị toast
                $_SESSION['toastShown'] = true;
            }
        } else {
            // Nếu người dùng đăng xuất, đặt lại giá trị biến session
            $_SESSION['toastShown'] = false;
        }

        ?>
    </header>
    <script>
        const toastLiveExample = document.getElementById('liveToast')

        if (toastLiveExample) {
            const toastBootstrap = new bootstrap.Toast(toastLiveExample)
            if (<?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>) {
                toastBootstrap.show()
            }
        }
    </script>

    <!-- BEGIN CHANGEABLE CONTENT. -->