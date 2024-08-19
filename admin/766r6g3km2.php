<?php
/**
 * @package QuickAI - OpenAI Content & Image Generator
 * @author Bylancer
 * @version 4.5
 * @Updated Date: 03/Nov/2023
 * @Copyright 2015-23 Bylancer
 */

define("ROOTPATH", dirname(__DIR__));
define("APPPATH", ROOTPATH."/php/");

require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';

$con = db_connect();
admin_session_start();
if (!checkloggedadmin()) {
    exit('Access Denied.');
}
//Admin Ajax Function
if(isset($_REQUEST['action'])){
    if ($_REQUEST['action'] == "loginAsUser") {loginAsUser();}
    if ($_REQUEST['action'] == "deleteMembershipPlan") { deleteMembershipPlan(); }
    if ($_REQUEST['action'] == "deletePrepaidPlan") { deletePrepaidPlan(); }
    if ($_REQUEST['action'] == "deleteTaxes") { deleteTaxes(); }
    if ($_REQUEST['action'] == "deleteTransaction") { deleteTransaction(); }
    if ($_REQUEST['action'] == "deleteCurrency") { deleteCurrency(); }
    if ($_REQUEST['action'] == "deleteTimezone") { deleteTimezone(); }
    if ($_REQUEST['action'] == "blogCatPosition") { blogCatPosition(); }
    if ($_REQUEST['action'] == "installPayment") { installPayment(); }
    if ($_REQUEST['action'] == "uninstallPayment") { uninstallPayment(); }
    if ($_REQUEST['action'] == "deleteTestimonial") { deleteTestimonial(); }
    if ($_REQUEST['action'] == "deleteLanguage") { deleteLanguage(); }
    if ($_REQUEST['action'] == "deleteSubscriber") { deleteSubscriber(); }
    if ($_REQUEST['action'] == "deleteusers") { deleteUsers(); }
    if ($_REQUEST['action'] == "deleteAdmin") { deleteAdmin(); }
    if ($_REQUEST['action'] == "deleteStaticPage") { deleteStaticPage(); }
    if ($_REQUEST['action'] == "deletefaq") { deletefaq(); }
    if ($_REQUEST['action'] == "addPlanCustom") {addPlanCustom(); }
    if ($_REQUEST['action'] == "editPlanCustom") {editPlanCustom(); }
    if ($_REQUEST['action'] == "delPlanCustom") {delPlanCustom(); }
    if ($_REQUEST['action'] == "langTranslation_PlanCustom") { langTranslation_PlanCustom(); }
    if ($_REQUEST['action'] == "edit_langTranslation_PlanCustom") { edit_langTranslation_PlanCustom(); }
    if ($_REQUEST['action'] == "edit_langTranslation") { edit_langTranslation(); }
    if ($_REQUEST['action'] == "langTranslation_FormFields") { langTranslation_FormFields(); }
    if ($_REQUEST['action'] == "editLanguageFile") { editLanguageFile(); }
    if ($_REQUEST['action'] == "saveBlog") { saveBlog(); }
    if ($_REQUEST['action'] == "deleteBlog") { deleteBlog(); }
    if ($_REQUEST['action'] == "approveComment") { approveComment(); }
    if ($_REQUEST['action'] == "deleteComment") { deleteComment(); }
    if ($_REQUEST['action'] == "addBlogCat") { addBlogCat(); }
    if ($_REQUEST['action'] == "delBlogCat") { delBlogCat(); }

    if ($_REQUEST['action'] == "quickad_update_maincat_position") { quickad_update_maincat_position(); }
    if ($_REQUEST['action'] == "quickad_update_subcat_position") { quickad_update_subcat_position(); }
    if ($_REQUEST['action'] == "quickad_update_plan_custom_position") { quickad_update_plan_custom_position(); }
    if ($_REQUEST['action'] == "aiTplCategoryPosition") { aiTplCategoryPosition(); }
    if ($_REQUEST['action'] == "aiChatBotCategoryPosition") { aiChatBotCategoryPosition(); }
    if ($_REQUEST['action'] == "aiChatBotsPosition") { aiChatBotsPosition(); }
    if ($_REQUEST['action'] == "aiChatPromptsPosition") { aiChatPromptsPosition(); }
    if ($_REQUEST['action'] == "aiTplPosition") { aiTplPosition(); }
    if ($_REQUEST['action'] == "prepaidPlansPosition") { prepaidPlansPosition(); }
    if ($_REQUEST['action'] == "plansPosition") { plansPosition(); }
    if ($_REQUEST['action'] == "paymentMethodsPosition") { paymentMethodsPosition(); }

    if ($_REQUEST['action'] == "deleteAIDocument") { deleteAIDocument(); }
    if ($_REQUEST['action'] == "deleteAIImages") { deleteAIImages(); }
    if ($_REQUEST['action'] == "deleteAICustomTemplates") { deleteAICustomTemplates(); }
    if ($_REQUEST['action'] == "deleteAITplCategories") { deleteAITplCategories(); }
    if ($_REQUEST['action'] == "deleteAPIKeys") { deleteAPIKeys(); }
    if ($_REQUEST['action'] == "deleteAIChatBots") { deleteAIChatBots(); }
    if ($_REQUEST['action'] == "deleteAIChatBotsCategories") { deleteAIChatBotsCategories(); }
    if ($_REQUEST['action'] == "deleteAIChatPrompts") { deleteAIChatPrompts(); }
    if ($_REQUEST['action'] == "deleteAISpeeches") { deleteAISpeeches(); }

}


function loginAsUser(){
    global $config, $link;
    if(check_allow()) {
        $user = ORM::for_table($config['db']['pre'] . 'user')
            ->find_one($_POST['id']);
        if (isset($user['id'])) {
            unset($_SESSION['user']);
            create_user_session($user['id'], $user['username'], $user['password_hash'], $user['user_type']);

            die($link['DASHBOARD']);
        }
    }
    die(0);
}

function deleteAIDocument(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'ai_documents')
            ->where_id_in($ids)
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAICustomTemplates(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'ai_custom_templates')
            ->where_id_in($ids)
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAITplCategories(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);

    $templates = ORM::for_table($config['db']['pre'] . 'ai_templates')
        ->where_in('category_id', $ids)
        ->count();

    $custom_templates = ORM::for_table($config['db']['pre'] . 'ai_custom_templates')
        ->where_in('category_id', $ids)
        ->count();

    if($templates + $custom_templates) {
        $result = array('success' => false, 'message' => __('You can not delete a category if it is assigned to any template.'));
        echo json_encode($result);
        die();
    }

    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'ai_template_categories')
            ->where_id_in($ids)
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAIImages() {
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        $images = ORM::for_table($config['db']['pre'] . 'ai_images')
            ->select('image')
            ->where_id_in($ids);
        foreach ($images->find_array() as $row) {
            $image_dir = "../storage/ai_images/";
            $main_image = trim((string) $row['image']);
            // delete Image
            if (!empty($main_image)) {
                $file = $image_dir . $main_image;
                if (file_exists($file))
                    unlink($file);

                $file = $image_dir . 'small_'.$main_image;
                if (file_exists($file))
                    unlink($file);
            }
        }

        $images->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAPIKeys(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'api_keys')
            ->where_id_in($ids)
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAIChatBots(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        $bot = ORM::for_table($config['db']['pre'] . 'ai_chat_bots')
            ->select('image')
            ->where_id_in($ids);

        foreach ($bot->find_array() as $row) {
            $image_dir = "../storage/chat-bots/";
            $main_image = $row['image'];
            // delete Image
            if (trim($main_image) != "") {
                $file = $image_dir . $main_image;
                if (file_exists($file))
                    unlink($file);
            }
        }

        $bot->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAIChatBotsCategories(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);

    $chatbots = ORM::for_table($config['db']['pre'] . 'ai_chat_bots')
        ->where_in('category_id', $ids)
        ->count();

    if($chatbots) {
        $result = array('success' => false, 'message' => __('You can not delete a category if it is assigned to any chat bots.'));
        echo json_encode($result);
        die();
    }

    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'ai_chat_bots_categories')
            ->where_id_in($ids)
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAIChatPrompts(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'ai_chat_prompts')
            ->where_id_in($ids)
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAISpeeches() {
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }

    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        $speeches = ORM::for_table($config['db']['pre'] . 'ai_speeches')
            ->select('file_name')
            ->where_id_in($ids);

        foreach ($speeches->find_array() as $row) {
            $dir = "../storage/ai_audios/";
            $main = $row['image'];
            // delete Image
            if (trim($main) != "") {
                $file = $dir . $main;
                if (file_exists($file))
                    unlink($file);
            }
        }

        $speeches->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteTaxes(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'taxes')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteTransaction(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'transaction')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteMembershipPlan(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'plans')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deletePrepaidPlan(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'prepaid_plans')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteCurrency(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'currencies')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteTimezone(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'time_zones')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteTestimonial(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        $testimonials = ORM::for_table($config['db']['pre'] . 'testimonials')
            ->select('image')
            ->where_id_in($ids);
        foreach ($testimonials->find_array() as $row) {
            $image_dir = "../storage/testimonials/";
            $main_image = $row['image'];
            // delete Image
            if (trim($main_image) != "" && $main_image != "default.png") {
                $file = $image_dir . $main_image;
                if (file_exists($file))
                    unlink($file);
            }
        }
        // delete
        $testimonials->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteLanguage(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        $languages = ORM::for_table($config['db']['pre'] . 'languages')
            ->select('file_name')
            ->where_id_in($ids);
        foreach ($languages->find_array() as $row) {
            $file_name = $row['file_name'];
            $file = '../includes/lang/lang_'.$file_name.'.php';
            if(file_exists($file))
                unlink($file);
        }
        // delete languages
        $languages->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteSubscriber() {
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    ORM::for_table($config['db']['pre'].'subscriber')
        ->where_raw("id IN (" . implode(',', $ids) . ")")
        ->delete_many();
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteAdmin(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    /* admin with id 1 can't be deleted */
    $ids = array_diff($ids, [1]);
    if (check_allow()) {
        $admin = ORM::for_table($config['db']['pre'].'admins')
            ->select('image')
            ->where_raw("id IN (" . implode(',', $ids) . ")");

        foreach ($admin->find_array() as $row) {
            $uploaddir = "../storage/profile/";
            // delete images
            if (trim($row['image']) != "" && $row['image'] != "default_user.png") {
                $file = $uploaddir . $row['image'];
                if (file_exists($file))
                    unlink($file);
            }
        }

        // delete admins
        $admin->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteUsers(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if (check_allow()) {
        /* Cancel subscription if there is any */
        cancel_recurring_payment($_SESSION['user']['id']);

        $users = ORM::for_table($config['db']['pre'].'user')
            ->select('image')
            ->where_raw("id IN (" . implode(',', $ids) . ")");

        foreach ($users->find_array() as $row) {
            $uploaddir = "../storage/profile/";
            // delete images
            if (trim($row['image']) != "" && $row['image'] != "default_user.png") {
                $file = $uploaddir . $row['image'];
                if (file_exists($file))
                    unlink($file);
            }
        }

        // delete documents of user
        ORM::for_table($config['db']['pre'] . 'ai_documents')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")")
            ->delete_many();
        ORM::for_table($config['db']['pre'] . 'word_used')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")")
            ->delete_many();

        // delete images of user
        $images = ORM::for_table($config['db']['pre'] . 'ai_images')
            ->select('image')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")");
        foreach ($images->find_array() as $row) {
            $image_dir = "../storage/ai_images/";
            $main_image = trim((string) $row['image']);
            // delete Image
            if (!empty($main_image)) {
                $file = $image_dir . $main_image;
                if (file_exists($file))
                    unlink($file);

                $file = $image_dir . 'small_'.$main_image;
                if (file_exists($file))
                    unlink($file);
            }
        }
        $images->delete_many();
        ORM::for_table($config['db']['pre'] . 'image_used')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")")
            ->delete_many();

        // delete audios of user
        $speeches = ORM::for_table($config['db']['pre'] . 'ai_speeches')
            ->select('file_name')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")");
        foreach ($speeches->find_array() as $row) {
            $dir = "../storage/ai_audios/";
            $main_file = $row['file_name'];

            if (trim($main_file) != "") {
                $file = $dir . $main_file;
                if (file_exists($file))
                    unlink($file);
            }
        }
        $speeches->delete_many();
        ORM::for_table($config['db']['pre'] . 'text_to_speech_used')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")")
            ->delete_many();

        // delete speech_to_text_used of user
        ORM::for_table($config['db']['pre'] . 'speech_to_text_used')
            ->where_raw("user_id IN (" . implode(',', $ids) . ")")
            ->delete_many();

        // Delete Users
        $users->delete_many();

    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function blogCatPosition() {
    global $config;

    $data = array_map('intval', $_POST['position']);
    foreach ($data as $position => $id) {
        $plan = ORM::for_table($config['db']['pre'].'blog_categories')
            ->find_one($id);
        $plan->set('position',$position);
        $plan->save();
    }
    $result = array('success' => true, 'message' => __('Updated successfully.'));
    echo json_encode($result);
}

function installPayment()
{
    global $config;
    if(isset($_POST['id']) && $_POST['folder']){
        $id = $_POST['id'];
        $folder = $_POST['folder'];

        if(check_allow()) {
            if (is_dir(ROOTPATH . '/includes/payments/' . $folder)) {

                $payment = ORM::for_table($config['db']['pre'].'payments')
                    ->use_id_column('payment_id')
                    ->find_one($id);
                $payment->set('payment_install', '1');
                $payment->save();

                if($payment->id())
                    $result = array('success' => true, 'message' => __('Installed.'));
                else
                    $result = array('success' => false, 'message' => __('Error : Please try again.'));
            } else {
                $result = array('success' => false, 'message' => __('Plugin directory not exist.'));
            }
        }
    }

    echo json_encode($result);
    die();
}

function uninstallPayment()
{
    global $config;
    if(isset($_POST['id'])){
        $id = $_POST['id'];

        if(check_allow()) {
            $payment = ORM::for_table($config['db']['pre'].'payments')
                ->use_id_column('payment_id')
                ->find_one($id);
            $payment->set('payment_install', '0');

            if($payment->save())
                $result = array('success' => true, 'message' => __('Uninstalled.'));
            else
                $result = array('success' => false, 'message' => __('Error : Please try again.'));
        }
    }

    echo json_encode($result);
    die();
}

function deleteStaticPage(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    ORM::for_table($config['db']['pre'].'pages')
        ->where_raw("parent_id IN (" . implode(',', $ids) . ")")
        ->delete_many();
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deletefaq(){
    global $config;
    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        ORM::for_table($config['db']['pre'] . 'faq_entries')
            ->where_raw("parent_id IN (" . implode(',', $ids) . ")")
            ->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function addPlanCustom(){
    global $config;
    $name = validate_input($_POST['name']);
    if (trim($name) != '' && is_string($name)) {
        if(check_allow()){
            $custom = ORM::for_table($config['db']['pre'].'plan_options')->create();
            $custom->title = $name;
            $custom->save();
            $id = $custom->id();

            $query = ORM::for_table($config['db']['pre'].'plan_options')->find_one($id);
            $query->position = $id;
            $query->save();
        }
        else{
            $id =1;
        }
        $result = array();
        $result['name'] = $name;
        $result['id'] = $id;
        echo json_encode($result);
        die();
    } else {
        echo 0;
        die();
    }
}

function editPlanCustom(){
    global $config;

    $name = validate_input($_GET['title']);
    $status = $_GET['status'];
    $id = $_GET['id'];
    if (trim($name) != '' && is_string($name) && trim($id) != '') {
        if(check_allow()){
            $plan = ORM::for_table($config['db']['pre'].'plan_options')
                ->where('id',$id)
                ->find_one();
            $plan->set('title',$name);
            $plan->set('active', $status);
            $plan->save();
        }
        echo '{"status" : "success","message" : "' . __('Successfully edited.') . '"}';
        die();
    } else {
        echo 0;
        die();
    }
}

function delPlanCustom(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'plan_options')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function approveComment(){
    global $config;
    if(check_allow()){
        $comment = ORM::for_table($config['db']['pre'].'blog_comment')
            ->find_one(validate_input($_POST['id']));
        $comment->set('active', '1');
        $comment->save();
    }
    $result = array('success' => true, 'message' => __('Saved successfully.'));
    echo json_encode($result);
    die();
}

function deleteComment(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'blog_comment')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function addBlogCat(){
    global $config;
    $_POST = validate_input($_POST);
    $name = $_POST['name'];
    if (trim($name) != '' && is_string($name)) {
        $slug = create_blog_cat_slug($name);
        if(check_allow()){
            $blog_cat = ORM::for_table($config['db']['pre'].'blog_categories')->create();
            $blog_cat->title = $name;
            $blog_cat->slug = $slug;
            $blog_cat->save();

            $id = $blog_cat->id();
            if($id){
                $blog_pos = ORM::for_table($config['db']['pre'].'blog_categories')->find_one($id);
                $blog_pos->position = validate_input($id);
                $blog_pos->save();
            }
        }
        $status = "success";
        $message = __("Saved Successfully");
    } else{
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function delBlogCat(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow())
        ORM::for_table($config['db']['pre'].'blog_categories')->where_id_in($ids)->delete_many();

    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function deleteBlog(){
    global $config;

    if(isset($_POST['id'])) {
        $_POST['ids'][] = $_POST['id'];
    }
    $ids = array_map('intval', $_POST['ids']);
    if(check_allow()) {
        $blogs = ORM::for_table($config['db']['pre'] . 'blog')
            ->select('image')
            ->where_id_in($ids);
        foreach ($blogs->find_array() as $row) {
            $image_dir = "../storage/blog/";
            $main_image = $row['image'];
            // delete Image
            if (trim($main_image) != "" && $main_image != "default.png") {
                $file = $image_dir . $main_image;
                if (file_exists($file))
                    unlink($file);
            }
        }
        // delete
        $blogs->delete_many();
    }
    $result = array('success' => true, 'message' => __('Deleted successfully.'));
    echo json_encode($result);
    die();
}

function saveBlog(){
    global $config;

    $title = validate_input($_POST['title']);

    $tags = mb_strtolower(validate_input($_POST['tags']));
    $image = null;
    $description = validate_input($_POST['description'],true, true);
    $error = array();

    if(empty($title)){
        $error[] = __('Title required.');
    }
    if(empty($description)){
        $error[] = __('Description required.');
    }

    if (empty($error)) {
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $target_dir = ROOTPATH . "/storage/blog/";
            $result = quick_file_upload('image', $target_dir);
            if ($result['success']) {
                $image = $result['file_name'];
                resizeImage(900, $target_dir . $image, $target_dir . $image);
                if (isset($_POST['id'])) {
                    // remove old image
                    $info = ORM::for_table($config['db']['pre'] . 'blog')
                        ->select('image')
                        ->find_one($_POST['id']);

                    if (!empty(trim($info['image'])) && $info['image'] != "default.png") {
                        if (file_exists($target_dir . $info['image'])) {
                            unlink($target_dir . $info['image']);
                        }
                    }
                }
            } else {
                $error[] = $result['error'];
            }
        }
    }

    if (empty($error)) {
        $id = 1;
        if(check_allow()){
            $now = date("Y-m-d H:i:s");
            if(!empty($_POST['id'])){
                $blog = ORM::for_table($config['db']['pre'].'blog')
                    ->where('id',validate_input($_POST['id']))
                    ->where('author',$_SESSION['admin']['id'])
                    ->find_one();

                if($blog){
                    if(!empty($image)){
                        $blog->set('image', $image);
                    }
                    $blog->set('title',$title);
                    $blog->set('description',$description);
                    $blog->set('tags', $tags);
                    $blog->set('status', validate_input($_POST['status']));
                    $blog->set('updated_at', $now);
                    $blog->save();
                    $id = $_POST['id'];
                }

                ORM::for_table($config['db']['pre'].'blog_cat_relation')
                    ->where('blog_id',$_POST['id'])
                    ->delete_many();
            }else{

                $blog = ORM::for_table($config['db']['pre'].'blog')->create();
                $blog->title = $title;
                $blog->image = $image;
                $blog->description = ($description);
                $blog->author = $_SESSION['admin']['id'];
                $blog->status = validate_input($_POST['status']);
                $blog->tags = $tags;
                $blog->created_at = $now;
                $blog->updated_at = $now;
                $blog->save();
                $id = $blog->id();
            }

            if(!empty($_POST['category']) && is_array($_POST['category'])){
                foreach($_POST['category'] as $cat){
                    $blog_cat = ORM::for_table($config['db']['pre'].'blog_cat_relation')->create();
                    $blog_cat->blog_id = $id;
                    $blog_cat->category_id = $cat;
                    $blog_cat->save();
                }
            }
        }
        $result = array();
        $result['status'] = 'success';
        $result['id'] = $id;
        $result['message'] = __("Saved Successfully.");
        echo json_encode($result);

    } else {
        $result = array();
        $result['status'] = 'error';
        $result['message'] = implode('<br>',$error);
        echo json_encode($result);
    }
    die();
}

function langTranslation_PlanCustom(){
    global $config;

    $id = $_POST['id'];
    $field_tpl = '<input type="hidden" name="id" id="field_id" value="'.$id.'">';
    if ($id) {
        $info = ORM::for_table($config['db']['pre'] . 'plan_options')->find_one($id);
        $translation_lang = explode(',', (string) $info['translation_lang']);
        $translation_name = explode(',',(string) $info['translation_name']);
        $count = 0;
        foreach($translation_lang as $key=>$value)
        {
            if($value != '')
            {
                $translation[$translation_lang[$key]] = $translation_name[$key];

                $count++;
            }
        }

        $orm = ORM::for_table($config['db']['pre'] . 'languages')
            ->where('active','1')
            ->where_not_equal('code','en');
        $languages = $orm->find_many();
        $num = $orm->count();
        if($num){
            foreach($languages as $fetch){
                $trans_name = (isset($translation[$fetch['code']]))? $translation[$fetch['code']] : '';
                $count = 0;
                $field_tpl .= '
                <div class="form-group">
                <div class="row align-items-center">
                <div class="col-md-3">
                <label class="m-0" for="id_'.$fetch['code'].'">'.$fetch['name'].'</label>
                </div>
                <div class="col-md-9">
                <input type="hidden" name="trans_lang[]" value="'.$fetch['code'].'">
                <input type="text" id="id_'.$fetch['code'].'" value="'.$trans_name.'" data-lang-code="'.$fetch['code'].'" class="form-control title_code" name="trans_name[]">
                </div>
                </div>
                </div>';
            }
        }else{
            $field_tpl .= '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            '.__("No language activated. Your site run with single language.").'</div>';
        }

        echo $field_tpl;
        die();
    } else {
        echo 0;
        die();
    }
}

function edit_langTranslation_PlanCustom(){
    global $config;

    $id = $_POST['id'];
    $trans_lang = implode(',', $_POST['trans_lang']);
    $trans_name = implode(',', $_POST['trans_name']);

    if($_POST['id']){
        if(check_allow()){
            $trans_lang = validate_input($trans_lang);
            $trans_name = validate_input($trans_name);

            $options = ORM::for_table($config['db']['pre'] . 'plan_options')->find_one($id);
            $options->translation_lang = $trans_lang;
            $options->translation_name = $trans_name;
            $options->save();

            echo '{"status" : "success","message" : "' . __('Successfully edited.') . '"}';
            die();
        }
    }
    echo 0;
    die();
}

function edit_langTranslation(){
    global $config;
    $_POST = validate_input($_POST);

    $id = $_POST['id'];
    $cattype = $_POST['cat_type'];
    if(check_allow()){
        foreach ($_POST['value'] as $items) {
            $code = $items['code'];
            $title = $items['title'];
            $slug = $items['slug'];
            $title = validate_input($title);

            $source = 'en';
            $target = $code;

            /*$trans = new GoogleTranslate();
            $title = $trans->translate($source, $target, $title);*/

            if($slug == "")
                $slug = create_category_slug($title);
            else
                $slug = create_category_slug($slug);

            $orm = ORM::for_table($config['db']['pre'] . 'category_translation')
                ->where(array(
                    'translation_id' => $id,
                    'lang_code' => $code,
                    'category_type' => $cattype
                ));

            $rowcount = $orm->count();

            if($rowcount){
                $info = $orm->find_one();
                $cat_translation = ORM::for_table($config['db']['pre'] . 'category_translation')->find_one($info['id']);
                $cat_translation->title = $title;
                $cat_translation->slug = $slug;
                $cat_translation->save();

            }else{
                $cat_translation = ORM::for_table($config['db']['pre'] . 'category_translation')->create();
                $cat_translation->lang_code = $code;
                $cat_translation->title = $title;
                $cat_translation->slug = $slug;
                $cat_translation->category_type = $cattype;
                $cat_translation->translation_id = $id;
                $cat_translation->save();
            }
        }
        echo 1;
        die();
    }
    echo 0;
    die();
}

function langTranslation_FormFields(){
    global $config;
    $_POST = validate_input($_POST);

    $id = $_POST['id'];
    $cattype = $_POST['cat_type'];
    $field_tpl = '<input type="hidden" id="category_id" value="'.$id.'"><input type="hidden" id="category_type" value="'.$cattype.'">';
    if ($id) {
        $orm = ORM::for_table($config['db']['pre'] . 'languages')
            ->where('active','1')
            ->where_not_equal('code','en');
        $info = $orm->find_many();
        $rows = $orm->count();
        if($rows){
            foreach($info as $fetch){

                $info = ORM::for_table($config['db']['pre'] . 'category_translation')
                    ->where(array(
                        'translation_id' => $id,
                        'lang_code' => $fetch['code'],
                        'category_type' => $cattype
                    ))
                    ->find_one();

                if($type == "custom_option"){
                    $field_tpl .= '
<div class="row translate_row">
    <div class="col-md-12 col-sm-12">
        <div class="form-group">
            <label class="col-md-3 control-label">' . $fetch['name'] . '</label>
            <div class="col-md-9">
                <input type="text" value="' . $info['title'] . '" class="form-control cat_title" placeholder="In ' . $fetch['name'] . '">
                <input type="hidden" class="lang_code" value="' . $fetch['code'] . '">
            </div>
        </div>
    </div>
</div>
';
                }else{
                    $field_tpl .= '
<div class="row translate_row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label class="col-md-3 control-label">' . $fetch['name'] . '</label>
            <div class="col-md-9">
                <input type="text" value="' . $info['title'] . '" class="form-control cat_title" placeholder="In ' . $fetch['name'] . '">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
            <label class="col-md-3 control-label">'.__("Slug").'</label>
            <div class="col-md-9">
                <input type="text" value="' . $info['slug'] . '" class="form-control cat_slug" placeholder="Slug">
            </div>
        </div>
    </div>
    <input type="hidden" class="lang_code" value="' . $fetch['code'] . '">
</div>
';
                }

            }
        }else{
            $field_tpl .= '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             '.__("No language activated. Your site run with single language.").'</div>';
        }
        echo $field_tpl;
        die();
    } else {
        echo 0;
        die();
    }
}

function quickad_update_plan_custom_position(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            foreach($position as $id){
                $plan = ORM::for_table($config['db']['pre'].'plan_options')
                    ->where('id',$id)
                    ->find_one();
                $plan->set('position',$count);
                $plan->save();

                $count++;
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function aiTplCategoryPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $plan = ORM::for_table($config['db']['pre'] . 'ai_template_categories')
                        ->find_one($id);
                    $plan->set('position', $count);
                    $plan->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function aiChatBotCategoryPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $plan = ORM::for_table($config['db']['pre'] . 'ai_chat_bots_categories')
                        ->find_one($id);
                    $plan->set('position', $count);
                    $plan->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function aiChatBotsPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $plan = ORM::for_table($config['db']['pre'] . 'ai_chat_bots')
                        ->find_one($id);
                    $plan->set('position', $count);
                    $plan->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function aiChatPromptsPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $plan = ORM::for_table($config['db']['pre'] . 'ai_chat_prompts')
                        ->find_one($id);
                    $plan->set('position', $count);
                    $plan->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function aiTplPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $plan = ORM::for_table($config['db']['pre'] . 'ai_templates')
                        ->find_one($id);
                    $plan->set('position', $count);
                    $plan->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function prepaidPlansPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $plan = ORM::for_table($config['db']['pre'] . 'prepaid_plans')
                        ->find_one($id);
                    $plan->set('position', $count);
                    $plan->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function plansPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    if($id != 'free' && $id != 'trial') {
                        $plan = ORM::for_table($config['db']['pre'] . 'plans')
                            ->find_one($id);
                        $plan->set('position', $count);
                        $plan->save();

                        $count++;
                    }
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function paymentMethodsPosition(){
    global $config;

    if(isset($_POST['position'])){
        $position = $_POST['position'];
        if (is_array($position)) {
            $count = 0;
            if(check_allow()) {
                foreach ($position as $id) {
                    $payments = ORM::for_table($config['db']['pre'] . 'payments')
                        ->use_id_column('payment_id')
                        ->find_one($id);
                    $payments->set('position', $count);
                    $payments->save();

                    $count++;
                }
            }
            $result = array('success' => true, 'message' => __("Updated Successfully"));
        } else {

            $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
        }
    }else{
        $result = array('success' => false, 'message' => __("Problem in saving, Please try again."));
    }
    echo json_encode($result);
    die();
}

function editLanguageFile(){
    if(isset($_POST['file_name']) && $_POST['file_name'] != ""){
        $file_name = $_POST['file_name'];
        $filePath = '../includes/lang/lang_'.$file_name.'.php';

        if(isset($_POST['key'])){
            if(check_allow()){
                $value = validate_input($_POST['value'], true);
                $newLangArray = array(
                    $_POST['key'] => $value
                );
                if(file_exists($filePath)){
                    change_language_file_settings($filePath, $newLangArray);
                    echo 1;
                    die();
                }
            }
        }
    }else{
        echo 0;
        die();
    }
    echo 0;
    die();
}

function change_language_file_settings($filePath, $newArray)
{
    $file_lang = getLanguageFileVariable($filePath);

    // Find the difference - after this, $fileSettings contains only the variables
    // declared in the file
    //$fileSettings = array_diff($file_lang, $newArray);

    // Update $fileSettings with any new values
    $fileSettings = array_merge($file_lang, $newArray);
    // Build the new file as a string
    $newFileStr = "<?php\n";
    foreach ($fileSettings as $name => $val) {
        // Using var_export() allows you to set complex values such as arrays and also
        // ensures types will be correct
        $newFileStr .= '$lang['. var_export($name, true) .'] = ' . var_export($val, true) . ";\n";
    }
    // Closing tag intentionally omitted, you can add one if you want

    // Write it back to the file
    file_put_contents($filePath, $newFileStr);
}

/**
 * @param $filename
 * @return string
 */
function getFile($filename)
{
    $file = fopen($filename, 'r') or die('Unable to open file getFile!');
    $buffer = fread($file, filesize($filename));
    fclose($file);

    return $buffer;
}

/**
 * @param $filename
 * @param $buffer
 */
function writeFile($filename, $buffer)
{
    // Delete the file before writing
    if (file_exists($filename)) {
        unlink($filename);
    }
    // Write the new file
    $file = fopen($filename, 'w') or die('Unable to open file writeFile!');
    fwrite($file, $buffer);
    fclose($file);
}
/**
 * @param $rawFilePath
 * @param $filePath
 * @param $con
 * @return mixed|string
 */
function setSqlWithDbPrefix($rawFilePath, $filePath, $prefix)
{
    if (!file_exists($rawFilePath)) {
        return '';
    }

    // Read and replace prefix
    $sql = getFile($rawFilePath);
    $sql = str_replace('<<prefix>>', $prefix, $sql);

    // Write file
    writeFile($filePath, $sql);

    return $sql;
}

/**
 * @param $con
 * @param $filePath
 * @return bool
 */

function importSql($con, $filePath)
{

    try {
        $errorDetect = false;

        // Temporary variable, used to store current query
        $tmpline = '';
        // Read in entire file
        $lines = file($filePath);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || trim($line) == '') {
                continue;
            }
            if (substr($line, 0, 2) == '/*') {
                continue;
            }

            // Add this line to the current segment
            $tmpline .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                if (!$con->query($tmpline)) {
                    echo "<pre>Error performing query '<strong>" . $tmpline . "</strong>' : " . $con->error . " - Code: " . $con->errno . "</pre><br />";
                    $errorDetect = true;
                }
                // Reset temp variable to empty
                $tmpline = '';
            }
        }
        // Check if error is detected
        if ($errorDetect) {
            //dd('ERROR');
        }
    } catch (\Exception $e) {
        $msg = __('Error when importing required data : ') . $e->getMessage();
        echo '<pre>';
        print_r($msg);
        echo '</pre>';
        exit();
    }


    // Delete the SQL file
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    return true;
}

/**
 * Import Geonames Default country database
 * @param $con
 * @param $site_info
 * @return bool
 */
function importGeonamesSql($con,$config,$default_country)
{
    if (!isset($default_country)) return false;

    // Default country SQL file
    $filename = 'database/countries/' . strtolower($default_country) . '.sql';
    $rawFilePath = '../storage/'.$filename;
    $filePath = '../storage/installed-db/' . $filename;

    setSqlWithDbPrefix($rawFilePath, $filePath, $config['db']['pre']);

    return importSql($con, $filePath);
}