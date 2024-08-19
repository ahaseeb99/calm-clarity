<?php
global $config;

// if disabled by admin
if(!$config['enable_speech_to_text']) {
    page_not_found();
}

if (isset($current_user['id'])) {

    $start = date('Y-m-01');
    $end = date_create(date('Y-m-t'))->modify('+1 day')->format('Y-m-d');

    $total_speech_text_used = get_user_option($_SESSION['user']['id'], 'total_speech_used', 0);

    $membership = get_user_membership_detail($_SESSION['user']['id']);
    $speech_text_limit = $membership['settings']['ai_speech_to_text_limit'];
    $speech_text_file_limit = $membership['settings']['ai_speech_to_text_file_limit'];

    HtmlTemplate::display('ai-speech-text', array(
        'total_speech_text_used' => $total_speech_text_used,
        'speech_text_limit' => $speech_text_limit,
        'speech_text_file_limit' => $speech_text_file_limit,
        'languages' => get_ai_languages()
    ));
} else {
    headerRedirect($link['LOGIN']);
}