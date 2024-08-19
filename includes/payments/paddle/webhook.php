<?php

if(empty($_POST)) {
    die();
}

$public_key = openssl_get_publickey(get_option('paddle_public_key'));

$signature = base64_decode($_POST['p_signature']);

$fields = $_POST;
unset($fields['p_signature']);

ksort($fields);
foreach($fields as $k => $v) {
    if(!in_array(gettype($v), array('object', 'array'))) {
        $fields[$k] = "$v";
    }
}
$data = serialize($fields);

$verification = openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA1);

if(!$verification) {
    die('Invalid signature verification.');
}

/* Start getting the payment details */
$payment_subscription_id = null;
$payment_id = $_POST['p_order_id'];
$payment_total = $_POST['p_sale_gross'];
$payment_currency = $_POST['p_currency'];
$pay_mode = 'one_time'; /* Process meta data */
$metadata = json_decode($_POST['passthrough']);

payment_webhook_success('paddle', $metadata, $payment_id, $payment_subscription_id, $pay_mode,$payment_total);

die('successful');