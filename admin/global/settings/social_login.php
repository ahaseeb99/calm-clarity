<div class="tab-pane" id="quick_social_login_setting">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Social Login Setting') ?></h5>
            </div>
            <div class="card-body">
                <div class="quick-accordion quick-payment-sortable ui-sortable" id="accordion">
                    <!-- Favebook Login -->
                    <div class="card quick-card">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center">
                                <button class="btn btn-link pl-0 ml-1" data-toggle="collapse"
                                        data-target="#facebook" aria-expanded="false"
                                        aria-controls="facebook"
                                        type="button"><?php _e('Facebook Login') ?></button>
                            </h5>
                        </div>
                        <div class="collapse" id="facebook" aria-labelledby="facebook"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php _e('Facebook app id:') ?></label>
                                            <div>
                                                <input name="facebook_app_id" type="text"
                                                       class="form-control"
                                                       value="<?php echo get_option("facebook_app_id"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php _e('Facebook app secret:') ?></label>
                                            <div>
                                                <input name="facebook_app_secret" type="text"
                                                       class="form-control"
                                                       value="<?php echo get_option("facebook_app_secret"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php _e('Facebook callback url:') ?></label>
                                            <p class="help-block"><?php _e('Use this redirect url in facebook app.') ?></p>
                                            <div>
                                                <input type="text" class="form-control" disabled
                                                       value="<?php echo $config['site_url']; ?>includes/social_login/facebook/index.php">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Google Login -->
                    <div class="card quick-card">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center">
                                <button class="btn btn-link pl-0 ml-1" data-toggle="collapse"
                                        data-target="#google" aria-expanded="false"
                                        aria-controls="google" type="button"><?php _e('Google Login') ?>
                                </button>
                            </h5>
                        </div>
                        <div class="collapse" id="google" aria-labelledby="google"
                             data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php _e('Google app id:') ?></label>
                                            <div>
                                                <input name="google_app_id" type="text"
                                                       class="form-control"
                                                       value="<?php echo get_option("google_app_id"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php _e('Google app secret:') ?></label>
                                            <div>
                                                <input name="google_app_secret" type="text"
                                                       class="form-control"
                                                       value="<?php echo get_option("google_app_secret"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php _e('Google callback url:') ?></label>
                                            <div>
                                                <input type="text" class="form-control" disabled
                                                       value="<?php echo $config['site_url']; ?>includes/social_login/google/index.php">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="social_login_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>