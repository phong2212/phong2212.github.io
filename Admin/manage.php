<?php

include __DIR__ . '/../Apps/bootstrap.php';
$page = 'manage';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';
require_once __DIR__ . '/components/check_admin.php';

use Apps\Models\User;
use Apps\Models\UsersInformation;
use Apps\Models\Destination;
use Apps\Models\Continent;
use Apps\Models\Blog;


$user = new User($PDO);
$users = $user->getAll();

$userInfor = new UsersInformation($PDO);
$usersInfor = $userInfor->getAll();

$dest = new Destination($PDO);
$dests = $dest->getAll();

$cont = new Continent($PDO);
$conts = $cont->getAll();

$blog = new Blog($PDO);
$blogs = $blog->getAll();


?>

<main>
    <div id="switch">
        <ul class="nav">
            <li class="nav-item">
                <a id="S_user" class="Animation_click nav-link link-dark"><i class="fa-solid fa-user"></i> Bảng tài khoản</a>
            </li>
            <li class="nav-item">
                <a id="S_dest" class="Animation_click nav-link link-dark"><i class="fa-solid fa-location-dot"></i> Bảng địa điểm</a>
            </li>
            <li class="nav-item">
                <a id="S_blog" class="Animation_click nav-link link-dark"><i class="fa-solid fa-blog"></i> Bảng blog</a>
            </li>
        </ul>
    </div>
    <section id="user">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <h1 class="subtitle mb-3">Bảng tài khoản</h1>
                <table id="T_user" class="display">
                    <thead>
                        <tr>
                            <th>Mã tài khoản</th>
                            <th>Tên tài khoản</th>
                            <th>Email</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <?php
                            $userInfor = null;
                            foreach ($usersInfor as $info) {
                                if ($info->getUserID() === $user->getUserID()) {
                                    $userInfor = $info;
                                    break;
                                }
                            }
                            ?>
                            <tr>
                                <td><?= $user->getUserID() ?></td>
                                <td><a type="button" href="#" data-bs-toggle="modal" data-bs-target="#ShowInfor<?= $user->getUserID() ?>"><?= $user->getUsername() ?></a></td>
                                <!-- Modal ShowInfor -->
                                <div class="modal fade" id="ShowInfor<?= $user->getUserID() ?>" tabindex="-1" aria-labelledby="ShowInforLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="ShowInforLabel">Thông tin chi tiết</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>Họ và tên:</strong> <?= ($userInfor !== null) ? $userInfor->getFullName() : 'N/A' ?><br>
                                                <strong>Số điện thoại:</strong> <?= ($userInfor !== null) ? $userInfor->getPhone() : 'N/A' ?><br>
                                                <strong>Email:</strong> <?= ($userInfor !== null) ? $userInfor->getEmail() : 'N/A' ?> <br>
                                                <strong>Địa chỉ:</strong> <?= ($userInfor !== null) ? $userInfor->getAddress() : 'N/A' ?><br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <td><?= ($userInfor !== null) ? $userInfor->getEmail() : 'N/A' ?></td>
                                <td>
                                    <button class="delete-button" data-bs-toggle="modal" data-bs-target="#DeleteUser<?= $user->getUserID() ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="DeleteUser<?= $user->getUserID() ?>" tabindex="-1" aria-labelledby="DeleteUserLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="DeleteUserLabel">Thông báo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="button" onClick="deleteUser(<?= $user->getUserID() ?>)" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section id="dest" style="display: none;">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <div class="d-flex mb-2 justify-content-between align-items-center">
                    <h1 class="subtitle">Bảng địa điểm </h1>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddModel"><i class="fa-solid fa-plus"></i> Thêm địa điểm</button>
                </div>
                <!-- Modal Add -->
                <form id="AddDest" enctype="multipart/form-data">
                    <div class="modal fade" id="AddModel" tabindex="-1" aria-labelledby="AddModelLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="AddModelLabel">Thêm địa điểm</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="mb-3 row">
                                        <label for="D_Name" class="col-4 col-form-label"><strong>Tên địa điểm:
                                            </strong></label>
                                        <div class="col-8">
                                            <input class="form-control" type="text" name="Name" id="D_Name">
                                            <div id="n_validation" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Description" class="col-4 col-form-label"><strong>Mô tả:
                                            </strong></label>
                                        <div class="col-8" style="height: 8rem;">
                                            <textarea id="Description" class="form-control" style="caret-color: #000;" name="Description" rows="4" cols="50" placeholder="Nhập mô tả..."></textarea>
                                            <div id="d_validation" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Location" class="col-4 col-form-label"><strong>Vị trí:
                                            </strong></label>
                                        <div class="col-8">
                                            <input class="form-control" type="text" name="Location" id="Location">
                                            <div id="l_validation" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="img" class="col-4 col-form-label"><strong>Ảnh địa điểm:
                                            </strong></label>
                                        <div class="col-8">
                                            <input class="form-control" id="img" type="file" name="Img">
                                            <div id="i_validation" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="ContinentID" class="col-4 col-form-label"><strong>Thuộc châu lục:
                                            </strong></label>
                                        <div class="col-8">
                                            <select id="ContinentID" class="form-select" name="ContinentID" aria-label="Default select example">
                                                <option value="">--- Châu lục ---</option>
                                                <?php foreach ($conts as $cont) : ?>
                                                    <option value="<?php echo $cont->getContinentID() ?>">
                                                        <?php echo $cont->getName() ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <div id="c_validation" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-bresult">Đồng ý</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="modal-bresult" class="modal fade" tabindex="-1" aria-labelledby="modal-bresult-title" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modal-bresult-title">Thông báo
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div id="bResult" class="modal-body">
                                    <h6 class="text-danger">Lỗi</h6>
                                </div>
                                <div class="modal-footer">
                                    <div id="replace">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddModel">Quay lại</button>
                                    </div>
                                    <button type="button" class="reload btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table id="T_dest" class="display">
                    <thead>
                        <tr>
                            <th>Mã địa điểm</th>
                            <th>Tên địa điểm</th>
                            <th>Mô tả</th>
                            <th>Vị trí</th>
                            <th>Ảnh</th>
                            <th>Thuộc châu lục</th>
                            <th>Sửa/Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dests as $dest) : ?>
                            <tr>
                                <td><?= $dest->getDestinationID() ?></td>
                                <td><a href="/tourDetails/<?= $dest->getDestinationID() ?>"><?= $dest->getName() ?></a></td>
                                <td style="width: 7rem;"><?= $dest->getDescription() ?></td>
                                <td><?= $dest->getLocation() ?></td>
                                <td><a type="button" data-bs-toggle="modal" data-bs-target="#D_ShowImg<?= $dest->getDestinationID() ?>" href="#"><img class="img-fluid zoom-image" src="/assets/img/Dest_<?= $dest->getDestinationID() ?>.jpg" alt=""></a></td>
                                <!-- Modal Show IMG-->
                                <div class="modal modal-lg fade" id="D_ShowImg<?= $dest->getDestinationID() ?>" tabindex="-1" aria-labelledby="D_ShowImgLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="D_ShowImgLabel">Phóng to ảnh</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img class="img-fluid zoom-image" src="/assets/img/Dest_<?= $dest->getDestinationID() ?>.jpg" alt="">
                                            </div>
                                            <div class=" modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $contName = null;
                                foreach ($conts as $cont) {
                                    if ($cont->getContinentID() === $dest->getContinentID()) {
                                        $contName = $cont->getName();
                                        break;
                                    }
                                }
                                ?>

                                <td><?= ($contName !== null) ? $contName : 'N/A' ?></td>
                                <td><a type="button" href="/editDestination/<?= $dest->getDestinationID() ?>" class="edit-button">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button class="delete-button" data-bs-toggle="modal" data-bs-target="#DeleteDestination<?= $dest->getDestinationID() ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <!-- Modal Edit -->

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="DeleteDestination<?= $dest->getDestinationID() ?>" tabindex="-1" aria-labelledby="DeleteDestinationLabel" aria-hidden="true">
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
                                                    <button type="button" onClick="deleteDestination(<?= $dest->getDestinationID() ?>)" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section id="blog" style="display: none;">
        <div class="container p-5 bg-light rounded my-5">
            <div class="row justify-content-between">
                <h1 class="subtitle mb-3">Bảng blog</h1>
                <table id="T_blog" class="display table">
                    <thead>
                        <tr>
                            <th>Mã blog</th>
                            <th>Tác giả</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Ảnh</th>
                            <th>Thời gian đăng tải</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blogs as $blog) : ?>
                            <tr>
                                <td><?= $blog->getBlogID() ?></td>
                                <?php
                                $userFullName = null;
                                foreach ($usersInfor as $userInfor) {
                                    if ($userInfor->getUserID() === $blog->getUserID()) {
                                        $userFullName = $userInfor->getFullname();
                                        break;
                                    }
                                }
                                ?>
                                <td><?= ($userFullName !== null) ? $userFullName : 'N/A' ?></td>
                                <td><a href="/blogDetails/<?= $blog->getBlogID() ?>"><?= $blog->getTitle() ?></a></td>
                                <td class="truncate "><?= $blog->getContent() ?></td>
                                <td><a type="button" data-bs-toggle="modal" data-bs-target="#B_ShowImg<?= $blog->getBlogID() ?>" href="#"><img class="img-fluid zoom-image" src="/assets/img/Blog_<?= $blog->getBlogID() ?>.jpg" alt=""></a></td>
                                <!-- Modal Show IMG-->
                                <div class="modal modal-lg fade" id="B_ShowImg<?= $blog->getBlogID() ?>" tabindex="-1" aria-labelledby="B_ShowImgLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="B_ShowImgLabel">Phóng to ảnh</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img class="img-fluid zoom-image" src="/assets/img/Blog_<?= $blog->getBlogID() ?>.jpg" alt="">
                                            </div>
                                            <div class=" modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <td><?php $originalDateTime = $blog->getCreatedAt();
                                    $dateTime = new DateTime($originalDateTime);
                                    $formattedDateTime = $dateTime->format('H:i:s d-m-Y');
                                    echo $formattedDateTime; ?></td>
                                <td>
                                    <button class="delete-button" data-bs-toggle="modal" data-bs-target="#DeleteBlog<?= $blog->getBlogID() ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="DeleteBlog<?= $blog->getBlogID() ?>" tabindex="-1" aria-labelledby="DeleteBlogLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="DeleteBlogLabel">Thông báo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <a type="button" onClick="deleteBlog(<?= $blog->getBlogID() ?>)" class="btn btn-danger" data-bs-dismiss="modal">Xóa</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <!-- modal -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>



<?php

require_once __DIR__ . '/components/footer.php';

?>