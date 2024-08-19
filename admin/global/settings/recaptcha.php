<div class="tab-pane" id="quick_recaptcha">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Google reCAPTCHA') ?></h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <h5 class="quick-bold"><?php _e('Instructions') ?></h5>
                    <p><?php _e('To find your Site Key and Secret Key, follow the below steps:') ?></p>
                    <ol>
                        <li><?php _e('Go to the <a href="https://www.google.com/recaptcha/admin/create" target="_blank">Google reCAPTCHA</a> and register a new site.') ?></li>
                        <li><?php _e("Enter label and select <strong>reCAPTCHA v2</strong> -> <strong>\"I'm not a robot\" Checkbox</strong> in <strong>reCAPTCHA type</strong> field.") ?></li>
                        <li><?php _e('Enter your domain url.') ?></li>
                        <li><?php _e('Accept Terms of Service and click on the <strong>Submit</strong> button.') ?></li>
                        <li><?php _e('Look for the <strong>Site Key</strong> and <strong>Secret Key</strong>. Use them in the form below on this page.') ?></li>
                        <li><?php _e('Enable Google reCAPTCHA and click on the <strong>Save</strong> button.') ?></li>
                    </ol>
                </div>
                <?php quick_switch(__('Google reCAPTCHA'), 'recaptcha_mode', (get_option("recaptcha_mode") == '1')); ?>

                <div class="form-group">
                    <label><?php _e('Public Key:') ?></label>
                    <div>
                        <input name="recaptcha_public_key" type="text" class="form-control"
                               value="<?php echo get_option("recaptcha_public_key"); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label><?php _e('Private Key:') ?></label>
                    <div>
                        <input name="recaptcha_private_key" type="text" class="form-control"
                               value="<?php echo get_option("recaptcha_private_key"); ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="recaptcha_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>