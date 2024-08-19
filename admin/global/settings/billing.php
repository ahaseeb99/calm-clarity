<div class="tab-pane" id="quick_billing_details">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Billing Details') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php quick_switch(__('Enable Tax and Billing'), 'enable_tax_billing', (get_option("enable_tax_billing", 1) == '1'), __('Enable this feature to ask billing details from the user before the payment and allow tax.')); ?>
                    </div>
                    <div class="col-sm-12">
                        <p><?php _e('These details will be used for the invoice.') ?></p>
                        <div class="form-group">
                            <label class=""><?php _e('Invoice Number Prefix') ?></label>
                            <div>
                                <input name="invoice_nr_prefix" type="text" class="form-control"
                                       value="<?php echo get_option("invoice_nr_prefix"); ?>"
                                       placeholder="Ex: INV-">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=""><?php _e('Name') ?></label>
                            <div>
                                <input name="invoice_admin_name" type="text" class="form-control"
                                       value="<?php echo get_option("invoice_admin_name"); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""><?php _e('Email') ?></label>
                                    <div>
                                        <input name="invoice_admin_email" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_email"); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""><?php _e('Phone') ?></label>
                                    <div>
                                        <input name="invoice_admin_phone" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_phone"); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=""><?php _e('Address') ?></label>
                            <div>
                                <input name="invoice_admin_address" type="text" class="form-control"
                                       value="<?php echo get_option("invoice_admin_address"); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""><?php _e('City') ?></label>
                                    <div>
                                        <input name="invoice_admin_city" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_city"); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class=""><?php _e('State/Province') ?></label>
                                    <div>
                                        <input name="invoice_admin_state" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_state"); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class=""><?php _e('ZIP Code') ?></label>
                                    <div>
                                        <input name="invoice_admin_zipcode" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_zipcode"); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=""><?php _e('Country') ?></label>
                            <div>
                                <select class="form-control" name="invoice_admin_country">
                                    <?php
                                    $country = get_country_list();
                                    foreach ($country as $value) {
                                        echo '<option value="' . $value['code'] . '" ' . (($value['code'] == get_option('invoice_admin_country', $config['specific_country'])) ? 'selected' : '') . '>' . $value['asciiname'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""><?php _e('Tax Type') ?></label>
                                    <div>
                                        <input name="invoice_admin_tax_type" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_tax_type"); ?>"
                                               placeholder="Ex: VAT">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""><?php _e('Tax ID') ?></label>
                                    <div>
                                        <input name="invoice_admin_tax_id" type="text"
                                               class="form-control"
                                               value="<?php echo get_option("invoice_admin_tax_id"); ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="billing_details" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>