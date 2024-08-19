<div class="tab-pane" id="quick_affiliate_settings">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Affiliate Program') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php quick_switch(__('Enable'), 'enable_affiliate_program', (get_option("enable_affiliate_program") == '1')); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="affiliate_rule"><?php _e('Affiliate Rule') ?></label>
                            <div>
                                <select name="affiliate_rule" id="affiliate_rule"
                                        class="form-control" required>
                                    <option value="first" <?php if ('first' == get_option('affiliate_rule')) echo 'selected'; ?>><?php _e('Only The First Purchase') ?></option>
                                    <option value="all" <?php if ('all' == get_option('affiliate_rule')) echo 'selected'; ?>><?php _e('All Purchases') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""><?php _e('Commission Rate (%)') ?></label>
                            <div>
                                <input name="affiliate_commission_rate" type="number"
                                       class="form-control"
                                       value="<?php echo get_option("affiliate_commission_rate", 30); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php quick_switch(__('Allow Payouts'), 'allow_affiliate_payouts', (get_option("allow_affiliate_payouts", 1) == '1'), __('If disabled, users can use the wallet amount to upgrade their membership.')); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""><?php _e('Minimum Payout Amount') ?>
                                (<?php _esc($config['currency_code']) ?>)</label>
                            <div>
                                <input name="affiliate_minimum_payout" type="number"
                                       class="form-control"
                                       value="<?php echo get_option("affiliate_minimum_payout", 50); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="affiliate_payout_methods"><?php _e('Payout methods') ?></label>
                            <textarea id="affiliate_payout_methods" name="affiliate_payout_methods"
                                      class="form-control"><?= get_option("affiliate_payout_methods", "Paypal, Bank Deposit"); ?></textarea>
                            <span class="form-text text-mute"><?php _e('Enter payment gateways for payout, separated by commas.'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="affiliate_program_settings" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>