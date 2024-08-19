<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

global $config, $lang, $link;

$user_id = $_SESSION['user']['id'];
$currency = $config['currency_code'];

if (isset($access_token)) {
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];
    $title = $_SESSION['quickad'][$access_token]['name'];
    $amount = $_SESSION['quickad'][$access_token]['amount'];
    $taxes_ids = isset($_SESSION['quickad'][$access_token]['taxes_ids']) ? $_SESSION['quickad'][$access_token]['taxes_ids'] : null;

    $sslcommerz_store_id = get_option('sslcommerz_store_id');
    $sslcommerz_store_pass = get_option('sslcommerz_store_pass');
    $sslcommerz_sandbox_mode = get_option('sslcommerz_sandbox_mode');

    $order_id = isset($_SESSION['quickad'][$access_token]['order_id']) ? $_SESSION['quickad'][$access_token]['order_id'] : rand(1, 400);

} else {
    error(__('Invalid Payment Processor'), __LINE__, __FILE__, 1);
    exit();
}

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

$return_url = $link['IPN'] . "/?access_token=" . $access_token . "&i=sslcommerz";
$cancel_url = $link['PAYMENT'] . "/?access_token=" . $access_token . "&status=cancel";

if ($sslcommerz_sandbox_mode == 'test') {
    $api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
} else {
    $api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
}

$username = $_SESSION['user']['username'];
$userdata = get_user_data($username);
$user_email = $userdata['email'];

$post_data = array();
$post_data['store_id'] = $sslcommerz_store_id;
$post_data['store_passwd'] = $sslcommerz_store_pass;
$post_data['total_amount'] = $amount;
$post_data['currency'] = $currency;
$post_data['tran_id'] = "SSLCZ_" . uniqid();
$post_data['success_url'] = $return_url;
$post_data['fail_url'] = $cancel_url;
$post_data['cancel_url'] = $cancel_url;
$post_data['ipn_url'] = $config['site_url'] . 'webhook/sslcommerz';

$post_data['cus_name'] = $username;
$post_data['cus_email'] = $user_email;

$post_data['cart'] = json_encode(array(
    array("product" => $title, "amount" => $amount)
));

if ($payment_type == "subscr") {
    $post_data['meta_data'] = array(
        'user_id' => $user_id,
        'package_id' => $package_id,
        'payment_type' => $payment_type,
        'payment_frequency' => $plan_interval,
        'base_amount' => $base_amount,
        'taxes_ids' => $taxes_ids
    );
} elseif ($payment_type == "prepaid_plan") {
    $post_data['meta_data'] = array(
        'user_id' => $user_id,
        'package_id' => $package_id,
        'payment_type' => $payment_type,
        'base_amount' => $base_amount,
        'taxes_ids' => $taxes_ids
    );
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$request = curl_exec($ch);
curl_close($ch);
$result = json_decode($request, true);

if (isset($result['GatewayPageURL']) && $result['GatewayPageURL'] != "") {
    header("Location: " . $result['GatewayPageURL']);
    exit;
} else {
    payment_fail_save_detail($access_token);
    $error_msg = !empty($result['failedreason']) ? $result['failedreason'] : __('Invalid Transaction');
    payment_error("error", $error_msg, $access_token);
    exit();
}
