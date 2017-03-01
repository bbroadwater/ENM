<?php
/*
 Plugin Name: Caching tweaks
 Plugin URI: https://pagely.com
 Description: Limit Ninja Forms sessions to the pages containing a form.
 Author: pagely.com
 Version: 0.0.1
 Author URI: https://pagely.com
 */

add_action(
    "init",
    function() {

        if (class_exists("Ninja_Forms") && method_exists("Ninja_Forms", "instance")) {
            remove_action("init",  array(Ninja_Forms::instance(), 'set_transient_id'), 1);

            if (ob_get_level()) {
                add_action("ninja_forms_display_init", array(Ninja_Forms::instance(), 'set_transient_id'));
            }
        }
    },
    -10
);

