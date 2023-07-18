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

// REST API endpoint for registration and login
add_action('rest_api_init', 'registration_endpoint' , 'login_endpoint');

// Login Function
function login_endpoint() {
    register_rest_route('my-app/v1', '/login', array(
        'methods'  => 'POST',
        'callback' => 'handle_login',
    ));
}


//Registration Function
function registration_endpoint() {
    register_rest_route('my-app/v1', '/register', array(
        'methods'  => 'POST',
        'callback' => 'handle_registration',
    ));
}

// Callback function for registration endpoint
function handle_registration($request) {
    $params = $request->get_json_params();

     // Retrieve name, username, email, and password from the request
     $name = $params['name'];
     $username = $params['username'];
     $email = $params['email'];
     $password = $params['password'];

      // Check if the email and password are provided
    if (empty($email) || empty($password)) {
        return rest_ensure_response(array('message' => 'Email and password are required.'));


}

// Create a new user
$user_id = wp_create_user($email, $password, $email);
if (is_wp_error($user_id)) {
    $error_message = $user_id->get_error_message();
    return rest_ensure_response(array('message' => $error_message));
}
// Response for successful registration
return rest_ensure_response(array('message' => 'Registration successful.'));
}


