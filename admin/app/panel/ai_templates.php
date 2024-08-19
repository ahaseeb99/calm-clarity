<?php
if (empty($_GET['id'])) {
    _e('Unexpected error, please try again.');
    die();
}

require_once '../../includes.php';

$info = array(
    'id' => '',
    'title' => '',
    'category_id' => '',
    'description' => '',
    'icon' => '',
    'active' => '',
);
$info = ORM::for_table($config['db']['pre'] . 'ai_templates')->find_one(validate_input($_GET['id']));
$info['translations'] = json_decode((string)$info['translations'], true);
$info['settings'] = json_decode((string)$info['settings'], true);

$languages = get_language_list('', 'selected', true);
?>

<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2><?php _e('Edit AI Template'); ?></h2>
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
        <div id="post_error"></div>
        <form name="form2" class="form form-horizontal" method="post" id="sidePanel_form"
              data-ajax-action="editAITemplate">
            <div class="form-body">
                <input type="hidden" name="id" value="<?php _esc($_GET['id']) ?>">
                <div class="form-group">
                    <label class="d-flex align-items-end" for="title">
                        <?php _e('Title') ?>
                        <div class="d-flex align-items-center translate-picker">
                            <i class="fa fa-language"></i>
                            <select class="custom-select custom-select-sm ml-1">
                                <option value="default"><?php _e('Default') ?></option>
                                <?php foreach ($languages as $l) { ?>
                                    <option value="<?php _esc($l['code']) ?>"><?php _esc($l['name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </label>
                    <div class="translate-fields translate-fields-default">
                        <input name="title" id="title" type="text" class="form-control"
                               value="<?php echo $info['title'] ?>">
                    </div>
                    <?php foreach ($languages as $l) { ?>
                        <div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">
                            <input type="text" class="form-control"
                                   name="translations[<?php _esc($l['code']) ?>][title]"
                                   value="<?php echo !empty($info['translations'][$l['code']]['title']) ? $info['translations'][$l['code']]['title'] : $info['title'] ?>"
                                   required>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="icon">
                        <?php _e('Icon') ?>
                        <i class="icon-feather-help-circle" title="<?php _e('You can use FontAwesome icons') ?>"
                           data-tippy-placement="top"></i>
                    </label>
                    <input name="icon" id="icon" type="text" class="form-control" value="<?php echo $info['icon'] ?>">
                </div>
                <div class="form-group">
                    <label for="category"><?php _e('Category') ?></label>
                    <select id="category" name="category" class="form-control">
                        <?php
                        $categories = ORM::for_table($config['db']['pre'] . 'ai_template_categories')
                            ->where('active', '1')
                            ->order_by_asc('position')
                            ->find_array();
                        foreach ($categories as $category) {
                            $category['translations'] = json_decode((string)$category['translations'], true);
                            $title = !empty($category['translations'][$config['lang_code']]['title'])
                                ? $category['translations'][$config['lang_code']]['title']
                                : $category['title'];
                            ?>
                            <option value="<?php _esc($category['id']) ?>" <?php if ($category['id'] == $info['category_id']) echo 'selected'; ?>><?php _esc($title) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="description">
                        <?php _e('Description') ?>
                        <div class="d-flex align-items-center translate-picker">
                            <i class="fa fa-language"></i>
                            <select class="custom-select custom-select-sm ml-1">
                                <option value="default"><?php _e('Default') ?></option>
                                <?php foreach ($languages as $l) { ?>
                                    <option value="<?php _esc($l['code']) ?>"><?php _esc($l['name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </label>
                    <div class="translate-fields translate-fields-default">
                        <textarea name="description" id="description" rows="4" type="text"
                                  class="form-control"><?php echo $info['description'] ?></textarea>
                    </div>
                    <?php foreach ($languages as $l) { ?>
                        <div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">
                            <textarea rows="4" type="text" class="form-control"
                                      name="translations[<?php _esc($l['code']) ?>][description]"><?php echo !empty($info['translations'][$l['code']]['description']) ? $info['translations'][$l['code']]['description'] : $info['description'] ?></textarea>
                        </div>
                    <?php } ?>
                </div>
                <?php quick_switch(__('Active'), 'active', $info['active']); ?>
                <!-- Settings -->
                <h5 class="m-t-35"><?php _e('Settings') ?></h5>
                <hr>
                <p><?php _e('You can enable/disable these fields.'); ?></p>
                <?php quick_switch(__('Language'), 'language', isset($info['settings']['language']) ? $info['settings']['language'] : 1); ?>

                <?php quick_switch(__('Quality type'), 'quality_type', isset($info['settings']['quality_type']) ? $info['settings']['quality_type'] : 1); ?>

                <?php quick_switch(__('Tone of Voice'), 'tone_of_voice', isset($info['settings']['tone_of_voice']) ? $info['settings']['tone_of_voice'] : 1); ?>
            </div>
        </form>
    </div>
</div>
<script>
    // translate picker
    $(document).off('change', ".translate-picker select").on('change', ".translate-picker select", function (e) {
        $('.translate-fields').hide();
        $('.translate-fields-' + $(this).val()).show();
        $('.translate-picker select').val($(this).val());
    });
</script>