<div class="tab-pane active" id="quick_settings_general">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('General') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="site_url">
                                <?php _e('Site URL') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('The site url is the url where you installed Script.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <input id="site_url" class="form-control" type="text" name="site_url"
                                   value="<?php _esc(get_option("site_url")); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="site_title">
                                <?php _e('Site Title') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('The site title is what you would like your website to be known as, this will be used in emails and in the title of your webpages.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <input name="site_title" class="form-control" type="text"
                                   id="site_title"
                                   value="<?php echo $config['site_title']; ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Disable Landing Page'), 'disable_landing_page', (get_option("disable_landing_page") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Enable Maintenance Mode'), 'enable_maintenance_mode', (get_option("enable_maintenance_mode") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Enable new users registration'), 'enable_user_registration', (get_option("enable_user_registration", '1') == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Enable FAQs'), 'enable_faqs', (get_option("enable_faqs", '1') == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="default_user_plan"><?php _e('Default Membership Plan for New Users') ?></label>
                            <select name="default_user_plan" id="default_user_plan"
                                    class="form-control">
                                <option value="free" <?php if (get_option("default_user_plan") == 'free') {
                                    echo "selected";
                                } ?>><?php _e('Free') ?></option>
                                <option value="trial" <?php if (get_option("default_user_plan") == 'trial') {
                                    echo "selected";
                                } ?>><?php _e('Trial') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__("Hide pages and features if not in user's plan"), 'hide_plan_disabled_features', (get_option("hide_plan_disabled_features") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="cron_exec_time"><?php _e('Cron job run time (In seconds)') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('Please enter time in seconds for example: 60 = 1 minutes<br>3600 = 1 Hour.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <input name="cron_exec_time" class="form-control" type="text"
                                   id="cron_exec_time"
                                   value="<?php echo $config['cron_exec_time']; ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="site_title"><?php _e('Show/hide Verify Email Message to Non-active Users') ?></label>
                            <select name="non_active_msg" id="non_active_msg" class="form-control">
                                <option value="1" <?php if (get_option("non_active_msg") == '1') {
                                    echo "selected";
                                } ?>>Show
                                </option>
                                <option value="0" <?php if (get_option("non_active_msg") == '0') {
                                    echo "selected";
                                } ?>>Hide
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="site_title"><?php _e('Allow Non-active users to use AI') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('When disallow, an error message will be shown to non-active users to verify their email address.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <select name="non_active_allow" id="non_active_allow"
                                    class="form-control">
                                <option value="1" <?php if (get_option("non_active_allow") == '1') {
                                    echo "selected";
                                } ?>><?php _e('Allow') ?></option>
                                <option value="0" <?php if (get_option("non_active_allow") == '0') {
                                    echo "selected";
                                } ?>><?php _e('Disallow') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputPassword4"><?php _e('Allow User Language Selection') ?></label>
                            <select name="userlangsel" class="form-control" id="userlangsel">
                                <option value="1" <?php if ($config['userlangsel'] == 1) {
                                    echo "selected";
                                } ?>><?php _e('Yes') ?></option>
                                <option value="0" <?php if ($config['userlangsel'] == 0) {
                                    echo "selected";
                                } ?>><?php _e('No') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="transfer_filter"><?php _e('Transfer Filter') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('Whether you should be shown a transfer screen between saving admin pages or not.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <select name="transfer_filter" class="form-control"
                                    id="transfer_filter">
                                <option value="1" <?php if ($config['transfer_filter'] == 1) {
                                    echo "selected";
                                } ?>><?php _e('Yes') ?></option>
                                <option value="0" <?php if ($config['transfer_filter'] == 0) {
                                    echo "selected";
                                } ?>><?php _e('No') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label><?php _e('Term & Condition Page Link') ?></label>
                            <div>
                                <input name="termcondition_link" type="url" class="form-control"
                                       value="<?php echo get_option("termcondition_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Privacy Page Link') ?></label>
                            <div>
                                <input name="privacy_link" type="url" class="form-control"
                                       value="<?php echo get_option("privacy_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Cookie Policy Page Link') ?></label>
                            <div>
                                <input name="cookie_link" type="url" class="form-control"
                                       value="<?php echo get_option("cookie_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('After login redirect page link') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('User will be redirected to this url after login. By default dashboard page link will be used.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <input name="after_login_link" type="url" class="form-control"
                                       value="<?php echo get_option("after_login_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="cookie_consent"><?php _e('Show/hide Cookie Consent Box') ?></label>
                            <select name="cookie_consent" class="form-control" id="userthemesel">
                                <option value="1" <?php if (get_option("cookie_consent") == 1) {
                                    echo "selected";
                                } ?>><?php _e('Show') ?></option>
                                <option value="0" <?php if (get_option("cookie_consent") == 0) {
                                    echo "selected";
                                } ?>><?php _e('Hide') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group <?php if (empty($config['purchase_key'])) {
                            echo "d-none";
                        } ?>">
                            <label for="developer_credit"><?php _e('Show Developer Credit') ?></label>
                            <select name="developer_credit" id="developer_credit"
                                    class="form-control">
                                <option value="1" <?php if ($config['developer_credit'] == 1) {
                                    echo "selected";
                                } ?>><?php _e('Yes') ?></option>
                                <option value="0" <?php if ($config['developer_credit'] == 0) {
                                    echo "selected";
                                } ?>><?php _e('No') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group <?php if ($config['quickad_debug'] == 0) {
                            echo "d-none";
                        } ?> ">
                            <label for="quickad_debug"><?php _e('Enable Developement Mode') ?></label>
                            <select name="quickad_debug" id="quickad_debug" class="form-control">
                                <option value="1" <?php if ($config['quickad_debug'] == 1) {
                                    echo "selected";
                                } ?>><?php _e('Yes') ?></option>
                                <option value="0" <?php if ($config['quickad_debug'] == 0) {
                                    echo "selected";
                                } ?>><?php _e('No') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="general_setting" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>