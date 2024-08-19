<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

global $config,$lang,$link;

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');


// manually set action for stripe payments
if (empty($action)) {
    $action = 'paddle_payment';
}

$currency = $config['currency_code'];
$user_id = $_SESSION['user']['id'];

if(isset($access_token)) {
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];

    $title = $_SESSION['quickad'][$access_token]['name'];
    $total = $_SESSION['quickad'][$access_token]['amount'];
    $taxes_ids = isset($_SESSION['quickad'][$access_token]['taxes_ids']) ? $_SESSION['quickad'][$access_token]['taxes_ids'] : null;

    $paddle_sandbox_mode = get_option('paddle_sandbox_mode');
    $paddle_vendor_id = get_option('paddle_vendor_id');
    $paddle_api_key = get_option('paddle_api_key');
    $paddle_public_key = get_option('paddle_public_key');

    if ($payment_type == "subscr") {
        $base_amount = $_SESSION['quickad'][$access_token]['base_amount'];
        $plan_interval = $_SESSION['quickad'][$access_token]['plan_interval'];
        $package_id = $_SESSION['quickad'][$access_token]['sub_id'];
    } else if ($payment_type == "prepaid_plan") {
        $base_amount = $_SESSION['quickad'][$access_token]['base_amount'];
        $payment_mode = $_SESSION['quickad'][$access_token]['payment_mode'];
        $package_id = $_SESSION['quickad'][$access_token]['sub_id'];
    } else {
        error(__('Invalid Payment Processor'), __LINE__, __FILE__, 1);
        exit();
    }

    if($action == 'paddle_payment') {

        if ($payment_type == "subscr") {
            $meta_data = array(
                'user_id' => $user_id,
                'package_id' => $package_id,
                'payment_type' => $payment_type,
                'payment_frequency' => $plan_interval,
                'base_amount' => $base_amount,
                'taxes_ids' => $taxes_ids
            );
        } elseif ($payment_type == "prepaid_plan") {
            $meta_data = array(
                'user_id' => $user_id,
                'package_id' => $package_id,
                'payment_type' => $payment_type,
                'base_amount' => $base_amount,
                'taxes_ids' => $taxes_ids
            );
        }

        $userdata = get_user_data(null, $user_id);
        $user_email = $userdata['email'];

        $params = [
            'vendor_id' => $paddle_vendor_id,
            'vendor_auth_code' => $paddle_api_key,
            'title' => $title,
            'webhook_url' => $config['site_url'] . 'webhook/paddle',
            'prices' => [$currency . ':' . $total],
            'customer_email' => $user_email,
            'passthrough' => json_encode($meta_data),
            'return_url' => $link['PAYMENT'] . "/?access_token=" . $access_token . "&i=paddle&action=paddle_ipn",
            'image_url' => $config['site_url'] . 'storage/logo/' . $config['site_logo'],
            'quantity_variable' => 0,
        ];

        $cancel_url = $link['PAYMENT']."/?access_token=".$access_token."&status=cancel";

        $ch = curl_init();
        if($paddle_sandbox_mode == 'test'){
            curl_setopt($ch, CURLOPT_URL, "https://sandbox-vendors.paddle.com/api/2.0/product/generate_pay_link");
        } else {
            curl_setopt($ch, CURLOPT_URL, "https://vendors.paddle.com/api/2.0/product/generate_pay_link");
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $request = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($request, true);

        if(!empty($result['response']['url'])){
            $redirect_url = $result['response']['url'];
            ?>
            <!DOCTYPE html>
            <html>
            <body onload="paynow()">
            <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
            <script>
                Paddle.Setup(
                    {
                        vendor: <?php _esc($paddle_vendor_id) ?>,
                        eventCallback: function(data) {
                            if (data.event === "Checkout.Close") {
                                window.location.href = '<?php echo $cancel_url; ?>';
                                return false;
                            }
                        }
                    }
                );

                <?php if($paddle_sandbox_mode == 'test'){ ?>
                Paddle.Environment.set('sandbox');
                <?php } ?>

                Paddle.Checkout.open({
                    override: "<?php _esc($redirect_url) ?>"
                });
            </script>
            </body>
            </html>
            <?php
        } else {
            payment_fail_save_detail($access_token);
            payment_error("error",$result['error']['message'],$access_token);
        }
        exit();
    } else {
        /* Redirect to the success page */
        message(__('Success'), __('Payment Successful'), $link['TRANSACTION']);
    }

} else {
    error(__('Invalid Payment Processor'), __LINE__, __FILE__, 1);
    exit();
}