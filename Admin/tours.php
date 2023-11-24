<?php
include __DIR__ . '/../Apps/bootstrap.php';
$page = 'tours';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';

use Apps\Models\Destination;
use Apps\Models\Continent;
use Apps\Models\Favorite;

$dest = new Destination($PDO);
$Eurodests = $dest->findAllDestinationsByContinent(2);

$Randomdests = $dest->findRandomDestinations();

$cont = new Continent($PDO);
$conts = $cont->getAll();

$fav = new Favorite($PDO);
$topDestinations = $fav->getTopDestinationsByFrequency();
?>

<main>
    <section id="search">
        <form role="search" method="get" id="search-form" action="/tours">
            <div class="container p-4 bg-light rounded-pill my-4" style="max-width: 50rem;">
                <div class="row justify-content-between">
                    <div class="input-group">
                        <input id="searchInput" type="text" class="form-control rounded-pill me-3" aria-label="Search" name="search" placeholder="Tìm kiếm Địa điểm...">
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



    <section id="Euro">
        <div class="container p-5 bg-light rounded mb-5">
            <div class="row justify-content-between">
                <div class="col-6">
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h5 class="subtitle m-0">CHÂU ÂU CÓ GÌ?</h5>
                    </div>
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h1 class="title">Những điểm đến nổi bật nhất của ở Châu Âu</h1>
                    </div>
                    <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
                        <p class="desc">
                            Châu Âu là một lục địa tại phía Tây của Châu Á, nằm giữa Đại Tây Dương và Biển Bắc. Với nền văn hóa đa dạng, kinh tế phát triển, Châu Âu đóng vai trò quan trọng trong cộng đồng quốc tế.
                        </p>
                    </div>
                </div>
                <div class="col-6 animate__animated animate__fadeInUp animate__paused">
                    <div class="row">
                        <div class="col-3">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-5.jpg" alt="" style="max-height: 9rem; width: 7rem;" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Eiffel</h6>
                                    <p class="list__stamp__overlay-text">
                                        Xây dựng năm 1889, là biểu tượng Paris lừng danh.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt-5">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-6.jpg" alt="" style="max-height: 9rem; width: 7rem;" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Big Ben</h6>
                                    <p class="list__stamp__overlay-text">
                                        Nổi tiếng với chuông lớn nhất thế giới.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-7.jpg" alt="" class="w-100" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Venice</h6>
                                    <p class="list__stamp__overlay-text">
                                        Nổi tiếng với hệ thống kênh và gondola duyên dáng.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mt-5">
                            <div class="list__image">
                                <div class="list__stamp">
                                    <img src="/assets/img/postmark-8.jpg" alt="" class="w-100" />
                                </div>
                                <div class="list__stamp__overlay">
                                    <h6 class="list__stamp__overlay-title">Pisa</h6>
                                    <p class="list__stamp__overlay-text">
                                        Xây năm 1173, là công trình nghệ thuật kỳ diệu..
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row animate__animated animate__slow animate__fadeInUp animate__paused mt-5">
                <div id="EuroCarousel" class="row carousel slide">
                    <div class="carousel-indicators m-0">
                        <?php for ($i = 0; $i < ceil(count($Eurodests) / 3); $i++) : ?>
                            <button type="button" data-bs-target="#EuroCarousel" data-bs-slide-to="<?= $i ?>" <?php echo ($i == 0) ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $i + 1 ?>"></button>
                        <?php endfor; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($Eurodests as $index => $Eurodest) : ?>
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
                                        <div class="image" style="background-image: url(/assets/img/Dest_<?= $Eurodest->getDestinationID() ?>.jpg); background-size: cover;">
                                            <div class="image__overlay">
                                                <h2 class="image__overlay__title"><?= $Eurodest->getName() ?></h2>
                                                <p class="image__overlay__text"><?= $Eurodest->getDescription() ?></p>
                                                <a type="button" href="/tourDetails/<?= $Eurodest->getDestinationID() ?>" class="btn btn-dark">Xem thêm</a type="button">
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (($index + 1) % 3 == 0 || $index == count($Eurodests) - 1) : ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#EuroCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#EuroCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="Favorite">
        <div class="container p-5 bg-light rounded mb-5">
            <div class="row justify-content-between">
                <div class="animate__animated animate__fadeInUp animate__paused">
                    <h5 class="subtitle m-0">YÊU HAY KHÔNG YÊU?</h5>
                </div>
                <div class="animate__animated animate__fadeInUp animate__paused">
                    <h1 class="title">Những điểm đến nổi bật được yêu thích nhất</h1>
                </div>
            </div>
            <div class="row animate__animated animate__slow animate__fadeInUp animate__paused">
                <div id="FavCarousel" class="row carousel slide">
                    <div class="carousel-indicators m-0">
                        <?php for ($i = 0; $i < ceil(count($topDestinations) / 3); $i++) : ?>
                            <button type="button" data-bs-target="#FavCarousel" data-bs-slide-to="<?= $i ?>" <?php echo ($i == 0) ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $i + 1 ?>"></button>
                        <?php endfor; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php
                        foreach ($topDestinations as $index => $destination) :
                        ?>
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
                                        <?php if ($destination) : ?>
                                            <div class="image" style="background-image: url(/assets/img/Dest_<?= $destination->getDestinationID() ?>.jpg); background-size: cover;">
                                                <div class="image__overlay">
                                                    <h2 class="image__overlay__title"><?= $destination->getName() ?></h2>
                                                    <p class="image__overlay__text"><?= $destination->getDescription() ?></p>
                                                    <a type="button" href="/tourDetails/<?= $destination->getDestinationID() ?>" class="btn btn-dark">Xem thêm</a>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <p>Destination not found.</p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (($index + 1) % 3 == 0 || $index == count($topDestinations) - 1) : ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#FavCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#FavCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="random">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <div class="col-6">
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h5 class="subtitle m-0">BẠN CÓ THỂ THÍCH?</h5>
                    </div>
                    <div class="animate__animated animate__fadeInUp animate__paused">
                        <h1 class="title">Vài gợi ý đến từ chúng tôi</h1>
                    </div>
                </div>
            </div>
            <div class="row animate__animated animate__slow animate__fadeInUp animate__paused">
                <div id="RandomCarousel" class="row carousel slide">
                    <div class="carousel-indicators m-0">
                        <?php for ($i = 0; $i < ceil(count($Randomdests) / 3); $i++) : ?>
                            <button type="button" data-bs-target="#RandomCarousel" data-bs-slide-to="<?= $i ?>" <?php echo ($i == 0) ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $i + 1 ?>"></button>
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
                                    <button class="carousel-control-prev" type="button" data-bs-target="#RandomCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#RandomCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>