<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

global $config,$lang,$link;

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');


// manually set action for stripe payments
if (empty($action)) {
    $action = 'mecadopago_payment';
}

$currency = $config['currency_code'];
$user_id = $_SESSION['user']['id'];

if(isset($access_token)) {
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];

    $title = $_SESSION['quickad'][$access_token]['name'];
    $total = $_SESSION['quickad'][$access_token]['amount'];
    $taxes_ids = isset($_SESSION['quickad'][$access_token]['taxes_ids']) ? $_SESSION['quickad'][$access_token]['taxes_ids'] : null;

    $mercadopago_access_token = get_option('mercadopago_access_token');

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

    if($action == 'mecadopago_payment') {

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

        $params = [
            'items' => [
                [
                    'id' => $package_id,
                    'title' => $title,
                    'quantity' => 1,
                    'currency_id' => $currency,
                    'unit_price' => (float) $total,
                ]
            ],
            'back_urls' => [
                'success' => $link['PAYMENT'] . "/?access_token=" . $access_token . "&i=mercadopago&action=mercadopago_ipn",
                'pending' => $link['PAYMENT'] . "/?access_token=" . $access_token . "&i=mercadopago&action=mercadopago_ipn",
                'failure' => $link['PAYMENT'] . "/?access_token=" . $access_token . "&status=cancel",
            ],
            'external_reference' => json_encode($meta_data),
            'notification_url' => $config['site_url'] . 'webhook/mercadopago',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer: ' . $mercadopago_access_token,
            'Content-Type: application/json'
        ]);
        $request = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($request, true);

        if(!empty($result['init_point'])){
            headerRedirect($result['init_point']);
        } else {
            payment_fail_save_detail($access_token);
            payment_error("error",$result['message'],$access_token);
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