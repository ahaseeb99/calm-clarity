<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

global $config,$lang,$link;

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

// manually set action
if (empty($action)) {
    $action = 'coinbase_payment';
}

$currency = $config['currency_code'];
$user_id = $_SESSION['user']['id'];

if(isset($access_token)) {
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];

    $title = $_SESSION['quickad'][$access_token]['name'];
    $total = $_SESSION['quickad'][$access_token]['amount'];
    $taxes_ids = isset($_SESSION['quickad'][$access_token]['taxes_ids']) ? $_SESSION['quickad'][$access_token]['taxes_ids'] : null;

    $coinbase_api_key = get_option('coinbase_api_key');

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

    if($action == 'coinbase_payment') {

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
        $price = number_format($total, 2, '.', '');

        $params = [
            'name' => $title,
            'description' => $title,
            'local_price' => [
                'amount' => $price,
                'currency' => $currency
            ],
            'pricing_type' => 'fixed_price',
            'metadata' => $meta_data,
            'redirect_url' => $link['PAYMENT'] . "/?access_token=" . $access_token . "&i=coinbase&action=coinbase_ipn",
            'cancel_url' => $link['PAYMENT'] . "/?access_token=" . $access_token . "&status=cancel",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.commerce.coinbase.com/charges");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-CC-Version: 2018-03-22',
            'X-CC-Api-Key: '.$coinbase_api_key
        ]);
        $request = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($request, true);

        if(!empty($result['data']['hosted_url'])){
            headerRedirect($result['data']['hosted_url']);
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