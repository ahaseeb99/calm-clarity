<?php
global $config;

// if disabled by admin
if(!$config['enable_ai_images']) {
    page_not_found();
}

if(isset($current_user['id']))
{
    $start = date('Y-m-01');
    $end = date_create(date('Y-m-t'))->modify('+1 day')->format('Y-m-d');

    $total_images_used = get_user_option($_SESSION['user']['id'], 'total_images_used', 0);

    $membership = get_user_membership_detail($_SESSION['user']['id']);
    $images_limit = $membership['settings']['ai_images_limit'];

    // get ai images
    $ai_images = ORM::for_table($config['db']['pre'] . 'ai_images')
        ->where('user_id', $_SESSION['user']['id'])
        ->order_by_desc('id')
        ->limit(30)
        ->find_many();

    HtmlTemplate::display('ai-images', array(
        'total_images_used' => $total_images_used,
        'images_limit' => $images_limit,
        'ai_images' => $ai_images
    ));
}
else{
    headerRedirect($link['LOGIN']);
}