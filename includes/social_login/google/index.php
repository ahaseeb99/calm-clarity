<?php
//Include GP config file && User class
// Path to root directory of app.
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
require_once 'gpConfig.php';
require_once('../../lang/lang_'.$config['lang'].'.php');


if( !ini_get('allow_url_fopen') ) {
    die('allow_url_fopen is disabled. file_get_contents would not work');
}

// if disabled by admin
if(!get_option("enable_user_registration", '1')) {
    page_not_found();
}

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	
    $gender = isset($gpUserProfile['gender'])? $gpUserProfile['gender'] : "male";
    $link = isset($gpUserProfile['link'])? $gpUserProfile['link'] : "";
	//Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
        'gender'        => $gender,
        'link'          => $link
    );

    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );
    $flargePic = file_get_contents($gpUserProfile['picture'], false, stream_context_create($arrContextOptions));
    $upOne = realpath(dirname(__FILE__) . '/../../..');

    $picname = $gpUserProfile['id'].'.jpg';
    $sfile = $upOne.'/storage/profile/small_'.$picname;
    $lfile = $upOne.'/storage/profile/'.$picname;
    file_put_contents($sfile, $flargePic);
    file_put_contents($lfile, $flargePic);

    /* ---- Session Variables -----*/
    $userData = array();
    $userData = checkSocialUser($gpUserData,$picname);

    if(!isset($userData['email']))
    {
        $error = __('Email address does not exist');
        echo "<script type='text/javascript'>alert('$error');</script>";
        redirect_parent($config['site_url'] ."login",true);
    }
    elseif($userData['status'] == 2)
    {
        $error = __('This account has been banned');
        echo "<script type='text/javascript'>alert('$error');</script>";
        redirect_parent($config['site_url'] ."login",true);
    }
    else
    {
        create_user_session($userData['id'],$userData['username'],$userData['password_hash'],$userData['user_type']);

        update_lastactive();

        $redirect_url = get_option('after_login_link');
        if(empty($redirect_url)){
            $redirect_url = $config['site_url'] ."login";
        }

        redirect_parent($redirect_url,true);
    }
} else {
	$authUrl = $gClient->createAuthUrl();
    headerRedirect($authUrl);
}