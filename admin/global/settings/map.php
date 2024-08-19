<div class="tab-pane" id="quick_map">
    <form method="post" class="ajax_submit_form" data-action="SaveSettings"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5><?php _e('Map') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="map_type"><?php _e('Map Type (Google/Openstreet)') ?></label>
                            <select name="map_type" id="map_type" class="form-control">
                                <option value="google" <?php if (get_option('map_type') == 'google') {
                                    echo "selected";
                                } ?>><?php _e('Google Map') ?></option>
                                <option value="openstreet" <?php if (get_option('map_type') == 'openstreet') {
                                    echo "selected";
                                } ?>><?php _e('Openstreet Map') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Google Map Color:') ?></label>
                            <div>
                                <input name="map_color" type="color" class="form-control"
                                       value="<?php echo get_option('map_color'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="gmap_api_key"><?php _e('OpenStreet Access Token') ?></label>
                            <p class="help-block"><a
                                    href="https://account.mapbox.com/access-tokens/"
                                    target="_blank"><?php _e('Get MapBox Access Token For OpenStreet Map') ?></a>
                            </p>
                            <input name="openstreet_access_token" class="form-control" type="text"
                                   id="openstreet_access_token"
                                   value="<?php echo get_option('openstreet_access_token'); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="gmap_api_key"><?php _e('Google Map API Key') ?></label>
                            <p class="help-block"><a
                                    href="https://developers.google.com/maps/documentation/javascript/get-api-key"
                                    target="_blank"><?php _e('Get API Key') ?></a></p>
                            <input name="gmap_api_key" class="form-control" type="text"
                                   id="gmap_api_key"
                                   value="<?php echo get_option('gmap_api_key'); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Default Map Latitude:') ?></label>
                            <div>
                                <input name="home_map_latitude" type="text" class="form-control"
                                       value="<?php echo get_option('home_map_latitude'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Default Map Longitude:') ?></label>
                            <div>
                                <input name="home_map_longitude" type="text" class="form-control"
                                       value="<?php echo get_option('home_map_longitude'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Contact Map Latitude:') ?></label>
                            <div>
                                <input name="contact_latitude" type="text" class="form-control"
                                       value="<?php echo get_option('contact_latitude'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class=""><?php _e('Contact Map Longitude:') ?></label>
                            <div>
                                <input name="contact_longitude" type="text" class="form-control"
                                       value="<?php echo get_option('contact_longitude'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="hidden" name="quick_map" value="1">
                <button name="submit" type="submit"
                        class="btn btn-primary"><?php _e('Save') ?></button>
            </div>
        </div>
    </form>
</div>