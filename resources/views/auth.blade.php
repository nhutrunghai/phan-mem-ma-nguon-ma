@php
    $demoUser = session('demo_user');
    $assetPath = static fn (string $path): string => asset('web-home/' . ltrim($path, '/'));
    $defaultTab = ($mode ?? 'login') === 'register' ? 'register' : 'login';
@endphp
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ $assetPath('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .auth-page-shell::before,
        .auth-page-shell::after {
            display: none;
        }
        .auth-page {
            padding: 20px 0 36px;
        }
        .auth-card {
            float: none;
            margin: 0 auto;
        }
        .font-family-san {
            font-family: Montserrat, Inter, "Segoe UI", Arial, sans-serif !important;
        }
        .font-14 {
            font-size: 14px;
        }
        .font-16 {
            font-size: 16px;
        }
        .margin-bottom-10 {
            margin-bottom: 10px;
        }
        .margin-bottom-20 {
            margin-bottom: 20px;
        }
        .margin-top-20 {
            margin-top: 20px;
        }
        .tab-style-1 .nav-tabs {
            border-bottom: 0;
            margin: 0;
        }
        .tab-information > li.active > a,
        .tab-information > li.active > a:hover,
        .tab-information > li.active > a:focus {
            background: #005198 !important;
            color: #fff !important;
        }
        .tab-information > li.active > a:after {
            border: none !important;
        }
        .tab-information > li > a,
        .tab-information > li > a:hover,
        .tab-information > li > a:focus {
            background: transparent;
            border: 0 !important;
            border-radius: 0 !important;
            color: #333;
            font-weight: 700;
            margin-right: 0 !important;
            padding: 14px 12px;
        }
        .auth-card .tab-content {
            background: #fff;
            box-shadow: 0 10px 28px rgba(7, 31, 57, .08);
            padding: 20px 18px 24px;
        }
        .input-icon {
            position: relative;
        }
        .input-icon > .form-control {
            padding-left: 33px;
        }
        .input-icon > i {
            color: #ccc;
            display: block;
            position: absolute;
            margin: 8px 2px 4px 10px;
            z-index: 3;
            width: 16px;
            font-size: 16px;
            text-align: center;
        }
        .btn-mua-ve {
            border: 0;
            padding: 10px 40px;
            position: relative;
            border-radius: 10px !important;
            background-color: #005198;
            color: #fff !important;
            text-decoration: none;
            transition: all .5s ease;
            display: inline-block;
            min-width: 220px;
            text-transform: uppercase;
        }
        .btn-mua-ve:hover,
        .btn-mua-ve:focus {
            text-decoration: none;
            color: #fff !important;
            background-color: #3db1f3;
        }
        .btn-loginfacebook {
            background-color: #f595a6 !important;
        }
        .btn-loginfacebook:hover,
        .btn-loginfacebook:focus {
            background-color: #e67388 !important;
        }
        .auth-card .form-control {
            height: 34px;
            border-radius: 0;
            box-shadow: none;
        }
        .auth-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 9998;
            padding: 24px 16px;
            overflow: auto;
        }
        .auth-modal.is-open {
            display: block;
        }
        .auth-modal-dialog {
            max-width: 540px;
            margin: 40px auto;
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
        }
        .auth-modal-head {
            position: relative;
            padding: 16px 20px;
            border-bottom: 1px solid #e5e5e5;
        }
        .auth-modal-body {
            padding: 20px;
        }
        .auth-modal-close {
            position: absolute;
            right: 16px;
            top: 10px;
            font-size: 28px;
            color: #666;
            background: none;
            border: 0;
            line-height: 1;
        }
        .spinner-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .spinner-container {
            position: relative;
            width: 75px;
            height: 75px;
        }
        .spinner {
            width: 100%;
            height: 100%;
            border: 5px solid #fff;
            border-top-color: #3498db;
            border-radius: 50px !important;
            animation: spin 2s linear infinite;
        }
        .spinner-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @media (max-width: 767px) {
            .auth-card .tab-content {
                padding: 16px 12px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell home-page auth-page-shell">
        <div class="topbar">
            <div class="container topbar-inner">
                <div class="topbar-spacer"></div>
                <div class="topbar-links">
                    @if ($demoUser)
                        <a href="{{ route('account.demo') }}">{{ $demoUser['name'] }}</a>
                        <span>|</span>
                        <a href="{{ route('auth.demo.logout') }}">Đăng xuất</a>
                    @else
                        @foreach ($topLinks as $index => $link)
                            <a href="{{ $link['href'] ?? '#' }}">{{ $link['label'] ?? '' }}</a>
                            @if ($index < count($topLinks) - 1)
                                <span>|</span>
                            @endif
                        @endforeach
                    @endif
                    <span class="flag">GB</span>
                </div>
            </div>
        </div>

        <header class="header">
            <div class="container header-inner">
                <a class="brand" href="{{ url('/') }}">
                    <img class="brand-img" src="{{ $assetPath('assets/img/beta-logo.png') }}" alt="Beta Cinemas">
                </a>

                <button class="location-pill" type="button">
                    Beta Thái Nguyên <span class="caret">▾</span>
                </button>

                <nav class="nav">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main class="auth-page">
            <div class="container">
                <div id="BodyContent_ctl00_ctl02_divLogin" class="col-lg-8 col-md-8 col-sm-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-2 tab-style-1 margin-bottom-20 margin-top-20 auth-card">
                    <ul class="nav nav-tabs text-uppercase tab-information">
                        <li class="{{ $defaultTab === 'login' ? 'active' : '' }} text-center" style="width: 50%">
                            <a class="font-16" href="#login" data-toggle="tab">Đăng nhập</a>
                        </li>
                        <li class="{{ $defaultTab === 'register' ? 'active' : '' }} text-center" style="width: 50%">
                            <a class="font-16" href="#register" data-toggle="tab">Đăng ký</a>
                        </li>
                    </ul>

                    <div class="tab-content font-family-san font-14">
                        <div class="tab-pane fade {{ $defaultTab === 'login' ? 'in active' : '' }}" id="login">
                            <form id="loginForm" action="{{ route('auth.demo.login') }}" method="get">
                                <div class="form-group">
                                    <div id="error-status" class="col-md-16 margin-bottom-10"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 margin-bottom-10">
                                        <label class="control-label font-14">Email</label>
                                        <div class="input-icon">
                                            <i class="fa fa-user"></i>
                                            <input type="text" id="txtLoginName" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 margin-bottom-20">
                                        <label class="control-label font-14">Mật khẩu</label>
                                        <div class="input-icon">
                                            <i class="fa fa-lock"></i>
                                            <input type="password" id="txtLoginPassword" class="form-control" placeholder="Mật khẩu">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 margin-bottom-20">
                                        <a href="#" data-open-modal="forgot-password">Quên mật khẩu?</a>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 text-center">
                                        <div class="form-group">
                                            <button type="button" id="btnLogin" class="btn-mua-ve">Đăng nhập bằng tài khoản</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn-loginfacebook btn-mua-ve" disabled>Đăng nhập bằng Facebook</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>

                        <div class="tab-pane fade {{ $defaultTab === 'register' ? 'in active' : '' }}" id="register">
                            <form id="registerForm" action="{{ route('auth.demo.register') }}" method="get">
                                <div class="form-group">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Họ tên</label>
                                        <input type="text" style="height: 30px;" id="txtName" name="name" class="form-control" placeholder="Họ tên">
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Email</label>
                                        <div class="input-icon">
                                            <i class="fa fa-envelope"></i>
                                            <input type="text" style="height: 30px;" id="txtEmail" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Mật khẩu</label>
                                        <div class="input-icon">
                                            <i class="fa fa-lock"></i>
                                            <input type="password" style="height: 30px;" id="txtMatKhau" class="form-control" placeholder="Mật khẩu">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Xác nhận lại mật khẩu</label>
                                        <div class="input-icon">
                                            <i class="fa fa-lock"></i>
                                            <input type="password" style="height: 30px;" id="txtXacNhanMatKhau" class="form-control" placeholder="Xác nhận lại mật khẩu">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Ngày sinh</label>
                                        <div class="input-icon">
                                            <i class="fa fa-calendar"></i>
                                            <input id="txtNgaySinh" style="height: 30px;" class="form-control" placeholder="Ngày sinh">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14">Giới tính</label>
                                        <div class="input-icon">
                                            <i class="fa fa-male"></i>
                                            <select id="cboSex" style="height: 30px;" class="form-control">
                                                <option value="">Giới tính</option>
                                                <option value="male">Nam</option>
                                                <option value="female">Nữ</option>
                                                <option value="other">Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                                        <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Số điện thoại</label>
                                        <div class="input-icon">
                                            <i class="fa fa-phone"></i>
                                            <input type="text" style="height: 30px;" id="txtDienThoai" class="form-control" placeholder="Số điện thoại">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16">
                                        <div class="form-group">
                                            <input type="checkbox" id="chk" value="1">
                                            <span>
                                                Tôi cam kết tuân theo
                                                <a href="#" data-open-modal="privacy-policy">chính sách bảo mật</a>
                                                và
                                                <a href="#" data-open-modal="terms-of-use">điều khoản sử dụng</a>
                                                của BetaCinemas.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 text-center">
                                        <div class="form-group">
                                            <button type="button" id="btnRegister" class="btn btn-mua-ve">Đăng ký</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-16 text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-loginfacebook btn-mua-ve" disabled>Tiếp tục với Facebook</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container footer-inner">
                <div class="footer-brand">
                    <div class="brand brand-footer">
                        <div class="brand-mark">beta</div>
                        <div class="brand-text">cinemas</div>
                    </div>
                    <ul>
                        @foreach (($footer['links'] ?? []) as $link)
                            <li><a href="#">{{ $link['label'] ?? '' }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>{{ $footer['cinemasTitle'] ?? 'CỤM RẠP BETA' }}</h4>
                    <ul>
                        @foreach (($footer['cinemas'] ?? []) as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>{{ $footer['contactTitle'] ?? 'LIÊN HỆ' }}</h4>
                    <p><strong>{{ $footer['companyName'] ?? '' }}</strong></p>
                    <p>{{ $footer['companyInfo'] ?? '' }}</p>
                    <p>{{ $footer['address'] ?? '' }}</p>
                    <p><strong>{{ $footer['supportLabel'] ?? '' }}</strong></p>
                    <p>{{ $footer['hotline'] ?? '' }}</p>
                    <p>{{ $footer['email'] ?? '' }}</p>
                </div>
            </div>
        </footer>
    </div>

    <div class="auth-modal" id="forgot-password-modal" aria-hidden="true">
        <div class="auth-modal-dialog">
            <div class="auth-modal-head">
                <h3 class="no-padding no-margin">Lấy lại mật khẩu</h3>
                <button type="button" class="auth-modal-close" data-close-modal>&times;</button>
            </div>
            <div class="auth-modal-body font-family-san font-14">
                <div class="form-group">
                    <div class="col-md-16 margin-bottom-10">
                        <label class="control-label font-14">Email</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input type="text" id="txtChangePassEmail" class="form-control" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <div class="col-md-16 text-center">
                        <div class="form-group">
                            <button type="button" id="btnForgotPass" class="btn-mua-ve">Lấy lại mật khẩu</button>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="auth-modal" id="terms-modal" aria-hidden="true">
        <div class="auth-modal-dialog">
            <div class="auth-modal-head">
                <h3 class="no-padding no-margin">Điều khoản sử dụng</h3>
                <button type="button" class="auth-modal-close" data-close-modal>&times;</button>
            </div>
            <div class="auth-modal-body font-family-san font-14">
                <p>Popup điều khoản sẽ được nối nội dung đầy đủ ở bước tiếp theo nếu bạn cần.</p>
            </div>
        </div>
    </div>

    <div class="auth-modal" id="privacy-modal" aria-hidden="true">
        <div class="auth-modal-dialog">
            <div class="auth-modal-head">
                <h3 class="no-padding no-margin">Chính sách bảo mật</h3>
                <button type="button" class="auth-modal-close" data-close-modal>&times;</button>
            </div>
            <div class="auth-modal-body font-family-san font-14">
                <p>Popup chính sách bảo mật sẽ được nối nội dung đầy đủ ở bước tiếp theo nếu bạn cần.</p>
            </div>
        </div>
    </div>

    <div class="spinner-overlay" id="spinnerOverlay">
        <div class="spinner-container">
            <div class="spinner"></div>
            <div class="spinner-text">Loading</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
    <script>
        (() => {
            const overlay = document.getElementById('spinnerOverlay');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const errorStatus = document.getElementById('error-status');

            const showOverlay = () => {
                overlay.style.display = 'flex';
            };

            const hideOverlay = () => {
                overlay.style.display = 'none';
            };

            const showError = (message) => {
                errorStatus.innerHTML = message ? "<label style='color:red'>" + message + "</label>" : "";
            };

            const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

            const openModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = (modal) => {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            };

            const login = () => {
                const email = document.getElementById('txtLoginName');
                const password = document.getElementById('txtLoginPassword');

                showError('');

                if (!email.value.trim()) {
                    showError('Vui lòng nhập email!');
                    email.focus();
                    return;
                }

                if (!validateEmail(email.value.trim())) {
                    showError('Email nhập chưa đúng định dạng!');
                    email.focus();
                    return;
                }

                if (!password.value.trim()) {
                    showError('Vui lòng nhập mật khẩu!');
                    password.focus();
                    return;
                }

                showOverlay();
                loginForm.submit();
            };

            const register = () => {
                const name = document.getElementById('txtName');
                const email = document.getElementById('txtEmail');
                const password = document.getElementById('txtMatKhau');
                const confirmPassword = document.getElementById('txtXacNhanMatKhau');
                const birthday = document.getElementById('txtNgaySinh');
                const phone = document.getElementById('txtDienThoai');
                const terms = document.getElementById('chk');

                if (!name.value.trim()) {
                    alert('Vui lòng nhập họ tên!');
                    name.focus();
                    return;
                }

                if (!email.value.trim()) {
                    alert('Vui lòng nhập email!');
                    email.focus();
                    return;
                }

                if (!validateEmail(email.value.trim())) {
                    alert('Email nhập chưa đúng định dạng!');
                    email.focus();
                    return;
                }

                if (!password.value.trim()) {
                    alert('Vui lòng nhập mật khẩu!');
                    password.focus();
                    return;
                }

                if (!confirmPassword.value.trim()) {
                    alert('Vui lòng xác nhận lại mật khẩu!');
                    confirmPassword.focus();
                    return;
                }

                if (password.value !== confirmPassword.value) {
                    alert('Mật khẩu xác nhận lại chưa chính xác!');
                    confirmPassword.focus();
                    return;
                }

                if (!birthday.value.trim()) {
                    alert('Vui lòng nhập ngày sinh!');
                    birthday.focus();
                    return;
                }

                if (!phone.value.trim()) {
                    alert('Vui lòng nhập số điện thoại!');
                    phone.focus();
                    return;
                }

                if (!terms.checked) {
                    alert('Bạn cần đồng ý với chính sách và điều khoản trước khi đăng ký!');
                    terms.focus();
                    return;
                }

                showOverlay();
                registerForm.submit();
            };

            const forgotPassword = () => {
                const email = document.getElementById('txtChangePassEmail');

                if (!email.value.trim()) {
                    alert('Vui lòng nhập email!');
                    email.focus();
                    return;
                }

                if (!validateEmail(email.value.trim())) {
                    alert('Email nhập chưa đúng định dạng!');
                    email.focus();
                    return;
                }

                alert('Luồng quên mật khẩu backend chưa được nối. Giao diện đã bỏ captcha và giữ sẵn để nối PHP thật ở bước sau.');
            };

            $(function () {
                const hash = window.location.hash;
                if (hash === '#register') {
                    $('.nav-tabs a[href="#register"]').tab('show');
                } else {
                    $('.nav-tabs a[href="#login"]').tab('show');
                }
            });

            document.getElementById('btnLogin').addEventListener('click', login);
            document.getElementById('btnRegister').addEventListener('click', register);
            document.getElementById('btnForgotPass').addEventListener('click', forgotPassword);

            document.getElementById('txtLoginPassword').addEventListener('keyup', (event) => {
                if (event.key === 'Enter') {
                    login();
                }
            });

            document.querySelectorAll('[data-open-modal]').forEach((trigger) => {
                trigger.addEventListener('click', (event) => {
                    event.preventDefault();
                    const type = trigger.getAttribute('data-open-modal');
                    if (type === 'forgot-password') openModal('forgot-password-modal');
                    if (type === 'terms-of-use') openModal('terms-modal');
                    if (type === 'privacy-policy') openModal('privacy-modal');
                });
            });

            document.querySelectorAll('[data-close-modal]').forEach((button) => {
                button.addEventListener('click', () => {
                    closeModal(button.closest('.auth-modal'));
                });
            });

            document.querySelectorAll('.auth-modal').forEach((modal) => {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                });
            });

            window.addEventListener('pageshow', hideOverlay);
        })();
    </script>
</body>
</html>
