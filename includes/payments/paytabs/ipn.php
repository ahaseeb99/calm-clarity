<?php

if (!empty($_GET['access_token'])) {
    $access_token = filter_var($_GET['access_token'], FILTER_SANITIZE_STRING);
    if (!empty($_SESSION['quickad'][$access_token]['tran_ref'])) {
        $tran_ref = filter_var($_SESSION['quickad'][$access_token]['tran_ref'], FILTER_SANITIZE_STRING);

        $paytabs_profile_id = get_option('paytabs_profile_id');
        $paytabs_secret_key = get_option('paytabs_secret_key');

        $data = array(
            'profile_id' => $paytabs_profile_id,
            'tran_ref' => $tran_ref
        );

        $data = json_encode($data);

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, 'https://secure-global.paytabs.com/payment/query');
        curl_setopt($ch, CURLOPT_URL, 'https://secure-egypt.paytabs.com/payment/query');
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

        if ($result['payment_result']['response_status'] == "A") {

            payment_success_save_detail($access_token);

        } else {
            payment_fail_save_detail($access_token);
            $error_msg = __("Transaction was not successful: Last gateway response was: ").$result['payment_result']['response_message'];
            payment_error("error",$error_msg,$access_token);
            exit();
        }
    }
    payment_fail_save_detail($access_token);
    $error_msg = __("Transactions not successful");
    payment_error("error", $error_msg, $access_token);
    exit();
}
error(__("Page not found"), __LINE__, __FILE__, 1);

