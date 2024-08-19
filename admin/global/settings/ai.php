<div class="tab-pane" id="quick_ai_setting">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('AI Settings') ?></h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="bad_words"><?php _e('Bad Words') ?></label>
                    <textarea name="bad_words" id="bad_words" type="text" class="form-control"
                              rows="2"><?php echo get_option("bad_words"); ?></textarea>
                    <span class="form-text text-mute"><?php _e('You can enter bad words seperated by commas to filter every request.'); ?></span>
                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('OpenAI') ?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php quick_switch(__('Use single OpenAI model for all plans'), 'single_model_for_plans', (get_option("single_model_for_plans") == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group open_ai_model">
                                <?php $selected_model = get_option('open_ai_model', 'gpt-3.5-turbo'); ?>
                                <label for="open_ai_model"><?php _e('OpenAI Model') ?></label>
                                <select id="open_ai_model" class="form-control"
                                        name="open_ai_model">
                                    <?php foreach (get_opeai_models() as $key => $model) { ?>
                                        <option value="<?php _esc($key) ?>" <?php echo $key == $selected_model ? 'selected' : '' ?>><?php _esc($model) ?></option>
                                    <?php } ?>
                                </select>
                                <span class="form-text text-muted"><?php _e('Select the AI model for all users.') ?> <a
                                            href="https://platform.openai.com/docs/models/gpt-3"
                                            target="_blank"><?php _e('Read more here.') ?></a></span>
                                <span class="form-text text-warning"><?php _e('ChatGPT 4 (Beta) model is not publicly accessible yet.') ?> <a
                                            href="https://openai.com/waitlist/gpt-4-api"
                                            target="_blank"><?php _e('Contact OpenAI for the access.') ?></a></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="open_ai_api_key"><?php _e('API Key') ?></label>
                                <div>
                                    <?php
                                    $api_keys = ORM::for_table($config['db']['pre'] . 'api_keys')
                                        ->where('active', '1')
                                        ->where('type', 'openai')
                                        ->find_array();
                                    $default_key = get_option('open_ai_api_key');
                                    ?>
                                    <select name="open_ai_api_key" id="open_ai_api_key"
                                            class="form-control" required>
                                        <option value="random" <?php if ('random' == $default_key) echo 'selected'; ?>><?php _e('Use all randomly') ?></option>
                                        <?php foreach ($api_keys as $key) { ?>
                                            <option value="<?php _esc($key['id']) ?>" <?php if ($key['id'] == $default_key) echo 'selected'; ?>><?php _esc($key['title']) ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="form-text text-mute"><a
                                                href="<?php echo ADMINURL ?>app/api-keys.php"
                                                target="_blank"><?php _e('Setup your API keys here'); ?></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable AI Templates'), 'enable_ai_templates', (get_option("enable_ai_templates", 1) == '1')); ?>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ai_languages"><?php _e('Languages') ?></label>
                                <textarea id="ai_languages" name="ai_languages" type="text"
                                          class="form-control"><?php echo get_option("ai_languages"); ?></textarea>
                                <span class="form-text text-mute"><?php _e('Insert languages seperated by commas (in english only).'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_default_lang"><?php _e('Default Language') ?></label>
                                <input id="ai_default_lang" name="ai_default_lang" type="text"
                                       class="form-control"
                                       value="<?php echo get_option("ai_default_lang"); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_default_quality_type"><?php _e('Default Quality type') ?></label>
                                <select name="ai_default_quality_type" id="ai_default_quality_type"
                                        class="form-control" required>
                                    <option value="0.25" <?php if ('0.25' == get_option('ai_default_quality_type')) echo 'selected'; ?>><?php _e('Economy') ?></option>
                                    <option value="0.5" <?php if ('0.5' == get_option('ai_default_quality_type')) echo 'selected'; ?>><?php _e('Average') ?></option>
                                    <option value="0.75" <?php if ('0.75' == get_option('ai_default_quality_type')) echo 'selected'; ?>><?php _e('Good') ?></option>
                                    <option value="1" <?php if ('1' == get_option('ai_default_quality_type')) echo 'selected'; ?>><?php _e('Premium') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_default_tone_voice"><?php _e('Default Tone of Voice') ?></label>
                                <select name="ai_default_tone_voice" id="ai_default_tone_voice"
                                        class="form-control" required>
                                    <option value="funny" <?php if ('funny' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Funny') ?></option>
                                    <option value="casual" <?php if ('casual' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Casual') ?></option>
                                    <option value="excited" <?php if ('excited' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Excited') ?></option>
                                    <option value="professional" <?php if ('professional' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Professional') ?></option>
                                    <option value="witty" <?php if ('witty' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Witty') ?></option>
                                    <option value="sarcastic" <?php if ('witty' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Sarcastic') ?></option>
                                    <option value="feminine" <?php if ('feminine' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Feminine') ?></option>
                                    <option value="masculine" <?php if ('masculine' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Masculine') ?></option>
                                    <option value="bold" <?php if ('bold' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Bold') ?></option>
                                    <option value="dramatic" <?php if ('dramatic' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Dramatic') ?></option>
                                    <option value="gumpy" <?php if ('gumpy' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Gumpy') ?></option>
                                    <option value="secretive" <?php if ('secretive' == get_option('ai_default_tone_voice')) echo 'selected'; ?>><?php _e('Secretive') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_default_max_langth"><?php _e('Default Max Results Length') ?></label>
                                <input id="ai_default_max_langth" name="ai_default_max_langth"
                                       type="number" class="form-control"
                                       value="<?php echo get_option("ai_default_max_langth"); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('AI Image') ?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable AI Image'), 'enable_ai_images', (get_option("enable_ai_images") == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_image_openai_model"><?php _e('OpenAI Model') ?></label>
                                <select name="ai_image_openai_model" id="ai_image_openai_model"
                                        class="form-control" required>
                                    <option value="dall-e-2" <?php if ('dall-e-2' == get_option('ai_image_openai_model')) echo 'selected'; ?>><?php _e('Dall-E 2') ?></option>
                                    <option value="dall-e-3" <?php if ('dall-e-3' == get_option('ai_image_openai_model')) echo 'selected'; ?>><?php _e('Dall-E 3') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_image_api"><?php _e('AI API') ?></label>
                                <select name="ai_image_api" id="ai_image_api"
                                        class="form-control api-type" required>
                                    <option value="openai" <?php if ('openai' == get_option('ai_image_api')) echo 'selected'; ?>><?php _e('OpenAI') ?></option>
                                    <option value="stable-diffusion" <?php if ('stable-diffusion' == get_option('ai_image_api')) echo 'selected'; ?>><?php _e('Stable Diffusion') ?></option>
                                </select>
                                <span class="form-text text-mute"><?php _e('Select the AI to use for generating the images.'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_image_api_key"><?php _e('API Key') ?></label>
                                <?php
                                $api_keys = ORM::for_table($config['db']['pre'] . 'api_keys')
                                    ->where('active', '1')
                                    ->find_array();
                                $default_key = get_option('ai_image_api_key');
                                ?>
                                <select name="ai_image_api_key" id="ai_image_api_key"
                                        class="form-control ai-image-api-key" required>
                                    <option value="random" <?php if ('random' == $default_key) echo 'selected'; ?>><?php _e('Use all randomly') ?></option>
                                    <?php foreach ($api_keys as $key) { ?>
                                        <option value="<?php _esc($key['id']) ?>"
                                                data-type="<?php _esc($key['type']) ?>" <?php if ($key['id'] == $default_key) echo 'selected'; ?>><?php _esc($key['title']) ?></option>
                                    <?php } ?>
                                </select>
                                <span class="form-text text-mute"><a
                                            href="<?php echo ADMINURL ?>app/api-keys.php"
                                            target="_blank"><?php _e('Setup your API keys here'); ?></a></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Show AI Images on Home Page'), 'show_ai_images_home', (get_option("show_ai_images_home") == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_images_home_limit"><?php _e('Number of Images on Home page') ?></label>
                                <input id="ai_images_home_limit" name="ai_images_home_limit"
                                       type="number" class="form-control"
                                       value="<?php echo get_option("ai_images_home_limit"); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('AI Code') ?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable AI Code'), 'enable_ai_code', (get_option("enable_ai_code") == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_code_max_token"><?php _e('Max Results Length (Words)') ?></label>
                                <input id="ai_code_max_token" name="ai_code_max_token" type="number"
                                       class="form-control"
                                       value="<?php echo get_option("ai_code_max_token", '-1'); ?>">
                                <span class="form-text text-mute"><?php _e('Set -1 for no limit.'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('AI Chat') ?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable AI Chat'), 'enable_ai_chat', (get_option("enable_ai_chat") == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group open_ai_model">
                                <label for="open_ai_chat_model"><?php _e('OpenAI Model') ?></label>
                                <select id="open_ai_chat_model" class="form-control" name="open_ai_chat_model">
                                    <?php
                                    $selected_model = get_option('open_ai_chat_model');
                                    foreach (get_opeai_chat_models() as $key => $model) { ?>
                                        <option value="<?php _esc($key) ?>" <?php echo $key == $selected_model ? 'selected' : '' ?>><?php _esc($model) ?></option>
                                    <?php } ?>
                                </select>
                                <span class="form-text text-muted"><?php _e('Select the model for AI Chat.') ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_chat_max_token"><?php _e('Max Results Length (Words)') ?></label>
                                <input id="ai_chat_max_token" name="ai_chat_max_token" type="number"
                                       class="form-control"
                                       value="<?php echo get_option("ai_chat_max_token", '-1'); ?>">
                                <span class="form-text text-mute"><?php _e('Set -1 for no limit.'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable Speech to Text for AI chat'), 'enable_ai_chat_mic', (get_option("enable_ai_chat_mic", 1) == '1'), __('A microphone icon will appear near the send button.')); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable Chat Prompts'), 'enable_ai_chat_prompts', (get_option("enable_ai_chat_prompts", 1) == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable "Enter" to send message'), 'enable_ai_chat_enter_send', (get_option("enable_ai_chat_enter_send", 0) == '1')); ?>
                            <span class="form-text mt-n3 form-group"><?php _e('Configure whether pressing enter sends a message or not') ?></span>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable Default Chat Bot'), 'enable_default_chat_bot', (get_option("enable_default_chat_bot", 1) == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_chat_bot_name"><?php _e('Chat Bot Name') ?></label>
                                <input id="ai_chat_bot_name" name="ai_chat_bot_name" type="text"
                                       class="form-control"
                                       value="<?php echo get_option("ai_chat_bot_name"); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><?php _e('Chat Bot Avatar') ?></label>
                                <input class="form-control input-sm" type="file"
                                       name="chat_bot_avatar"
                                       onchange="readURL(this,'chat_bot_uploader')">
                                <span class="help-block"><?php _e('Ideal Size 90x90 PX') ?></span>
                                <div class="screenshot">
                                    <img class="redux-option-image" id="chat_bot_uploader"
                                         src="<?php _esc($config['site_url']); ?>/storage/profile/<?php echo get_option('chat_bot_avatar') ?>"
                                         alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('Speech to Text') ?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php quick_switch(__('Enable Speech to Text'), 'enable_speech_to_text', (get_option("enable_speech_to_text") == '1')); ?>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('Text to Speech') ?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable Text to Speech'), 'enable_text_to_speech', (get_option("enable_text_to_speech") == '1')); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php quick_switch(__('Enable Text Translation'), 'enable_tts_translation', (get_option("enable_tts_translation") == '1'), __('This will allow the users to translate the text via OpenAI before converting to speech')); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_tts_language"><?php _e('Default Language') ?></label>
                                <select name="ai_tts_language" id="ai_tts_language"
                                        class="form-control" required>
                                    <?php foreach (get_ai_voices() as $language) { ?>
                                        <option value="<?php _esc($language['language_code']) ?>" <?php echo $language['language_code'] == get_option('ai_tts_language') ? 'selected' : '' ?>><?php _esc($language['language']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ai_tts_voice"><?php _e('Default Voice') ?></label>
                                <select id="ai_tts_voice" name="ai_tts_voice" class="form-control" required>
                                    <?php foreach (get_ai_voices() as $language) {
                                        foreach ($language['voices'] as $voice) { ?>
                                            <option value="<?php _esc($voice['voice_id']) ?>"
                                                    class="lang-<?php _esc($language['language_code']) ?>" <?php echo $voice['voice_id'] == get_option('ai_tts_voice') ? 'selected' : '' ?>>
                                                <?php _esc($voice['voice'] . ' (' . $voice['gender'] . ')');
                                                if ($voice['voice_type'] == 'neural')
                                                    _esc(' Neural');

                                                if ($voice['vendor'] == 'gcp')
                                                    _esc(' - Google TTS');
                                                else
                                                    _esc(' - AWS TTS');
                                                ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 pl-4">
                        <h6 class="text-danger"><?php _e('AWS TTS') ?></h6>
                        <hr>
                        <div class="alert alert-info">
                            <h5><?php _e('Instructions') ?></h5>
                            <ol class="m-0">
                                <li><?php _e('Go to <a href="https://console.aws.amazon.com/" class="alert-link" target="_blank">AWS Console</a> page and make sure you are logged in.'); ?></li>
                                <li><?php _e('Go to the <strong>Security credentials</strong> page from your account and generate a new <strong>Access key</strong>.'); ?></li>
                                <li><?php _e('Copy both the Access key and the Access key secret and paste in the below form.'); ?></li>
                            </ol>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php quick_switch(__('AWS TTS'), 'enable_aws_tts', (get_option("enable_aws_tts", get_option('enable_text_to_speech')) == '1')); ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ai_tts_aws_region"><?php _e('AWS Region') ?></label>
                                    <select id="ai_tts_aws_region" name="ai_tts_aws_region" class="form-control">
                                        <option value="us-east-2" <?php echo 'us-east-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>US East (Ohio) - us-east-2</option>
                                        <option value="us-east-1" <?php echo 'us-east-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>US East (N. Virginia) - us-east-1</option>
                                        <option value="us-west-1" <?php echo 'us-west-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>US West (N. California) - us-west-1</option>
                                        <option value="us-west-2" <?php echo 'us-west-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>US West (Oregon) - us-west-2</option>
                                        <option value="af-south-1" <?php echo 'af-south-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Africa (Cape Town) - af-south-1</option>
                                        <option value="ap-east-1" <?php echo 'ap-east-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Hong Kong) - ap-east-1</option>
                                        <option value="ap-south-2" <?php echo 'ap-south-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Hyderabad) - ap-south-2</option>
                                        <option value="ap-southeast-3" <?php echo 'ap-southeast-3' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Jakarta) - ap-southeast-3</option>
                                        <option value="ap-southeast-4" <?php echo 'ap-southeast-4' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Melbourne) - ap-southeast-4</option>
                                        <option value="ap-south-1" <?php echo 'ap-south-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Mumbai) - ap-south-1</option>
                                        <option value="ap-northeast-3" <?php echo 'ap-northeast-3' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Osaka) - ap-northeast-3</option>
                                        <option value="ap-northeast-2" <?php echo 'ap-northeast-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Seoul) - ap-northeast-2</option>
                                        <option value="ap-southeast-1" <?php echo 'ap-southeast-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Singapore) - ap-southeast-1</option>
                                        <option value="ap-southeast-2" <?php echo 'ap-southeast-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Sydney) - ap-southeast-2</option>
                                        <option value="ap-northeast-1" <?php echo 'ap-northeast-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Asia Pacific (Tokyo) - ap-northeast-1</option>
                                        <option value="ca-central-1" <?php echo 'ca-central-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Canada (Central) - ca-central-1</option>
                                        <option value="eu-central-1" <?php echo 'eu-central-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Frankfurt) - eu-central-1</option>
                                        <option value="eu-west-1" <?php echo 'eu-west-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Ireland) - eu-west-1</option>
                                        <option value="eu-west-2" <?php echo 'eu-west-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (London) - eu-west-2</option>
                                        <option value="eu-south-1" <?php echo 'eu-south-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Milan) - eu-south-1</option>
                                        <option value="eu-west-3" <?php echo 'eu-west-3' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Paris) - eu-west-3</option>
                                        <option value="eu-south-2" <?php echo 'eu-south-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Spain) - eu-south-2</option>
                                        <option value="eu-north-1" <?php echo 'eu-north-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Stockholm) - eu-north-1</option>
                                        <option value="eu-central-2" <?php echo 'eu-central-2' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Europe (Zurich) - eu-central-2</option>
                                        <option value="me-south-1" <?php echo 'me-south-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Middle East (Bahrain) - me-south-1</option>
                                        <option value="me-central-1" <?php echo 'me-central-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>Middle East (UAE) - me-central-1</option>
                                        <option value="sa-east-1" <?php echo 'sa-east-1' == get_option('ai_tts_aws_region') ? 'selected' : '' ?>>South America (São Paulo) - sa-east-1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ai_tts_aws_access_key"><?php _e('AWS Access Key') ?></label>
                                    <input id="ai_tts_aws_access_key" name="ai_tts_aws_access_key"
                                           type="text" class="form-control"
                                           value="<?php echo check_allow() ? get_option("ai_tts_aws_access_key") : '***********'; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ai_tts_aws_secret_key"><?php _e('AWS Secret Key') ?></label>
                                    <input id="ai_tts_aws_secret_key" name="ai_tts_aws_secret_key"
                                           type="text" class="form-control"
                                           value="<?php echo check_allow() ? get_option("ai_tts_aws_secret_key") : '***********'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 pl-4">
                        <h6 class="text-danger"><?php _e('Google TTS') ?></h6>
                        <hr>
                        <div class="alert alert-info">
                            <h5><?php _e('Instructions') ?></h5>
                            <ol class="m-0">
                                <li><?php _e('Go to <a href="https://cloud.google.com" class="alert-link" target="_blank">Google Cloud</a> page and make sure you are logged in.'); ?></li>
                                <li><?php _e('<a href="https://cloud.google.com/text-to-speech/docs/before-you-begin" class="alert-link" target="_blank">Follow these instructions</a> - '); ?>
                                    <ol type="a">
                                        <li><?php _e('Create a project.'); ?></li>
                                        <li><?php _e('Enable text-to-speech API and enable billing.'); ?></li>
                                        <li><?php _e('Create a service account.'); ?></li>
                                        <li><?php _e('Create a JSON key for your app and download the JSON file.'); ?></li>
                                    </ol>
                                </li>
                                <li><?php _e('Upload the JSON file to the <strong>"storage"</strong> folder of the Website root directory.'); ?></li>
                                <li><?php _e('Enter the name of the JSON file in the below field. (Ex. quickai-234a3s3-dfasdf7adsfa2.json)'); ?></li>
                            </ol>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php quick_switch(__('Google TTS'), 'enable_google_tts', (get_option("enable_google_tts") == '1')); ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ai_tts_google_json_path"><?php _e('GCS File (JSON) Name') ?></label>
                                    <input id="ai_tts_google_json_path" name="ai_tts_google_json_path"
                                           type="text" class="form-control"
                                           value="<?php echo check_allow() ? get_option("ai_tts_google_json_path") : '***********'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-primary"><?php _e('Proxies') ?></h4>
                    <hr>
                    <p><?php _e('You can setup the proxies here for the API requests to hide your identity. You can enter multiple values separated by commas.'); ?></p>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                                <textarea id="ai_proxies" title="" name="ai_proxies"
                                                          class="form-control"
                                                          placeholder="http://username:password@ip:port"><?php echo get_option("ai_proxies"); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="ai_settings" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>