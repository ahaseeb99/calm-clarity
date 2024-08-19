<?php

if (empty($_POST)) {
    die();
}

$val_id = urlencode($_POST['val_id']);
$store_id = urlencode(get_option('sslcommerz_store_id'));
$store_passwd = urlencode(get_option('sslcommerz_store_pass'));
$sslcommerz_sandbox_mode = get_option('sslcommerz_sandbox_mode');

if ($sslcommerz_sandbox_mode == 'test') {
    $api_url = "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php";
} else {
    $api_url = "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php";
}

$requested_url = "$api_url?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($handle);
$result = json_decode($result, true);

if ($result['status'] == 'VALID' || $result['status'] == 'VALIDATED') {
    /* Start getting the payment details */
    $payment_subscription_id = null;
    $payment_id = $result['val_id'];
    $payment_total = $result['amount'];
    $payment_currency = $result['currency'];
    $pay_mode = 'one_time'; /* Process meta data */
    $metadata = json_decode($result['meta_data']);

    payment_webhook_success('sslcommerz', $metadata, $payment_id, $payment_subscription_id, $pay_mode, $payment_total);
}

die('successful');