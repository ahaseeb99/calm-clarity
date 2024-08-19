<?php

if (!empty($_GET['access_token'])) {
    $access_token = $_GET['access_token'];
    if (!empty($_SESSION['quickad'][$access_token]['payment_id'])) {
        $paymentId = $_SESSION['quickad'][$access_token]['payment_id'];

        $yoomoney_shop_id = get_option('yoomoney_shop_id');
        $yoomoney_secret_key = get_option('yoomoney_secret_key');

        require 'lib/autoload.php';

        $client = new \YooKassa\Client();
        $client->setAuth($yoomoney_shop_id, $yoomoney_secret_key);

        try {
            $response = $client->getPaymentInfo($paymentId);

            if($response->getStatus() == 'succeeded'){
                payment_success_save_detail($access_token);
            }
        } catch (\Exception $e) {
            payment_error("error",$e->getMessage(),$access_token);
            exit();
        }
    }
    payment_fail_save_detail($access_token);
    $error_msg = __("Transactions not successful");
    payment_error("error", $error_msg, $access_token);
    exit();
}
error(__("Page not found"), __LINE__, __FILE__, 1);