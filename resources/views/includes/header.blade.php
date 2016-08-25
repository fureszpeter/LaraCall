<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calling Card - <?= $controller->getTitle(); ?></title>
    <meta charset="utf-8">
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>
    <meta name="description" content="Cheap Calling Card and Phone Card services, Voip Service">
    <meta name="keywords" content="Calling Card, Voip, Free Call">
    <meta name="author" content="4Call, Furesz Peter">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/css/responsive.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="screen">
    <!-- custom icons -->
    <!-- font awesome icons -->
    <link href="/assets/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <!-- ionicons -->
    <link href="/assets/icons/ionicons/css/ionicons.min.css" rel="stylesheet" media="screen">
    <link href="/assets/css/iosnoty.css" rel="stylesheet" media="screen">

    <style>


        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 400;
            src: local('Ubuntu'), url(/media/fonts/vRvZYZlUaogOuHbBTT1SNevvDin1pK8aKteLpeZ5c0A.woff) format('woff');
        }

        @font-face {
            font-family: 'Ubuntu';
            font-style: normal;
            font-weight: 700;
            src: local('Ubuntu Bold'), local('Ubuntu-Bold'), url(/media/fonts/0ihfXUL2emPh0ROJezvraLO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
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

        div.message > .closeMessage {
            float: right;
            padding-right: 5px;
        }

        div.errormsg {
            color: red;
        }

        div#spinner {
            display: none;
            width: 100px;
            height: 100px;
            position: fixed;
            top: 50%;
            left: 50%;
            background: url('/img/ajax_loader_blue_64.gif') no-repeat center #fff;
            text-align: center;
            padding: 10px;
            font: normal 16px Tahoma, Geneva, sans-serif;
            border: 1px solid #666;
            margin-left: -50px;
            margin-top: -50px;
            z-index: 99;
            overflow: auto;
        }

        #lang_selector > ul > li > a {
            color: black;
        }

        #lang_selector > ul > li.selected > a {
            background-color: #444444;
            color: white;
        }
    </style>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/superfish.js"></script>
    <script type="text/javascript" src="/js/jquery.mobilemenu.js"></script>
    <script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/js/jquery.ui.totop.js"></script>
    <script type="text/javascript"
            src="/js/jquery.equalheights.js"></script> <?php //Services                                                                                                                                                                                                                                                                                            ?>
    <script type="text/javascript"
            src="/js/forms.js"></script> <?php //Contacts                                                                                                                                                                                                                                                                                            ?>
    <?php $this->load->view("google_analytics"); ?>
    <script>

        $(window).load(function () {
            $().UItoTop({easingType: 'easeOutQuart'});
        })
    </script>

    <!--[if lt IE 8]>
    <div style='text-align:center'><a
            href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img
            src="http://www.theie6countdown.com/img/upgrade.jpg" border="0" alt=""/></a></div>
    <![endif]-->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:700' rel='stylesheet' type='text/css'>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<div class="container" id="lang_selector">
    <ul class="nav navbar-nav inline pull-right" style="height: 5px;">
        <div id="fb-root"></div>
        <div class="fb-like" data-href="https://www.facebook.com/4call.us.saving" data-layout="button_count"
             data-action="like" data-show-faces="true" data-share="true"></div>
        <li><a href="<?= site_url("login"); ?>.html"><i class="icon-lock"></i><?= lang('login') ?></a></li>
        <li><a href="<?= site_url("login"); ?>.html?register=1"><i class="icon-user"></i><?= lang('registration') ?></a>
        </li>
        <li class="" data-val="en"><a href="<?= $controller->lang->switch_uri("en") ?>">en</a></li>
        <li class="" data-val="hu"><a href="<?= $controller->lang->switch_uri("hu") ?>">hu</a></li>
    <!-- li class="" data-val="es"><a href="<?= $controller->lang->switch_uri("es") ?>">es</a></li -->
    </ul>
</div>
<script>
    $("#lang_selector").find("li[data-val='<?= $controller->lang->getLangCode() ?>']").addClass("selected");
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
                        <li><a href="<?= site_url("welcome"); ?>.html"><?= lang('home') ?></a></li>
                        <li><a href="<?= site_url("credit/buy"); ?>.html"><?= lang('credit') ?></a></li>
                        <li><a href="<?= site_url("packages"); ?>.html"><?= lang('packages') ?></a></li>
                        <li><a href="<?= site_url("callingcard"); ?>.html"><?= lang('calling_card') ?></a>
                            <?php /*
                                      <ul>
                                      <li><a href="<?= site_url("callingcard"); ?>.html"><?= lang('calling_card') ?></a></li>
                                      <!-- li><a href="#"><?= lang('set_top') ?></a></li -->

                                      <li class="sub-menu"><a href="#"><?= lang('special') ?> </a>
                                      <ul class="sub-menu" style="display: none;">
                                      <li><a href="#"><?= lang('call_recording') ?></a></li>
                                      <!-- li><a href="#"><?= lang('international_did') ?></a></li -->
                                      <li><a href="#"><?= lang('sms') ?></a></li>
                                      </ul>
                                      </li>
                                      <!-- li class="sub-menu"><a href="#"><?= lang('partner_program') ?></a>
                                      <ul class="sub-menu" style="display: none;">
                                      <li><a href="<?= site_url("reseller"); ?>.html"><?= lang('reseller') ?></a></li>
                                      <li><a href="#"><?= lang('webmaster') ?></a></li>
                                      <li><a href="#"><?= lang('agent') ?></a></li>
                                      </ul>
                                      </li -->
                                      </ul>
                                     *
                                     */
                            ?>
                        </li>
                        <li><a href="<?= site_url("downloads") ?>.html"><?= lang('downloads') ?></a></li>
                        <li><a href="<?= site_url("help") ?>.html"><?= lang('help') ?></a></li>
                        <li><a href="<?= site_url("contact") ?>.html"><?= lang('contact') ?></a></li>
                        <li><a href="<?= site_url("earn_credit") ?>.html">Earn Credit</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id='messageContainer'>
            <?php foreach ($error as $v) { ?>
            <div class="message error"><?= $v; ?>
                <div class="closeMessage">Close[X]</div>
            </div><?php } ?>
            <?php foreach ($info as $v) { ?>
            <div class="message info"><?= $v; ?>
                <div class="closeMessage">Close[X]</div>
            </div><?php } ?>

        </div>
        <div id="mynavbar" style="display: none;"></div>

    </div>
</header>
<script>
    //Facebook
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    var bindMessages = function () {
        $("div.message > div.closeMessage").on("click", function () {
            $(this).closest("div.message").hide("slow");                                                    //Hide message div on click
        });
        setTimeout(function () {
            $("div.message.info").hide("slow");                                                             //Autohide info messages after 5 sec
        }, 5000);
    }
    var clearMessages = function () {
        $("div.message > div.closeMessage").click();
    }
    $("#navbar_inner").find("a[href='" + window.top.location.href + "']").closest("li").addClass("active"); //Highlight the active menu
    $().ready(function () {
        bindMessages();
    });
</script>

<div id="spinner">
    <?= lang('loading') ?>...
</div>
