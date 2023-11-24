<?php
$page = 'login';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';
?>

<main>

    <div class="container" id="container">
        <div class="form-container register-container">
            <form id="registerForm" method="post" class="form">
                <h1>Đăng ký</h1>
                <div class="form-control1">
                    <input id="username" type="text" placeholder="Tài khoản" name="username" />
                    <small id="username-error"></small>
                    <span></span>
                </div>
                <div class="form-control1">
                    <input id="email" type="email" placeholder="Email" name="email" />
                    <small id="email-error"></small>
                    <span></span>
                </div>
                <div class="form-control1">
                    <input id="password" type="password" placeholder="Mật khẩu" name="password" />
                    <small id="password-error"></small>
                    <span></span>
                </div>
                <input type="hidden" name="action" value="createUser">
                <button type="submit" value="submit">Đăng ký</button>
                <span>Hoặc dùng các tài khoản khác</span>
                <div class="social-container">
                    <a href="#" class="social" data-bs-toggle="modal" data-bs-target="#ErrorModal"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social" data-bs-toggle="modal" data-bs-target="#ErrorModal"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="social" data-bs-toggle="modal" data-bs-target="#ErrorModal"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </form>
        </div>

        <div class="form-container login-container">
            <form class="form-lg" method="post" action="<?php echo htmlspecialchars("/login"); ?>">
                <h1>Đăng nhập</h1>
                <div class="form-control2">
                    <input type="text" class="username-2" placeholder="Tài khoản" name="username" />
                    <small class="username-error-2"></small>
                    <span></span>
                </div>
                <div class="form-control2">
                    <input type="password" class="password-2" placeholder="Mật khẩu" name="password" />
                    <small class="password-error-2"></small>
                    <span></span>
                </div>
                <div class="form-control2">
                    <img src="<?= $builder->inline() ?>" alt="Captcha" class="rounded">
                    <br>
                    <input type="text" name="captcha" placeholder="Captcha">
                </div>
                <div class="content">
                    <div class="checkbox">
                        <input type="checkbox" name="checkbox" id="checkbox" />
                        <label for="">Ghi nhớ tôi</label>
                    </div>
                    <div class="pass-link">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#ErrorModal">Quên mật khẩu</a>
                    </div>
                </div>
                <input type="hidden" name="action" value="checkLogin">
                <button type="submit" value="submit">Đăng nhập</button>
                <span>Hoặc dùng các tài khoản khác</span>
                <div class="social-container">
                    <a href="#" class="social" data-bs-toggle="modal" data-bs-target="#ErrorModal"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social" data-bs-toggle="modal" data-bs-target="#ErrorModal"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="social" data-bs-toggle="modal" data-bs-target="#ErrorModal"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">
                        Xin chào <br />
                        bạn!
                    </h1>
                    <p>Nếu bạn đã có tài khoản, thì đăng nhập tại đây và tận hưởng nhé!</p>
                    <button class="ghost" id="login">
                        Đăng nhập
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div class="overlay-panel overlay-right">
                    <h1 class="title">
                        Bắt đầu <br />
                        ngay bây giờ!
                    </h1>
                    <p>
                        Nếu bạn chưa có tài khoản, hãy tham gia cùng chúng tôi ngay!
                    </p>
                    <button class="ghost" id="register">
                        Đăng ký
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Captch-->
    <div class="modal fade" id="CaptchaModel" tabindex="-1" aria-labelledby="CaptchaModelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="CaptchaModelLabel"><i class="fa-solid fa-circle-exclamation"></i> Lỗi </h1>
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