<?php
/*
Plugin Name: ZenoApi
Plugin URI: https://zeno.co.tz
Description: Handles custom registration functionality for Zeno Limited.
Version: 1.0
Author: Dastani Ferdinandi
Author URI: https://instagram.com/iamdastani
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zeno-login-plugin
Domain Path: /languages
*/
// REST API endpoint for registration
add_action('rest_api_init', 'registration_endpoint');

function registration_endpoint() {
    register_rest_route('my-app/v1', '/register', array(
        'methods'  => 'POST',
        'callback' => 'handle_registration',
    ));
}

// Callback function for registration endpoint
function handle_registration($request) {
    $params = $request->get_json_params();}
