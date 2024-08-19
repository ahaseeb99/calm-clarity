<div class="tab-pane" id="quick_purchase_code">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Purchase Code') ?></h5>
            </div>
            <div class="card-body">
                <?php if (isset($config['purchase_key']) && $config['purchase_key'] != "") { ?>
                    <div class="alert alert-info"><?php _e('Your purchase code is already verified.') ?></div>
                <?php } ?>
                <div class="form-group">
                    <label for="quick_purchase_code"><?php _e('Purchase Code') ?></label>
                    <p>
                        <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-"
                           target="_blank"><?php _e('Do not know your purchase code? Find here.') ?></a>
                    </p>
                    <input id="quick_purchase_code" class="form-control" type="text"
                           name="purchase_key">
                </div>
                <div class="form-group">
                    <label for="buyer_email"><?php _e('Email') ?></label>
                    <input id="buyer_email" class="form-control" type="text" name="buyer_email">
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="valid_purchase_setting" value="1">
                <button type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>