@php
    $demoUser = session('demo_user');
    $defaultTab = ($mode ?? 'login') === 'register' ? 'register' : 'login';
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from betacinemas.vn/login.htm by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Apr 2026 07:51:08 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head><title>
	Trang đăng nhập/Đăng kí
</title><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><meta name="apple-itunes-app" content="app-id=1403107666" /><meta name="google-play-app" content="app-id=com.beta.betacineplex" /><meta name="viewport" content="width=device-width, initial-scale=1" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Bootstrap/css/bootstrap.min.css') }}" /><link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Bootstrap/css/bootstrap-theme.min.css') }}" /><link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/font-awesome/css/font-awesome.min.css') }}" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/css/components0e34.css?v=33') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/fancybox/source/jquery.fancybox1bce.css?v=6') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.css') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/slider-layer-slider/css/layerslider.css') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /><link href="{{ asset('web-home/assets/legacy-beta/assets/frontend/pages/css/style-layer-slider.css') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/DownloadPlugin/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/Assets/Common/css/style0e34.css?v=33') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/Assets/Common/css/css9bf4.css?v=31') }}" rel="stylesheet" /><link rel="stylesheet" type="text/css" href="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/select2/select2.css') }}" /><link href="{{ asset('web-home/assets/legacy-beta/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" /><link href="{{ asset('web-home/assets/legacy-beta/assets/frontend/pages/css/style-shop9bf4.css?v=31') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/assets/frontend/layout/css/themes/blue9bf4.css?v=31') }}" rel="stylesheet" /><link href="{{ asset('web-home/assets/legacy-beta/assets/frontend/layout/css/custom71de.css?v=34') }}" rel="stylesheet" /><link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/assets/Specific/smart-app-banner/smart-app-banner.css') }}" type="text/css" media="screen" /><link rel="android-touch-icon" sizes="57x57" href="apple-icon-57x57.html" /><link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.html" /><link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.html" /><link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.html" /><link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.html" /><link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.html" /><link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.html" /><link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.html" /><link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.html" /><link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.html" /><link rel="icon" type="image/png" sizes="192x192" href="android-icon-192x192.html" /><link rel="icon" type="image/png" sizes="32x32" href="{{ asset('web-home/assets/legacy-beta/favicon-32x32.png') }}" /><link rel="icon" type="image/png" sizes="96x96" href="{{ asset('web-home/assets/legacy-beta/favicon-32x32.png') }}" /><link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web-home/assets/legacy-beta/favicon-16x16.png') }}" /><link rel="manifest" href="manifest.html" /><meta name="msapplication-TileColor" content="#ffffff" /><meta name="msapplication-TileImage" content="ms-icon-144x144.html" /><meta name="theme-color" content="#ffffff" />



    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/JQuery/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/DownloadPlugin/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/DownloadPlugin/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.vi.min.js') }}"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/Assets/global/plugins/fancybox/source/jquery.fancybox1bce.js?v=6') }}" type="text/javascript"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <!-- pop up -->
    <!-- Start mandatories scripts -->
    <script type="text/javascript" defer="defer" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Modernizr/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    <!-- End mandatories scripts -->
    <script src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
    <!-- slider for products -->
    <script src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/image-scale/image-scale.js') }}" type="text/javascript"></script>
    <!-- BEGIN LayerSlider -->
    <script src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/slider-layer-slider/js/greensock.js') }}" type="text/javascript"></script>
    <!-- External libraries: GreenSock -->
    <script src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js') }}" type="text/javascript"></script>
    <!-- LayerSlider script files -->
    <script src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js') }}" type="text/javascript"></script>
    <!-- LayerSlider script files -->
    <script src="{{ asset('web-home/assets/legacy-beta/assets/frontend/pages/scripts/layerslider-init.js') }}" type="text/javascript"></script>
    <!-- END LayerSlider -->
    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/assets/global/plugins/jquery-mixitup/jquery.mixitup.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/assets/frontend/pages/scripts/portfolio.js') }}" type="text/javascript"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/assets/frontend/layout/scripts/back-to-top.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/scripts/layout.js') }}"></script>




    <!-- Google tag (gtag.js) -->
    <script type="text/javascript" async src="https://www.googletagmanager.com/gtag/js?id=G-GEWKW597G3"></script>
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-GEWKW597G3', { send_page_view: false });
    </script>

    <!-- Facebook Pixel Code -->

    <!-- End Facebook Pixel Code -->
    <!-- Google Tag Manager -->
    <script type="text/javascript">(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    '../www.googletagmanager.com/gtm5445.html?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PZ45WZ5');</script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager -->
    <script type="text/javascript">(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    '../www.googletagmanager.com/gtm5445.html?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-K5K46MZT');</script>
    <!-- End Google Tag Manager -->


    <style type="text/css">
        .fb_customer_chat_bubble_animated_no_badge {
            box-shadow: none !important;
        }

            .fb_customer_chat_bubble_animated_no_badge:hover {
                box-shadow: none !important;
            }
    </style>
</head>
<body class="corporate">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZ45WZ5"
            height="0" width="0" style="display: none; visibility: hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K5K46MZT"
            height="0" width="0" style="display: none; visibility: hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="fb-root"></div>
    <script>
        // Load the SDK asynchronously
        window.fbAsyncInit = function () {
            FB.init({
                appId: '367174740769877',
                xfbml: true,
                version: 'v17.0'
            });
            FB.AppEvents.logPageView();
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) { return; }
            js = d.createElement(s); js.id = id;
            js.src = "../connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- Chat box facebook -->
    <div class="fb-customerchat"
        attribution="setup_tool"
        page_id="372534489582129"
        logged_in_greeting="Xin chào tín đồ điện ảnh, Beta có thể giúp gì cho bạn? 😍"
        logged_out_greeting="Xin chào tín đồ điện ảnh, Beta có thể giúp gì cho bạn? 😍">
    </div>
    <!-- End Chat box facebook -->


<div>

    <div class="desktop-panel" id="desktop-panel">
        <div>
            <div>
                <!--//--- Top Panel ---//-->
                <div id="BodyContent_ctl00_topPanel" class="ecm-panel"><script>
    $(function () {
        Layout.initFixHeaderWithPreHeader(); /* Switch On Header Fixing (only if you have pre-header) */
        //jQuery(".fancybox-choosecinema").fancybox({
        //    afterLoad: function () {
        //        alert("OK");
        //    }
        //});
        $('#cboTinhThanh').select2({
            allowClear: true
        });
        $("#cboTinhThanh").change(function () {

            var cityId = $("#cboTinhThanh").select2('data').id;
            var cityName = $("#cboTinhThanh").select2('data').text;

            var aData = [];
            aData[0] = cityId;
            aData[1] = cityName;

            var jsonData = JSON.stringify({ aData: aData });
            $.ajax({
                type: "POST",
                url: "../Ajax.aspx/ChooseCinemaByCity",
                data: jsonData,
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    $('#cboRap').html(data.d);
                    $("#cboRap").select2({
                        allowClear: true
                    });
                },
                error: function () {
                    alert("Error loading data! Please try again.");
                }
            })//done handler
                .done(function (msg) {
                });

        });
        $("#cboRap").change(function () {

            var cinemaId = $("#cboRap").select2('data').id;
            var cinemaName = $("#cboRap").select2('data').text;

            if (cinemaId !== "0") {
                var aData = [];
                aData[0] = cinemaId;
                aData[1] = cinemaName;

                var jsonData = JSON.stringify({ aData: aData });
                $.ajax({
                    type: "POST",
                    url: "../Ajax.aspx/ChooseCinema",
                    data: jsonData,
                    dataType: "json",
                    contentType: "application/json; charset=utf-8",
                    success: function (data) {
                        RedirectUrl(window.location.href);
                        //window.location.href = window.location.href;
                    },
                    error: function () {
                        alert("Error loading data! Please try again.");
                    }
                })//done handler
                    .done(function (msg) {
                    });
            }
        });

        localStorage["lang"] = $('#hfLanguage').val();
    });
    function ChooseCinema(cinemaId, cinemaName) {

        gtag('event', 'select_theater', {
            'cinema_id': cinemaId,
            'cinema_name': cinemaName
        });

        var aData = [];
        aData[0] = cinemaId;
        aData[1] = cinemaName;

        var jsonData = JSON.stringify({ aData: aData });
        $.ajax({
            type: "POST",
            url: "../Ajax.aspx/ChooseCinema",
            data: jsonData,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                //$('#tab-content').html(data.d);
                window.location.href = window.location.href;
            },
            error: function () {
                alert("Error loading data! Please try again.");
            }
        })//done handler
            .done(function (msg) {
            });
    };
    function RedirectUrl(url) {
        if (url !== "") {
            window.location.href = url;
            location.reload();
        }
    };
    function RedirectUrl2(url) {
        if (url !== "") {
            window.location.href = url;
        }
    };
    function logout() {
        var aData = [];
        var jsonData = JSON.stringify({ aData: aData });
        $.ajax({
            type: "POST",
            url: "../Ajax.aspx/Logout",
            data: jsonData,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                RedirectUrl(window.location.href);
            },
            error: function () {
                alert("Error loading data! Please try again.");
            }
        })//done handler
            .done(function (msg) {
            });
    }
    function changelang(lang) {
        var aData = [];
        aData[0] = lang;
        var jsonData = JSON.stringify({ aData: aData });
        $.ajax({
            type: "POST",
            url: "../Ajax.aspx/ChangeLanguage",
            data: jsonData,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                RedirectUrl(window.location.href);
            },
            error: function () {
                alert("Error loading data! Please try again.");
            }
        })//done handler
            .done(function (msg) {
                localStorage["lang"] = lang;
            });
    }

    $(document).ready(function () {
        // Lặp qua tất cả các thẻ li trong div
        $('div.header-navigation ul li a').each(function () {
            // Kiểm tra nếu href của thẻ a trùng với URL hiện tại của trang
            if (window.location.pathname === $(this).attr('href')) {
                // Thêm class "active" vào thẻ li chứa thẻ a
                $(this).parent('li').addClass('active');
            }
        });
    });
</script>
<input type="hidden" id="hfLanguage" value="vie"/>
<div class="main-header">
    <!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-16 col-sm-16 additional-nav">
                <div class="pull-right padding-left-10">

                    <a id="BodyContent_ctl00_ctl03_hlEn" onclick="changelang(&#39;eng&#39;);"><img src="{{ asset('web-home/assets/legacy-beta/Assets/Common/icons/united-kingdom.png') }}" class="img-responsive"/></a>
                </div>
                @if ($demoUser)
                <ul class="list-unstyled list-inline pull-right" style="margin-bottom: 4px;margin-top: 4px;">
                    <li><a href="{{ route('account.show') }}">Xin chào: {{ $demoUser['name'] ?? 'Beta Member' }}</a></li>
                    <li style="border-left: 1px solid; padding-left: 10px !important;"><a href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                </ul>
                @else
                <ul class="list-unstyled list-inline pull-right" style="margin-bottom: 4px;margin-top: 4px;">
                    <li id="BodyContent_ctl00_ctl03_liLogin"><a href="{{ route('auth.login.form') }}#login">Đăng nhập</a></li>
                    <li id="BodyContent_ctl00_ctl03_liRegister" style="border-left: 1px solid; padding-left: 10px !important;"><a href="{{ route('auth.register.form') }}#register">Đăng ký</a></li>
                </ul>
                @endif
                <!-- BEGIN TOP NAVIGATION MENU -->

                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->
<!-- BEGIN HEADER -->
<div class="header">
    <div class="container">
        <div class="row">
        <a class="site-logo" href="{{ url('/') }}"><img alt="" style="height: 55px;" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/logo/logo.png') }}" alt="Beta Cinemas"/></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
        <div class="top-cart-block">
            <div class="top-cart-info">
                <!-- BEGIN NAVIGATION -->
                <div class="header-navigation font-transform-inherit font-family-san menu-cinema">
                    <ul>
                        <li class="dropdown">
                            <a class="dropdown-toggle no-padding" data-toggle="dropdown" data-target="#" href="javascript:;">Beta Thái Nguyên <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">

                                    <li class='dropdown-submenu'>
                                        <a>Hà Nội <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('1f0b7d55-9dd6-4c46-bd4d-3b50024d14ec', 'Beta Thanh Xuân');">Beta Thanh Xuân</a></li>

                                                    <li><a onclick="ChooseCinema('86fa4c35-8d26-4f60-9cf2-fbaaba0ee25d', 'Beta Mỹ Đình');">Beta Mỹ Đình</a></li>

                                                    <li><a onclick="ChooseCinema('8bdac2c9-2cc7-464b-8cff-4bc41403b74f', 'Beta Đan Phượng');">Beta Đan Phượng</a></li>

                                                    <li><a onclick="ChooseCinema('94d6c0ca-125b-43d0-8f65-9f0880b90beb', 'Beta Giải Phóng');">Beta Giải Phóng</a></li>

                                                    <li><a onclick="ChooseCinema('ea1c1507-9560-49ff-b5e7-3fc94d5dd409', 'Beta Xuân Thủy');">Beta Xuân Thủy</a></li>

                                                    <li><a onclick="ChooseCinema('381f745f-c110-4d0c-9117-3a79f36ba9c4', 'Beta Tây Sơn');">Beta Tây Sơn</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>TP. Hồ Chí Minh <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('0fdbe392-734d-402b-9399-d22bd37b6cee', 'Beta Quang Trung');">Beta Quang Trung</a></li>

                                                    <li><a onclick="ChooseCinema('a4ed71b7-2af3-46d4-acff-b7778fb2c91d', 'Beta Empire Bình Dương');">Beta Empire Bình Dương</a></li>

                                                    <li><a onclick="ChooseCinema('98b7a985-235f-4488-a795-4a9b9577a70a', 'Beta Ung Văn Khiêm');">Beta Ung Văn Khiêm</a></li>

                                                    <li><a onclick="ChooseCinema('3aa17be3-387c-4271-a313-2e5bb069b509', 'Beta Hồ Tràm');">Beta Hồ Tràm</a></li>

                                                    <li><a onclick="ChooseCinema('65966bb8-ec4a-4ef6-bd0d-429deb2b563e', 'Beta Tân Uyên');">Beta Tân Uyên</a></li>

                                                    <li><a onclick="ChooseCinema('8f2c1f5f-d274-4081-9c87-441e13dab3ee', 'Beta Trần Quang Khải');">Beta Trần Quang Khải</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>An Giang <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('6e476e92-a262-4792-8120-daeb4433c025', 'Beta TRMall Phú Quốc');">Beta TRMall Phú Quốc</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Đồng Nai <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('6af5c313-0e3e-4e72-86d6-2e4ed45e7e35', 'Beta Biên Hòa');">Beta Biên Hòa</a></li>

                                                    <li><a onclick="ChooseCinema('d1678477-49ce-4417-bc39-a080cad0e9e8', 'Beta Long Khánh');">Beta Long Khánh</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Khánh Hòa <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('b0e45ea2-443f-404f-9412-b97a6001f157', 'Beta Nha Trang');">Beta Nha Trang</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Thái Nguyên <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('dfd9306f-fbc8-4807-a8c6-5e6c3f7ad71c', 'Beta Thái Nguyên');">Beta Thái Nguyên</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Thanh Hóa <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('7d4980ac-eb8f-4bcb-97eb-77cbcd75dba2', 'Beta Thanh Hóa');">Beta Thanh Hóa</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Bắc Ninh <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('ed75f9eb-4f2c-4448-aef8-7804178df564', 'Beta Bắc Giang');">Beta Bắc Giang</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Lào Cai <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('dac58b9b-f8f7-4f75-8586-2b43fb8824c0', 'Beta Lào Cai');">Beta Lào Cai</a></li>

                                            </ul>

                                    </li>

                                    <li class='dropdown-submenu'>
                                        <a>Phú Thọ <i class='fa fa-angle-right'></i></a>

                                            <ul class="dropdown-menu" role="menu">

                                                    <li><a onclick="ChooseCinema('6bffc6ab-b2ac-408c-a92e-b7b3a0832075', 'Beta Vĩnh Yên');">Beta Vĩnh Yên</a></li>

                                            </ul>

                                    </li>

                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- END NAVIGATION -->
            </div>
        </div>
        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">
            <ul>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_0">
                            <a href="{{ route('schedule.index') }}">LỊCH CHIẾU THEO RẠP</a>
                        </li>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_1">
                            <a href="{{ route('movies.index') }}">PHIM</a>
                        </li>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_2">
                            <a href="{{ route('cinemas.info') }}">RẠP</a>
                        </li>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_3">
                            <a href="{{ route('prices.index') }}">GIÁ VÉ</a>
                        </li>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_4">
                            <a href="{{ route('promotions.index') }}">TIN MỚI VÀ ƯU ĐÃI</a>
                        </li>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_5">
                            <a href="{{ route('franchise.index') }}">NHƯỢNG QUYỀN</a>
                        </li>


                        <li id="BodyContent_ctl00_ctl03_rptMenu2_liNoChild_6">
                            <a href="login-2.html#thongtintaikhoan">THÀNH VIÊN</a>
                        </li>


                <!-- BEGIN TOP SEARCH -->

                <!-- END TOP SEARCH -->
            </ul>
        </div>
        <!-- END NAVIGATION -->
        </div>
    </div>
</div>
<!-- Header END -->
</div>
</div>
            </div>
            <div class="margin-none">
                <!--//--- Time Panel ---//-->
                <div id="BodyContent_ctl00_sliderPanel" class="ecm-panel sliderpanel"></div>
                <div id="BodyContent_ctl00_mainPanel" class="ecm-panel" style="position: relative;">
<script>
    $(document).ready(function () {

        gtag('event', 'auth_begin');

        $(function () {
            jQuery(".fancybox-fast-view").fancybox();
        });
        $('.datepicker').datepicker();
        $('#cboCity').select2({
            allowClear: true
        });
        $("#cboCity").change(function () {

            var cityId = $("#cboCity").select2('data').id;
            var cityName = $("#cboCity").select2('data').text;

            var aData = [];
            aData[0] = cityId;
            aData[1] = cityName;

            var jsonData = JSON.stringify({ aData: aData });
            $.ajax({
                type: "POST",
                url: "Ajax.aspx/LoadDistrictByCity",
                data: jsonData,
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    $('#cboDistrict').html(data.d);
                    $("#cboDistrict").select2({
                        allowClear: true
                    });
                },
                error: function () {
                    alert("Error loading data! Please try again.");
                }
            })//done handler
                .done(function (msg) {
                });

        });
        var hash = window.location.hash.substr(1);
        activaTab(hash);

        //Add Enter
        var input = document.getElementById("txtLoginCaptcha");
        input.addEventListener("keyup", function (event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                document.getElementById("btnLogin").click();
            }
        });
    });
    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        var htmlBody = $("html,body"),
            top = 0;

        if (htmlBody.is(':animated')) {
            htmlBody.stop(true, true);  //Need to stop if it is already being animated
        }

        htmlBody.animate({ scrollTop: top }, 1000); //Scroll to the top of the page by animating for 1 sec.
    };
    $.urlParam = function (name) {
        var results = new RegExp('[\?]' + name + '=([^#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        }
        else {
            return decodeURI(results[1]) || 0;
        }
    }
    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return true;
        }
        //alert("You have entered an invalid email address!");
        return false;
    }
    function login() {
        var overlay = document.getElementById('spinnerOverlay');
        overlay.style.display = "flex"; // Show the overlay with the spinner

        var refererUrl = $.urlParam('referer');
        var email = document.getElementById('txtLoginName').value;
        var password = document.getElementById('txtLoginPassword').value;
        var captcha = document.getElementById('txtLoginCaptcha').value;
        if (email === null || email.trim() === "") {
            overlay.style.display = "none";
            alert('Vui lòng nhập email!');
            document.getElementById('txtLoginName').focus();
            return false;
        }

        if (!ValidateEmail(email)) {
            overlay.style.display = "none";
            alert('Email nhập chưa đúng định dạng!');
            document.getElementById('txtLoginName').focus();
            return false;
        }

        if (password === null || password.trim() === "") {
            overlay.style.display = "none";
            alert('Vui lòng nhập mật khẩu!');
            document.getElementById('txtLoginPassword').focus();
            return false;
        }

        if (captcha === null || captcha.trim() === "") {
            overlay.style.display = "none";
            alert('Vui lòng nhập mã xác thực!');
            document.getElementById('txtLoginCaptcha').focus();
            return false;
        }

        var aData = [];
        aData[0] = email;
        aData[1] = password;
        aData[2] = captcha;

        var jsonData = JSON.stringify({ aData: aData });
        $.ajax({
            type: "POST",
            url: "Ajax.aspx/Login",
            data: jsonData,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                if (data.d[0] === "1") {
                    //alert('Đăng nhập thành công!');

                    gtag('set', 'user_properties', {
                        'user_id': data.d.split("_")[1]
                    });

                    gtag('event', 'sign_in_complete', {
                        'method': 'email'
                    });

                    if (refererUrl !== null && refererUrl !== "") {
                        window.location.href = 'https://betacinemas.vn' + refererUrl;
                    } else {
                        window.location.href = "{{ url('/') }}";
                    }
                } else {
                    overlay.style.display = "none";
                    showError(data.d);
                    //alert(data.d);
                    changeImage('captchalogin', 'CreateCapchaLogin.aspx');
                }
            },
            error: function () {
                overlay.style.display = "none";
                alert("Error loading data! Please try again.");
                changeImage('captchalogin', 'CreateCapchaLogin.aspx');
            }
        }).done(function (msg) {
        });
    }
    function forgotpass() {
        var email = document.getElementById('txtChangePassEmail').value;
        var captcha = document.getElementById('txtChangePassCaptcha').value;
        if (email === null || email.trim() === "") {
            alert('Vui lòng nhập email!');
            document.getElementById('txtChangePassEmail').focus();
            return false;
        }

        if (!ValidateEmail(email)) {
            alert('Email nhập chưa đúng định dạng!');
            document.getElementById('txtChangePassEmail').focus();
            return false;
        }

        if (captcha === null || captcha.trim() === "") {
            alert('Vui lòng nhập mã xác thực!');
            document.getElementById('txtChangePassCaptcha').focus();
            return false;
        }

        var aData = [];
        aData[0] = email;
        aData[1] = captcha;

        var jsonData = JSON.stringify({ aData: aData });
        $.ajax({
            type: "POST",
            url: "Ajax.aspx/ForgotPassword",
            data: jsonData,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                if (data.d === "1") {
                    alert('Mật khẩu mới đã được gửi vào mail của bạn!');
                    window.location.href = "{{ route('auth.login.form') }}#login";
                    //changeImage('captchachangepass', 'CreateCapchaChangePass.aspx');
                } else {
                    alert(data.d);
                    changeImage('captchachangepass', 'CreateCapchaChangePass.aspx');
                }
            },
            error: function () {
                alert("Error loading data! Please try again.");
                changeImage('captchachangepass', 'CreateCapchaChangePass.aspx');
            }
        }).done(function (msg) {
        });
    }
    function dangKy() {
        //var ho = document.getElementById('txtHo').value;
        var name = document.getElementById('txtName').value;
        var email = document.getElementById('txtEmail').value;
        var password = document.getElementById('txtMatKhau').value;
        var confirmpassword = document.getElementById('txtXacNhanMatKhau').value;
        var phone = document.getElementById('txtDienThoai').value;
        //var passport = document.getElementById('txtCMND').value;
        var birthday = document.getElementById('txtNgaySinh').value;
        var sex = $("#cboSex").val();
        //var cityId = $("#cboCity").select2('data').id;
        //var districtId = $("#cboDistrict").select2('data').id;
        //var address = document.getElementById('txtDiaChi').value;
        var captcha = document.getElementById('txtMaXacThuc').value;
        //var checkThe = $('#chkThe:checked').val();



        if (name === null || name.trim() === "") {
            alert('Vui lòng nhập họ tên!');
            document.getElementById('txtName').focus();
            return false;
        }

        if (email === null || email.trim() === "") {
            alert('Vui lòng nhập email!');
            document.getElementById('txtEmail').focus();
            return false;
        }

        if (!ValidateEmail(email)) {
            alert('Email nhập chưa đúng định dạng!');
            document.getElementById('txtEmail').focus();
            return false;
        }

        if (password === null || password.trim() === "") {
            alert('Vui lòng nhập mật khẩu!');
            document.getElementById('txtMatKhau').focus();
            return false;
        }

        if (confirmpassword === null || confirmpassword.trim() === "") {
            alert('Vui lòng xác nhận lại mật khẩu!');
            document.getElementById('txtXacNhanMatKhau').focus();
            return false;
        }

        if (password !== confirmpassword) {
            alert('Mật khẩu xác nhận lại chưa chính xác!');
            document.getElementById('txtXacNhanMatKhau').focus();
            return false;
        }



        if (birthday === null || birthday.trim() === "") {
            alert('Vui lòng nhập ngày sinh!');
            document.getElementById('txtNgaySinh').focus();
            return false;
        }

        if (phone === null || phone.trim() === "") {
            alert('Vui lòng nhập số điện thoại!');
            document.getElementById('txtDienThoai').focus();
            return false;
        }

        if (captcha === null || captcha.trim() === "") {
            alert('Vui lòng nhập mã xác thực!');
            document.getElementById('txtMaXacThuc').focus();
            return false;
        }

        var check = $('#chk:checked').val();
        if (typeof (check) === 'undefined') {
            alert('Vui lòng chấp nhận các điều khoản của chúng tôi!');
            return false;
        }

        var aData = [];
        //aData[0] = ho;
        aData[0] = name;
        aData[1] = email;
        aData[2] = password;
        aData[3] = phone;
        //aData[5] = passport;
        aData[4] = birthday;
        aData[5] = sex;
        //aData[8] = cityId;
        //aData[9] = districtId;
        //aData[10] = address;
        aData[6] = captcha;
        aData[7] = "1";

        var jsonData = JSON.stringify({ aData: aData });
        $.ajax({
            type: "POST",
            url: "Ajax.aspx/Register",
            data: jsonData,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                if (data.d === "") {


                    gtag('event', 'sign_up_complete');

                    alert('Đăng ký tài khoản thành công!');
                    window.location.href = "{{ route('auth.login.form') }}#login";
                } else {
                    alert(data.d);
                    changeImage('captcharegister', 'CreateCapchaRegister.aspx');
                }
            },
            error: function () {
                alert("Error loading data! Please try again.");
                changeImage('captcharegister', 'CreateCapchaRegister.aspx');
            }
        })
        .done(function (msg) {
        });
    };
    function changeImage(imgName, imgSrc) {
        var d = new Date();
        var image = document.getElementById(imgName);
        image.src = imgSrc + "?d=" + d;
    }
    function showError(mes) {
        $("#error-status").empty();
        var mess = "<label style='color:red'>" + mes + "</label>";
        $("#error-status").append(mess);
    }
</script>
<form method="post" action="https://betacinemas.vn/login.htm?url=login.htm" id="ctl00">
<div class="aspNetHidden">
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="0wkcRdrbghd6Q0F2iPQyu9PcpzJwLXS8CzTOgPbQMQDfgK02O0Ec20GJQImF1phN2OuqX3oNdgS6kds8tfPFqtmXOvxb5K+3P4vrE4bncB4=" />
</div>

<div class="aspNetHidden">

	<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="3989C74E" />
</div>
    <script type="text/javascript">
        function loginByFacebook() {
            FB.login(function (response) {
                if (response.authResponse) {
                    gtag('set', 'user_properties', {
                        'user_id': response.authResponse.userID
                    });

                    gtag('event', 'sign_in_complete', {
                        'method': 'facebook'
                    });

                    FacebookLoggedIn(response);
                }
                 else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, { scope: 'email' });
        }

        function FacebookLoggedIn(response) {
            var refererUrl = $.urlParam('referer');
            var loc = '/callback.aspx';
            if (loc.indexOf('?') > -1)
                window.location = loc + '&authprv=facebook&access_token=' + response.authResponse.accessToken + '&refererUrl=' + refererUrl;
            else
                window.location = loc + '?authprv=facebook&access_token=' + response.authResponse.accessToken + '&refererUrl=' + refererUrl;
        }
    </script>
    <div class="container">
        <!-- TABS -->
        <div id="BodyContent_ctl00_ctl02_divLogin" class="col-lg-8 col-md-8 col-sm-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-2 tab-style-1 margin-bottom-20 margin-top-20">
            <ul class="nav nav-tabs text-uppercase tab-information">
                <li class="{{ $defaultTab === 'login' ? 'active' : '' }} text-center" style="width: 50%"><a class="font-16" href="#login" data-toggle="tab">
                    Đăng nhập</a></li>
                <li style="width: 50%" class="{{ $defaultTab === 'register' ? 'active' : '' }} text-center"><a class="font-16" href="#register" data-toggle="tab">
                    Đăng ký</a></li>
            </ul>
            <div class="tab-content font-family-san font-14" style="background-color: #fff;">
                <div class="tab-pane fade {{ $defaultTab === 'login' ? 'in active' : '' }}" id="login">
                    <div class="form-group">
                        <div id="error-status" class="col-md-16 margin-bottom-10">
                            @if (session('status'))
                                <span style="color:#16a34a;">{{ session('status') }}</span>
                            @endif
                            @if ($errors->any())
                                <span style="color:#e11d48;">{{ $errors->first() }}</span>
                            @endif

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-16 margin-bottom-10">
                            <label class="control-label font-14">Email</label>
                            <div class="input-icon">
                                <i class="fa fa-user"></i>
                                <input type="text" id="txtLoginName" class="form-control" placeholder="Email">
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
                            <a href="#doimatkhau-pop-up" class="fancybox-fast-view">
                                Quên mật khẩu?</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-9 margin-bottom-20">
                            <img class="pull-left" id="captchalogin" src="CreateCapchaLogin.jpg" alt="" /><a onclick="changeImage('captchalogin', 'CreateCapchaLogin.aspx')" class="pull-left" style="padding: 9px;"><i style="font-size: 30px;" class="fa fa-refresh"></i></a>
                        </div>
                        <div class="col-md-7 margin-bottom-20">
                            <input type="text" id="txtLoginCaptcha" class="form-control" placeholder="Mã xác thực">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-16 text-center">
                            <div class="form-group">
                                <button type="button" style="min-width: 220px; text-transform: uppercase" id="btnLogin" onclick="login();" class="btn-mua-ve">
                                    Đăng nhập bằng tài khoản</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="tab-pane fade {{ $defaultTab === 'register' ? 'in active' : '' }}" id="register">
                    <!-- BEGIN FORM-->
                    <div class="form-group">

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                            <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Họ tên</label>
                            <input type="text" style="height: 30px;" id="txtName" class="form-control" placeholder="Họ tên">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                            <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Email</label>
                            <div class="input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="text" style="height: 30px;" id="txtEmail" class="form-control" placeholder="Email">
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
                                <input id="txtNgaySinh" style="height: 30px;" class="datepicker form-control" placeholder="Ngày sinh" data-date-format="dd/mm/yyyy" data-date-end-date="-13y">

                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                            <label class="control-label font-14">Giới tính</label>
                            <div class="input-icon">
                                <i class="fa fa-male"></i>
                                <select id="cboSex" style="height: 30px;" class="form-control" data-placeholder="Giới tính" tabindex="1">
                                    <option class="option-item" value="0">Giới tính</option>
                                    <option class="option-item" value="1">Nam</option>
                                    <option class="option-item" value="2">Nữ</option>
                                    <option class="option-item" value="3">Khác</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                            <label class="control-label font-14"><span style="color: red;">*</span>&nbsp;Số điện thoại</label>
                            <div class="input-icon">
                                <i class="fa fa-phone-square"></i>
                                <input type="text" style="height: 30px;" id="txtDienThoai" class="form-control" placeholder="Số điện thoại">
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                            <img class="pull-left" id="captcharegister" src="CreateCapchaRegister.jpg" alt="" /><a onclick="changeImage('captcharegister', 'CreateCapchaRegister.aspx')" class="pull-left" style="padding: 6px 4px 0px;"><i style="font-size: 30px;" class="fa fa-refresh"></i></a>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-16 margin-bottom-10">
                            <input type="text" style="height: 30px;" id="txtMaXacThuc" class="form-control" placeholder="Mã xác thực">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-16">
                            <div class="form-group">
                                <input type="checkbox" id="chk" value="1">
                                <span style="display: normal">Tôi cam kết tuân theo <a href="#chinhsachbaomat-pop-up" class="fancybox-fast-view">chính sách bảo mật</a> và <a href="#dieukhoansudung-pop-up" class="fancybox-fast-view">điều khoản sử dụng</a> của BetaCinemas.
                                </span>
                                <span style="display: none">I have read and accecpt the <a href="#chinhsachbaomat-pop-up" class="fancybox-fast-view">Privacy policy</a> and <a href="#dieukhoansudung-pop-up" class="fancybox-fast-view">Terms and conditions</a> of BetaCinemas.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-md-16 text-center">
                            <div class="form-group">
                                <button type="button" onclick="dangKy();" class="btn btn-mua-ve">
                                    Đăng ký</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END TABS -->
    </div>
</form>
<!-- BEGIN fast view chinh sach bao mat -->
<div id="chinhsachbaomat-pop-up" style="display: none; width: 800px;" class="no-padding">
    <div class="product-page product-pop-up">
        <div class="modal-header">
            <h3 class="no-padding no-margin">
                CHÍNH SÁCH BẢO MẬT</h3>
        </div>
        <div class="modal-body font-family-san font-14" style="max-height: 572px; overflow-y: auto;">

                    <p style="text-align: justify;">CH&Iacute;NH S&Aacute;CH BẢO MẬT TH&Ocirc;NG TIN C&Aacute; NH&Acirc;N KH&Aacute;CH H&Agrave;NG</p>

<p style="text-align: justify;"><strong>1. &nbsp; Mục đ&iacute;ch v&agrave; phạm vi thu thập</strong></p>

<p style="text-align: justify;">Việc thu thập dữ liệu chủ yếu tr&ecirc;n website Betacinemas.vn bao gồm: email, điện thoại, số chứng minh thư nh&acirc;n d&acirc;n/căn cước c&ocirc;ng d&acirc;n, mật khẩu đăng nhập, địa chỉ kh&aacute;ch h&agrave;ng (th&agrave;nh vi&ecirc;n). Đ&acirc;y l&agrave; c&aacute;c th&ocirc;ng tin m&agrave; website Betacinemas.vn cần th&agrave;nh vi&ecirc;n cung cấp bắt buộc khi đăng k&yacute; sử dụng dịch vụ v&agrave; để website Betacinemas.vn li&ecirc;n hệ x&aacute;c nhận khi kh&aacute;ch h&agrave;ng đăng k&yacute; sử dụng dịch vụ tr&ecirc;n website Betacinemas.vn nhằm đảm bảo quyền lợi cho người ti&ecirc;u d&ugrave;ng.</p>

<p style="text-align: justify;">Trong qu&aacute; tr&igrave;nh giao dịch thanh to&aacute;n Website Betacinemas.vn, ch&uacute;ng t&ocirc;i chỉ lưu giữ th&ocirc;ng tin chi tiết về đơn h&agrave;ng đ&atilde; thanh to&aacute;n của th&agrave;nh vi&ecirc;n, c&aacute;c th&ocirc;ng tin về số t&agrave;i khoản ng&acirc;n h&agrave;ng của th&agrave;nh vi&ecirc;n sẽ kh&ocirc;ng được lưu giữ.</p>

<p style="text-align: justify;">C&aacute;c th&agrave;nh vi&ecirc;n sẽ tự chịu tr&aacute;ch nhiệm về bảo mật v&agrave; lưu giữ mọi hoạt động sử dụng dịch vụ dưới t&ecirc;n đăng k&yacute;, mật khẩu v&agrave; hộp thư điện tử của m&igrave;nh. Ngo&agrave;i ra, th&agrave;nh vi&ecirc;n c&oacute; tr&aacute;ch nhiệm th&ocirc;ng b&aacute;o kịp thời cho Ban quản l&yacute; website Betacinemas.vn về những h&agrave;nh vi sử dụng tr&aacute;i ph&eacute;p, lạm dụng, vi phạm bảo mật, lưu giữ t&ecirc;n đăng k&yacute; v&agrave; mật khẩu của b&ecirc;n thứ ba để c&oacute; biện ph&aacute;p giải quyết ph&ugrave; hợp.<br />
https://www.betacinemas.vn/thong-tin-chung.htm#tab-7<br />
https://www.betacinemas.vn/thong-tin-chung.htm#tab-9</p>

<p style="text-align: justify;"><strong>2. Phạm vi sử dụng th&ocirc;ng tin</strong></p>

<p style="text-align: justify;">C&ocirc;ng ty sử dụng th&ocirc;ng tin th&agrave;nh vi&ecirc;n cung cấp để:</p>

<p style="text-align: justify;">- Cung cấp c&aacute;c dịch vụ đến th&agrave;nh vi&ecirc;n;</p>

<p style="text-align: justify;">- Gửi c&aacute;c th&ocirc;ng b&aacute;o về c&aacute;c hoạt động trao đổi th&ocirc;ng tin giữa th&agrave;nh vi&ecirc;n v&agrave; website Betacinemas.vn;</p>

<p style="text-align: justify;">- Ngăn ngừa c&aacute;c hoạt động ph&aacute; hủy t&agrave;i khoản người d&ugrave;ng của th&agrave;nh vi&ecirc;n hoặc c&aacute;c hoạt động giả mạo th&agrave;nh vi&ecirc;n;</p>

<p style="text-align: justify;">- Li&ecirc;n lạc v&agrave; giải quyết với th&agrave;nh vi&ecirc;n trong những trường hợp đặc biệt.</p>

<p style="text-align: justify;">- Kh&ocirc;ng sử dụng th&ocirc;ng tin c&aacute; nh&acirc;n của th&agrave;nh vi&ecirc;n ngo&agrave;i mục đ&iacute;ch x&aacute;c nhận v&agrave; li&ecirc;n hệ c&oacute; li&ecirc;n quan đến giao dịch tại website Betacinemas.vn.</p>

<p style="text-align: justify;">- Trong trường hợp c&oacute; y&ecirc;u cầu của ph&aacute;p luật: C&ocirc;ng ty c&oacute; tr&aacute;ch nhiệm hợp t&aacute;c cung cấp th&ocirc;ng tin c&aacute; nh&acirc;n th&agrave;nh vi&ecirc;n khi c&oacute; y&ecirc;u cầu từ cơ quan tư ph&aacute;p bao gồm: Viện kiểm s&aacute;t, t&ograve;a &aacute;n, cơ quan c&ocirc;ng an điều tra li&ecirc;n quan đến h&agrave;nh vi vi phạm ph&aacute;p luật n&agrave;o đ&oacute; của kh&aacute;ch h&agrave;ng. Ngo&agrave;i ra, kh&ocirc;ng ai c&oacute; quyền x&acirc;m phạm v&agrave;o th&ocirc;ng tin c&aacute; nh&acirc;n của th&agrave;nh vi&ecirc;n.</p>

<p style="text-align: justify;">- Trong những trường hợp c&ograve;n lại, ch&uacute;ng t&ocirc;i sẽ c&oacute; th&ocirc;ng b&aacute;o cụ thể cho Qu&yacute; Kh&aacute;ch H&agrave;ng khi phải tiết lộ th&ocirc;ng tin cho một b&ecirc;n thứ ba v&agrave; th&ocirc;ng tin n&agrave;y chỉ được cung cấp khi được sự phản hồi đồng &lrm;&yacute;&lrm; từ ph&iacute;a Qu&yacute; Kh&aacute;ch H&agrave;ng. VD: c&aacute;c chương tr&igrave;nh khuyến m&atilde;i c&oacute; sự hợp t&aacute;c, t&agrave;i trợ với c&aacute;c đối t&aacute;c của C&ocirc;ng ty Beta; cung cấp c&aacute;c th&ocirc;ng tin giao nhận cần thiết cho c&aacute;c đơn vị vận chuyển.</p>

<p style="text-align: justify;"><strong>3. Thời gian lưu trữ th&ocirc;ng tin</strong></p>

<p style="text-align: justify;">- Dữ liệu c&aacute; nh&acirc;n của kh&aacute;ch h&agrave;ng sẽ được lưu trữ cho đến khi c&oacute; y&ecirc;u cầu hủy bỏ hoặc tự kh&aacute;ch h&agrave;ng đăng nhập v&agrave; thực hiện hủy bỏ. C&ograve;n lại trong mọi trường hợp th&ocirc;ng tin c&aacute; nh&acirc;n kh&aacute;ch h&agrave;ng sẽ được bảo mật tr&ecirc;n m&aacute;y chủ của website Betacinemas.vn.</p>

<p style="text-align: justify;"><strong>4. Những người hoặc tổ chức c&oacute; thể được tiếp cận với th&ocirc;ng tin đ&oacute;</strong></p>

<p style="text-align: justify;">- Ban quản l&yacute; website Betacinemas.vn v&agrave; c&aacute;c bộ phận li&ecirc;n quan đến việc hỗ trợ v&agrave; thực hiện hợp đồng với người ti&ecirc;u d&ugrave;ng.</p>

<p style="text-align: justify;">- Trong trường hợp c&oacute; y&ecirc;u cầu của ph&aacute;p luật: C&ocirc;ng ty c&oacute; tr&aacute;ch nhiệm hợp t&aacute;c cung cấp th&ocirc;ng tin c&aacute; nh&acirc;n kh&aacute;ch h&agrave;ng khi c&oacute; y&ecirc;u cầu từ cơ quan tư ph&aacute;p bao gồm: Viện kiểm s&aacute;t, t&ograve;a &aacute;n, cơ quan c&ocirc;ng an điều tra li&ecirc;n quan đến h&agrave;nh vi vi phạm ph&aacute;p luật n&agrave;o đ&oacute; của kh&aacute;ch h&agrave;ng. Ngo&agrave;i ra, kh&ocirc;ng ai c&oacute; quyền x&acirc;m phạm v&agrave;o th&ocirc;ng tin c&aacute; nh&acirc;n của kh&aacute;ch h&agrave;ng.</p>

<p style="text-align: justify;"><strong>5. Địa chỉ của đơn vị thu thập v&agrave; quản l&yacute; th&ocirc;ng tin c&aacute; nh&acirc;n</strong></p>

<p style="text-align: justify;">C&ocirc;ng ty Cổ Phần BETA MEDIA</p>

<p style="text-align: justify;">Tầng 3, số 595, đường Giải Ph&oacute;ng, phường Gi&aacute;p B&aacute;t, quận Ho&agrave;ng Mai, th&agrave;nh phố H&agrave; Nội</p>

<p style="text-align: justify;">Email: <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="4023332b280022253421232f32306e362e">[email&#160;protected]</a></p>

<p style="text-align: justify;">Hoặc li&ecirc;n hệ hotline: 1900 636807</p>

<p style="text-align: justify;">Đối với c&aacute;c thắc mắc về hoạt động thu thập, xử l&yacute; th&ocirc;ng tin li&ecirc;n quan đến c&aacute; nh&acirc;n người ti&ecirc;u d&ugrave;ng, kh&aacute;ch h&agrave;ng c&oacute; thể li&ecirc;n hệ hotline</p>

<p style="text-align: justify;"><strong>6. Phương thức v&agrave; c&ocirc;ng cụ để người ti&ecirc;u d&ugrave;ng tiếp cận v&agrave; chỉnh sửa dữ liệu c&aacute; nh&acirc;n của m&igrave;nh</strong></p>

<p style="text-align: justify;">- Th&agrave;nh vi&ecirc;n c&oacute; quyền tự kiểm tra, cập nhật, điều chỉnh hoặc hủy bỏ th&ocirc;ng tin c&aacute; nh&acirc;n của m&igrave;nh bằng c&aacute;ch đăng nhập v&agrave;o t&agrave;i khoản đ&atilde; được cấp tr&ecirc;n website Betacinemas.vn. Sau đ&oacute;, chọn mục &ldquo;Th&ocirc;ng tin c&aacute; nh&acirc;n&rdquo; để thực hiện việc chỉnh sửa theo y&ecirc;u cầu của người ti&ecirc;u d&ugrave;ng.</p>

<p style="text-align: justify;"><strong>7. Cam kết bảo mật th&ocirc;ng tin c&aacute; nh&acirc;n kh&aacute;ch h&agrave;ng</strong></p>

<p style="text-align: justify;">- Th&ocirc;ng tin c&aacute; nh&acirc;n của th&agrave;nh vi&ecirc;n tr&ecirc;n Website Betacinemas.vn được C&ocirc;ng ty Cổ phần Beta Media cam kết bảo mật tuyệt đối theo ch&iacute;nh s&aacute;ch bảo vệ th&ocirc;ng tin c&aacute; nh&acirc;n của C&ocirc;ng ty. Việc thu thập v&agrave; sử dụng th&ocirc;ng tin của mỗi th&agrave;nh vi&ecirc;n chỉ được thực hiện khi c&oacute; sự đồng &yacute; của kh&aacute;ch h&agrave;ng đ&oacute; trừ những trường hợp ph&aacute;p luật c&oacute; quy định kh&aacute;c.</p>

<p style="text-align: justify;">- Kh&ocirc;ng sử dụng, kh&ocirc;ng chuyển giao, cung cấp hay tiết lộ cho b&ecirc;n thứ 3 n&agrave;o về th&ocirc;ng tin c&aacute; nh&acirc;n của th&agrave;nh vi&ecirc;n khi kh&ocirc;ng c&oacute; sự cho ph&eacute;p đồng &yacute; từ th&agrave;nh vi&ecirc;n.</p>

<p style="text-align: justify;">- Trong trường hợp m&aacute;y chủ lưu trữ th&ocirc;ng tin bị hacker tấn c&ocirc;ng dẫn đến mất m&aacute;t dữ liệu c&aacute; nh&acirc;n th&agrave;nh vi&ecirc;n, Website Betacinemas.vn sẽ c&oacute; tr&aacute;ch nhiệm th&ocirc;ng b&aacute;o vụ việc cho cơ quan chức năng điều tra xử l&yacute; kịp thời v&agrave; th&ocirc;ng b&aacute;o cho th&agrave;nh vi&ecirc;n được biết.</p>

<p style="text-align: justify;">- Bảo mật tuyệt đối mọi th&ocirc;ng tin giao dịch trực tuyến của th&agrave;nh vi&ecirc;n bao gồm th&ocirc;ng tin h&oacute;a đơn kế to&aacute;n chứng từ số h&oacute;a tại khu vực dữ liệu trung t&acirc;m an to&agrave;n cấp 1 của Website Betacinemas.vn.</p>

<p style="text-align: justify;">- Ban quản l&yacute; Website Betacinemas.vn y&ecirc;u cầu c&aacute;c c&aacute; nh&acirc;n khi đăng k&yacute;/mua h&agrave;ng l&agrave; Th&agrave;nh vi&ecirc;n, phải cung cấp đầy đủ th&ocirc;ng tin c&aacute; nh&acirc;n c&oacute; li&ecirc;n quan như: Họ v&agrave; t&ecirc;n, địa chỉ li&ecirc;n lạc, email, số chứng minh nh&acirc;n d&acirc;n, điện thoại, số t&agrave;i khoản, số thẻ thanh to&aacute;n &hellip; v&agrave; chịu tr&aacute;ch nhiệm về t&iacute;nh ph&aacute;p l&yacute; của những th&ocirc;ng tin tr&ecirc;n. Ban quản l&yacute; Website Betacinemas.vn kh&ocirc;ng chịu tr&aacute;ch nhiệm cũng như kh&ocirc;ng giải quyết mọi khiếu nại c&oacute; li&ecirc;n quan đến quyền lợi của th&agrave;nh vi&ecirc;n đ&oacute; nếu x&eacute;t thấy tất cả th&ocirc;ng tin c&aacute; nh&acirc;n của th&agrave;nh vi&ecirc;n đ&oacute; cung cấp khi đăng k&yacute; ban đầu l&agrave; kh&ocirc;ng ch&iacute;nh x&aacute;c.</p>

<p style="text-align: justify;"><strong>8. Cơ chế tiếp nhận v&agrave; giải quyết khiếu nại li&ecirc;n quan đến việc th&ocirc;ng tin c&aacute; nh&acirc;n kh&aacute;ch h&agrave;ng</strong></p>

<p style="text-align: justify;">- Khi ph&aacute;t hi&ecirc;̣n th&ocirc;ng tin c&aacute; nh&acirc;n của m&igrave;nh bị sử dụng sai mục đ&iacute;ch hoặc phạm vi, th&agrave;nh vi&ecirc;n c&oacute; thể cung cấp c&aacute;c th&ocirc;ng tin, chứng cứ li&ecirc;n quan đến việc n&agrave;y theo địa chỉ:&nbsp;</p>

<p style="text-align: justify;">C&ocirc;ng ty Cổ Phần BETA MEDIA</p>

<p style="text-align: justify;">Tầng 3, số 595, đường Giải Ph&oacute;ng, phường Gi&aacute;p B&aacute;t, quận Ho&agrave;ng Mai, th&agrave;nh phố H&agrave; Nội</p>

<p style="text-align: justify;">Email: <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="a3c0d0c8cbe3c1c6d7c2c0ccd1d38dd5cd">[email&#160;protected]</a></p>

<p style="text-align: justify;">Hoặc li&ecirc;n hệ hotline:&nbsp;1900 636807</p>

<p style="text-align: justify;">Trong thời hạn 10 ng&agrave;y l&agrave;m việc kể từ ng&agrave;y nhận được khiếu nại của th&agrave;nh vi&ecirc;n, Bộ phận/đơn vị chủ tr&igrave; giải quyết khiếu nại c&oacute; tr&aacute;ch nhiệm t&igrave;m ra nguy&ecirc;n nh&acirc;n khiếu nại v&agrave; đưa ra phương &aacute;n giải quyết. Trả lời cho th&agrave;nh vi&ecirc;n về kết quả giải quyết khiếu nại. T&ugrave;y theo mức độ, t&iacute;nh chất của việc khiếu nại m&agrave; Bộ phận/đơn vị chủ tr&igrave; giải quyết khiếu nại sẽ c&oacute; biện ph&aacute;p giải quyết cụ thể.</p>

<p style="text-align: justify;">Nếu th&ocirc;ng qua h&igrave;nh thức thỏa thuận m&agrave; vẫn kh&ocirc;ng thể giải quyết được khiếu nại của th&agrave;nh vi&ecirc;n th&igrave; một trong hai b&ecirc;n sẽ c&oacute; quyền nhờ đến cơ quan ph&aacute;p luật c&oacute; thẩm quyền can thiệp nhằm đảm bảo lợi &iacute;ch hợp ph&aacute;p của c&aacute;c b&ecirc;n.</p>

                        <div class="clearfix margin-bottom-10" style="margin-bottom: 10px;"></div>


        </div>
    </div>
</div>
<!-- END fast view chinh sach bao mat -->
<!-- BEGIN fast view dieu khoan su dung -->
<div id="dieukhoansudung-pop-up" style="display: none; width: 800px;" class="no-padding">
    <div class="product-page product-pop-up">
        <div class="modal-header">
            <h3 class="no-padding no-margin">
                ĐIỀU KHOẢN SỬ DỤNG</h3>
        </div>
        <div class="modal-body font-family-san font-14" style="max-height: 572px; overflow-y: auto;">

                    <p dir="ltr" style="text-align: justify;">Việc bạn sử dụng website n&agrave;y đồng nghĩa với việc bạn đồng &yacute; với những thỏa thuận dưới đ&acirc;y.</p>

<p dir="ltr" style="text-align: justify;">Nếu bạn kh&ocirc;ng đồng &yacute;, xin vui l&ograve;ng kh&ocirc;ng sử dụng website.</p>

<p dir="ltr" style="text-align: justify;"><strong>1. Chấp nhận c&aacute;c điều khoản sử dụng</strong></p>

<p dir="ltr" style="text-align: justify;">C&aacute;c điều khoản v&agrave; điều kiện sau đ&acirc;y (gọi chung l&agrave; c&aacute;c &ldquo;Điều khoản sử dụng&rdquo;) quy định việc truy cập v&agrave; sử dụng c&aacute;c dịch vụ, th&ocirc;ng tin từ Beta Cinemas</p>

<p dir="ltr" style="text-align: justify;">Bằng việc sử dụng bất kỳ dịch vụ n&agrave;o của c&ocirc;ng ty, Qu&yacute; kh&aacute;ch chấp nhận, đồng &yacute; bị r&agrave;ng buộc v&agrave; tu&acirc;n thủ c&aacute;c điều khoản sử dụng dưới đ&acirc;y.</p>

<p dir="ltr" style="text-align: justify;">Nếu Qu&yacute; kh&aacute;ch kh&ocirc;ng đồng &yacute; với bất kỳ điều khoản sử dụng, ch&iacute;nh s&aacute;ch bảo mật của Beta Cinemas hoặc kh&ocirc;ng c&oacute; đầy đủ năng lực h&agrave;nh vi d&acirc;n sự ph&ugrave; hợp, xin vui l&ograve;ng dừng việc truy cập v&agrave; sử dụng ngay lập tức.</p>

<p dir="ltr" style="text-align: justify;"><strong>2. Truy cập&nbsp;</strong></p>

<p dir="ltr" style="text-align: justify;">Beta Cinemas bảo lưu quyền được chấm dứt, thay đổi bất kỳ dịch vụ, th&ocirc;ng tin n&agrave;o m&agrave; Beta Cinemas cung cấp v&agrave;o bất cứ l&uacute;c n&agrave;o, theo quyết định của c&ocirc;ng ty m&agrave; kh&ocirc;ng cần b&aacute;o trước. Để truy cập v&agrave; sử dụng c&aacute;c dịch vụ, th&ocirc;ng tin của c&ocirc;ng ty, Qu&yacute; kh&aacute;ch c&oacute; thể được y&ecirc;u cầu cung cấp một số th&ocirc;ng tin đăng k&yacute; nhất định khi Qu&yacute; kh&aacute;ch đăng k&yacute; th&agrave;nh vi&ecirc;n/ đăng k&yacute; nhận bản tin.</p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch đảm bảo rằng tất cả c&aacute;c th&ocirc;ng tin Qu&yacute; kh&aacute;ch cung cấp cho Beta Cinemas l&agrave; ch&iacute;nh x&aacute;c, đầy đủ v&agrave; cập nhật. Qu&yacute; kh&aacute;ch đồng &yacute; rằng tất cả c&aacute;c th&ocirc;ng tin m&agrave; Qu&yacute; kh&aacute;ch cung cấp cho Beta Cinemas th&ocirc;ng qua Website được điều chỉnh bởi ch&iacute;nh s&aacute;ch bảo mật của c&ocirc;ng ty .</p>

<p dir="ltr" style="text-align: justify;">Nếu Qu&yacute; kh&aacute;ch lựa chọn, hoặc được cung cấp, một t&ecirc;n người d&ugrave;ng, mật khẩu hoặc bất kỳ phần n&agrave;o kh&aacute;c của th&ocirc;ng tin như l&agrave; một phần của thủ tục an ninh, Qu&yacute; kh&aacute;ch c&oacute; nghĩa vụ bảo mật c&aacute;c th&ocirc;ng tin n&agrave;y, v&agrave; kh&ocirc;ng được tiết lộ cho bất kỳ người n&agrave;o hoặc tổ chức n&agrave;o kh&aacute;c.</p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch cũng x&aacute;c nhận rằng t&agrave;i khoản của Qu&yacute; kh&aacute;ch l&agrave; d&agrave;nh ri&ecirc;ng cho Qu&yacute; kh&aacute;ch v&agrave; đồng &yacute; kh&ocirc;ng cung cấp th&ocirc;ng tin t&agrave;i khoản cho bất kỳ người n&agrave;o kh&aacute;c để truy cập v&agrave;o c&aacute;c dịch vụ, th&ocirc;ng tin của Beta Cinemas. Qu&yacute; kh&aacute;ch đồng &yacute; th&ocirc;ng b&aacute;o cho Beta Cinemas ngay lập tức bất kỳ việc truy cập tr&aacute;i ph&eacute;p n&agrave;o c&oacute; sử dụng đến t&ecirc;n sử dụng, mật khẩu của Qu&yacute; kh&aacute;ch.</p>

<p dir="ltr" style="text-align: justify;">Beta Cinemas c&oacute; quyền v&ocirc; hiệu h&oacute;a bất kỳ t&ecirc;n người d&ugrave;ng, mật khẩu hoặc số nhận dạng kh&aacute;c, đ&atilde; được lựa chọn bởi Qu&yacute; kh&aacute;ch hoặc cung cấp bởi Beta Cinemas, bất cứ l&uacute;c n&agrave;o theo quyết định của Beta Cinemas m&agrave; kh&ocirc;ng cần th&ocirc;ng b&aacute;o l&yacute; do của việc v&ocirc; hiệu h&oacute;a đ&oacute;.</p>

<p dir="ltr" style="text-align: justify;"><strong>3. Quyền sở hữu tr&iacute; tuệ</strong></p>

<p dir="ltr" style="text-align: justify;">C&aacute;c Điều khoản sử dụng cho ph&eacute;p Qu&yacute; kh&aacute;ch sử dụng c&aacute;c dịch vụ của Beta Cinemas cho c&aacute; nh&acirc;n, cho mục đ&iacute;ch phi thương mại.</p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch kh&ocirc;ng được sao ch&eacute;p, ph&acirc;n phối, sửa đổi, hiển thị c&ocirc;ng khai, thực hiện c&ocirc;ng khai, t&aacute;i xuất bản, tải về, lưu trữ hoặc truyền tải bất kỳ nội dung hoặc t&agrave;i liệu c&oacute; sẵn tr&ecirc;n Website của Beta Cinemas ngoại trừ trường hợp việc n&agrave;y được thực hiện tự động bởi m&aacute;y t&iacute;nh/tr&igrave;nh duyệt web m&agrave; Qu&yacute; kh&aacute;ch sử dụng, cần thiết cho việc truy cập v&agrave; sử dụng c&aacute;c dịch vụ, th&ocirc;ng tin của Beta Cinemas.</p>

<p dir="ltr" style="text-align: justify;"><strong>4. Thương hiệu</strong></p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch kh&ocirc;ng được sử dụng thương hiệu của Beta Cinemas m&agrave; kh&ocirc;ng c&oacute; sự cho ph&eacute;p trước bằng văn bản của c&ocirc;ng ty. C&aacute;c thương hiệu của c&aacute;c b&ecirc;n thứ ba, c&aacute;c biểu tượng, sản phẩm hoặc dịch vụ, thiết kế hay khẩu hiệu xuất hiện tr&ecirc;n web kh&ocirc;ng nhất thiết chỉ ra bất kỳ sự li&ecirc;n kết n&agrave;o của c&aacute;c b&ecirc;n thứ ba đ&oacute;.</p>

<p dir="ltr" style="text-align: justify;"><strong>5. H&agrave;nh vi nghi&ecirc;m cấm</strong></p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch chỉ c&oacute; thể sử dụng c&aacute;c dịch vụ của Beta Cinemas cho c&aacute;c mục đ&iacute;ch hợp ph&aacute;p v&agrave; ph&ugrave; hợp với c&aacute;c điều khoản sử dụng. Qu&yacute; kh&aacute;ch đồng &yacute; kh&ocirc;ng sử dụng c&aacute;c dịch vụ của Beta Cinemas cho bất kỳ h&agrave;nh vi hoặc mục đ&iacute;ch vi phạm ph&aacute;p luật.</p>

<p dir="ltr" style="text-align: justify;"><strong>6. Đ&oacute;ng g&oacute;p của th&agrave;nh vi&ecirc;n</strong></p>

<p dir="ltr" style="text-align: justify;">C&aacute;c dịch vụ của Beta Cinemas c&oacute; thể chứa bảng tin, c&aacute;c trang web c&aacute; nh&acirc;n hoặc cấu h&igrave;nh, chức năng nhắn tin v&agrave; c&aacute;c t&iacute;nh năng tương t&aacute;c kh&aacute;c (gọi chung l&agrave; &ldquo;Dịch vụ tương t&aacute;c&rdquo;) cho ph&eacute;p người d&ugrave;ng gửi, xuất bản, truyền tải cho người kh&aacute;c nội dung hoặc t&agrave;i liệu (gọi chung l&agrave; &ldquo;những đ&oacute;ng g&oacute;p của th&agrave;nh vi&ecirc;n&rdquo;), tr&ecirc;n hoặc th&ocirc;ng qua Dịch vụ của Beta Cinemas.</p>

<p dir="ltr" style="text-align: justify;">Bất kỳ th&ocirc;ng tin n&agrave;o Qu&yacute; kh&aacute;ch gửi đến c&aacute;c Dịch vụ của Beta Cinemas sẽ kh&ocirc;ng được coi l&agrave; c&aacute;c th&ocirc;ng tin bảo mật. Bằng c&aacute;ch cung cấp bất kỳ đ&oacute;ng g&oacute;p n&agrave;o tr&ecirc;n c&aacute;c Dịch vụ của Beta Cinemas, Qu&yacute; kh&aacute;ch cấp cho Beta Cinemas quyền kh&ocirc;ng thể thu hồi, đầy đủ, vĩnh viễn, v&agrave; miễn ph&iacute; để t&aacute;i xuất bản, trưng b&agrave;y, ph&acirc;n phối, sửa đổi.</p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch bảo đảm rằng Qu&yacute; kh&aacute;ch sở hữu hoặc kiểm so&aacute;t mọi quyền đối với c&aacute;c th&ocirc;ng tin đ&oacute;ng g&oacute;p cho Beta Cinemas. Qu&yacute; kh&aacute;ch đảm bảo t&iacute;nh hợp ph&aacute;p, độ tin cậy, t&iacute;nh ch&iacute;nh x&aacute;c v&agrave; ph&ugrave; hợp của c&aacute;c th&ocirc;ng tin đ&oacute;. Beta Cinemas kh&ocirc;ng chịu tr&aacute;ch nhiệm với bất kỳ b&ecirc;n thứ ba n&agrave;o, về nội dung hoặc t&iacute;nh ch&iacute;nh x&aacute;c của bất kỳ đ&oacute;ng g&oacute;p n&agrave;o của người d&ugrave;ng.</p>

<p dir="ltr" style="text-align: justify;"><strong>7. Gi&aacute;m s&aacute;t v&agrave; Thi h&agrave;nh</strong></p>

<p dir="ltr" style="text-align: justify;">Beta Cinemas c&oacute; quyền: loại bỏ hoặc từ chối đưa l&ecirc;n bất kỳ th&ocirc;ng tin đ&oacute;ng g&oacute;p n&agrave;o của th&agrave;nh vi&ecirc;n theo đ&aacute;nh gi&aacute; của c&ocirc;ng ty; thực hiện c&aacute;c sửa đổi m&agrave; Beta Cinemas cho l&agrave; cần thiết đối với c&aacute;c đ&oacute;ng g&oacute;p của th&agrave;nh vi&ecirc;n; tiết lộ danh t&iacute;nh của Qu&yacute; kh&aacute;ch hoặc c&aacute;c th&ocirc;ng tin kh&aacute;c về Qu&yacute; kh&aacute;ch theo c&aacute;c y&ecirc;u cầu của c&aacute;c cơ quan chức năng c&oacute; thẩm quyền; chấm dứt hoặc đ&igrave;nh chỉ truy cập của Qu&yacute; kh&aacute;ch đến tất cả hay một phần của Dịch vụ c&ocirc;ng ty cho bất kỳ hoặc kh&ocirc;ng v&igrave; l&yacute; do g&igrave;.</p>

<p dir="ltr" style="text-align: justify;">Beta Cinemas kh&ocirc;ng thực hiện xem x&eacute;t c&aacute;c t&agrave;i liệu trước khi n&oacute; được đăng tải tr&ecirc;n c&aacute;c Dịch vụ của Beta Cinemas, v&agrave; kh&ocirc;ng thể đảm bảo loại bỏ nhanh ch&oacute;ng c&aacute;c th&ocirc;ng tin n&agrave;y sau khi n&oacute; đ&atilde; được đăng.</p>

<p dir="ltr" style="text-align: justify;"><strong>8. Ti&ecirc;u chuẩn nội dung</strong></p>

<p dir="ltr" style="text-align: justify;">Ti&ecirc;u chuẩn &aacute;p dụng cho bất kỳ v&agrave; tất cả c&aacute;c đ&oacute;ng g&oacute;p của người sử dụng. Nội dung đ&oacute;ng g&oacute;p của người d&ugrave;ng phải tu&acirc;n thủ c&aacute;c quy định ph&aacute;p luật.</p>

<p dir="ltr" style="text-align: justify;">Theo đ&oacute;, Beta Cinemas kh&ocirc;ng chịu tr&aacute;ch nhiệm với bất kỳ b&ecirc;n thứ ba n&agrave;o về việc Beta Cinemas kh&ocirc;ng thể loại bỏ kịp thời c&aacute;c th&ocirc;ng tin đ&oacute;ng g&oacute;p bởi th&agrave;nh vi&ecirc;n tr&ecirc;n c&aacute;c dịch vụ của Beta Cinemas .</p>

<p dir="ltr" style="text-align: justify;"><strong>9. Vi phạm bản quyền</strong></p>

<p dir="ltr" style="text-align: justify;">Beta Cinemas coi trọng vấn đề bản quyền v&agrave; sẽ phản hồi lại c&aacute;c th&ocirc;ng b&aacute;o về việc vi phạm bản quyền theo đ&uacute;ng c&aacute;c quy định của ph&aacute;p luật. Nếu Qu&yacute; kh&aacute;ch tin rằng bất kỳ th&ocirc;ng tin n&agrave;o cung cấp tr&ecirc;n Beta Cinemas vi phạm bản quyền của Qu&yacute; kh&aacute;ch, Qu&yacute; kh&aacute;ch c&oacute; thể y&ecirc;u cầu loại bỏ c&aacute;c th&ocirc;ng tin n&agrave;y từ c&aacute;c dịch vụ của Beta Cinemas bằng c&aacute;ch gửi th&ocirc;ng b&aacute;o cho Beta Cinemas qua thư điện tử hoặc c&aacute;c h&igrave;nh thức li&ecirc;n lạc ph&ugrave; hợp kh&aacute;c.</p>

<p dir="ltr" style="text-align: justify;"><strong>10. Dựa v&agrave;o th&ocirc;ng tin cung cấp</strong></p>

<p dir="ltr" style="text-align: justify;">C&aacute;c th&ocirc;ng tin c&oacute; sẵn tr&ecirc;n hoặc th&ocirc;ng qua Dịch vụ của Beta Cinemas được cung cấp duy nhất cho mục đ&iacute;ch th&ocirc;ng tin chung. Beta Cinemas c&oacute; thể cập nhật c&aacute;c th&ocirc;ng tin n&agrave;y theo thời gian, nhưng nội dung của n&oacute; kh&ocirc;ng nhất thiết phải ho&agrave;n chỉnh hoặc được cập nhật một c&aacute;ch đầy đủ. Bất kỳ th&ocirc;ng tin n&agrave;o c&oacute; sẵn tr&ecirc;n Website c&oacute; thể được thay đổi tại bất kỳ thời điểm n&agrave;o, v&agrave; Beta Cinemas kh&ocirc;ng c&oacute; nghĩa vụ phải cập nhật th&ocirc;ng tin như vậy.</p>

<p dir="ltr" style="text-align: justify;">Th&ocirc;ng tin được cung cấp tr&ecirc;n Beta Cinemas cho mục đ&iacute;ch th&ocirc;ng tin chung. Ch&uacute;ng t&ocirc;i từ chối bất kỳ v&agrave; tất cả c&aacute;c tr&aacute;ch nhiệm li&ecirc;n quan đến độ ch&iacute;nh x&aacute;c, ho&agrave;n thiện, tin cậy, hiệu quả, sử dụng, hoặc kết quả sử dụng c&aacute;c th&ocirc;ng tin c&ocirc;ng bố tr&ecirc;n Beta Cinemas; v&agrave; Qu&yacute; kh&aacute;ch chịu tr&aacute;ch nhiệm ho&agrave;n to&agrave;n với bất kỳ h&agrave;nh động n&agrave;o dựa v&agrave;o việc sử dụng bất cứ th&ocirc;ng tin c&ocirc;ng bố tr&ecirc;n Beta Cinemas.</p>

<p dir="ltr" style="text-align: justify;"><strong>11. Từ chối c&aacute;c bảo đảm</strong></p>

<p dir="ltr" style="text-align: justify;">Qu&yacute; kh&aacute;ch hiểu rằng Beta Cinemas kh&ocirc;ng thể v&agrave; kh&ocirc;ng đảm bảo những tập tin c&oacute; sẵn để tải về từ Internet hoặc c&aacute;c trang web sẽ kh&ocirc;ng chứa virus hoặc c&aacute;c m&atilde; ph&aacute; hoại kh&aacute;c. Qu&yacute; kh&aacute;ch chịu tr&aacute;ch nhiệm thực hiện đầy đủ thủ tục kiểm tra để đ&aacute;p ứng c&aacute;c y&ecirc;u cầu cụ thể để bảo vệ Qu&yacute; kh&aacute;ch chống virus v&agrave; c&aacute;c chương tr&igrave;nh ph&aacute; hoại.</p>

<p dir="ltr" style="text-align: justify;"><strong>12. Miễn trừ tr&aacute;ch nhiệm ph&aacute;p l&yacute;</strong></p>

<p dir="ltr" style="text-align: justify;">Trong bất cứ trường hợp n&agrave;o, Beta Cinemas sẽ kh&ocirc;ng chịu tr&aacute;ch nhiệm với Qu&yacute; kh&aacute;ch hoặc bất kỳ người n&agrave;o kh&aacute;c/ b&ecirc;n thứ ba n&agrave;o kh&aacute;c cho mọi, hậu quả ph&aacute;t sinh b&ecirc;n ngo&agrave;i hoặc li&ecirc;n quan đến những điều khoản sử dụng v&agrave;/hoặc những dịch vụ của Beta Cinemas.</p>

<p dir="ltr" style="text-align: justify;"><strong>13. X&oacute;a dữ liệu c&aacute; nh&acirc;n&nbsp;tr&ecirc;n ứng dụng Android hoặc iOS</strong></p>

<p>(1) Sau khi mở ứng dụng tr&ecirc;n Android hoặc iOS, m&agrave;n h&igrave;nh đăng nhập sẽ xuất hiện.</p>

<p>(2) Ch&uacute;ng ta chọn &quot;ĐĂNG NHẬP BẰNG FACEBOOK&quot;.</p>

<p>(3) Sẽ c&oacute; th&ocirc;ng b&aacute;o hiện ra ch&uacute;ng ta chọn &quot;Tiếp tục&quot;.</p>

<p>(4) M&agrave;n h&igrave;nh sẽ chuyển hướng đến Facebook; khi c&oacute; th&ocirc;ng b&aacute;o kh&aacute;c hiện ra chọn &quot;Mở&quot;.</p>

<p>(5) Chọn &#39;Tiếp tục với t&ecirc;n t&agrave;i khoản facebook&#39; để v&agrave;o ứng dụng Beta Cinemas.</p>

<p>(6) Sau đ&oacute; ứng dụng sẽ y&ecirc;u cầu bạn tạo mật khẩu. Sau khi điền xong nhấn v&agrave;o &quot;CẬP NHẬT&quot;.</p>

<p>(7) M&agrave;n h&igrave;nh sẽ chuyển về m&agrave;n h&igrave;nh ch&iacute;nh của ứng dụng Beta Cinemas.</p>

<p>(8) Bấm v&agrave;o biểu tượng avatar ở g&oacute;c tr&ecirc;n c&ugrave;ng b&ecirc;n tr&aacute;i (cạnh t&ecirc;n người d&ugrave;ng) để truy cập trang c&aacute; nh&acirc;n của bạn trong ứng dụng Beta Cinemas.&nbsp;K&eacute;o xuống dưới sẽ thấy d&ograve;ng &quot;X&oacute;a t&agrave;i khoản&quot;. Khi click v&agrave;o đ&acirc;y sẽ xuất hiện th&ocirc;ng b&aacute;o hỏi bạn c&oacute; chắc chắn muốn x&oacute;a to&agrave;n bộ th&ocirc;ng tin t&agrave;i khoản, lịch sử giao dịch, điểm kh&aacute;ch h&agrave;ng th&acirc;n thiết hay kh&ocirc;ng:</p>

<ul dir="ltr">
	<li style="text-align: justify;">Nếu qu&yacute; kh&aacute;ch chọn &ldquo; Đồng &yacute; &rdquo; hệ thống sẽ x&oacute;a to&agrave;n bộ th&ocirc;ng tin li&ecirc;n quan đến t&agrave;i khoản, lịch sử giao dịch, điểm kh&aacute;ch h&agrave;ng th&acirc;n thiết.</li>
	<li style="text-align: justify;">Nếu chọn &quot;Hủy&quot; th&igrave; th&ocirc;ng b&aacute;o sẽ biến mất.&quot;</li>
</ul>

                        <div class="clearfix margin-bottom-10" style="margin-bottom: 10px;"></div>


        </div>
    </div>
</div>
<!-- END fast view dieu khoan su dung -->
<!-- BEGIN fast view dieu khoan su dung -->
<div id="doimatkhau-pop-up" style="display: none;" class="no-padding">
    <div class="product-page product-pop-up">
        <div class="modal-header">
            <h3 class="no-padding no-margin">
                LẤY LẠI MẬT KHẨU</h3>
        </div>
        <div class="modal-body font-family-san font-14">
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
                <div class="col-md-9 margin-bottom-30">
                    <img class="pull-left" id="captchachangepass" src="CreateCapchaChangePass.jpg" alt="" /><a onclick="changeImage('captchachangepass', 'CreateCapchaChangePass.aspx')" class="pull-left" style="padding: 9px;"><i style="font-size: 30px;" class="fa fa-refresh"></i></a>
                </div>
                <div class="col-md-7 margin-bottom-30">
                    <input type="text" id="txtChangePassCaptcha" class="form-control" placeholder="Mã xác thực">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <div class="col-md-16 text-center">
                    <div class="form-group">
                        <button type="button" onclick="forgotpass();" class="btn-mua-ve">
                            LẤY LẠI MẬT KHẨU</button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
 <div class="spinner-overlay" id="spinnerOverlay">
     <div class="spinner-container">
         <div class="spinner"></div>
         <div class="spinner-text">Loading</div>
     </div>
 </div>
<style>
     /* Full-page overlay */
 .spinner-overlay {
     display: none; /* Hidden by default */
     position: fixed;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
     z-index: 9999; /* Ensures it appears on top of all other elements */
     justify-content: center;
     align-items: center;
 }

 /* Spinner container (holds spinner + text) */
 .spinner-container {
     position: relative;
     width: 75px;
     height: 75px;
 }

 /* Spinner Ring */
 .spinner {
     width: 100%;
     height: 100%;
     border: 5px solid white; /* Static white background */
     border-top: 5px solid #3498db; /* Blue running segment */
     border-radius: 50px !important; /* Makes it circular */
     animation: spin 2s linear infinite; /* Smooth spinning animation */
 }

 /* Static Text */
 .spinner-text {
     position: absolute;
     top: 50%;
     left: 50%;
     transform: translate(-50%, -50%); /* Center the text */
     font-size: 16px;
     color: white; /* Match spinner's blue */
     font-weight: bold;
     text-align: center;
     z-index: 1; /* Ensure it stays above the spinner */
     pointer-events: none; /* Prevent interaction with the text */
 }

 /* Spinning animation keyframes */
 @keyframes spin {
     0% {
         transform: rotate(0deg);
     }

     100% {
         transform: rotate(360deg);
     }
 }
</style>
<!-- END fast view dieu khoan su dung -->
</div>
            </div>
        </div>
      <!-- BEGIN PRE-FOOTER -->
      <div class="pre-footer">
          <div class="container">
              <div class="row">
                  <div class="col-md-3 col-sm-16 pre-footer-col">
					<div id="BodyContent_ctl00_bottomPanel" class="ecm-panel">
<ul class="list-unstyled">
    <li style="margin-bottom: 25px;" class="col-lg-16 col-md-16 col-xs-16 margin-xs-bottom-25">
        <a class="site-logo" href="{{ url('/') }}"><img style="width: 120px;" alt="" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/logo/logo-white.png') }}" alt="Beta Cinemas"/></a>
    </li>

            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-3" onclick="RedirectUrl('thong-tin-chung.html#tab-3')">Tuyển dụng</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-1" onclick="RedirectUrl('thong-tin-chung.html#tab-1')">Giới thiệu</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-2" onclick="RedirectUrl('thong-tin-chung.html#tab-2')">Liên hệ</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-4" onclick="RedirectUrl('thong-tin-chung.html#tab-4')">F.A.Q</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="gioi-thieu/trach-nhiem-xa-hoi-va-cong-dong.html" onclick="RedirectUrl('gioi-thieu/trach-nhiem-xa-hoi-va-cong-dong.html')">Hoạt động xã hội</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-7" onclick="RedirectUrl('thong-tin-chung.html#tab-7')">Điều khoản sử dụng</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="dieu-khoan/dieu-khoan-thanh-toan.html" onclick="RedirectUrl('dieu-khoan/dieu-khoan-thanh-toan.html')">Chính sách thanh toán, đổi trả - hoàn vé</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-8" onclick="RedirectUrl('thong-tin-chung.html#tab-8')">Liên hệ quảng cáo</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="thong-tin-chung.html#tab-9" onclick="RedirectUrl('thong-tin-chung.html#tab-9')">Điều khoản bảo mật</a></li>


            <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a href="dieu-khoan/huong-dan-dat-ve-online.html" onclick="RedirectUrl('dieu-khoan/huong-dan-dat-ve-online.html')">Hướng dẫn đặt vé online</a></li>


</ul>

<div style="display: inline-block">
    <h2>Tải ứng dụng</h2>
    <ul class="list-unstyled">
        <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a target="_blank" href="https://apps.apple.com/vn/app/beta-cinemas/id1403107666?l=vi">Beta Cinemas cho iOS</a></li>
        <li class="col-lg-16 col-md-8 col-sm-8 col-xs-8"><i class="fa fa-angle-right"></i><a target="_blank" href="https://play.google.com/store/apps/details?id=com.beta.betacineplex&amp;hl=vi">Beta Cinemas cho Android</a></li>
    </ul>
</div>
</div>
                  </div>
                  <div class="col-md-13 col-sm-16 pre-footer-col">
					<div id="BodyContent_ctl00_bottomRightPanel" class="ecm-panel">
<div class="col-md-9 col-sm-16 pre-footer-col">
    <h2>CỤM RẠP BETA</h2>
    <ul class="list-unstyled" style="float: left;">
        <li><i class="fa fa-angle-right"></i><a
            href="tin-ben-le/beta-xuan-thuy-sap-khai-truong.html">Beta Cinemas Xuân Thủy, Hà Nội - Hotline 0333 023 183 </a></li>
        <li><i class="fa fa-angle-right"></i><a
            href="tin-ben-le/beta-cinemas-tay-son-sap-khai-truong.html">Beta Cinemas Tây Sơn, Hà Nội - Hotline 0976 894 773 </a></li>
        <li><i class="fa fa-angle-right"></i><a
            href="thong-tin-rap/beta-cinemas-vinh-yen-vinh-phuc.html">Beta Cinemas Vĩnh Yên, Phú Thọ - Hotline 0977 632 215 </a></li>
        <li><i class="fa fa-angle-right"></i><a
            href="beta-cinemas-ung-van-khiem-sieu-pham-trong-thoi-gian-toi.html">Beta Cinemas Ung Văn Khiêm, TP Hồ Chí Minh - Hotline 0969 874 873 </a></li>
        <li><i class="fa fa-angle-right"></i><a
            href="thong-tin-rap/beta-lao-cai.html">Beta Cinemas Lào Cai - Hotline 0358 968 970 </a></li>
        <li><i class="fa fa-angle-right"></i><a
            href="beta-imc-tran-quang-khai.html">Beta Cinemas Trần Quang Khải, TP Hồ Chí Minh - Hotline 1900 638 362 </a></li>
        <li><i class="fa fa-angle-right"></i><a
            href="thong-tin-rap/beta-trmall-phu-quoc.html">Beta Cinemas TRMall Phú Quốc, An Giang - Hotline 0983 474 440 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-empire.html">Beta Cinemas Empire Bình Dương, TP Hồ Chí Minh - Hotline 0784 531 525 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-cinemas-quang-trung-khai-truong-dau-nam-2021.html">Beta Cinemas Quang Trung, TP Hồ Chí Minh - Hotline 0706 075 509 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-cinemas-giai-phong.html">Beta Cinemas Giải Phóng, Hà Nội - Hotline 0585 680 360 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-thanh-xuan.html">Beta Cinemas Thanh Xuân, Hà Nội - Hotline 082 4812878 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/rap-my-dinh.html">Beta Cinemas Mỹ Đình, Hà Nội - Hotline 0866 154 610</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/rap-dan-phuong.html">Beta Cinemas Đan Phượng, Hà Nội - Hotline 0983 901 714 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-thai-nguyen.html">Beta Cinemas Thái Nguyên - Hotline 0867 460 053</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-thanh-hoa.html">Beta Cinemas Thanh Hóa - Hotline 0325 360 249</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-bac-giang.html">Beta Cinemas Bắc Giang, Bắc Ninh - Hotline 0866 493 413</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-nha-trang.html">Beta Cinemas Nha Trang, Khánh Hòa - Hotline 0399 475 165</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-bien-hoa.html">Beta Cinemas Biên Hòa, Đồng Nai - Hotline 0979 460 002</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-cinemas-long-khanh.html">Beta Cinemas Long Khánh, Đồng Nai - Hotline 0925 165 684</a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-ho-tram.html">Beta Cinemas Hồ Tràm, TP Hồ Chí Minh - Hotline 0254 3788601 </a></li>
        <li><i class="fa fa-angle-right"></i><a href="thong-tin-rap/beta-tan-uyen.html">Beta Cinemas Tân Uyên, TP Hồ Chí Minh - Hotline 0937 905 925 </a></li>
    </ul>
</div>

<div class="col-md-7 col-sm-16 pre-footer-col">
    <div style="float: left;">
        <h2>LIÊN HỆ</h2>
        <div class="contact" style="float: left;">
            <h5 class="no-margin">CÔNG TY CỔ PHẦN BETA MEDIA</h5>
            <h6 class="font-12">Giấy chứng nhận ĐKKD số: 0106633482 - Đăng ký lần đầu ngày 08/09/2014 tại Sở Kế hoạch và Đầu tư Thành phố Hà Nội
            </h6>
            <h6 class="font-12">Địa chỉ trụ sở: Tầng 3, số 595, đường Giải Phóng, Phường Tương Mai, Thành phố Hà Nội, Việt Nam</h6>
            <p>
                <h5 class="uppercase">Liên hệ chăm sóc khách hàng:</h5>
                <h6 class="no-margin font-12">Hotline: 1900 636807 </h6>
                <h6 class="no-margin font-12">Email: <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="036e68774361667762606a6d666e62702d756d">[email&#160;protected]</a></h6>
            </p>
            <p>
                <h5>LIÊN HỆ QUẢNG CÁO:</h5>
                <h6 class="no-margin font-12">Hotline: 0934 632 682 </h6>
                <h6 class="no-margin font-12">Email: <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="2b4a4f6b494e5f4a4c59445e5b055d45">[email&#160;protected]</a></h6>
            </p>
            <p>
                <h5>LIÊN HỆ HỢP TÁC KINH DOANH:</h5>
                <h6 class="no-margin font-12">Hotline: 1800 646420</h6>
                <h6 class="no-margin font-12">Email: <a href="cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="6a080b09021e122a080f1e0b0d18051f1a441c04">[email&#160;protected]</a></h6>
            </p>
        </div>
    </div>

    <div style="float: left;">
        <h2>KẾT NỐI VỚI CHÚNG TÔI</h2>
        <div>
            <ul class="social-icons">
                <li><a class="facebook" target="_blank" data-original-title="facebook" href="https://www.facebook.com/betacinemas"></a></li>
                <li><a class="youtube" target="_blank" data-original-title="youtube" href="https://www.youtube.com/channel/UCGj6uah35-eNiH_2mdubYRw"></a></li>
                <li><a class="tiktok" target="_blank" data-original-title="tiktok" href="https://www.tiktok.com/@beta_cinemas"></a></li>
                <li><a class="instagram" target="_blank" data-original-title="instagram" href="https://www.instagram.com/betacinemas/"></a></li>

            </ul>
            <img style="width: 180px;" alt="" src="{{ asset('web-home/assets/legacy-beta/Assets/Common/logo/dathongbao.png') }}" alt="Beta Cinemas" />
        </div>
    </div>
</div>
</div>
                  </div>
              </div>
          </div>
      </div>
      <!-- END PRE-FOOTER -->
    </div>


</div>

    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script type="text/javascript">
        $(document).ready(function () {
            jQuery(document).ready(function () {
                Layout.init();
                Layout.initOWL();
            });
            $("img.scale").imageScale();
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9f3cb81cbf1b87c6',t:'MTc3NzQ0OTA2MQ=='};var a=document.createElement('script');a.src='cdn-cgi/challenge-platform/h/b/scripts/jsd/0b8fb825cb67/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/v8c78df7c7c0f484497ecbca7046644da1771523124516" integrity="sha512-8DS7rgIrAmghBFwoOTujcf6D9rXvH8xm8JQ1Ja01h9QX8EzXldiszufYa4IFfKdLUKTTrnSFXLDkUEOTrZQ8Qg==" data-cf-beacon='{"version":"2024.11.0","token":"b706ab488d034371a85357d552200363","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
<script>
(function () {
    var defaultTab = @json($defaultTab);
    var loginUrl = @json(route('auth.login.submit'));
    var registerUrl = @json(route('auth.register.submit'));
    var forgotPasswordUrl = @json(route('password.otp.send'));
    var csrfToken = @json(csrf_token());
    function isEmail(value) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value); }
    function hideLegacyCaptcha(ids) {
        ids.forEach(function (id) {
            var element = document.getElementById(id);
            if (!element) return;
            var row = element.closest ? element.closest('.form-group') : null;
            if (row) row.style.display = 'none';
        });
    }
    window.login = function () {
        var emailInput = document.getElementById('txtLoginName');
        var passwordInput = document.getElementById('txtLoginPassword');
        var email = (emailInput && emailInput.value ? emailInput.value : '').trim();
        var password = passwordInput && passwordInput.value ? passwordInput.value : '';
        if (!email) { alert('Vui lòng nhập email!'); if (emailInput) emailInput.focus(); return false; }
        if (!isEmail(email)) { alert('Email nhập chưa đúng định dạng!'); if (emailInput) emailInput.focus(); return false; }
        if (!password.trim()) { alert('Vui lòng nhập mật khẩu!'); if (passwordInput) passwordInput.focus(); return false; }
        window.location.href = loginUrl + '?email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password);
        return false;
    };
    window.dangKy = function () {
        var nameInput = document.getElementById('txtName');
        var emailInput = document.getElementById('txtEmail');
        var passwordInput = document.getElementById('txtMatKhau');
        var confirmInput = document.getElementById('txtXacNhanMatKhau');
        var birthdayInput = document.getElementById('txtNgaySinh');
        var phoneInput = document.getElementById('txtDienThoai');
        var genderInput = document.getElementById('cboSex');
        var termsInput = document.getElementById('chk');
        var name = (nameInput && nameInput.value ? nameInput.value : '').trim();
        var email = (emailInput && emailInput.value ? emailInput.value : '').trim();
        var password = passwordInput && passwordInput.value ? passwordInput.value : '';
        var confirmPassword = confirmInput && confirmInput.value ? confirmInput.value : '';
        var birthday = (birthdayInput && birthdayInput.value ? birthdayInput.value : '').trim();
        var phone = (phoneInput && phoneInput.value ? phoneInput.value : '').trim();
        var gender = (genderInput && genderInput.value ? genderInput.value : '').trim();
        if (!name) { alert('Vui lòng nhập họ tên!'); if (nameInput) nameInput.focus(); return false; }
        if (!email) { alert('Vui lòng nhập email!'); if (emailInput) emailInput.focus(); return false; }
        if (!isEmail(email)) { alert('Email nhập chưa đúng định dạng!'); if (emailInput) emailInput.focus(); return false; }
        if (!password.trim()) { alert('Vui lòng nhập mật khẩu!'); if (passwordInput) passwordInput.focus(); return false; }
        if (!confirmPassword.trim()) { alert('Vui lòng xác nhận lại mật khẩu!'); if (confirmInput) confirmInput.focus(); return false; }
        if (password !== confirmPassword) { alert('Mật khẩu xác nhận lại chưa chính xác!'); if (confirmInput) confirmInput.focus(); return false; }
        if (!birthday) { alert('Vui lòng nhập ngày sinh!'); if (birthdayInput) birthdayInput.focus(); return false; }
        if (!phone) { alert('Vui lòng nhập số điện thoại!'); if (phoneInput) phoneInput.focus(); return false; }
        if (termsInput && !termsInput.checked) { alert('Bạn cần đồng ý với chính sách và điều khoản sử dụng!'); return false; }
        window.location.href = registerUrl + '?name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password) + '&birthday=' + encodeURIComponent(birthday) + '&phone=' + encodeURIComponent(phone) + '&gender=' + encodeURIComponent(gender);
        return false;
    };
    window.forgotpass = function () {
        var emailInput = document.getElementById('txtChangePassEmail');
        var email = (emailInput && emailInput.value ? emailInput.value : '').trim();
        if (!email) { alert('Vui lòng nhập email!'); if (emailInput) emailInput.focus(); return false; }
        if (!isEmail(email)) { alert('Email nhập chưa đúng định dạng!'); if (emailInput) emailInput.focus(); return false; }
        var form = document.createElement('form');
        form.method = 'post';
        form.action = forgotPasswordUrl;
        form.style.display = 'none';
        form.innerHTML = '<input type="hidden" name="_token" value="' + csrfToken.replace(/"/g, '&quot;') + '"><input type="hidden" name="email" value="' + email.replace(/"/g, '&quot;') + '">';
        document.body.appendChild(form);
        form.submit();
        return false;
    };
    document.addEventListener('DOMContentLoaded', function () {
        hideLegacyCaptcha(['captchalogin', 'txtLoginCaptcha', 'captcharegister', 'txtMaXacThuc', 'captchachangepass', 'txtChangePassCaptcha']);
        if (window.jQuery) jQuery('.nav-tabs a[href="#' + defaultTab + '"]').tab('show');
        var passwordInput = document.getElementById('txtLoginPassword');
        if (passwordInput) passwordInput.addEventListener('keyup', function (event) { if (event.keyCode === 13) { event.preventDefault(); window.login(); } });
    });
})();
</script>
</body>

<!-- Mirrored from betacinemas.vn/login.htm by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Apr 2026 07:51:33 GMT -->
</html>
