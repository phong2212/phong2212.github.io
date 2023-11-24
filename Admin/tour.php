<?php
include __DIR__ . '/../Apps/bootstrap.php';
$page = 'tour';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';

use Apps\Models\Destination;
use Apps\Models\Continent;
use Apps\Models\UsersInformation;
use Apps\Models\Favorite;

$user = new UsersInformation($PDO);
if(isset($_SESSION['user'])){
    $user->getUser($_SESSION['user']);
}

$dest = new Destination($PDO);
$dests = $dest->findDestination($id);
switch ($dest->getContinentID()) {
    case "1":
        $Contdests = $dest->findAllDestinationsByContinent(1);
        break;
    case "2":
        $Contdests = $dest->findAllDestinationsByContinent(2);
        break;
    case "3":
        $Contdests = $dest->findAllDestinationsByContinent(3);
        break;
    case "4":
        $Contdests = $dest->findAllDestinationsByContinent(4);
        break;
    case "5":
        $Contdests = $dest->findAllDestinationsByContinent(5);
        break;
    default:
        echo "Lỗi";
        break;
};
$Randomdests = $dest->findRandomDestinations();

$cont = new Continent($PDO);
$conts = $cont->getAll();

$fav = new Favorite($PDO);
$favs = $fav->getAll();
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
                <div id="SearchCarousel" class="carousel slide">
                    <div class="carousel-indicators m-0">
                        <!-- Indicators will be added dynamically using JavaScript -->
                    </div>
                    <div class="carousel-inner">
                        <!-- Carousel items will be added dynamically using JavaScript -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#SearchCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#SearchCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section id="detail">
        <div class="container p-5 bg-light rounded my-5 position-relative">
            <div class="row justify-content-between">
                <div class="col-8">
                    <h5 class="subtitle m-0"><?= $dest->getLocation() ?></h5>
                    <h1 class="title"><?= $dest->getName() ?></h1>
                    <p class="desc"> <?= $dest->getDescription() ?></p>
                    <img class="img-fluid rounded shadow" src="/assets/img/Dest_<?= $dest->getDestinationID() ?>.jpg" alt="" style="min-width: 50rem;">
                    <p class="fw-light text-center fst-italic mt-1" style="font-size: 0.6rem;">Hình 1. <?= $dest->getName() ?></p>
                    <p class="desc mb-3 mt-4">Chào mừng đến với thế giới phiêu lưu, nơi mà những chuyến đi không chỉ là việc di chuyển từ điểm A đến B, mà còn là hành trình khám phá vẻ đẹp của thế giới xung quanh. Hãy cùng chúng tôi bắt đầu một cuộc phiêu lưu mới, nơi mà mỗi địa điểm là một câu chuyện, mỗi hình ảnh là một trải nghiệm và mỗi khoảnh khắc là một ký ức khó quên.</p>
                    <p class="desc my-3">Trong hành trình này, chúng ta sẽ khám phá một địa điểm đặc biệt, nơi những lịch sử, văn hóa và đẹp tự nhiên hội tụ để tạo nên một bức tranh tuyệt vời. Đắm chìm trong các con đường nhỏ, đắm mình trong hương vị độc đáo của ẩm thực địa phương, và cảm nhận nhịp sống động đầy màu sắc của đất đến mới lạ.</p>
                    <p class="desc my-3">Hãy cùng chúng tôi mở cánh cửa của sự kỳ diệu và khám phá những điều bí ẩn đang chờ đợi. Hãy để cuộc phiêu lưu bắt đầu và để mỗi chuyến đi là một chương trình đặc sắc, tình cảm và tràn đầy niềm vui. Chúng ta sẽ không chỉ du lịch qua không gian địa lý mà còn qua thời gian và không gian của những trải nghiệm không ngừng lan tỏa.</p>
                    <p class="desc mt-3 mb-5">
                        Chào mừng bạn đến với hành trình mới, nơi mà thế giới mở ra và cuộc sống trở nên đầy hứng khởi. Hãy cùng nhau bắt đầu chuyến phiêu lưu này và tìm kiếm những khoảnh khắc đáng nhớ, từng bước chân một.
                    </p>
                    <?php
                    $contName = null;
                    foreach ($conts as $cont) {
                        if ($cont->getContinentID() === $dest->getContinentID()) {
                            $contName = $cont->getName();
                            break;
                        }
                    }
                    ?>
                    <div class="d-inline">Tags:
                        <a class="click btn btn-outline-dark fs-6 px-1 py-0 ms-2" href="#">#<p class="d-inline" style="font-size: 0.8rem;"><?= ($contName !== null) ? $contName : 'N/A' ?></p></a>
                    </div>
                </div>
                <div class="col-4">
                    <form role="search" method="get" id="search-form" action="/tour">
                        <div class="input-group">
                            <input id="searchInput" type="text" class="form-control rounded-pill me-3" aria-label="Search" name="search" placeholder="Tìm kiếm Địa điểm...">
                            <button id="searchButton" class="btn btn-outline-secondary rounded-pill " type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <div class="bg-white rounded shadow p-5 mt-5">
                        <h5 class="subtitle">Giá Tour</h5>
                        <div class="d-block mb-4">
                            <i class="d-inline fs-3 fa-solid fa-tag me-3"></i>
                            <h3 class="d-inline fs-2 fw-bold">1.000.000Đ</h3>
                        </div>
                        <p class="fw-bold mb-4">Tour du lịch đã có sẵn.</p>
                        <?php
                        $isFavorite = false;

                        foreach ($favs as $fav) {
                            if ($user->getUserID() == $fav->getUserID() && $dest->getDestinationID() == $fav->getDestinationID()) {
                                $isFavorite = true;
                                break;
                            }
                        }

                        echo '<a href="#" class="click link-dark float-end fs-6" ';
                        if (isset($_SESSION['user'])) {
                            if ($isFavorite) {
                                echo 'onclick="deleteFavorite(' . $user->getUserID() . ',' . $dest->getDestinationID() . ')"';
                                echo ' data-bs-toggle="modal" data-bs-target="#DeleteFavorite">';
                                echo '<i class="fa-solid fa-heart me-2" style="color: #d63384;"></i>';
                                echo '<p class="d-inline" style="font-size: 0.8rem;">Xóa khỏi yêu thích!</p>';
                            } else {
                                echo 'onclick="addFavorite(' . $user->getUserID() . ',' . $dest->getDestinationID() . ')"';
                                echo ' data-bs-toggle="modal" data-bs-target="#AddFavorite">';
                                echo '<i class="d-inline fa-regular fa-heart me-2"></i>';
                                echo '<p class="d-inline" style="font-size: 0.8rem;">Thêm vào yêu thích!</p>';
                            }
                        } else {
                            echo ' data-bs-toggle="modal" data-bs-target="#CheckLogin">';
                            echo '<i class="d-inline fa-regular fa-heart me-2"></i>';
                            echo '<p class="d-inline" style="font-size: 0.8rem;">Thêm vào yêu thích!</p>';
                        }
                        echo '</a>';
                        ?>
                    </div>
                    <div class="card_contact shadow rounded p-5 mt-5 text-start">
                        <span class="d-block mb-2 text_shadow">
                            <i class="fa-solid fa-phone me-3"></i>
                            +84 999999999
                        </span>
                        <span class="d-block text_shadow">
                            <i class="fa-solid fa-envelope me-3"></i>
                            travelhub@gmail.com
                        </span>
                    </div>

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
                </div>
            </div>
    </section>

    <section id="relate">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <h3 class="subtitle mb-4">Những địa điểm khác đến tới từ <?= ($contName !== null) ? $contName : 'N/A' ?></h3>
            </div>
            <div id="carouselAutoplaying" class="row carousel slide">
                <div class="carousel-indicators m-0">
                    <?php for ($i = 0; $i < ceil(count($Contdests) / 3); $i++) : ?>
                        <button type="button" data-bs-target="#carouselAutoplaying" data-bs-slide-to="<?= $i ?>" <?php echo ($i == 0) ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $i + 1 ?>"></button>
                    <?php endfor; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($Contdests as $index => $Contdest) : ?>
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
                                    <div class="image" style="background-image: url(/assets/img/Dest_<?= $Contdest->getDestinationID() ?>.jpg); background-size: cover;">
                                        <div class="image__overlay">
                                            <h2 class="image__overlay__title"><?= $Contdest->getName() ?></h2>
                                            <p class="image__overlay__text"><?= $Contdest->getDescription() ?></p>
                                            <a type="button" href="/tourDetails/<?= $Contdest->getDestinationID() ?>" class="btn btn-dark">Xem thêm</a type="button">
                                        </div>
                                    </div>
                                </div>

                                <?php if (($index + 1) % 3 == 0 || $index == count($Contdests) - 1) : ?>
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
        </div>
    </section>

    <section id="random">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <h3 class="subtitle mb-4">Bạn có thể thích?</h3>
            </div>
            <div id="carouselAutoplaying2" class="row carousel slide">
                <div class="carousel-indicators m-0">
                    <?php for ($i = 0; $i < ceil(count($Randomdests) / 3); $i++) : ?>
                        <button type="button" data-bs-target="#carouselAutoplaying2" data-bs-slide-to="<?= $i ?>" <?php echo ($i == 0) ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $i + 1 ?>"></button>
                    <?php endfor; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($Randomdests as $index => $Randomdest) : ?>
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
                                    <div class="image" style="background-image: url(/assets/img/Dest_<?= $Randomdest->getDestinationID() ?>.jpg); background-size: cover;">
                                        <div class="image__overlay">
                                            <h2 class="image__overlay__title"><?= $Randomdest->getName() ?></h2>
                                            <p class="image__overlay__text"><?= $Randomdest->getDescription() ?></p>
                                            <a type="button" href="/tourDetails/<?= $Randomdest->getDestinationID() ?>" class="btn btn-dark">Xem thêm</a type="button">
                                        </div>
                                    </div>
                                </div>

                                <?php if (($index + 1) % 3 == 0 || $index == count($Randomdests) - 1) : ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAutoplaying2" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselAutoplaying2" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                </div>
            </div>
        </div>
    </section>

    <?php
    if (!isset($_SESSION['user'])) {
        echo '<div class="modal fade" id="CheckLogin" tabindex="-1" aria-labelledby="CheckLoginLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CheckLoginLabel">Thông báo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <h6 class="text-danger">Hãy đăng nhập trước</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button> 
                        <a type="button" href="/login" class="btn btn-primary">Đăng nhập</a>                    
                    </div>
                </div>
            </div>
        </div>';
    } else {
        $username = $_SESSION['user'];
        echo '
            <div class="modal fade" id="AddFavorite" tabindex="-1" aria-labelledby="AddFavoritelabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AddFavoritelabel">Thông báo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <h6 class="text-success">Đã thêm vào danh sách yêu thích thành công!</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary reload" data-bs-dismiss="modal">Đóng</button>
                            <a type="button" href="/favorite/' . $username . '" class="btn btn-primary">Xem</a>                    
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="DeleteFavorite" tabindex="-1" aria-labelledby="DeleteFavoritelabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="DeleteFavoritelabel">Thông báo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <h6 class="text-success">Đã Xóa khỏi danh sách yêu thích thành công!</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary reload" data-bs-dismiss="modal">Đóng</button>
                            <a type="button" href="/favorite/' . $username . '" class="btn btn-primary">Xem</a>                    
                        </div>
                    </div>
                </div>
            </div>';
    }
    ?>
</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>