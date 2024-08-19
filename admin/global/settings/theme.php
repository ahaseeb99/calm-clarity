<div class="tab-pane" id="quick_theme_setting">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Theme Setting') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php quick_switch(__('Show membership plan on home page'), 'show_membershipplan_home', (get_option("show_membershipplan_home") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Show partners slider on home page'), 'show_partner_logo_home', (get_option("show_partner_logo_home") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Show newsletter form on home page'), 'show_newsletter_form_home', (get_option("show_newsletter_form_home") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Theme Color:') ?></label>
                            <div>
                                <input name="theme_color" type="color" class="form-control"
                                       value="<?php echo get_option("theme_color"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Meta Keywords:') ?></label>
                            <div>
                                <input name="meta_keywords" type="text" class="form-control"
                                       value="<?php echo get_option("meta_keywords"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Meta Description:') ?></label>
                            <div>
                                <input name="meta_description" type="text" class="form-control"
                                       value="<?php echo get_option("meta_description"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Contact Address:') ?></label>
                            <div>
                                <input name="contact_address" type="text" class="form-control"
                                       value="<?php echo get_option("contact_address"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Contact Email:') ?></label>
                            <div>
                                <input name="contact_email" type="text" class="form-control"
                                       value="<?php echo get_option("contact_email"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Contact Phone:') ?></label>
                            <div>
                                <input name="contact_phone" type="text" class="form-control"
                                       value="<?php echo get_option("contact_phone"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Footer Facebook Page Link:') ?></label>
                            <div>
                                <input name="facebook_link" type="text" class="form-control"
                                       value="<?php echo get_option("facebook_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Footer Twitter Page Link:') ?></label>
                            <div>
                                <input name="twitter_link" type="text" class="form-control"
                                       value="<?php echo get_option("twitter_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Footer Instagram Page Link:') ?></label>
                            <div>
                                <input name="instagram_link" type="text" class="form-control"
                                       value="<?php echo get_option("instagram_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Footer LinkedIn Page Link:') ?></label>
                            <div>
                                <input name="linkedin_link" type="text" class="form-control"
                                       value="<?php echo get_option("linkedin_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Footer Pinterest Page Link:') ?></label>
                            <div>
                                <input name="pinterest_link" type="text" class="form-control"
                                       value="<?php echo get_option("pinterest_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Footer Youtube Page/Video Link:') ?></label>
                            <div>
                                <input name="youtube_link" type="text" class="form-control"
                                       value="<?php echo get_option("youtube_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Copyright text:') ?></label>
                            <div>
                                <input name="copyright_text" type="text" class="form-control"
                                       value="<?php echo get_option("copyright_text"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Footer text:') ?></label>
                            <div>
                                                <textarea name="footer_text"
                                                          class="form-control"><?php echo get_option("footer_text"); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Android APP Link') ?></label>
                            <div>
                                                <input type="url" name="android_app_link"
                                                          class="form-control" value="<?php echo get_option("android_app_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('IOS APP Link') ?></label>
                            <div>
                                                <input type="url" name="ios_app_link"
                                                          class="form-control" value="<?php echo get_option("ios_app_link"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('External Javascript or Css In header:') ?> <i
                                    class="icon-feather-help-circle"
                                    title="<?php _e("You can add Any javascript code and style css. Like Google Analytics code. This code will paste on head part."); ?>"
                                    data-tippy-placement="top"></i></label>
                            <p class="help-block"></p>
                            <div>
                                                <textarea name="external_code" type="text" class="form-control"
                                                          rows="5"><?php echo get_option("external_code"); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="theme_setting" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>