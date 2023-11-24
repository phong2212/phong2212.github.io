<?php
include __DIR__ . '/../Apps/bootstrap.php';
$page = 'blog';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';

use Apps\Models\Blog;
use Apps\Models\User;
use Apps\Models\UsersInformation;

$blog = new Blog($PDO);
$user = new User($PDO);
$userInfor = new UsersInformation($PDO);

$blogs = $blog->findBlog($id);
$userName = $user->findUser($blogs->getUserID());
$usersInfor = $userInfor->getAll();
$lastedblogs = $blog->findLatestBlogs();
function timeAgo($createdAt)
{
    $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
    $createdTime = new DateTime($createdAt, new DateTimeZone('Asia/Ho_Chi_Minh'));
    $interval = $now->diff($createdTime);

    $timeAgo = '';

    if ($interval->y > 0) {
        $timeAgo .= $interval->y . ' năm trước';
    } elseif ($interval->m > 0) {
        $timeAgo .= $interval->m . ' tháng trước';
    } elseif ($interval->d > 0) {
        $timeAgo .= $interval->d . ' ngày trước';
    } elseif ($interval->h > 0) {
        $timeAgo .= $interval->h . ' giờ trước';
    } elseif ($interval->i > 0) {
        $timeAgo .= $interval->i . ' phút trước';
    } else {
        $timeAgo .= 'Vừa xong';
    }

    return $timeAgo;
}
?>

<main>
<section id="search-result" style="display: none;">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row">
                <div class="col-8">
                    <h1 class="title"></h1>
                </div>
            </div>
            <div id="search-results-container" class="row">
            </div>

    </section>

    <section id="detail">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <div class="col-8 row">
                    <div class="col-10">
                        <h5 class="subtitle m-0">BLOG</h5>
                        <h5 class="blog_title m-0"><?= $blog->getTitle() ?></h5>
                    </div>
                    <div class="col-2 align-self-start">
                        <?php if (isset($_SESSION['user']) && $_SESSION['user'] == $userName->getUsername()) : ?>
                            <div class="dropdown ms-5">
                                <button class="btn btn-outline-dark rounded-pill px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#EditBlogModel">Sửa Blog</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#DeleteBlogModel">Xoá Blog</a></li>
                                </ul>
                            </div>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="DeleteBlogModel" tabindex="-1" aria-labelledby="DeleteBlogModelLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="DeleteBlogModelLabel">Thông báo</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="button" onClick="deleteBlog(<?= $blog->getBlogID() ?>)" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Edit -->
                            <form id="EditBlog" enctype="multipart/form-data">
                                <div class="modal fade" id="EditBlogModel" tabindex="-1" aria-labelledby="EditBlogModelLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="EditBlogModelLabel">Chỉnh sửa Blog</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" name="UserID" hidden value="<?= $user->getUserID() ?>">
                                                <input type="text" name="BlogID" hidden value="<?= $blog->getBlogID() ?>">
                                                <div class="mb-3 row">
                                                    <label for="Title" class="col-4 col-form-label"><strong>Tiêu đề:
                                                        </strong></label>
                                                    <div class="col-8">
                                                        <input class="form-control" type="text" name="Title" id="Title" value="<?= $blog->getTitle() ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="Content" class="col-4 col-form-label"><strong>Nội dung:
                                                        </strong></label>
                                                    <div class="col-8" style="height: 8rem;">
                                                        <textarea id="Content" class="form-control" style="caret-color: #000;" name="Content" rows="4" cols="50" placeholder="Nhập mô tả..."><?= $blog->getContent() ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="img" class="col-4 col-form-label"><strong>Cập nhật ảnh:
                                                        </strong></label>
                                                    <div class="col-8">
                                                        <input class="form-control" id="img" type="file" name="Img">
                                                        <div id="i_validation" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#show-result">Đồng ý</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="show-result" class="modal fade" tabindex="-1" aria-labelledby="show-result-title" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="show-result-title">Thông báo
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div id="EditResult" class="modal-body">
                                                <h6 class="text-danger">Lỗi</h6>
                                            </div>
                                            <div class="modal-footer">
                                                <div id="replace">
                                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#EditBlogModel">Quay lại</button>
                                                </div>
                                                <button type="button" class="reload btn btn-primary reload" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php
                    $userFullName = null;
                    foreach ($usersInfor as $userInfor) {
                        if ($userInfor->getUserID() === $blog->getUserID()) {
                            $userFullName = $userInfor->getFullname();
                            break;
                        }
                    }
                    ?>
                    <div class="d-flex justify-content-start align-items-center mb-2">
                        <h6 class="blog_author"><?= ($userFullName !== null) ? $userFullName : 'N/A' ?></h6>
                        <h5 class="mx-1" style="color: grey;">&middot;</h5>
                        <h6 class="blog_time"><?= timeAgo($blog->getCreatedAt()) ?></h6>
                    </div>
                    <img class="img-fluid rounded shadow" src="/assets/img/Blog_<?= $blog->getBlogID() ?>.jpg" alt="" style="min-width: 50rem;">
                    <p class="fw-light text-center fst-italic mt-1" style="font-size: 0.6rem;">Hình 1. <?= $blog->getTitle() ?></p>
                    <p class="blog_desc">
                        <?= nl2br($blog->getContent()) ?>
                    </p>
                    <div class="d-inline mb-0">Tags:
                        <btn class="btn btn-outline-dark fs-6 px-1 py-0 ms-2">#<p class="d-inline" style="font-size: 0.8rem;">Khám phá</p>
                        </btn>
                        <btn class="btn btn-outline-dark fs-6 px-1 py-0 ms-2">#<p class="d-inline" style="font-size: 0.8rem;">Du lịch</p>
                        </btn>
                    </div>
                </div>
                <div class="col-4">
                    <form role="search" method="get" id="search-form" action="/blog">
                        <div class="input-group">
                            <input id="searchInput" type="text" class="form-control rounded-pill me-3" aria-label="Search" name="search" placeholder="Tìm kiếm blog...">
                            <button id="searchButton" class="btn btn-outline-secondary rounded-pill " type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <div class="bg-body-secondary rounded shadow p-5 mt-5 text-start">
                        <h5 class="subtitle mb-4">Tại sao chọn chúng tôi?</h5>
                        <span class="d-block text-body-tertiary">
                            <img src="/assets/img/icon-1.png" style="width: 3rem;" alt="">
                            Giải pháp du lịch hoàn thiện
                        </span>
                        <hr>
                        <span class="d-block text-body-tertiary">
                            <img src="/assets/img/icon-2.png" style="width: 3rem;" alt="">
                            Giá rẻ mỗi ngày
                        </span>
                        <hr>
                        <span class="d-block text-body-tertiary">
                            <img src="/assets/img/icon-3.png" style="width: 3rem;" alt="">
                            Phương thức thanh toán an toàn
                        </span>
                        <hr>
                        <span class="d-block text-body-tertiary">
                            <img src="/assets/img/icon-4.png" style="width: 3rem;" alt="">
                            Hỗ trợ khách hàng 24/7
                        </span>
                    </div>
                    <div class="shadow rounded p-5 mt-5 text-start" style="background-image: url(/assets/img/background_1.jpg);">
                        <span class="d-block mb-2 text-white">
                            <i class="fa-solid fa-phone me-3"></i>
                            +84 999999999
                        </span>
                        <span class="d-block text-white">
                            <i class="fa-solid fa-envelope me-3"></i>
                            travelhub@gmail.com
                        </span>
                    </div>
                </div>
            </div>
    </section>

    <section id="lasted-blog">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row">
                <div class="animate__animated animate__fadeInUp animate__paused">
                    <h5 class="subtitle m-0">BLOG</h5>
                </div>
                <div class="animate__animated animate__fadeInUp animate__paused">
                    <h1 class="title">Những bài đăng gần đây.</h1>
                </div>
            </div>
            <div class="row animate__animated animate__fadeInUp animate__paused">
                <?php foreach ($lastedblogs as $lastedblog) : ?>
                    <a href="/blogDetails/<?= $lastedblog->getBlogID() ?>" class="col-3">
                        <div class="blog__box">
                            <div class="blog__imgbox">
                                <img src="/assets/img/Blog_<?= $lastedblog->getBlogID() ?>.jpg" alt="" class="blog__img" />
                            </div>
                            <div class="blog__textbox">
                                <h5 class="blog__title"><?= $lastedblog->getTitle() ?></h5>
                                <p class="blog__desc limited-text ">
                                    <?= nl2br($lastedblog->getContent()) ?>
                                </p>
                                <?php
                                $userFullName = null;
                                foreach ($usersInfor as $userInfor) {
                                    if ($userInfor->getUserID() === $lastedblog->getUserID()) {
                                        $userFullName = $userInfor->getFullname();
                                        break;
                                    }
                                }
                                ?>
                                <h6 class="blog__author"><?= ($userFullName !== null) ? $userFullName : 'N/A' ?></h6>
                                <h6 class="blog__time"><?= timeAgo($lastedblog->getCreatedAt()) ?></h6>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </section>

</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>