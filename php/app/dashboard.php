<?php
global $config, $link;
if (isset($current_user['id'])) {
    $start = date('Y-m-01');
    $end = date_create(date('Y-m-t'))->modify('+1 day')->format('Y-m-d');

    $days = $word_used = [];

    $period = new \DatePeriod(date_create($start), \DateInterval::createFromDateString('1 day'), date_create($end));
    /** @var \DateTime $dt */
    foreach ($period as $dt) {
        $days[] = date('d M', $dt->getTimestamp());
        $word_used[date('d M', $dt->getTimestamp())] = 0;
    }

    $total_words_used = get_user_option($_SESSION['user']['id'], 'total_words_used', 0);

    $total_images_used = get_user_option($_SESSION['user']['id'], 'total_images_used', 0);

    $total_speech_used = get_user_option($_SESSION['user']['id'], 'total_speech_used', 0);

    $total_documents_created = ORM::for_table($config['db']['pre'] . 'ai_documents')
        ->where('user_id', $_SESSION['user']['id'])
        ->count();

    $membership = get_user_membership_detail($_SESSION['user']['id']);
    $membership_name = $membership['name'];
    $membership_settings = $membership['settings'];


    $sql = "SELECT DATE(`date`) AS created, SUM(`words`) AS used_words 
                FROM " . $config['db']['pre'] . "word_used 
                WHERE 
                    `user_id` = {$_SESSION['user']['id']} 
                    AND `date` BETWEEN '$start' AND '$end'
                GROUP BY DATE(`date`)";

    $result = ORM::for_table($config['db']['pre'] . 'word_used')
        ->raw_query($sql)
        ->find_many();

    foreach ($result as $data) {
        $word_used[date('d M', strtotime($data['created']))] = $data['used_words'];
    }

    HtmlTemplate::display('dashboard', array(
        'word_used' => json_encode(array_values($word_used)),
        'days' => json_encode(array_values($days)),
        'membership_name' => $membership_name,
        'membership_settings' => $membership_settings,
        'total_documents_created' => $total_documents_created,
        'total_speech_used' => $total_speech_used,
        'total_words_used' => $total_words_used ?: 0,
        'total_images_used' => $total_images_used ?: 0
    ));
} else {
    headerRedirect($link['LOGIN']);
}