<?php

namespace LaraCall\Domain\PayPal;

class NativePayPalService implements PayPalIpnValidator
{
    public function isSentByPayPal(array $raw): bool
    {
        // STEP 1: read POST data
        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream.
        $raw_post_array = $raw;
        $myPost         = [];
        foreach ($raw_post_array as $key => $value) {
            $myPost[$key] = urldecode($value);
        }

        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req                     = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Step 2: POST IPN data back to PayPal to validate
        $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);
        // In wamp-like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
        // the directory path of the certificate as shown below:
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if (!($res = curl_exec($ch))) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // inspect IPN validation result and act accordingly
        if (strcmp($res, "VERIFIED") == 0) {
            // The IPN is verified, process it
            return true;
        } else {
            if (strcmp($res, "INVALID") == 0) {
                // IPN invalid, log for manual investigation
                return false;
            }
        }
    }

    public function isSandbox(array $raw): bool
    {
        return
            array_key_exists('test_ipn', $raw)
            && $raw['test_ipn'] == 1;
    }
}
