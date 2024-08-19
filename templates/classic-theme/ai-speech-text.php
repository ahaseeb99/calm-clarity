<?php

overall_header(__('Speech to Text'));


?>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <?php
        include_once TEMPLATE_PATH . '/dashboard_sidebar.php';
        ?>
        <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">
                <?php print_adsense_code('header_bottom'); ?>
                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3 class="d-flex align-items-center">
                        <?php _e('Speech to Text') ?>
                        <div class="word-used-wrapper margin-left-10">
                            <i class="icon-feather-bar-chart-2"></i>
                            <?php echo '<i id="quick-speech-left">' .
                                _esc(number_format((float)$total_speech_text_used), 0) . '</i> / ' .
                                ($speech_text_limit == -1
                                    ? __('Unlimited')
                                    : _esc(number_format($speech_text_limit + get_user_option($_SESSION['user']['id'], 'total_speech_available', 0)), 0));
                            ?>
                            <strong><?php _e('Used'); ?></strong>
                        </div>
                    </h3>
                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                            <li><?php _e('Speech to Text') ?></li>
                        </ul>
                    </nav>
                </div>

                <div class="row">
                    <!-- Dashboard Box -->
                    <div class="col-md-4">
                        <form id="speech_to_text" name="speech_to_text" method="post" action="#">
                            <div class="dashboard-box margin-top-0 margin-bottom-30">
                                <!-- Headline -->
                                <div class="headline">
                                    <h3>
                                        <i class="icon-feather-headphones"></i><?php _e('Speech to Text') ?>
                                    </h3>
                                </div>
                                <div class="content with-padding">
                                    <div class="notification small-notification notice"><?php _e('Create audio transcription from a file.') ?></div>
                                    <div>
                                        <div class="submit-field margin-bottom-20">
                                            <h6><?php _e("Title") ?></h6>
                                            <input name="title" type="text" class="with-border small-input quick-text-counter"
                                                   data-maxlength="100">
                                        </div>
                                        <div class="submit-field margin-bottom-20">
                                            <h6><?php _e("Upload Media") ?><span class="form-required">*</span></h6>
                                            <div class="uploadButton margin-top-0">
                                                <input class="uploadButton-input" name="file" type="file" id="upload">
                                                <label class="uploadButton-button ripple-effect" for="upload"><?php _e('Upload Media') ?></label>
                                            </div>
                                            <small><?php _e('.mp3, .mp4, .mpeg, .mpga, .m4a, .wav, .webm allowed.'); ?>&nbsp;<?php _e('Max file size:'); ?> <?php _esc(($speech_text_file_limit == -1
                                                    ? __('Unlimited')
                                                    : number_format($speech_text_file_limit).' MB')) ?></small>
                                        </div>
                                        <div class="submit-field margin-bottom-20">
                                            <h6><?php _e("Language") ?></h6>
                                            <select name="language" id="language"
                                                    class="with-border small-input selectpicker" data-live-search="true">
                                                <option value=""><?php _e('Auto Detect') ?></option>
                                                <option value="af">Afrikaans</option>
                                                <option value="ar">Arabic</option>
                                                <option value="hy">Armenian</option>
                                                <option value="az">Azerbaijani</option>
                                                <option value="be">Belarusian</option>
                                                <option value="bs">Bosnian</option>
                                                <option value="bg">Bulgarian</option>
                                                <option value="ca">Catalan</option>
                                                <option value="zh">Chinese</option>
                                                <option value="hr">Croatian</option>
                                                <option value="cs">Czech</option>
                                                <option value="da">Danish</option>
                                                <option value="nl">Dutch</option>
                                                <option value="en">English</option>
                                                <option value="et">Estonian</option>
                                                <option value="fi">Finnish</option>
                                                <option value="fr">French</option>
                                                <option value="gl">Galician</option>
                                                <option value="de">German</option>
                                                <option value="el">Greek</option>
                                                <option value="he">Hebrew</option>
                                                <option value="hi">Hindi</option>
                                                <option value="hu">Hungarian</option>
                                                <option value="is">Icelandic</option>
                                                <option value="id">Indonesian</option>
                                                <option value="it">Italian</option>
                                                <option value="ja">Japanese</option>
                                                <option value="kn">Kannada</option>
                                                <option value="kk">Kazakh</option>
                                                <option value="ko">Korean</option>
                                                <option value="lv">Latvian</option>
                                                <option value="lt">Lithuanian</option>
                                                <option value="mk">Macedonian</option>
                                                <option value="ms">Malay</option>
                                                <option value="mr">Marathi</option>
                                                <option value="mi">Maori</option>
                                                <option value="ne">Nepali</option>
                                                <option value="no">Norwegian</option>
                                                <option value="fa">Persian</option>
                                                <option value="pl">Polish</option>
                                                <option value="pt">Portuguese</option>
                                                <option value="ro">Romanian</option>
                                                <option value="ru">Russian</option>
                                                <option value="sr">Serbian</option>
                                                <option value="sk">Slovak</option>
                                                <option value="sl">Slovenian</option>
                                                <option value="es">Spanish</option>
                                                <option value="sw">Swahili</option>
                                                <option value="sv">Swedish</option>
                                                <option value="tl">Tagalog</option>
                                                <option value="ta">Tamil</option>
                                                <option value="th">Thai</option>
                                                <option value="tr">Turkish</option>
                                                <option value="uk">Ukrainian</option>
                                                <option value="ur">Urdu</option>
                                                <option value="vi">Vietnamese</option>
                                                <option value="cy">Welsh</option>
                                            </select>
                                        </div>
                                        <div class="submit-field margin-bottom-20">
                                            <h6><?php _e("Audio Description") ?></h6>
                                            <textarea name="description" class="with-border small-input quick-text-counter" data-maxlength="200"></textarea>
                                            <small><?php _e('Describe the speech from the file to help the AI. (Optional)'); ?></small>
                                        </div>
                                        <small class="form-error"></small>
                                        <button type="submit" name="submit"
                                                    class="button ripple-effect full-width"><?php _e("Generate") ?>
                                                <i class="icon-feather-arrow-right"></i></button>
                                        <div class="notification small-notification notice margin-top-5"><?php _e('Audio transcription may takes time due to the file size.') ?></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="dashboard-box margin-top-0 margin-bottom-30">
                            <!-- Headline -->
                            <div class="headline">
                                <h3><i class="fa fa-align-left"></i><?php _e("Generated Result") ?></h3>
                                <div class="margin-left-auto line-height-1">
                                    <a href="#" class="button ripple-effect btn-sm" id="export_to_word"
                                       data-tippy-placement="top"
                                       title="<?php _e("Export as Word Document") ?>"><i class="fa fa-file-word-o"></i></a>
                                    <a href="#" class="button ripple-effect btn-sm" id="export_to_txt"
                                       title="<?php _e("Export as Text File") ?>"
                                       data-tippy-placement="top"><i class="fa fa-file-text-o"></i></a>
                                    <a href="#" class="button ripple-effect btn-sm" id="copy_text"
                                       title="<?php _e("Copy Text") ?>"
                                       data-tippy-placement="top"><i class="fa fa-copy"></i></a>
                                </div>
                            </div>
                            <div class="content with-padding">
                                <div id="content-focus"></div>
                                <textarea name="content" class="tiny-editor"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <?php print_adsense_code('footer_top'); ?>
                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
                <div class="small-footer margin-top-15">
                    <div class="footer-copyright">
                        <?php _esc($config['copyright_text']); ?>
                    </div>
                    <ul class="footer-social-links">
                        <?php
                        if ($config['facebook_link'] != "")
                            echo '<li><a href="' . _esc($config['facebook_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>';
                        if ($config['twitter_link'] != "")
                            echo '<li><a href="' . _esc($config['twitter_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>';
                        if ($config['instagram_link'] != "")
                            echo '<li><a href="' . _esc($config['instagram_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a></li>';
                        if ($config['linkedin_link'] != "")
                            echo '<li><a href="' . _esc($config['linkedin_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>';
                        if ($config['pinterest_link'] != "")
                            echo '<li><a href="' . _esc($config['pinterest_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a></li>';
                        if ($config['youtube_link'] != "")
                            echo '<li><a href="' . _esc($config['youtube_link'], false) . '" target="_blank" rel="nofollow"><i class="fa fa-youtube"></i></a></li>';
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
<?php ob_start() ?>
    <script src="<?php _esc(TEMPLATE_URL); ?>/js/jquery-simple-txt-counter.min.js"></script>
    <script src="<?php _esc($config['site_url'] . $config['admin_folder']); ?>/assets/plugins/tinymce/tinymce.min.js"></script>
    <script>
        // text counter
        $('.quick-text-counter').each(function () {
            var $this = $(this);

            $this.simpleTxtCounter({
                maxLength: $this.data('maxlength'),
                countElem: '<div class="form-text"></div>',
                lineBreak: false,
            });
        });

        // tinymce
        tinymce.init({
            selector: '.tiny-editor',
            min_height: 500,
            resize: true,
            plugins: 'advlist lists table autolink link wordcount fullscreen autoresize',
            toolbar: [
                "blocks | bold italic underline strikethrough | alignleft aligncenter alignright  | link blockquote",
                "undo redo | removeformat | table | bullist numlist | outdent indent"
            ],
            menubar: "",
            // link
            relative_urls: false,
            link_assume_external_targets: true,
            content_style: 'body { font-size:14px }'
        });
    </script>
<?php
$footer_content = ob_get_clean();
include_once TEMPLATE_PATH . '/overall_footer_dashboard.php';