@php
    $demoUser = session('demo_user');
@endphp

@if (is_array($demoUser) && !empty($demoUser['name']))
    <ul class="list-unstyled list-inline pull-right tracker-user-menu" style="margin-bottom: 4px;margin-top: 4px;">
        <li class="tracker-user-menu__greeting">
            <a href="{{ route('account.demo', [], false) }}">Xin chào: {{ $demoUser['name'] }} <i class="fa fa-angle-down"></i></a>
        </li>
        <li class="tracker-user-menu__logout" style="border-left: 1px solid; padding-left: 10px !important;">
            <a href="{{ route('auth.demo.logout', [], false) }}" aria-label="Đăng xuất"><i class="fa fa-sign-out"></i></a>
        </li>
    </ul>
@else
    <ul class="list-unstyled list-inline pull-right tracker-user-menu" style="margin-bottom: 4px;margin-top: 4px;">
        <li class="tracker-user-menu__login"><a href="{{ route('auth.login.form', [], false) }}#login">Đăng nhập</a></li>
        <li class="tracker-user-menu__register" style="border-left: 1px solid; padding-left: 10px !important;">
            <a href="{{ route('auth.register.form', [], false) }}#register">Đăng ký</a>
        </li>
    </ul>
@endif
