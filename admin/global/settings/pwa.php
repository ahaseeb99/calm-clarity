<div class="tab-pane" id="quick_pwa">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('PWA Setting') ?></h5>
            </div>
            <div class="card-body">
                <?php if(empty(get_option('pwa_icon')) || empty(get_option('pwa_app_name')) || empty(get_option('pwa_short_name'))) { ?>
                <div class="alert alert-danger"><?php _e('Fill all the required details. Without these details the PWA feature will not work.') ?></div>
                <?php } ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Icon') ?> <code>*</code></label>
                            <div class="screenshot">
                                <img class="redux-option-image" width="200"
                                     id="pwa_icon_uploader"
                                     src="<?php _esc($config['site_url']); ?>/storage/logo/<?php echo get_option('pwa_icon') ?>" alt="">
                            </div>
                            <input class="form-control input-sm mb-2" type="file" name="pwa_icon"
                                   onchange="readURL(this,'pwa_icon_uploader')">
                            <span class="help-block"><?php _e('Use 512x512 px Size.') ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pwa_app_name"><?php _e('App Name') ?> <code>*</code></label>
                            <input id="pwa_app_name" class="form-control" type="text" name="pwa_app_name"
                                   value="<?php _esc(get_option("pwa_app_name")); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pwa_short_name"><?php _e('App Short Name') ?> <code>*</code></label>
                            <input id="pwa_short_name" class="form-control" type="text" name="pwa_short_name"
                                   value="<?php _esc(get_option("pwa_short_name")); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pwa_bg_color"><?php _e('Background Color') ?></label>
                            <input id="pwa_bg_color" class="form-control" type="color" name="pwa_bg_color"
                                   value="<?php _esc(get_option("pwa_bg_color", '#ffffff')); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pwa_theme_color"><?php _e('Theme Color') ?></label>
                            <input id="pwa_theme_color" class="form-control" type="color" name="pwa_theme_color"
                                   value="<?php _esc(get_option("pwa_theme_color", '#ffffff')); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="pwa_app_description"><?php _e('App Description') ?></label>
                            <textarea id="pwa_app_description" class="form-control" name="pwa_app_description"><?php _esc(get_option("pwa_app_description")); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="pwa_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>