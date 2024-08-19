<div class="tab-pane" id="quick_logo_watermark">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Logo') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Favicon upload-->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Favicon') ?>
                                <code>*</code></label>
                            <div class="screenshot">
                                <img class="redux-option-image" id="favicon_uploader"
                                     src="<?php _esc($config['site_url']); ?>/storage/logo/<?php echo $config['site_favicon'] ?>"
                                     alt="" target="_blank" rel="external">
                            </div>
                            <input class="form-control input-sm" type="file" name="favicon"
                                   onchange="readURL(this,'favicon_uploader')">
                            <span class="help-block"><?php _e('Ideal Size 16x16 PX') ?></span>
                        </div>
                    </div>

                    <!-- Site Logo upload-->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Logo') ?><code>*</code></label>
                            <div class="screenshot"><img class="redux-option-image"
                                                         id="image_logo_uploader"
                                                         src="<?php _esc($config['site_url']); ?>/storage/logo/<?php echo $config['site_logo'] ?>"
                                                         alt="" target="_blank" rel="external">
                            </div>
                            <input class="form-control input-sm" type="file" name="file"
                                   onchange="readURL(this,'image_logo_uploader')">
                            <span class="help-block"><?php _e('Ideal Size 170x60 PX') ?></span>
                        </div>
                    </div>

                    <!-- Site Logo upload-->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Footer Logo') ?>
                                <code>*</code></label>
                            <div class="screenshot"><img class="redux-option-image"
                                                         id="image_flogo_uploader"
                                                         src="<?php _esc($config['site_url']); ?>/storage/logo/<?php echo $config['site_logo_footer'] ?>"
                                                         alt="" target="_blank" rel="external">
                            </div>
                            <input class="form-control input-sm" type="file" name="footer_logo"
                                   onchange="readURL(this,'image_flogo_uploader')">
                            <span class="help-block"><?php _e('Display in the footer') ?></span>
                        </div>
                    </div>

                    <!-- Admin Logo upload-->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Admin Logo') ?></label>
                            <div class="screenshot"><img class="redux-option-image" id="adminlogo"
                                                         src="<?php _esc($config['site_url']); ?>/storage/logo/<?php echo $config['site_admin_logo'] ?>"
                                                         alt="" target="_blank" rel="external">
                            </div>
                            <input class="form-control input-sm" type="file" name="adminlogo"
                                   onchange="readURL(this,'adminlogo')">
                            <span class="help-block"><?php _e('Ideal Size 235x62 PX') ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Meta Image') ?></label>
                            <div class="screenshot"><img class="redux-option-image" id="metaimage"
                                                         src="<?php _esc($config['site_url']); ?>/storage/logo/<?php echo get_option('site_metaimage') ?>"
                                                         alt="" >
                            </div>
                            <input class="form-control input-sm" type="file" name="metaimage"
                                   onchange="readURL(this,'metaimage')">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="logo_watermark" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>