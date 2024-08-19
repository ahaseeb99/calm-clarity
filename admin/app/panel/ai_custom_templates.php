<?php
require_once '../../includes.php';

$info = array(
    'id' => '',
    'title' => '',
    'slug' => '',
    'category_id' => '',
    'description' => '',
    'prompt' => '',
    'icon' => 'fa fa-check-square',
    'active' => '1',
    'parameters' => '[{"title":"Text","type":"text","placeholder":"","options":""}]',
);
if (!empty($_GET['id'])) {
    $info = ORM::for_table($config['db']['pre'] . 'ai_custom_templates')->find_one(validate_input($_GET['id']));
    $info['translations'] = json_decode((string)$info['translations'], true);
    $info['settings'] = json_decode((string)$info['settings'], true);
}

$languages = get_language_list('', 'selected', true);
?>

<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2><?php echo isset($_GET['id']) ? __('Edit Custom Template') : __('Add Custom Template'); ?></h2>
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
              data-ajax-action="editAICustomTemplate">
            <div class="form-body">
                <?php if (isset($_GET['id'])) { ?>
                    <input type="hidden" name="id" value="<?php _esc($_GET['id']) ?>">
                <?php } ?>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="title">
                        <?php _e('Title') ?> *
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
                    <label for="slug"><?php _e('Slug') ?></label>
                    <input name="slug" id="slug" type="text" class="form-control" value="<?php echo $info['slug'] ?>">
                    <small class="form-text text-muted"><?php _e('Use only alphanumeric value without space. (Hyphen(-) allow).'); ?></small>
                    <small class="form-text text-muted"><?php _e('Slug will be used for the template url.'); ?></small>
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
                    <label for="category"><?php _e('Category') ?> *</label>
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
                        <?php _e('Description') ?> *
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
                            <textarea rows="4" class="form-control"
                                      name="translations[<?php _esc($l['code']) ?>][description]"><?php echo !empty($info['translations'][$l['code']]['description']) ? $info['translations'][$l['code']]['description'] : $info['description'] ?></textarea>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="prompt"><?php _e('Prompt') ?> *</label>
                    <textarea name="prompt" id="prompt" rows="4" type="text" class="form-control"
                              required><?php echo $info['prompt'] ?></textarea>
                    <small>
                        <?php _e('Use {{input title}} shortcode in the prompt for the custom input value') ?>
                        <br>
                        <?php _e("Custom input value will be automatically added at the end of the prompt if you do not add the shortcode in the prompt. It is beneficial for the option inputs.") ?>
                    </small>
                </div>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="description">
                        <?php _e('Custom Inputs') ?> *
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
                    <div class="custom-inputs">
                        <?php
                        if (!empty($info['parameters'])) {
                            $parameters = json_decode($info['parameters'], true);
                            foreach ($parameters as $key => $parameter) {
                                ?>
                                <div class="custom-input-wrapper mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <!-- translate field -->
                                        <div class="translate-fields translate-fields-default mr-1">
                                            <input class="form-control" title="<?php _e('Title') ?>"
                                                   name="parameter_title[<?php _esc($key) ?>]" type="text"
                                                   placeholder="<?php _e('Title') ?>"
                                                   value="<?php _esc($parameter['title']) ?>">
                                        </div>
                                        <?php foreach ($languages as $l) { ?>
                                            <div class="translate-fields translate-fields-<?php _esc($l['code']) ?> mr-1"
                                                 style="display: none">
                                                <input class="form-control" title="<?php _e('Title') ?>"
                                                       name="parameter_translations[<?php _esc($key) ?>][<?php _esc($l['code']) ?>][title]"
                                                       type="text" placeholder="<?php _e('Title') ?>"
                                                       value="<?php echo !empty($parameter['translations'][$l['code']]['title']) ? $parameter['translations'][$l['code']]['title'] : $parameter['title'] ?>">
                                            </div>
                                        <?php } ?>
                                        <!-- /translate field -->
                                        <select class="form-control mr-2 field-type"
                                                title="<?php _e('Select Field Type') ?>" name="parameter_type[]">
                                            <option value="text" <?php echo 'text' == $parameter['type'] ? 'selected' : '' ?>><?php _e('Text Field') ?></option>
                                            <option value="textarea" <?php echo 'textarea' == $parameter['type'] ? 'selected' : '' ?>><?php _e('Textarea Field') ?></option>
                                            <option value="select" <?php echo 'select' == $parameter['type'] ? 'selected' : '' ?>><?php _e('Select List Field') ?></option>
                                        </select>
                                        <div class="mr-2" title="<?php _e('Mark as Required') ?>" data-tippy-placement="top">
                                        <label class="switch switch-sm">
                                            <input name="parameter_required[<?php _esc($key) ?>]"  type="checkbox"  value="1"<?php echo !empty($parameter['required']) ? ' checked' : ''; ?>>
                                            <span class="switch-state"></span>
                                        </label>
                                        </div>
                                        <a href="#" class="text-danger delete-parameter" title="<?php _e('Delete') ?>"
                                           data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                    </div>
                                    <!-- translate field -->
                                    <div class="translate-fields translate-fields-default">
                                        <input class="form-control mr-1 placeholder-field"
                                               title="<?php _e('Placeholder') ?>"
                                               name="parameter_placeholder[<?php _esc($key) ?>]" type="text"
                                               placeholder="<?php _e('Placeholder') ?>"
                                               value="<?php _esc($parameter['placeholder']) ?>" <?php echo $parameter['type'] == 'select' ? 'style="display: none"' : ''; ?>>
                                        <div class="options-field" <?php echo $parameter['type'] != 'select' ? 'style="display: none"' : ''; ?>>
                                            <input class="form-control mr-1" title="<?php _e('options') ?>"
                                                   name="parameter_options[<?php _esc($key) ?>]" type="text"
                                                   placeholder="<?php _e('Options') ?>"
                                                   value="<?php _esc($parameter['options']) ?>">
                                            <small class="text-muted"><?php _e('Enter comma separated values for the select list.') ?></small>
                                        </div>
                                    </div>
                                    <?php foreach ($languages as $l) { ?>
                                        <div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">
                                            <input class="form-control mr-1 placeholder-field"
                                                   title="<?php _e('Placeholder') ?>"
                                                   name="parameter_translations[<?php _esc($key) ?>][<?php _esc($l['code']) ?>][placeholder]"
                                                   type="text"
                                                   placeholder="<?php _e('Placeholder') ?>"
                                                   value="<?php echo !empty($parameter['translations'][$l['code']]['placeholder'])
                                                       ? $parameter['translations'][$l['code']]['placeholder']
                                                       : $parameter['placeholder'] ?>"
                                                <?php echo $parameter['type'] == 'select' ? 'style="display: none"' : ''; ?>>

                                            <div class="options-field" <?php echo $parameter['type'] != 'select' ? 'style="display: none"' : ''; ?>>
                                                <input class="form-control mr-1" title="<?php _e('options') ?>"
                                                       name="parameter_translations[<?php _esc($key) ?>][<?php _esc($l['code']) ?>][options]" type="text"
                                                       placeholder="<?php _e('Options') ?>"
                                                       value="<?php echo !empty($parameter['translations'][$l['code']]['options']) ? $parameter['translations'][$l['code']]['options'] : $parameter['options'] ?>">
                                                <small class="text-muted"><?php _e('Enter comma separated values for the select list.') ?></small>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- /translate field -->
                                </div>
                            <?php }
                        } ?>
                    </div>
                    <button class="btn btn-primary btn-sm" type="button" id="add-parameter"><i
                                class="icon-feather-plus"></i> <?php _e('Add Field'); ?></button>
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
    $('#add-parameter').off('click').on('click', function (e) {
        e.preventDefault();
        let key = $('.custom-inputs > div').length;
        $('.custom-inputs').append(
            $('<div class="custom-input-wrapper mb-3">' +
                '<div class="d-flex align-items-center mb-1">' +
                // translation fields
                '<div class="translate-fields translate-fields-default mr-1">' +
                '<input class="form-control" title="<?php _e('Title') ?>" name="parameter_title['+key+']" type="text" placeholder="<?php _e('Title') ?>">' +
                '</div>' +
                <?php foreach ($languages as $l) { ?>
                '<div class="translate-fields translate-fields-<?php _esc($l['code']) ?> mr-1" style="display: none">' +
                `<input class="form-control" title="<?php _e('Title') ?>"
                           name="parameter_translations[`+key+`][<?php _esc($l['code']) ?>][title]"
                           type="text" placeholder="<?php _e('Title') ?>">` +
                '</div>' +
                <?php } ?>
                // /translation fields
                '<select class="form-control field-type mr-2" title="<?php _e('Select Field Type') ?>" name="parameter_type['+key+']">' +
                '<option value="text"><?php _e('Text Field') ?></option>' +
                '<option value="textarea"><?php _e('Textarea Field') ?></option>' +
                '<option value="select"><?php _e('Select List Field') ?></option></select>' +
                `<div class="mr-2" title="<?php _e('Mark as Required') ?>" data-tippy-placement="top">
                    <label class="switch switch-sm">
                        <input name="parameter_required[`+key+`]"  type="checkbox"  value="1" checked>
                        <span class="switch-state"></span>
                    </label>
                </div>` +
                '<a href="#" class="text-danger delete-parameter" title="<?php _e('Delete') ?>" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>' +
                '</div>' +
                // translation fields
                '<div class="translate-fields translate-fields-default">' +
                `<input class="form-control mr-1 placeholder-field"
                title="<?php _e('Placeholder') ?>"
                name="parameter_placeholder[`+key+`]" type="text"
                placeholder="<?php _e('Placeholder') ?>"
                value="">
                <div class="options-field" style="display: none"'>
                <input class="form-control mr-1" title="<?php _e('options') ?>" name="parameter_options[`+key+`]" type="text" placeholder="<?php _e('Options') ?>" value="">` +
                '<small class="text-muted"><?php echo escape(__('Enter comma separated values for the select list.')) ?></small>' +
                '</div>' +
                '</div>' +
                <?php foreach ($languages as $l) { ?>
                '<div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">' +
                `<input class="form-control mr-1 placeholder-field"
                title="<?php _e('Placeholder') ?>"
                name="parameter_translations[`+key+`][<?php _esc($l['code']) ?>][placeholder]" type="text"
                placeholder="<?php _e('Placeholder') ?>"
                value="">
                <div class="options-field" style="display: none"'>
                <input class="form-control mr-1" title="<?php _e('options') ?>" name="parameter_translations[`+key+`][<?php _esc($l['code']) ?>][options]" type="text" placeholder="<?php _e('Options') ?>" value="">` +
                '<small class="text-muted"><?php echo escape(__('Enter comma separated values for the select list.')) ?></small>' +
                '</div>' +
                '</div>' +
                <?php } ?>
                // /translation fields
                '</div>')
        );
    });

    $('.custom-inputs').on('click', '.delete-parameter', function (e) {
        e.preventDefault();
        $(this).parents('.custom-input-wrapper').remove();
    })

        .on('change', '.field-type', function (e) {
            if ($(this).val() == 'select') {
                $(this).parents('.custom-input-wrapper').find('.placeholder-field').hide();
                $(this).parents('.custom-input-wrapper').find('.options-field').show();
            } else {
                $(this).parents('.custom-input-wrapper').find('.placeholder-field').show();
                $(this).parents('.custom-input-wrapper').find('.options-field').hide();
            }
        });

    // translate picker
    $(document).off('change', ".translate-picker select").on('change', ".translate-picker select", function (e) {
        $('.translate-fields').hide();
        $('.translate-fields-' + $(this).val()).show();
        $('.translate-picker select').val($(this).val());
    });
</script>