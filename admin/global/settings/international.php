<div class="tab-pane" id="quick_international">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('International') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="specific_country"><?php _e('Default Country') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('When user first time visit your website. Then the site run for that choosen default country.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <select class="js-select2 w-100 form-control"
                                        name="specific_country"
                                        id="specific_country">
                                    <?php

                                    $country = get_country_list(get_option("specific_country"));
                                    foreach ($country as $value) {
                                        echo '<option value="' . $value['code'] . '" ' . $value['selected'] . '>' . $value['asciiname'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="timezone"><?php _e('Timezone') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('Set your website timezone.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <select name="timezone" id="timezone"
                                        class="js-select2 w-100 form-control">
                                    <?php
                                    $timezone = get_timezone_list(get_option("timezone"));

                                    foreach ($timezone as $value) {
                                        $id = $value['id'];
                                        $country_code = $value['country_code'];
                                        $time_zone_id = $value['time_zone_id'];
                                        $selected = $value['selected'];
                                        echo '<option value="' . $time_zone_id . '" ' . $selected . ' data-tokens="' . $time_zone_id . '">' . $time_zone_id . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="currency"><?php _e('Currency') ?>
                                <i class="icon-feather-help-circle"
                                   title="<?php _e('This is default currecny which used for payment method.') ?>"
                                   data-tippy-placement="top"></i>
                            </label>
                            <div>
                                <select name="currency" id="currency"
                                        class="js-select2 w-100 form-control">
                                    <?php
                                    $currency = get_currency_list(get_option("currency_code"));

                                    foreach ($currency as $value) {
                                        $id = $value['id'];
                                        $code = $value['code'];
                                        $name = $value['name'];
                                        $html_code = $value['html_entity'];
                                        $selected = $value['selected'];

                                        echo '<option value="' . $id . '" ' . $selected . ' data-tokens="' . $name . '">' . $name . ' (' . $html_code . ')</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="inputEmail3"><?php _e('Language') ?></label>
                            <select name="lang" id="lang" class="js-select2 w-100 form-control">
                                <?php
                                $lang_list = get_language_list();

                                foreach ($lang_list as $l) {
                                    $lang_name = $l['name'];
                                    $lang_file_name = $l['file_name'];
                                    $path_of_file = ROOTPATH . '/includes/lang/lang_' . $lang_file_name . '.php';
                                    $selected = "";
                                    if (get_option("lang") == $lang_file_name) {
                                        $selected = "selected";
                                    }

                                    if (file_exists($path_of_file))
                                        echo '<option value="' . $lang_file_name . '" ' . $selected . '>' . $lang_name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php quick_switch(__('Auto Language Detection'), 'browser_lang', get_option('browser_lang'), __("Use visitor's browser language as the default language.")); ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="international" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>