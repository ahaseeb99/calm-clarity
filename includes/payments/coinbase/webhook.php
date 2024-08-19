<?php

function hashEqual($str1, $str2) {
    if(function_exists('hash_equals')) {
        return hash_equals($str1, $str2);
    }

    if(strlen($str1) != strlen($str2)) {
        return false;
    } else {
        $res = $str1 ^ $str2;
        $ret = 0;

        for ($i = strlen($res) - 1; $i >= 0; $i--) {
            $ret |= ord($res[$i]);
        }
        return !$ret;
    }
}

/* Verify the source of the webhook event */
$headers = getallheaders();
$signature_header = isset($headers['X-Cc-Webhook-Signature']) ? $headers['X-Cc-Webhook-Signature'] : null;
$payload = trim(@file_get_contents('php://input'));

try {
    $data = json_decode($payload);

    if(json_last_error()) {
        throw new Exception('Invalid payload provided. No JSON object could be decoded.', $payload);
    }

    if(!isset($data->event)) {
        throw new Exception('Invalid payload provided.', $payload);
    }

    $computed_signature = hash_hmac('sha256', $payload, get_option('coinbase_webhook_secret'));

    if(!hashEqual($signature_header, $computed_signature)) {
        throw new Exception($computed_signature, $payload);
    }
} catch (\Exception $exception) {
    error_log($exception->getMessage());
    echo $exception->getMessage();
    http_response_code(400);
    die();
}

if($data->event->type == 'charge:confirmed') {

    /* Start getting the payment details */
    $payment_subscription_id = null;
    $payment_id = $data->event->data->id;
    $payment_total = $data->event->data->pricing->local->amount;
    $payment_currency = $data->event->data->pricing->local->currency;
    $pay_mode = 'one_time';

    /* Payment payer details */
    $payer_email = '';
    $payer_name = '';

    /* Process meta data */
    $metadata = $data->event->data->metadata;

    payment_webhook_success('coinbase', $metadata, $payment_id, $payment_subscription_id, $pay_mode,$payment_total);

    die('successful');
}

die();