<div class="tab-pane" id="quick_live_chat">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Live Chat') ?> (Tawk.to)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php quick_switch(__('Enable'), 'enable_live_chat', (get_option("enable_live_chat") == '1')); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tawkto_chat_link"><?php _e('Direct Chat Link') ?></label>
                            <input id="tawkto_chat_link" name="tawkto_chat_link" type="url"
                                   class="form-control"
                                   value="<?php echo get_option("tawkto_chat_link"); ?>">
                            <span class="form-text text-muted"><a
                                    href="https://help.tawk.to/article/direct-chat-link"
                                    target="_blank"><?php _e('You can find here.'); ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php quick_switch(__('Membership Based'), 'tawkto_membership', (get_option("tawkto_membership") == '1'), __('Disable this to allow live chat for all users. Otherwise you need to specify in the Membership plan.')); ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="live_chat_settings" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>