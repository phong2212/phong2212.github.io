<?php
include __DIR__ . '/../Apps/bootstrap.php';
$page = 'home';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';

use Apps\Models\Destination;
use Apps\Models\Continent;
use Apps\Models\Blog;
use Apps\Models\UsersInformation;

$dest = new Destination($PDO);
$dests = $dest->findAllDestinationsByContinent(1);

$cont = new Continent($PDO);
$conts = $cont->getAll();

$blog  = new Blog($PDO);
$blogs = $blog->findLatestBlogs();

$userInfor = new UsersInformation($PDO);
$usersInfor = $userInfor->getAll();

?>

<main>
    <!-- list places -->
    <section id="list">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <div class="col-5">
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h5 class="subtitle m-0">CHÚNG TÔI CUNG CẤP NHỮNG GÌ?</h5>
                    </div>
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h1 class="title">Những điểm đến nổi bật nhất của Châu Á.</h1>
                    </div>
                    <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
                        <p class="desc">
                            Châu Á là một châu lục rộng lớn với nhiều nền văn hóa và cảnh
                            quan thiên nhiên đa dạng. Nơi đây có những địa điểm nổi bật
                            thu hút du khách từ khắp nơi trên thế giới, như:
                        </p>
                    </div>
                </div>
                <div class="col-6 animate__animated animate__fadeInUp animate__paused">
                    <div class="row">
                        <div class="col-3">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-1.jpg" alt="" class="w-100" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Núi Fuji</h6>
                                    <p class="list__stamp__overlay-text">
                                        Ngọn núi linh thiêng trong văn hóa Nhật Bản
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt-5">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-2.jpg" alt="" class="w-100" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Petronas</h6>
                                    <p class="list__stamp__overlay-text">
                                        Tòa nhà cao nhất thế giới từ 1998-2004.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-3.jpg" alt="" class="w-100" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Shanghai</h6>
                                    <p class="list__stamp__overlay-text">
                                        Thành phố không ngủ.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt-5">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-4.jpg" alt="" class="w-100" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Vịnh Hạ Long</h6>
                                    <p class="list__stamp__overlay-text">
                                        Kỳ quan thiên nhiên thế giới.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="carouselAutoplaying" class="row carousel slide animate__animated animate__slow animate__fadeInUp animate__paused pt-5" data-bs-ride="carousel">
                <div class="carousel-indicators m-0">
                    <?php for ($i = 0; $i < ceil(count($dests) / 3); $i++) : ?>
                        <button type="button" data-bs-target="#carouselAutoplaying" data-bs-slide-to="<?= $i ?>" <?php echo ($i == 0) ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $i + 1 ?>"></button>
                    <?php endfor; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($dests as $index => $dest) : ?>
                        <?php if ($index % 3 == 0) : ?>
                            <?php if ($index == 0) : ?>
                                <div class="carousel-item active">
                                <?php else : ?>
                                </div>
                                <div class="carousel-item">
                                <?php endif; ?>
                                <div class="row p-0">
                                <?php endif; ?>

                                <div class="col-4 pe-3">
                                    <div class="image" style="background-image: url(/assets/img/Dest_<?= $dest->getDestinationID() ?>.jpg); background-size: cover;">
                                        <div class="image__overlay">
                                            <h2 class="image__overlay__title"><?= $dest->getName() ?></h2>
                                            <p class="image__overlay__text"><?= $dest->getDescription() ?></p>
                                            <a type="button" href="/tourDetails/<?= $dest->getDestinationID() ?>" class="btn btn-dark">Xem thêm</a type="button">
                                        </div>
                                    </div>
                                </div>

                                <?php if (($index + 1) % 3 == 0 || $index == count($dests) - 1) : ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAutoplaying" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselAutoplaying" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                </div>
            </div>
    </section>

    <!-- Search -->
    <section id="search">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <div class="col-7">
                    <div class="search__textbox">
                        <div class="animate__animated animate__fadeInUp animate__paused">
                            <h5 class="subtitle m-0">TÌM KIẾM ĐỊA ĐIỂM</h5>
                        </div>
                        <div class="animate__animated animate__fadeInUp animate__paused">
                            <h1 class="title">
                                Khám phá thế giới với Địa điểm yêu thích.
                            </h1>
                        </div>
                        <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
                            <p class="desc">
                                Tìm kiếm địa điểm yêu thích của bạn trên toàn thế giới với
                                Địa điểm yêu thích. Chúng tôi có danh sách đầy đủ các địa
                                điểm du lịch, từ những điểm tham quan nổi tiếng đến những
                                địa điểm ẩn giấu. Tìm kiếm theo loại địa điểm, vị trí hoặc
                                sở thích của bạn.
                            </p>
                        </div>
                    </div>
                    <div class="search__imgbox animate__animated animate__slow animate__fadeInUp animate__paused">
                        <img src="/assets/img/landscape.png" alt="" class="img-fluid" />
                    </div>
                </div>
                <div class="col-4">
                    <div class="search__box animate__animated animate__slower animate__fadeIn animate__paused">
                            <fieldset class="border border-dark border-3 rounded p-5">
                                <legend class="title fs-4 text-center mb-3">
                                    ĐỊA ĐIỂM YÊU THÍCH
                                </legend>
                                <div class="mb-3">
                                    <label for="TextInput" class="form-label">
                                        Tên địa điểm</label>
                                    <input type="titleInput" id="TitleInput" class="form-control" placeholder="Nhập tên địa điểm..." />
                                </div>
                                <h5 class="subtitle mb-3 mt-4 text-center">HOẶC</h5>
                                <div class="mb-3">
                                    <label for="ContinentID" class="form-label">Tên châu lục</label>
                                    <select id="ContinentID" class="form-select" name="ContinentID" aria-label="Default select example">
                                        <option value="">--- Châu lục ---</option>
                                        <?php foreach ($conts as $cont) : ?>
                                            <option value="<?php echo $cont->getContinentID() ?>">
                                                <?php echo $cont->getName() ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <button data-bs-toggle="modal" data-bs-target="#ErrorModal" class="btn btn-outline-dark w-100 p-3 mt-2">
                                    Tìm kiếm
                                </button>
                            </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- about us -->
    <section id="about">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row">
                <div class="col-6">
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h5 class="subtitle m-0">VỀ CHÚNG TÔI</h5>
                    </div>
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h1 class="title">
                            Khám phá mọi ngóc ngách của thế giới cùng chúng tôi.
                        </h1>
                    </div>
                    <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
                        <p class="desc">
                            Chúng tôi là một công ty du lịch chuyên nghiệp, với đội ngũ
                            nhân viên giàu kinh nghiệm và nhiệt tình. Chúng tôi sẽ giúp
                            bạn tìm kiếm và lên kế hoạch cho chuyến đi hoàn hảo, từ việc
                            lựa chọn điểm đến, đặt vé máy bay, khách sạn, cho đến các hoạt
                            động tham quan, giải trí.
                        </p>
                    </div>
                    <div class="animate__animated animate__slower animate__fadeInUp animate__paused">
                        <p class="desc">
                            Với kinh nghiệm và sự hiểu biết sâu sắc về du lịch, chúng tôi
                            sẽ giúp bạn khám phá thế giới một cách trọn vẹn nhất. Chúng
                            tôi sẽ lắng nghe nhu cầu và sở thích của bạn để đưa ra những
                            gợi ý phù hợp nhất. Chúng tôi cũng sẽ hỗ trợ bạn giải quyết
                            mọi vấn đề phát sinh trong chuyến đi, đảm bảo bạn có một kỳ
                            nghỉ đáng nhớ.
                        </p>
                    </div>
                    <div class="animate__animated animate__slow animate__fadeInUp animate__paused mt-5">
                        <a href="./about" type="button" class="btn btn-dark rounded-pill px-5 py-2">
                            Xem thêm
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="animate__animated animate__slow animate__fadeInRight animate__paused">
                        <img src="/assets/img/aboutus.png" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- blog -->
    <section id="blog">
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
                <?php foreach ($blogs as $blog) : ?>
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
                <?php
                // Hàm tính thời gian trước đó
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
            </div>
        </div>
    </section>

    <!-- notification -->
    <section id="notification">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row">
                <div class="col-6">
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h5 class="subtitle m-0">THÔNG BÁO</h5>
                    </div>
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h1 class="title">Đăng ký nhận thông tin khuyến mãi.</h1>
                    </div>
                    <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
                        <p class="desc">
                            Bạn đang lên kế hoạch cho một chuyến du lịch? Bạn muốn tiết
                            kiệm chi phí? Đừng bỏ qua cơ hội nhận thông tin khuyến mãi từ
                            website du lịch của chúng tôi.
                        </p>
                        <p class="desc">
                            Khi đăng ký nhận thông tin khuyến mãi, bạn sẽ được cập nhật
                            thường xuyên về các chương trình giảm giá, ưu đãi đặc biệt
                            dành cho khách hàng. Bạn có thể tiết kiệm được một khoản tiền
                            đáng kể cho chuyến du lịch của mình.
                        </p>
                        <p class="desc">
                            Để đăng ký nhận thông tin khuyến mãi, bạn chỉ cần nhập email
                            hoặc số điện thoại của mình vào ô đăng ký. Chúng tôi sẽ gửi
                            thông tin khuyến mãi đến bạn ngay lập tức.
                        </p>
                        <p class="desc">
                            Hãy đăng ký ngay hôm nay để không bỏ lỡ bất cứ cơ hội tiết
                            kiệm nào!
                        </p>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <div class="w-75 search__box animate__animated animate__slower animate__fadeInRight animate__paused">
                        <div class="border border-dark border-3 rounded">
                            <fieldset class="p-5">
                                <div class="mb-3">
                                    <label for="Email" class="form-label"> Email</label>
                                    <input type="email" id="Email" class="form-control" placeholder="Nhập email..." />
                                </div>
                                <div class="mb-3">
                                    <label for="Phone" class="form-label">
                                        Số điện thoại</label>
                                    <input type="tel" id="Phone" class="form-control" placeholder="Nhập số điện thoại..." />
                                </div>
                                <button class="btn btn-outline-dark w-100 mt-2" data-bs-toggle="modal" data-bs-target="#ErrorModal">
                                    Đăng ký
                                </button>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="ErrorModal" tabindex="-1" aria-labelledby="ErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="ErrorModalLabel"><i class="fa-solid fa-circle-exclamation"></i> Lỗi </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tính năng chưa phát triển.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>