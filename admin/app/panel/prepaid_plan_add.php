<?php
require_once '../../includes.php';

$info = array(
    'id' => '',
    'status' => '1',
    'name' => '',
    'price' => '0',
    'settings' => json_encode(array(
            'ai_words_limit' => 0,
            'ai_images_limit' => 0,
            'ai_text_to_speech_limit' => 0,
            'ai_speech_to_text_limit' => 0
        )),
    'taxes_ids' => '',
    'active' => '1',
    'recommended' => 'no'
);
if (!empty($_GET['id'])) {
    $info = ORM::for_table($config['db']['pre'] . 'prepaid_plans')
        ->where('id', $_GET['id'])
        ->find_one();
}
$settings = json_decode($info['settings'], true);

?>
<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2><?php echo isset($_GET['id']) ? __('Edit Plan') : __('Add Plan'); ?></h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn-icon btn-primary" title="<?php _e('Save') ?>">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn-icon slidePanel-close" title="<?php _e('Close') ?>">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form method="post" id="sidePanel_form" data-ajax-action="editPrepaidPlan">
            <?php if (isset($_GET['id'])) { ?>
                <input type="hidden" name="id" value="<?php _esc($_GET['id']) ?>">
            <?php } ?>
            <div class="form-body">
                <?php quick_switch(__('Activate'), 'active', ($info['status'] == '1')); ?>
                <div class="form-group">
                    <label for="name"><?php _e('Plan Name') ?>*</label>
                    <input id="name" name="name" type="text" class="form-control" value="<?php _esc($info['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="price"><?php _e('Price') ?>*</label>
                    <input name="price" type="number" class="form-control" id="price"
                           value="<?php _esc($info['price']); ?>">
                </div>
                <?php quick_switch(__('Recommended'), 'recommended', ($info['recommended'] == 'yes')); ?>
                <h5 class="m-t-35"><?php _e('Plan Settings') ?></h5>
                <hr>
                <div class="form-group">
                    <label for="ai_words_limit"><?php _e('AI Words') ?></label>
                    <input name="ai_words_limit" type="number" class="form-control" id="ai_words_limit"
                           value="<?php _esc($settings['ai_words_limit']) ?>">
                </div>
                <div class="form-group">
                    <label for="ai_images_limit"><?php _e('AI Images') ?></label>
                    <input name="ai_images_limit" type="number" class="form-control" id="ai_images_limit"
                           value="<?php _esc($settings['ai_images_limit']) ?>">
                </div>
                <div class="form-group">
                    <label for="ai_speech_to_text_limit"><?php _e('Speech to Text') ?></label>
                    <input name="ai_speech_to_text_limit" type="number" class="form-control"
                           id="ai_speech_to_text_limit" value="<?php _esc($settings['ai_speech_to_text_limit']) ?>">
                </div>
                <div class="form-group">
                    <label for="ai_text_to_speech_limit"><?php _e('Text to Speech Characters') ?></label>
                    <input name="ai_text_to_speech_limit" type="number" class="form-control"
                           id="ai_text_to_speech_limit" value="<?php _esc($settings['ai_text_to_speech_limit']) ?>">
                    <span class="form-text text-muted"><?php _e('Set the characters limit for text to speech.') ?></span>
                </div>

                <h5 class="m-t-35"><?php _e('Taxes') ?></h5>
                <hr>
                <div class="form-group">
                    <label><?php _e('Select Taxes') ?></label>
                    <select class="form-control quick-select2" name="taxes[]" multiple>
                        <?php
                        $plan_taxes = explode(',', (string)$info['taxes_ids']);
                        $taxes = ORM::for_table($config['db']['pre'] . 'taxes')
                            ->find_many();
                        foreach ($taxes as $tax) {
                            $value = ($tax['value_type'] == 'percentage' ? (float)$tax['value'] . '%' : price_format($tax['value']));
                            echo '<option value="' . $tax['id'] . '" ' . (in_array($tax['id'], $plan_taxes) ? 'selected' : '') . '>' . $tax['name'] . ' (' . $value . ')</option>';
                        }
                        ?>
                    </select>
                    <span class="form-text text-muted"><?php _e('Select taxes for this plan.') ?></span>
                </div>
                <input type="hidden" name="submit">
            </div>
        </form>
    </div>
</div>
<script>
    $('.quick-select2').select2();
</script>