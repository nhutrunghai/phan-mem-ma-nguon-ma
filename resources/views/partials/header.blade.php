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
