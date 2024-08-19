<?php

if((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST')) {
    die();
}

$payload = @file_get_contents('php://input');

$data = json_decode($payload, true);

if(!$data) {
    die();
}

if(!in_array($data['action'], ['payment.created', 'payment.updated'])) {
    die();
}

/* Get payment data */
$payment_id = $data['data']['id'];

$mercadopago_access_token = get_option('mercadopago_access_token');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/v1/payments/' . $payment_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
    $ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$mercadopago_access_token]
);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$request = curl_exec($ch);
curl_close($ch);

if ($request) {
    $result = json_decode($request, true);
    if ($result) {
        if (isset($result['status']) && $result['status'] == 'approved') {
            /* Start getting the payment details */
            $payment_subscription_id = null;

            $payment_total = $result['transaction_details']['total_paid_amount'];
            $payment_currency = $config['currency_code'];
            $pay_mode = 'one_time';

            /* Process meta data */
            $metadata = json_decode($result['external_reference']);

            payment_webhook_success('mercadopago', $metadata, $payment_id, $payment_subscription_id, $pay_mode,$payment_total);

            die('successful');
        }
    }
}

http_response_code(400);
die();