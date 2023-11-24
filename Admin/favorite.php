<?php

include __DIR__ . '/../Apps/bootstrap.php';

use Apps\Models\Favorite;
use Apps\Models\UsersInformation;
use Apps\Models\Destination;

$user = new UsersInformation($PDO);
$user->getUser($_SESSION['user']);

$fav = new Favorite($PDO);
$favs = $fav->getAllFavoritesByUserID($user->getUserID());

$dest = new Destination($PDO);

$page = 'favorite';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';
?>

<main>
    <div class="container p-5 bg-light rounded my-5">
        <div class="row justify-content-between">
            <h3 class="subtitle">Những địa điểm yêu thích</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên địa điểm</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1;
                    foreach ($favs as $fav) :
                        $dest->findDestination($fav->getDestinationID()); ?>
                        <tr>
                            <th scope="row"><?= $counter ?></th>
                            <td><a href="/tourDetails/<?=$fav->getDestinationID() ?>" class="click link-dark"><?= $dest->getName() ?></a></td>
                            <td>
                                <button class="delete-button" data-bs-toggle="modal" data-bs-target="#DeleteFavorite<?= $fav->getDestinationID() ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="DeleteFavorite<?= $fav->getDestinationID() ?>" tabindex="-1" aria-labelledby="DeleteDestinationLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="DeleteDestinationLabel">Thông báo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="button" onClick="deleteFavorite(<?= $user->getUserID() ?>, <?= $fav->getDestinationID() ?>)" class="btn btn-danger reload" data-bs-dismiss="modal">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </td>
                                
                        </tr>
                    <?php $counter++;
                    endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>