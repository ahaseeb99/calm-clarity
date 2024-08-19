<div class="tab-pane" id="quick_testimonials">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Testimonials Setting') ?></h5>
            </div>
            <div class="card-body">
                <?php quick_switch(__('Testimonials'), 'testimonials_enable', (get_option("testimonials_enable") == '1')); ?>
                <?php quick_switch(__('Show On Blog Page'), 'show_testimonials_blog', (get_option("show_testimonials_blog") == '1')); ?>
                <?php quick_switch(__('Show On Home Page'), 'show_testimonials_home', (get_option("show_testimonials_home") == '1')); ?>

            </div>
            <div class="card-footer">
                <input type="hidden" name="testimonials_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>