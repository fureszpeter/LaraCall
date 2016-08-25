<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calling Card - TITLE</title>
    <meta charset="utf-8">
    <link rel="icon" href="{{asset('/img/favicon.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('/img/favicon.ico')}}" type="image/x-icon" />
    <meta name="description" content="Cheap Calling Card and Phone Card services, Voip Service">
    <meta name="keywords" content="Calling Card, Voip, Free Call">
    <meta name="author" content="4Call, Furesz Peter">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css" media="screen">
    <link rel="stylesheet" href="{{asset('/css/responsive.css')}}" type="text/css" media="screen">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}" type="text/css" media="screen">
    <!-- custom icons -->
    <!-- font awesome icons -->
    <link href="{{asset('/assets/icons/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" media="screen">
    <!-- ionicons -->
    <link href="{{asset('/assets/icons/ionicons/css/ionicons.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('/assets/css/iosnoty.css')}}" rel="stylesheet" media="screen">

    <style>




        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 400;
            src: local('Ubuntu'), url({{asset('/media/fonts/vRvZYZlUaogOuHbBTT1SNevvDin1pK8aKteLpeZ5c0A.woff')}}) format('woff');
        }
        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 700;
            src: local('Ubuntu Bold'), local('Ubuntu-Bold'), url({{asset('/media/fonts/0ihfXUL2emPh0ROJezvraLO3LdcAZYWl9Si6vvxL-qU.woff')}}) format('woff');
        }
        div.message {
            color: white;
            border: 1px solid black;
            text-align: center;
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        div.message.error {
            background-color: red;
        }

        div.message.info {
            background-color: green;
        }
        div.message > .closeMessage{
            float: right;
            padding-right: 5px;
        }
        div.errormsg{
            color: red;
        }
        div#spinner
        {
            display: none;
            width:100px;
            height: 100px;
            position: fixed;
            top: 50%;
            left: 50%;
            background:url({{asset('/img/ajax_loader_blue_64.gif')}}) no-repeat center #fff;
            text-align:center;
            padding:10px;
            font:normal 16px Tahoma, Geneva, sans-serif;
            border:1px solid #666;
            margin-left: -50px;
            margin-top: -50px;
            z-index:99;
            overflow: auto;
        }
        #lang_selector > ul > li > a{
            color: black;
        }
        #lang_selector > ul > li.selected > a{
            background-color: #444444;
            color: white;
        }
    </style>
    <script type="text/javascript" src={{asset('/js/jquery.js')}}></script>
    <script type="text/javascript" src={{asset('/js/superfish.js')}}></script>
    <script type="text/javascript" src={{asset('/js/jquery.mobilemenu.js')}}></script>
    <script type="text/javascript" src={{asset('/js/jquery.easing.1.3.js')}}></script>
    <script type="text/javascript" src={{asset('/js/jquery.ui.totop.js')}}></script>
    <script type="text/javascript" src={{asset('/js/jquery.equalheights.js')}}></script>
    <script type="text/javascript" src={{asset('/js/forms.js')}}></script>
    @include('includes.google_analytics')
    <script>

        $(window).load(function() {
            $().UItoTop({easingType: 'easeOutQuart'});
        })
    </script>

    <!--[if lt IE 8]>
    <div style='text-align:center'><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/img/upgrade.jpg"border="0"alt=""/></a></div>
    <![endif]-->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="{{asset('css/ie.css')}}" type="text/css" media="screen">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:700' rel='stylesheet' type='text/css'>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<div class="container" id="lang_selector" >
    <ul class="nav navbar-nav inline pull-right" style="height: 5px;">
        <div id="fb-root"></div>
        <div class="fb-like" data-href="https://www.facebook.com/4call.us.saving" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
        <li><a href="{{ url("/login")}}.html"><i class="icon-lock"></i>Login</a></li>
        <li><a href="{{ url("/register")}}.html?register=1"><i class="icon-user"></i>Registration</a></li>
        <li class="" data-val="en"><a href="">en</a></li>
        <li class="" data-val="hu"><a href="">hu</a></li>
    </ul>
</div>
<script>
    $("#lang_selector").find("li[data-val='']").addClass("selected");
</script>
<!--==============================header=================================-->
<header style="padding: 0px;">
    <div class="container">
        <div class="navbar navbar_ clearfix">
            <h1 class="brand"><a href="index.html"><strong>4Call.us</strong><span> communication company</span></a></h1>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse_">menu</a>
            <div class="nav-collapse nav-collapse_ collapse">
                <div class="navbar-inner" id="navbar_inner">
                    <ul class="nav sf-menu">
                        <li><a href="{{url("welcome")}}.html">Home</a></li>
                        <li><a href="{{url("credit/buy")}}.html">Credit</a></li>
                        <li><a href="{{url("packages")}}.html">Packages</a></li>
                        <li ><a href="{{url("callingcard")}}.html">Cards</a></li>
                        <li><a href="{{url("downloads")}}.html">Downloads</a></li>
                        <li><a href="{{url("help")}}.html">Help</a></li>
                        <li><a href="{{url("contact")}}.html">Contact</a></li>
                        <li><a href="{{url("earn_credit")}}.html">Earn Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id='messageContainer'>
            @foreach($errors as $error)
                <div class="message error">{{$error}}<div class="closeMessage">Close[X]</div></div>
            @endforeach
            {{--@foreach($infos as $info)--}}
                {{--<div class="message info">{{$info}}<div class="closeMessage">Close[X]</div></div>--}}
            {{--@endforeach--}}
        </div>
        <div id="mynavbar" style="display: none;"></div>

    </div>
</header>
<script>
    //Facebook
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    var bindMessages = function() {
        $("div.message > div.closeMessage").on("click", function() {
            $(this).closest("div.message").hide("slow");                                                    //Hide message div on click
        });
        setTimeout(function() {
            $("div.message.info").hide("slow");                                                             //Autohide info messages after 5 sec
        }, 5000);
    }
    var clearMessages = function() {
        $("div.message > div.closeMessage").click();
    }
    $("#navbar_inner").find("a[href='" + window.top.location.href + "']").closest("li").addClass("active"); //Highlight the active menu
    $().ready(function() {
        bindMessages();
    });
</script>

<div id="spinner">
    Loading...
</div>

@yield('content')

<!--==============================footer=================================-->
<footer>
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="footer-logo">
                    <a href="index.html">4Call.us™</a>
                    <ul style="list-style: none;">
                        <li >&copy; 2013  <a href="{{ url("terms_of_use")}}.html">Terms of Use</a></li>
                        <li>&copy; 2013 <a href="{{ url("privacy_policy")}}.html">Privacy Policy</a></li>
                        <li>&copy; 2013 <a href="{{ url("return_policy")}}.html">Return Policy</a></li>
                    </ul>
                </div>

            </div>
            <div class="span4">
                <img alt="American Express" class="" src="/media/img/payment_instruments/american_express.gif?382e8b7">
                <img alt="Discover" class="" src="/media/img/payment_instruments/discover.gif?382e8b7">
                <img alt="JCB" class="" src="/media/img/payment_instruments/jcb.gif?382e8b7">
                <img alt="MasterCard" class="" src="/media/img/payment_instruments/mastercard.gif?382e8b7">
                <img alt="Visa" class="" src="/media/img/payment_instruments/visa.gif?382e8b7">
                <img alt="Visa" class="" src="/media/img/payment_instruments/paypal.png?382e8b7">
                <a href="https://www.startssl.com/" target="_blank"><img src="//www.startssl.com/img/secured.gif" border="0" alt="Free SSL Secured By StartCom" title="Free SSL Secured By StartCom"></a>
            </div>
            <div class="span4">
                <ul class="social-icons">
                    <li><a href="#"><img src="/img/icon-1.png" alt=""></a></li>
                    <li><a href="#"><img src="/img/icon-2.png" alt=""></a></li>
                    <li><a href="#"><img src="/img/icon-3.png" alt=""></a></li>
                    <li><a href="#"><img src="/img/icon-4.png" alt=""></a></li>
                    <li><a href="#"><img src="/img/icon-5.png" alt=""></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<!-- noty notifications -->
<script src="/assets/lib/noty/js/noty/packaged/jquery.noty.packaged.js"></script>
<!-- iOS-style overlays/notifications -->
<script src="/assets/lib/iOS-Overlay/js/iosOverlay.js"></script>

<script src="/media/js/bindforms2.js"></script>
<script>


    var loading_overlay;
    ajaxLoading = function() {
        console.log("start");
        loading_overlay = iosOverlay({
            text: "Loading",
            icon: "fa fa-spinner fa-spin"
        });
    };
    ajaxStop = function(status) {
        console.log("stop")
        if (status) {
            loading_overlay.update({
                icon: "fa fa-check",
                text: "Success!"
            });
        } else {
            iosOverlay({
                text: "Error!",
                duration: 2000,
                icon: "fa fa-times"
            });
        }
        loading_overlay.hide();
    };
    var clearMessages = function() {
        $.noty.closeAll();
    };
    addMessage = function(message, type) {
        var timeout = false;
        if (type == "info") {
            type = "success";
            timeout = 2000;
        }

        noty({
            text: message,
            type: type,
            layout: "topCenter",
            closeWith: ['button'],
            maxVisible: 10,
            timeout: timeout
        });
    };

</script>
</body>
</html>
