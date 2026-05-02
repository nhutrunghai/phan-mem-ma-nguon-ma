@php
    $demoUser = session('demo_user');
@endphp

<div class="main-header">
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="col-md-16 col-sm-16 additional-nav">
                    <div class="pull-right padding-left-10">
                        <a href="#">
                            <img src="{{ asset('beta-mirror/Assets/Common/icons/united-kingdom.png') }}" class="img-responsive" alt="English">
                        </a>
                    </div>

                    @if ($demoUser)
                        <ul class="list-unstyled list-inline pull-right" style="margin-bottom: 4px; margin-top: 4px;">
                            <li>
                                <a href="{{ route('account.demo') }}">
                                    <i class="fa fa-user-circle-o"></i>
                                    {{ $demoUser['name'] }}
                                </a>
                            </li>
                            <li style="border-left: 1px solid; padding-left: 10px !important;">
                                <a href="{{ route('auth.demo.logout') }}">Đăng xuất</a>
                            </li>
                        </ul>
                    @else
                        <ul class="list-unstyled list-inline pull-right" style="margin-bottom: 4px; margin-top: 4px;">
                            <li><a href="{{ route('auth.login.form') }}#login">Đăng nhập</a></li>
                            <li style="border-left: 1px solid; padding-left: 10px !important;"><a href="{{ route('auth.register.form') }}#register">Đăng ký</a></li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="container">
            <div class="row">
                <a class="site-logo" href="{{ url('/') }}">
                    <img style="height: 55px;" src="{{ asset('beta-mirror/Assets/Common/logo/logo.png') }}" alt="Beta Cinemas">
                </a>

                <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

                <div class="top-cart-block">
                    <div class="top-cart-info">
                        <div class="header-navigation font-transform-inherit font-family-san menu-cinema">
                            <ul>
                                <li class="dropdown">
                                    <a class="dropdown-toggle no-padding" data-toggle="dropdown" data-target="#" href="javascript:;">
                                        Beta Thái Nguyên <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#">Hà Nội <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Thanh Xuân</a></li>
                                                <li><a href="#">Beta Mỹ Đình</a></li>
                                                <li><a href="#">Beta Đan Phượng</a></li>
                                                <li><a href="#">Beta Giải Phóng</a></li>
                                                <li><a href="#">Beta Xuân Thủy</a></li>
                                                <li><a href="#">Beta Tây Sơn</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">TP. Hồ Chí Minh <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Quang Trung</a></li>
                                                <li><a href="#">Beta Empire Bình Dương</a></li>
                                                <li><a href="#">Beta Ung Văn Khiêm</a></li>
                                                <li><a href="#">Beta Hồ Tràm</a></li>
                                                <li><a href="#">Beta Tân Uyên</a></li>
                                                <li><a href="#">Beta Trần Quang Khải</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">An Giang <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta TRMall Phú Quốc</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Đồng Nai <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Biên Hòa</a></li>
                                                <li><a href="#">Beta Long Khánh</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Khánh Hòa <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Nha Trang</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Thái Nguyên <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Thái Nguyên</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Thanh Hóa <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Thanh Hóa</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Bắc Ninh <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Bắc Giang</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Lào Cai <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Lào Cai</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Phú Thọ <i class="fa fa-angle-right"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Beta Vĩnh Yên</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="header-navigation pull-right font-transform-inherit">
                    <ul>
                        <li><a href="{{ route('schedule.index') }}">LỊCH CHIẾU THEO RẠP</a></li>
                        <li><a href="{{ route('movies.index') }}">PHIM</a></li>
                        <li><a href="#">RẠP</a></li>
                        <li><a href="#">GIÁ VÉ</a></li>
                        <li><a href="#">TIN MỚI VÀ ƯU ĐÃI</a></li>
                        <li><a href="#">NHƯỢNG QUYỀN</a></li>
                        <li><a href="{{ route('account.demo') }}">THÀNH VIÊN</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
