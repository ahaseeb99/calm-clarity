<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

global $config,$lang,$link;

if(isset($access_token)){
    $user_id = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];
    $title = $_SESSION['quickad'][$access_token]['name'];
    $amount = $_SESSION['quickad'][$access_token]['amount'];

    if($payment_type == "order") {
        $restaurant_id = $_SESSION['quickad'][$access_token]['restaurant_id'];
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->find_one($restaurant_id);

        $userdata = get_user_data(null, $restaurant['user_id']);
        $currency = !empty($userdata['currency'])?$userdata['currency']:get_option('currency_code');

        $paytabs_sandbox_mode = get_restaurant_option($restaurant_id,'restaurant_paytabs_sandbox_mode');
        $paytabs_profile_id = get_restaurant_option($restaurant_id,'restaurant_paytabs_profile_id');
        $paytabs_secret_key = get_restaurant_option($restaurant_id,'restaurant_paytabs_secret_key');
    }else{
        $currency = $config['currency_code'];

        $paytabs_sandbox_mode = get_option('paytabs_sandbox_mode');
        $paytabs_profile_id = get_option('paytabs_profile_id');
        $paytabs_secret_key = get_option('paytabs_secret_key');
    }

    $order_id = isset($_SESSION['quickad'][$access_token]['order_id'])? $_SESSION['quickad'][$access_token]['order_id'] : rand(1,400);

}else{
    error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
    exit();
}

$return_url = $link['IPN']."?access_token=".$access_token."&i=paytabs";
$cancel_url = $link['PAYMENT']."?access_token=".$access_token."&status=cancel";

$data = array(
    'profile_id' => $paytabs_profile_id,
    'tran_type' => 'sale',
    'tran_class' => 'ecom',
    'cart_id' => strval($order_id),
    'cart_description' => $title,
    'cart_currency' => $currency,
    'cart_amount' => $amount,
    'callback' => $return_url,
    'return' => $return_url,
    "hide_shipping" => true
);
$data = json_encode($data);
$result = array();

$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, 'https://secure-global.paytabs.com/payment/request');
curl_setopt($ch, CURLOPT_URL, 'https://secure-egypt.paytabs.com/payment/request');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$headers = array();
$headers[] = 'Authorization: '.$paytabs_secret_key.'';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$request = curl_exec($ch);
$result = json_decode($request, true);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

//Set tran_ref in session access_token
$_SESSION['quickad'][$access_token]['tran_ref'] = $result['tran_ref'];

if (isset($result['redirect_url'])) {
    header("Location: ".$result['redirect_url']);
}
else {
    $error_msg = $result['message'];
    payment_fail_save_detail($access_token);
    payment_error("error",$error_msg,$access_token);
    exit();
}