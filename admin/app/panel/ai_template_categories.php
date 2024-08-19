<?php
require_once '../../includes.php';

$info = array(
    'id' => '',
    'title' => '',
    'active' => '1',
);
if(!empty($_GET['id'])) {
    $info = ORM::for_table($config['db']['pre'] . 'ai_template_categories')->find_one(validate_input($_GET['id']));
    $info['translations'] = json_decode((string) $info['translations'], true);
}

$languages = get_language_list('','selected',true);
?>

<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2><?php echo isset($_GET['id']) ? __('Edit Category') : __('Add Category'); ?></h2>
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
        <form name="form2"  class="form form-horizontal" method="post" id="sidePanel_form"
              data-ajax-action="editAITplCategory" >
            <div class="form-body">
                <?php if(isset($_GET['id'])){ ?>
                    <input type="hidden" name="id" value="<?php _esc($_GET['id'])?>">
                <?php } ?>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="title">
                        <?php _e('Title') ?> *
                        <div class="d-flex align-items-center translate-picker">
                            <i class="fa fa-language"></i>
                            <select class="custom-select custom-select-sm ml-1">
                                <option value="default"><?php _e('Default') ?></option>
                                <?php foreach ($languages as $l){ ?>
                                    <option value="<?php _esc($l['code']) ?>"><?php _esc($l['name']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </label>
                    <div class="translate-fields translate-fields-default">
                    <input name="title" id="title" type="text" class="form-control" value="<?php echo $info['title'] ?>" required>
                    </div>
                    <?php foreach ($languages as $l){ ?>
                    <div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">
                        <input type="text" class="form-control"
                                name="translations[<?php _esc($l['code']) ?>][title]"
                               value="<?php echo !empty($info['translations'][$l['code']]['title']) ? $info['translations'][$l['code']]['title'] : $info['title']?>" required>
                    </div>
                    <?php } ?>
                </div>
                <?php
                quick_switch(__('Active'),'active', $info['active']); ?>
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