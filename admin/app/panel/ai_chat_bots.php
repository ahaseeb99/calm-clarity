<?php
require_once '../../includes.php';

$info = array(
    'id' => '',
    'name' => '',
    'image' => '',
    'welcome_message' => '',
    'role' => '',
    'prompt' => '',
    'training_data' => '',
    'category_id' => '',
    'active' => '1',
);
if(!empty($_GET['id'])) {
    $info = ORM::for_table($config['db']['pre'] . 'ai_chat_bots')->find_one(validate_input($_GET['id']));
    $info['translations'] = json_decode((string)$info['translations'], true);
}

if(!empty($info['image']))
    $img_url = $config['site_url'].'storage/chat-bots/'.$info['image'];
else
    $img_url = get_avatar_url_by_name($info['name']);

$languages = get_language_list('', 'selected', true);
?>
<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2><?php echo isset($_GET['id']) ? __('Edit Chat Bot') : __('Add Chat Bot'); ?></h2>
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
        <form method="post" data-ajax-action="editAIChatBot" id="sidePanel_form">
            <div class="form-body">
                <?php if(isset($_GET['id'])){ ?>
                    <input type="hidden" name="id" value="<?php _esc($_GET['id'])?>">
                <?php } ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?php _esc($img_url) ?>" width="80" class="rounded" alt="">
                        </div>
                        <div class="col-md-10">
                            <label for="image"><?php _e("Profile Picture"); ?></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image"
                                       accept="image/png, image/gif, image/jpeg">
                                <label class="custom-file-label" for="image"><?php _e("Choose file..."); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name"><?php _e("Name"); ?></label>
                    <input id="name" type="text" class="form-control" name="name" value="<?php _esc($info['name']) ?>">
                </div>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="role">
                        <?php _e('Role') ?>
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
                        <input id="role" type="text" class="form-control" name="role" value="<?php _esc($info['role']) ?>">
                    </div>
                    <?php foreach ($languages as $l) { ?>
                        <div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">
                            <input type="text" class="form-control"
                                   name="translations[<?php _esc($l['code']) ?>][role]"
                                   value="<?php echo !empty($info['translations'][$l['code']]['role']) ? $info['translations'][$l['code']]['role'] : $info['role'] ?>"
                                   required>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="category"><?php _e('Category') ?></label>
                    <select id="category" name="category" class="form-control">
                        <?php
                        $categories = ORM::for_table($config['db']['pre'] . 'ai_chat_bots_categories')
                            ->where('active', '1')
                            ->order_by_asc('position')
                            ->find_array();
                        foreach ($categories as $category) {
                            $category['translations'] = json_decode((string)$category['translations'], true);
                            $title = !empty($category['translations'][$config['lang_code']]['title'])
                                ? $category['translations'][$config['lang_code']]['title']
                                : $category['title'];
                            ?>
                            <option value="<?php _esc($category['id']) ?>" <?php if($category['id'] == $info['category_id']) echo 'selected'; ?>><?php _esc($title) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="welcome_message">
                        <?php _e('Welcome Message') ?>
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
                        <textarea name="welcome_message" rows="2" class="form-control" id="welcome_message"><?php _esc($info['welcome_message']) ?></textarea>
                    </div>
                    <?php foreach ($languages as $l) { ?>
                        <div class="translate-fields translate-fields-<?php _esc($l['code']) ?>" style="display: none">
                            <textarea rows="2" class="form-control"
                                      name="translations[<?php _esc($l['code']) ?>][welcome_message]"><?php echo !empty($info['translations'][$l['code']]['welcome_message']) ? $info['translations'][$l['code']]['welcome_message'] : $info['welcome_message'] ?></textarea>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="prompt"><?php _e("Prompt"); ?></label>
                    <textarea name="prompt" rows="2" class="form-control" id="prompt"><?php _esc($info['prompt']) ?></textarea>
                </div>
                <div class="form-group">
                    <label class="d-flex align-items-end" for="training_data">
                        <?php _e("Training Data (JSON)"); ?>
                        <button id="generate_test_data" class="btn btn-sm btn-secondary ml-auto" type="button"><?php _e("Generate test data"); ?></button>
                    </label>
                    <textarea name="training_data" rows="3" class="form-control" id="training_data" placeholder="<?php _e("Enter training data in json format"); ?>"><?php _esc($info['training_data']) ?></textarea>
                    <small class="form-text"><?php _e("OpenAI uses json format for the chat training data. It is the data of the conversations between the user and the System."); ?> <a href="https://platform.openai.com/docs/guides/gpt/chat-completions-api" target="_blank"><?php _e("More details"); ?></a></small>
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

    $(document).off('click', "#generate_test_data").on('click', "#generate_test_data", function (e) {
        $('#training_data').val(`[
	{
		"role": "user",
		"content": "Who won the world series in 2020?"
	},
	{
		"role": "assistant",
		"content": "The Los Angeles Dodgers won the World Series in 2020."
	},
	{
		"role": "user",
		"content": "Where was it played?"
	}
]`);
    });
</script>