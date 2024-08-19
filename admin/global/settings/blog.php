<div class="tab-pane" id="quick_blog">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Blog Setting') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php quick_switch(__('Blog'), 'blog_enable', (get_option("blog_enable") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Show Blog On Home Page'), 'show_blog_home', (get_option("show_blog_home") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Blog Commenting'), 'blog_comment_enable', (get_option("blog_comment_enable") == '1')); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="blog_page_limit"><?php _e('Number of Blogs on blog page:') ?></label>
                            <input name="blog_page_limit" id="blog_page_limit" type="text"
                                   class="form-control"
                                   value="<?php _esc(get_option('blog_page_limit', 8)) ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Blog Banner Image:') ?></label>
                            <div>
                                <select name="blog_banner" id="blog_banner" class="form-control">
                                    <option <?php if (get_option("blog_banner") == '1') {
                                        echo "selected";
                                    } ?> value="1"><?php _e('Show') ?></option>
                                    <option <?php if (get_option("blog_banner") == '0') {
                                        echo "selected";
                                    } ?> value="0"><?php _e('Hide') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?php _e('Comment Approval:') ?></label>
                            <div>
                                <select name="blog_comment_approval" id="blog_comment_approval"
                                        class="form-control">
                                    <option <?php if (get_option("blog_comment_approval") == '1') {
                                        echo "selected";
                                    } ?> value="1"><?php _e('Disable Auto Approve Comments') ?></option>
                                    <option <?php if (get_option("blog_comment_approval") == '2') {
                                        echo "selected";
                                    } ?> value="2"><?php _e('Auto Approve Login Users Comments') ?></option>
                                    <option <?php if (get_option("blog_comment_approval") == '3') {
                                        echo "selected";
                                    } ?> value="3"><?php _e('Auto Approve All Comments') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>
                                <?php _e('Who Can Comment') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('Non-login users have to enter their name and email address.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <select name="blog_comment_user" id="blog_comment_user"
                                        class="form-control">
                                    <option <?php if (get_option("blog_comment_user") == '1') {
                                        echo "selected";
                                    } ?> value="1"><?php _e('Everyone') ?></option>
                                    <option <?php if (get_option("blog_comment_user") == '0') {
                                        echo "selected";
                                    } ?> value="0"><?php _e('Only Login Users') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="blog_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>