<?php

// if disabled by admin
if (!$config['enable_affiliate_program'] || !get_option('allow_affiliate_payouts', 1)) {
    page_not_found();
}

if (isset($current_user['id'])) {

    $userdata = ORM::for_table($config['db']['pre'] . 'user')->find_one($_SESSION['user']['id']);
    $balance = $userdata['balance'];

    $error = "";
    if (isset($_POST['submit'])) {
        if (is_numeric($_POST['amount']) || $_POST['amount'] > 0) {
            if ($balance > $_POST['amount']) {
                if ($_POST['amount'] >= get_option('affiliate_minimum_payout')) {
                    if (!empty($_POST['payment_method']) && !empty($_POST['account_details'])) {

                        // minus balance
                        $total = $balance - $_POST['amount'];
                        $userdata->balance = number_format($total, 2, '.', '');
                        $userdata->save();

                        $now = date("Y-m-d H:i:s");
                        $create_withdraw = ORM::for_table($config['db']['pre'] . 'withdrawal')->create();
                        $create_withdraw->user_id = $_SESSION['user']['id'];
                        $create_withdraw->amount = validate_input($_POST['amount']);
                        $create_withdraw->payment_method_id = validate_input($_POST['payment_method']);
                        $create_withdraw->account_details = validate_input($_POST['account_details']);
                        $create_withdraw->created_at = $now;
                        $create_withdraw->save();

                        /* Admin : new request */
                        $html = $config['email_sub_withdraw_request'];
                        $html = str_replace('{SITE_TITLE}', $config['site_title'], $html);
                        $html = str_replace('{SITE_URL}', $config['site_url'], $html);
                        $html = str_replace('{USER_ID}', $userdata['id'], $html);
                        $html = str_replace('{USERNAME}', $userdata['username'], $html);
                        $html = str_replace('{EMAIL}', $userdata['email'], $html);
                        $html = str_replace('{USER_FULLNAME}', $userdata['name'], $html);
                        $html = str_replace('{AMOUNT}', validate_input($_POST['amount']), $html);
                        $email_subject = $html;

                        $html = $config['emailHTML_withdraw_request'];
                        $html = str_replace('{SITE_TITLE}', $config['site_title'], $html);
                        $html = str_replace('{SITE_URL}', $config['site_url'], $html);
                        $html = str_replace('{USER_ID}', $userdata['id'], $html);
                        $html = str_replace('{USERNAME}', $userdata['username'], $html);
                        $html = str_replace('{EMAIL}', $userdata['email'], $html);
                        $html = str_replace('{USER_FULLNAME}', $userdata['name'], $html);
                        $html = str_replace('{AMOUNT}', validate_input($_POST['amount']), $html);
                        $email_body = $html;

                        email($config['admin_email'], $config['site_title'], $email_subject, $email_body);

                        message(__("Success"), __("Amount added Successfully to withdrawal."), $link['WITHDRAWALS']);
                        exit();
                    } else {
                        $error = __("Payment details are required.");
                    }
                } else {
                    $error = __("Minimum withdrawal amount is:") . price_format(get_option('affiliate_minimum_payout'));
                }
            } else {
                $error = __("Insufficient fund, withdrawal amount must be lower than your wallet amount.");
            }

        } else {
            $error = __("Amount is not valid");
        }
    }

    $payment_methods = get_option("affiliate_payout_methods", "Paypal, Bank Deposit");
    $payment_methods = explode(',', $payment_methods);

    if($payment_methods === false)
        $payment_methods = [];

    $payment_methods = array_map('trim', $payment_methods);

    $withdrawals = ORM::for_table($config['db']['pre'] . 'withdrawal')
        ->where('user_id', $_SESSION['user']['id'])
        ->order_by_desc('id')
        ->find_array();

    /* For older users (deprecated) */
    foreach ($withdrawals as &$withdrawal){
        if(is_numeric($withdrawal['payment_method_id'])){
            $payment = ORM::for_table($config['db']['pre'] . 'payments')
                ->select('payment_title')
                ->where('payment_id', $withdrawal['payment_method_id'])
                ->find_one();
            $withdrawal['payment_method_id'] = $payment['payment_title'];
        }
    }

    HtmlTemplate::display('global/withdrawals', array(
        'affiliates' => array(),
        'error' => $error,
        'payment_methods' => $payment_methods,
        'withdrawals' => $withdrawals
    ));
} else {
    headerRedirect($link['LOGIN']);
}