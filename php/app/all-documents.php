<?php
global $config;
if (isset($current_user['id'])) {

    if (!isset($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];

    $limit = 25;

    $orm = ORM::for_table($config['db']['pre'] . 'ai_documents')
        ->where('user_id', $_SESSION['user']['id'])
        ->order_by_desc('id');

    $total = $orm->count();

    $rows = $orm
        ->limit($limit)
        ->offset(($page - 1) * $limit)
        ->find_many();

    $documents = array();
    foreach ($rows as $row) {
        $documents[$row['id']]['id'] = $row['id'];
        $documents[$row['id']]['title'] = $row['title'];
        $documents[$row['id']]['content'] = strlimiter(strip_tags((string) $row['content']), 50);
        $documents[$row['id']]['template'] = $row['template'];
        $documents[$row['id']]['date'] = date('d M, Y', strtotime($row['created_at']));
        $documents[$row['id']]['time'] = date('H:i:s', strtotime($row['created_at']));

        $template = ORM::for_table($config['db']['pre'] . 'ai_templates')
            ->where('slug', $row['template'])
            ->find_one();
        if(empty($template)){
            $template = ORM::for_table($config['db']['pre'] . 'ai_custom_templates')
                ->where('slug', $row['template'])
                ->find_one();
        }
        if(!empty($template)) {
            $translations = json_decode((string) $template['translations'], true);
            $template['title'] = !empty($translations[$config['lang_code']]['title'])
                ? $translations[$config['lang_code']]['title']
                : $template['title'];
            $documents[$row['id']]['template'] = $template;
        } else {
            if($row['template'] == 'quickai-speech-to-text'){
                $documents[$row['id']]['template'] = array(
                    'icon' => 'fa fa-headphones',
                    'title' => __('Speech to Text')
                );
            } else if($row['template'] == 'quickai-ai-code'){
                $documents[$row['id']]['template'] = array(
                    'icon' => 'fa fa-code',
                    'title' => __('AI Code')
                );
            } else {
                $documents[$row['id']]['template'] = array(
                    'icon' => 'fa fa-check-square',
                    'title' => $row['template']
                );
            }
        }
    }

    $pagging = pagenav($total, $page, $limit, $link['ALL_DOCUMENTS']);

    $start = date('Y-m-01');
    $end = date_create(date('Y-m-t'))->modify('+1 day')->format('Y-m-d');

    $total_words_used = get_user_option($_SESSION['user']['id'], 'total_words_used', 0);

    $membership = get_user_membership_detail($_SESSION['user']['id']);
    $words_limit = $membership['settings']['ai_words_limit'];

    HtmlTemplate::display('all-documents', array(
        'documents' => $documents,
        'pagging' => $pagging,
        'show_paging' => (int)($total > $limit),
        'total_words_used' => $total_words_used,
        'words_limit' => $words_limit
    ));
} else {
    headerRedirect($link['LOGIN']);
}