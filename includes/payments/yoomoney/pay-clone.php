<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

require 'lib/autoload.php';
use YooKassa\Client;
global $config,$lang,$link;

if(isset($access_token)){
    $user_id = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];
    $title = $_SESSION['quickad'][$access_token]['name'];
    $amount = $_SESSION['quickad'][$access_token]['amount'];
    $trans_desc = isset($_SESSION['quickad'][$access_token]['trans_desc']) ? $_SESSION['quickad'][$access_token]['trans_desc'] : $title;

    if($payment_type == "order") {
        $restaurant_id = $_SESSION['quickad'][$access_token]['restaurant_id'];
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->find_one($restaurant_id);

        $userdata = get_user_data(null, $restaurant['user_id']);
        $user_email = ''; //Please Pass buyer valid email id here its required.
        $currency = !empty($userdata['currency'])?$userdata['currency']:get_option('currency_code');

        $yoomoney_shop_id = get_restaurant_option($restaurant_id,'restaurant_yoomoney_shop_id');
        $yoomoney_secret_key = get_restaurant_option($restaurant_id,'restaurant_yoomoney_secret_key');
    }else{
        $currency = $config['currency_code'];

        $yoomoney_shop_id = get_option('yoomoney_shop_id');
        $yoomoney_secret_key = get_option('yoomoney_secret_key');

        $userdata = get_user_data(null, $user_id);
        $user_email = $userdata['email'];
    }

    $order_id = isset($_SESSION['quickad'][$access_token]['order_id'])? $_SESSION['quickad'][$access_token]['order_id'] : rand(1,400);

}else{
    error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
    exit();
}

$return_url = $link['IPN']."?access_token=".$access_token."&i=yoomoney";
$cancel_url = $link['PAYMENT']."?access_token=".$access_token."&status=cancel";

$curl = curl_init();

$customer_email = $user_email;
$amount = $amount;
$currency = $currency;
$redirect_url = $return_url;


$client = new \YooKassa\Client();
$client->setAuth($yoomoney_shop_id, $yoomoney_secret_key);

try {
    $idempotenceKey = uniqid('', true);
    $response = $client->createPayment(
        array(
            'amount' => array(
                'value' => $amount,
                'currency' => $currency,
            ),
            'confirmation' => array(
                'type' => 'redirect',
                'return_url' => $redirect_url,
            ),
            'capture' => true,
            'description' => $trans_desc,
            'metadata' => array(
                'orderNumber' => $order_id
            ),
            "receipt" => array(
                "customer" => array(
                    "full_name" => $userdata['username'],
                    "email" => $customer_email,
                ),
                "items" => array(
                    array(
                        "description" => $trans_desc,
                        "quantity" => "1.00",
                        "amount" => array(
                            "value" => $amount,
                            "currency" => $currency
                        ),
                        "vat_code" => "2",
                        "payment_mode" => "full_prepayment",
                        "payment_subject" => "commodity"
                    )
                )
            )
        ),
        $idempotenceKey
    );

    // redirect url
    $confirmationUrl = $response->getConfirmation()->getConfirmationUrl();

    //Set tran_ref in session access_token
    $_SESSION['quickad'][$access_token]['payment_id'] = $response->getId();


    headerRedirect($confirmationUrl);
} catch (\Exception $exception) {
    payment_fail_save_detail($access_token);
    //error_log($exception->getData());
    payment_error("error",$exception->getMessage(),$access_token);
}