<!--==============================footer=================================-->
<footer>
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="footer-logo">
                    <a href="index.html">4Call.us™</a>
                    <ul style="list-style: none;">
                        <li >&copy; 2013  <a href="<?= site_url("terms_of_use"); ?>.html">Terms of Use</a></li>
                        <li>&copy; 2013 <a href="<?= site_url("privacy_policy"); ?>.html">Privacy Policy</a></li>
                        <li>&copy; 2013 <a href="<?= site_url("return_policy"); ?>.html">Return Policy</a></li>
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
