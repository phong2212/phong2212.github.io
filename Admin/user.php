<?php

include __DIR__ . '/../Apps/bootstrap.php';

use Apps\Models\UsersInformation;

$user = new UsersInformation($PDO);
$user->getUser($_SESSION['user']);

$page = 'user';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';
?>

<main>
    <div class="container p-5 bg-light rounded my-5">
        <div class="row justify-content-between">
            <div class="accordion" id="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Thông tin chi tiết
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <strong>Họ và tên:</strong> <?php echo $user->getFullName() ?> <br>
                            <strong>Số điện thoại:</strong> <?php echo $user->getPhone() ?> <br>
                            <strong>Email:</strong> <?php echo $user->getEmail() ?> <br>
                            <strong>Địa chỉ:</strong> <?php echo $user->getAddress() ?><br>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Thay đổi thông tin chi tiết
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <form class="changeForm" id="changeInformation" novalidate>
                                <div class="mb-3 row">
                                    <label for="iFullName" class="col-4 col-form-label"><strong>Họ và tên:
                                        </strong></label>
                                    <div class="col-6" style="height: 3.5rem;">
                                        <input class="form-control" name="iFullName" type="text" id="iFullName" value="<?php echo $user->getFullName() ?>">
                                        <div id="n_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="iPhone" class="col-4 col-form-label"><strong>Số điện thoại:
                                        </strong></label>
                                    <div class="col-6" style="height: 3.5rem;">
                                        <input class="form-control" name="iPhone" type="phone" id="iPhone" value="<?php echo $user->getPhone() ?>">
                                        <div id="p_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="iEmail" class="col-4 col-form-label"><strong>Email:
                                        </strong></label>
                                    <div class="col-6" style="height: 3.5rem;">
                                        <input class="form-control" name="iEmail" type="email" id="iEmail" value="<?php echo $user->getEmail() ?>">
                                        <div id="e_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="iAddress" class="col-4 col-form-label"><strong>Địa chỉ:
                                        </strong></label>
                                    <div class="col-6" style="height: 3.5rem;">
                                        <input class="form-control" name="iAddress" type="text" id="iAddress" value="<?php echo $user->getAddress() ?>">
                                        <div id="a_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="my-3 row">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary mb-3 w-25" data-bs-toggle="modal" data-bs-target="#modal-ciresult">Lưu thông
                                            tin</button>
                                        <div id="modal-ciresult" class="modal fade" tabindex="-1" aria-labelledby="modal-ciresult-title" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modal-ciresult-title">Thông
                                                            báo
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div id="ciResult" class="modal-body">
                                                        <h6 class="text-danger">Thay đổi không thành công</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Thay đổi mật khẩu
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <form class="changeForm" id="changePass">
                                <div class="mb-3 row">
                                    <label for="iFullName" class="col-5 col-form-label"><strong>Mật khẩu cũ:
                                        </strong></label>
                                    <div class="col-6" style="height: 3.5rem;">
                                        <input class="form-control" name="old-Password" type="password" id="opwd">
                                        <div id="old_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="iFullName" class="col-5 col-form-label">
                                        <strong>Mật khẩu mới: </strong></label>
                                    <div class="col-6" style="height: 3.5rem;">
                                        <input class="form-control" name="new-Password" type="password" id="npwd"></input>
                                        <div id="new_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="mb-3 row" style="height: 3.5rem;">
                                    <label for="iFullName" class="col-5 col-form-label">
                                        <strong>Nhập lại mật khẩu mới: </strong></label>
                                    <div class="col-6">
                                        <input class="form-control" name="re-new-Password" type="password" id="rnpwd"></input>
                                        <div id="rnew_validation" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="my-3 row">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary mb-3 w-25" data-bs-toggle="modal" data-bs-target="#modal-cpresult">Đồng ý</button>
                                        <div id="modal-cpresult" class="modal fade" tabindex="-1" aria-labelledby="modal-cpresult-title" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modal-cpresult-title">Thông
                                                            báo
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div id="cpResult" class="modal-body">
                                                        <h6 class='text-dabger'>Thay đổi không thành công</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require_once __DIR__ . '/components/footer.php';
?>