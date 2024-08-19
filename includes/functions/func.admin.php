<?php
/**
 * Check if user can manage admin (Used for demo)
 *
 * @return bool
 */
function check_allow()
{
    if(isset($_SESSION['admin']['id']) && $_SESSION['admin']['id'] == 1)
    {
        return TRUE;
    }
    else
    {
        return TRUE;
    }
}

/**
 * Start admin session
 */
function admin_session_start() {
    define("CAN_REGISTER", "no");
    define("DEFAULT_ROLE", "admin");
    define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}

/**
 * Check admin logged in
 *
 * @return bool|void
 */
function checkloggedadmin(){

    global $config,$password;
    $mysqli = db_connect();
    // Check if all session variables are set
    if (isset($_SESSION['admin']['id'],
        $_SESSION['admin']['username'],
        $_SESSION['admin']['login_string']))
    {
        $user_id = $_SESSION['admin']['id'];
        $login_string = $_SESSION['admin']['login_string'];
        $username = $_SESSION['admin']['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password_hash FROM `".$config['db']['pre']."admins` WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }

    // check user login via cookie, if the session variable expired
    if(!empty($_COOKIE["qarm"])){
        $hash = explode(".", $_COOKIE["qarm"], 2);

        if (count($hash) == 2) {
            $count = ORM::for_table($config['db']['pre'].'admins')
                ->where('id', $hash[0])
                ->count();
            if($count){
                $admin = ORM::for_table($config['db']['pre'].'admins')
                    ->select_many('id','username','password_hash','permission')
                    ->where('id', $hash[0])
                    ->find_one();

                $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                $login_string = hash('sha512', $admin['password_hash'] . $user_browser);
                if (hash_equals($login_string,$hash[1]))
                {
                    // update cookie expire time
                    setcookie("qarm", $admin['id'].".".$login_string, time()+86400*30, "/");
                    // update session data
                    $_SESSION['admin']['id']  = $admin['id'];
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $admin['username']); // XSS protection as we might print this value
                    $_SESSION['admin']['username'] = $username;
                    $_SESSION['admin']['login_string'] = $login_string;

                    // Logged In!!!!
                    return true;
                }
            }
        }
    }

    // Not logged in
    return false;
}

/**
 * Admin login
 *
 * @param string $email
 * @param string $password
 * @return bool|void
 */
function adminlogin($email,$password){

    global $config, $user_id, $username,  $db_password, $where;
    $mysqli = db_connect();

    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

    if(!preg_match("/^[[:alnum:]]+$/", $email))
    {
        if(!preg_match($regex,$email))
        {
            return false;
        }
        else{
            //checking in email
            $where = " WHERE email = ? ";
        }
    }
    else{
        //checking in username
        $where = " WHERE username = ? ";
    }

    // Using prepared statements means that SQL injection is not possible.
    $sql = "SELECT id, username, password_hash, permission 
        FROM `".$config['db']['pre']."admins`
        $where
        LIMIT 1";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $permission);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            // Check if the password in the database matches
            // the password the user submitted. We are using
            // the password_verify function to avoid timing attacks.
            if (password_verify($password, $db_password)) {
                // Password is correct!
                // Login successful.
                $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                $_SESSION['admin']['id']  = $user_id;
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                $_SESSION['admin']['username'] = $username;
                $_SESSION['admin']['login_string'] = hash('sha512', $db_password . $user_browser);

                $_SESSION['admin']['permission']  = $permission;

                setcookie("qarm", $user_id.".".$_SESSION['admin']['login_string'], time()+86400*30, "/");

                return true;

            } else {
                // Password is not correct
                return false;
            }
        } else {
            // No user exists.
            return false;
        }
    }

}

/**
 * @return false|void
 */
function check_purchase_valid(){

    global $config;
    $cron_validation_time = isset($config['cron_validation_time']) ? $config['cron_validation_time'] : time();
    $cron_validation_exec_time = isset($config['cron_validation_exec_time']) ? $config['cron_validation_exec_time'] : "86400";
    if((time()-$cron_validation_exec_time) > $cron_validation_time) {
        ignore_user_abort(1);
        @set_time_limit(0);
        $start_time = time();
        update_option('cron_validation_time',time());
        $status = "";
        $message = "";
        if(isset($config['purchase_key'])){
            $url = "https://bylancer.com/api/api.php?verify-purchase=" . $config['purchase_key'] . "&site_url=". $config['site_url'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            $output = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if ($output['success']) {
                update_option("validation_attempt",0);
                $status = "success";
                $message = 'success';
            } else {
                if(validation_attempt_exceed()){
                    $filename = $config['quickad_secret_file'];
                    $filename = $filename.".php";
                    unlink($filename);
                    delete_option("quickad_secret_file");
                    delete_option("purchase_key");
                }
                $status = "error";
                $message = $output['error'];
            }
        }else{
            if(validation_attempt_exceed()){
                if(isset($config['quickad_secret_file'])){
                    $filename = "admin/".$config['quickad_secret_file'];
                    unlink($filename);
                    delete_option("quickad_secret_file");
                    delete_option("purchase_key");
                }
                $status = "error";
                $message = "Invalid";
            }

        }
        $end_time = (time()-$start_time);
        $valid = "yes";
        $cron_details = "Vaidation: ".$valid."<br>";
        $cron_details.= $status ." : ". $message."<br>";
        $cron_details.= "Cron Took: ".$end_time." seconds";
        log_adm_action('P-C-Validation',$cron_details);
    }
    else {
        return false;
    }
}
check_purchase_valid();

function validation_attempt_exceed(){
    $number = get_option("validation_attempt");
    if($number == NULL){
        $number = 1;
    }else{
        $number++;
    }

    if($number <= 5){
        update_option("validation_attempt",$number);
        return false;
    } else{
        update_option("validation_attempt",0);
        return true;
    }
}

/**
 * Get all variables from the language file
 *
 * @param string $filePath
 * @return array
 */
function getLanguageFileVariable($filePath){
    $lang = array();
    if(file_exists($filePath)){
        include $filePath;
    }
    return $lang;
}

/**
 * Check if new version available
 *
 * @return false|mixed|string|void
 */
function check_update_available(){
    global $config;
    //Check For An Update
    $getVersions = file_get_contents('https://bylancer.com/api/quickad-release-versions.php') or die ('ERROR');
    $versionList = explode("\n", $getVersions);
    foreach ($versionList as $aV) {
        if ($aV > $config['version']) {
            return $aV;
        }
    }
    return false;
}

/**
 * Print switch button
 *
 * @param $title
 * @param $id
 * @param false $checked
 * @param string $hint
 */
function quick_switch($title, $id, $checked = false, $hint = ''){
    ?>
    <div class="form-group">
        <label for="<?php echo $id; ?>"><?php echo $title; ?>
            <?php if(!empty($hint)) { ?>
                <i class="icon-feather-help-circle" title="<?php echo $hint; ?>" data-tippy-placement="top"></i>
            <?php } ?>
        </label>
        <div class="form-toggle-option">
            <div>
                <label for="<?php echo $id; ?>"><?php _e('Enable') ?></label>
            </div>
            <div>
                <input type="hidden" name="<?php echo $id; ?>" value="0">
                <label class="switch switch-sm">
                    <input name="<?php echo $id; ?>" type="checkbox" id="<?php echo $id; ?>" value="1"<?php echo $checked ? ' checked' : ''; ?>>
                    <span class="switch-state"></span>
                </label>
            </div>
        </div>
    </div>
    <?php
}