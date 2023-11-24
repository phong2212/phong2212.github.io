<?php


include __DIR__ . '/../Apps/bootstrap.php';
$page = 'edit';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';
require_once __DIR__ . '/components/check_admin.php';

use Apps\Models\Destination;
use Apps\Models\Continent;

$cont = new Continent($PDO);
$conts = $cont->getAll();


$dest = new Destination($PDO);
$dests = $dest->findDestination($id);

?>

<main>

    <div class="container p-5 bg-light rounded my-5">
        <div class="row justify-content-between">
            <form id="EditDest" enctype="multipart/form-data">
                <h1 class="subtitle mb-5">Sửa địa điểm</h1>
                <input type="text" name="DestinationID" hidden value="<?= $dest->getDestinationID() ?>">

                <div class="mb-3 row">
                    <label for="D_eName" class="col-4"><strong>Tên địa điểm:
                        </strong></label>
                    <div class="col-8">
                        <input class="form-control" type="text" name="Name" id="D_eName" value="<?= $dest->getName() ?>">
                        <div id="en_validation" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="eDescription" class="col-4"><strong>Mô tả:
                        </strong></label>
                    <div class="col-8" style="height: 8rem;">
                        <textarea id="eDescription" class="form-control" style="caret-color: #000;" name="Description" rows="4" cols="50" placeholder="Nhập mô tả..."><?= $dest->getDescription() ?></textarea>
                        <div id="ed_validation" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="eLocation" class="col-4"><strong>Vị trí:
                        </strong></label>
                    <div class="col-8">
                        <input class="form-control" type="text" name="Location" id="eLocation" value="<?= $dest->getLocation() ?>">
                        <div id="el_validation" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="eimg" class="col-4"><strong>Ảnh địa điểm:
                        </strong></label>
                    <div class="col-8">
                        <input class="form-control" id="eimg" type="file" name="Img">
                        <div id="ei_validation" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="eContinentID" class="col-4"><strong>Thuộc châu lục:
                        </strong></label>
                    <div class="col-8">
                        <select id="eContinentID" class="form-select" name="ContinentID" aria-label="Default select example">
                            <option value="">--- Châu lục ---</option>
                            <?php
                            $contName = null;
                            foreach ($conts as $cont) {
                                if ($cont->getContinentID() === $dest->getContinentID()) {
                                    $contName = $cont->getName();
                                    break;
                                }
                            }
                            ?>
                            <option selected value="<?= $dest->getContinentID() ?>">
                                <?= ($contName !== null) ? $contName : 'N/A' ?></option>
                            <?php foreach ($conts as $cont) : ?>
                                <?php
                                if ($dest->getContinentID() != $cont->getContinentID())
                                    echo '<option value="' . $cont->getContinentID() . '">' .
                                        $cont->getName() . '</option>';

                                ?>


                            <?php endforeach ?>
                        </select>
                        <div id="ec_validation" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a type="button" href="/manage" class="btn btn-secondary me-3">Hủy</a>
                    <button type="submit" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-cResult">Đồng ý</button>
                </div>
        </div>
    </div>
    </div>
    <div id="modal-cResult" class="modal fade" tabindex="-1" aria-labelledby="modal-bresult-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-bresult-title">Thông báo
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="cResult" class="modal-body">
                    <h6 class="text-danger">Lỗi</h6>
                </div>
                <div class="modal-footer">
                    <div class="replace">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddModel">Quay lại</button>
                    </div>
                    <button id="reload" type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    </div>
    </div>
</main>

<?php

require_once __DIR__ . '/components/footer.php';

?>