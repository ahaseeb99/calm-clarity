<?php
overall_header(__("Billing Details"));
?>
<?php print_adsense_code('header_bottom'); ?>
    <!-- Titlebar
    ================================================== -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><?php _e("Billing Details") ?></h2>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs">
                        <ul>
                            <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                            <li><a href="<?php url("MEMBERSHIP") ?>/changeplan"><?php _e("Membership Plan") ?></a></li>
                            <li><?php _e("Billing Details") ?></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div style="overflow: hidden">
                <div class="notification notice"><?php _e("These details will be used in invoice and tax handling.") ?></div>
                <form method="post" accept-charset="UTF-8">
                    <div class="submit-field">
                        <h5><?php _e("Type") ?></h5>
                        <select name="billing_details_type" id="billing_details_type"  class="with-border selectpicker" required>
                            <option value="personal" <?php if($billing_details_type == "personal"){ echo 'selected';} ?> ><?php _e("Personal") ?></option>
                            <option value="business" <?php if($billing_details_type == "business"){ echo 'selected';} ?> ><?php _e("Business") ?></option>
                        </select>
                    </div>
                    <div class="submit-field billing-tax-id">
                        <h5>
                            <?php
                            if($config['invoice_admin_tax_type'] != ""){
                                _esc($config['invoice_admin_tax_type']);
                            }else{
                                _e("Tax ID");
                            }
                            ?>
                        </h5>
                        <input type="text" id="billing_tax_id" name="billing_tax_id" class="with-border" value="<?php _esc($billing_tax_id)?>">
                    </div>
                    <div class="submit-field">
                        <h5><?php _e("Name") ?> *</h5>
                        <input type="text" id="billing_name" name="billing_name" class="with-border" value="<?php _esc($billing_name)?>" required>
                    </div>
                    <div class="submit-field">
                        <h5><?php _e("Address") ?> *</h5>
                        <input type="text" id="billing_address" name="billing_address" class="with-border" value="<?php _esc($billing_address)?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="submit-field">
                                <h5><?php _e("City") ?> *</h5>
                                <input type="text" id="billing_city" name="billing_city" class="with-border" value="<?php _esc($billing_city)?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="submit-field">
                                <h5><?php _e("State") ?> *</h5>
                                <input type="text" id="billing_state" name="billing_state" class="with-border" value="<?php _esc($billing_state)?>" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="submit-field">
                                <h5><?php _e("Zip code") ?> *</h5>
                                <input type="text" id="billing_zipcode" name="billing_zipcode" class="with-border" value="<?php _esc($billing_zipcode)?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="submit-field">
                        <h5><?php _e("Country") ?> *</h5>
                        <select name="billing_country" id="billing_country" class="with-border" required>
                            <?php
                            foreach($countries as $country){
                                ?>
                                <option value="<?php _esc($country['code']) ?>" <?php _esc($country['selected']) ?>><?php _esc($country['asciiname']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" name="billing-submit" class="button ripple-effect"><?php _e("Save and Continue to checkout") ?></button>
                    <?php if(isset($buy_prepaid_plan)){ ?>
                        <input type="hidden" name="buy-prepaid-plan" value="<?php _esc($plan_id)?>">
                    <?php } else { ?>
                    <input type="hidden" name="upgrade" value="<?php _esc($plan_id)?>">
                    <input type="hidden" name="billed-type" value="<?php _esc($billed_type)?>">
                    <?php } ?>
                </form>
        </div>
    </div>
    <div class="margin-top-80"></div>
<script>
    $('#billing_details_type').on('change', function () {
        if($(this).val() == 'business')
            $('.billing-tax-id').slideDown();
        else
            $('.billing-tax-id').slideUp();
    }).trigger('change');
</script>
<?php
overall_footer();