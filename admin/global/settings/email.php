<div class="tab-pane" id="quick_email">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Email Setting') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="admin_email">
                                <?php _e('Admin Email') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('This is the email address that the contact and report emails will be sent to.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <input name="admin_email" class="form-control" type="text"
                                       id="admin_email"
                                       value="<?php echo get_option("admin_email"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="from_email">
                                <?php _e('From Email Address') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('This email will be used to send the emails.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <input name="from_email" class="form-control" type="text"
                                       id="from_email"
                                       value="<?php echo get_option("from_email", get_option("admin_email")); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email_type">
                                <?php _e('E-Mail Sending Method') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('E-Mail connection and sending method. SMTP is a commonly used method. But if you have trouble with SMTP connections, you can choose different method.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <p>
                                <strong><?php _e('IMPORTANT:') ?></strong> <?php _e('If you use foreign SMTP accounts on your server you may get SMTP connection errors, if your hosting service provider block foreign e-mail account connections.') ?>
                            </p>
                            <div>
                                <select name="email_type" id="email_type" class="form-control">
                                    <option value="smtp" <?php if (get_option("email_type") == 'smtp') {
                                        echo "selected";
                                    } ?>>SMTP
                                    </option>
                                    <option value="mail" <?php if (get_option("email_type") == 'mail') {
                                        echo "selected";
                                    } ?>>PHPMail
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mt-5">
                            <div class="mailMethod-smtp mailMethods" <?php if ($config['email_type'] != 'smtp') {
                                echo 'style="display: none;"';
                            } ?>>
                                <h4 class="text-warning"><?php _e('SMTP') ?></h4>
                                <hr>
                                <div class="form-group">
                                    <label for="smtp_host">
                                        <?php _e('SMTP Host') ?>
                                        <i class="icon-feather-help-circle"
                                           title="<?php _e('This is the host address for your smtp server, this is only needed if you are using SMTP as the Email Send Type.') ?>"
                                           data-tippy-placement="top"></i>
                                    </label>
                                    <div>
                                        <input name="smtp_host" type="text" class="form-control"
                                               id="smtp_host"
                                               value="<?php echo get_option("smtp_host"); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="smtp_host">
                                        <?php _e('SMTP Port') ?>
                                    </label>
                                    <input name="smtp_port" type="text" class="form-control"
                                           id="smtp_port"
                                           value="<?php echo get_option("smtp_port"); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="smtp_username">
                                        <?php _e('SMTP Username') ?>
                                        <i class="icon-feather-help-circle"
                                           title="<?php _e('This is the username for your smtp server, this is only needed if you are using SMTP as the Email Send Type.') ?>"
                                           data-tippy-placement="top"></i>
                                    </label>
                                    <input name="smtp_username" class="form-control" type="text"
                                           id="smtp_username"
                                           value="<?php echo get_option("smtp_username"); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="smtp_password">
                                        <?php _e('SMTP Password') ?>
                                        <i class="icon-feather-help-circle"
                                           title="<?php _e('This is the password for your smtp server, this is only needed if you are using SMTP as the Email Send Type.') ?>"
                                           data-tippy-placement="top"></i>
                                    </label>
                                    <input name="smtp_password" type="password" class="form-control"
                                           id="smtp_password"
                                           value="<?php echo check_allow() ? get_option("smtp_password") : '***********'; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="smtp_secure">
                                        <?php _e('SMTP Encryption') ?>
                                        <i class="icon-feather-help-circle"
                                           title="<?php _e('If your e-mail service provider supported secure connections, you can choose security method on list.') ?>"
                                           data-tippy-placement="top"></i>
                                    </label>
                                    <select name="smtp_secure" id="smtp_secure"
                                            class="form-control">
                                        <option value="0" <?php if (get_option("smtp_secure") == '0') {
                                            echo "selected";
                                        } ?>><?php _e('Off') ?></option>
                                        <option value="1" <?php if (get_option("smtp_secure") == '1') {
                                            echo "selected";
                                        } ?>><?php _e('SSL') ?></option>
                                        <option value="2" <?php if (get_option("smtp_secure") == '2') {
                                            echo "selected";
                                        } ?>><?php _e('TLS') ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="smtp_auth">
                                        <?php _e('SMTP Auth') ?>
                                        <i class="icon-feather-help-circle"
                                           title="<?php _e('SMTP Authentication, often abbreviated SMTP AUTH, is an extension of the Simple Mail Transfer Protocol whereby an SMTP client may log in using an authentication mechanism chosen among those supported by the SMTP server.') ?>"
                                           data-tippy-placement="top"></i>
                                    </label>
                                    <select name="smtp_auth" id="smtp_auth" class="form-control">
                                        <option value="true" <?php if (get_option("smtp_auth") == 'true') {
                                            echo "selected";
                                        } ?>><?php _e('On') ?></option>
                                        <option value="false" <?php if (get_option("smtp_auth") == 'false') {
                                            echo "selected";
                                        } ?>><?php _e('Off') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="email_setting" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>