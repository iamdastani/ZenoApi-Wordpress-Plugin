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
add_action('rest_api_init', 'registration_and_login_endpoints');

// Login Function
function registration_and_login_endpoints() {
    register_rest_route('my-app/v1', '/login', array(
        'methods'  => 'POST',
        'callback' => 'handle_login',
    ));

    register_rest_route('my-app/v1', '/register', array(
        'methods'  => 'POST',
        'callback' => 'handle_registration',
    ));
}

// Callback function for login endpoint
function handle_login($request) {
    $params = $request->get_json_params();

    // Retrieve email and password from the request
    $email = isset($params['email']) ? $params['email'] : '';
    $password = isset($params['password']) ? $params['password'] : '';

    // Check if the email and password are provided
    if (empty($email) || empty($password)) {
        return rest_ensure_response(array('message' => 'Email and password are required.'));
    }

    // Perform your login logic here, e.g., authenticate the user
    // and generate an authentication token. For demonstration purposes,
    // we'll return a simple success message.
    return rest_ensure_response(array('message' => 'Login successful.'));
}

// Callback function for registration endpoint
function handle_registration($request) {
    $params = $request->get_json_params();

    // Retrieve name, username, email, and password from the request
    $name = isset($params['name']) ? $params['name'] : '';
    $username = isset($params['username']) ? $params['username'] : '';
    $email = isset($params['email']) ? $params['email'] : '';
    $password = isset($params['password']) ? $params['password'] : '';

    // Check if all required fields are provided
    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        return rest_ensure_response(array('message' => 'All fields are required.'));
    }

    // Create a new user
    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        $error_message = $user_id->get_error_message();
        return rest_ensure_response(array('message' => $error_message));
    }

    // You can perform additional actions here, like sending a welcome email,
    // setting user roles, etc.

    // Response for successful registration
    return rest_ensure_response(array('message' => 'Registration successful.'));
}
