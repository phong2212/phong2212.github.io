<?php
include __DIR__ . '/../Apps/bootstrap.php';
$page = 'blogs';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';

use Apps\Models\Blog;
use Apps\Models\UsersInformation;

$blog = new Blog($PDO);
$userInfor = new UsersInformation($PDO);

$blogs = $blog->getAll();
if (isset($_SESSION['user'])) {
    $user = $userInfor->getUser($_SESSION['user']);
}
$usersInfor =  $userInfor->getAll();

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
    <section id="search">
        <form role="search" method="get" id="search-form" action="/blogs">
            <div class="container p-4 bg-light rounded-pill my-4" style="max-width: 50rem;">
                <div class="row justify-content-between">
                    <div class="input-group">
                        <input id="searchInput" type="text" class="form-control rounded-pill me-3" aria-label="Search" name="search" placeholder="Tìm kiếm blog...">
                        <button id="searchButton" class="btn btn-outline-secondary rounded-pill " type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </section>

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

    <section id="blog">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <div class="col-8">
                    <h5 class="subtitle m-0">BLOG</h5>
                    <h1 class="title">Tất cả bài blog tại Travel Hub</h1>
                </div>
                <div class="col-2 align-self-center">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <button class="btn btn-outline-secondary rounded-pill ms-5" type="button" data-bs-toggle="modal" data-bs-target="#CreateBlogModel">
                            Thêm Blog<i class="fa-solid fa-pen-nib ms-2"></i>
                        </button>
                        <!-- Modal CreateBlog -->
                        <form id="CreateBlog" enctype="multipart/form-data">
                            <div class="modal fade" id="CreateBlogModel" tabindex="-1" aria-labelledby="CreateBlogModelLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="CreateBlogModelLabel">Thêm blog</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="UserID" hidden value="<?= $user->getUserID() ?>">
                                            <div class="mb-3 row">
                                                <label for="Title" class="col-4 col-form-label"><strong>Tiêu đề:
                                                    </strong></label>
                                                <div class="col-8">
                                                    <input class="form-control" type="text" name="Title" id="Title">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="Content" class="col-4 col-form-label"><strong>Nội dung:
                                                    </strong></label>
                                                <div class="col-8" style="height: 8rem;">
                                                    <textarea id="Content" class="form-control" style="caret-color: #000;" name="Content" rows="4" cols="50" placeholder="Nhập mô tả..."></textarea>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="img" class="col-4 col-form-label"><strong>Thêm ảnh:
                                                    </strong></label>
                                                <div class="col-8">
                                                    <input class="form-control" id="img" type="file" name="Img">
                                                    <div id="i_validation" class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
                                        <div id="AddResult" class="modal-body">
                                            <h6 class="text-danger">Lỗi</h6>
                                        </div>
                                        <div class="modal-footer">
                                            <div id="replace">
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#CreateBlogModel">Quay lại</button>
                                            </div>
                                            <button type="button" class="reload btn btn-primary reload" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
            <div class="row">
                <?php
                $perPage = 4;
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($currentPage - 1) * $perPage;
                $pagedBlogs = array_slice($blogs, $offset, $perPage);

                foreach ($pagedBlogs as $blog) :
                ?>
                    <a href="/blogDetails/<?= $blog->getBlogID() ?>" class="col-3">
                        <div class="blog__box">
                            <div class="blog__imgbox">
                                <img src="/assets/img/Blog_<?= $blog->getBlogID() ?>.jpg" alt="" class="blog__img" />
                            </div>
                            <div class="blog__textbox">
                                <h5 class="blog__title"><?= $blog->getTitle() ?></h5>
                                <p class="blog__desc limited-text ">
                                    <?= nl2br($blog->getContent()) ?>
                                </p>
                                <?php
                                $userFullName = null;
                                foreach ($usersInfor as $userInfor) {
                                    if ($userInfor->getUserID() === $blog->getUserID()) {
                                        $userFullName = $userInfor->getFullname();
                                        break;
                                    }
                                }
                                ?>
                                <h6 class="blog__author"><?= ($userFullName !== null) ? $userFullName : 'N/A' ?></h6>
                                <h6 class="blog__time"><?= timeAgo($blog->getCreatedAt()) ?></h6>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>

            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <?php
                    $totalPages = ceil(count($blogs) / $perPage);
                    ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($currentPage > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&laquo;</span>
                                </li>
                            <?php endif ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?= ($i === $currentPage) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor ?>

                            <?php if ($currentPage < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="page-item disabled">
                                    <span class="page-link" aria-hidden="true">&raquo;</span>
                                </li>
                            <?php endif ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>



</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>