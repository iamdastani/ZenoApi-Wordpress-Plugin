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

// Hook function to add logo in WordPress dashboard
function add_plugin_logo() {
    $logo_url = plugins_url( 'logo.png', __FILE__ ); 
    ?>
    <style>
        /* CSS to style the logo */
        #adminmenu #menu-posts-your-custom-post-type .wp-menu-image {
            background: url('<?php echo $logo_url; ?>') no-repeat 6px 6px !important;
        }
    </style>
    <?php
}

// Hook the function to the admin menu
add_action('admin_head', 'add_plugin_logo');

function custom_posts_endpoint() {
    register_rest_route('flutter/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'get_posts_for_flutter',
    ));
}
add_action('rest_api_init', 'custom_posts_endpoint');
function get_posts_for_flutter() {
    $args = array(
        'post_type' => 'post', // Change this if needed
        'posts_per_page' => -1, // Retrieve all posts, you can set a limit
        // Add more parameters if required for post filtering
    );

    $posts = get_posts($args);

    $formatted_posts = array();

    foreach ($posts as $post) {
        setup_postdata($post);

        // Fetch content using ACF function to retrieve 'brk-page-content' field
        $content = get_field('content', $post->ID);
        $content = apply_filters('the_content', $content);
        $content = wp_kses_post($content); // Ensures only allowed HTML tags

        $formatted_posts[] = array(
            'id' => $post->ID,
            'title' => get_the_title($post->ID),
            'content' => $content,
            // Add more fields as needed
        );
    }

    wp_reset_postdata(); // Reset post data

    return new WP_REST_Response($formatted_posts, 200);
}




function get_listings_for_flutter() {
    $args = array(
        'post_type' => 'rz_listing', // Routiz listing post type
        'posts_per_page' => -1,
        // Add more parameters if needed for filtering
    );

    $listings = get_posts($args);

    $formatted_listings = array();

    foreach ($listings as $listing) {
        $image_url = get_the_post_thumbnail_url($listing->ID, 'full'); 
        // Customize this section to structure the data as required for Flutter

        $formatted_listings[] = array(
            'id' => $listing->ID,
            'title' => get_the_title($listing->ID),
            'image_url' => $image_url,

            // Add more fields as needed (e.g., excerpt, custom fields, etc.)
        );
    }

    return new WP_REST_Response($formatted_listings, 200);
}

function register_listing_rest_route() {
    register_rest_route('flutter/v1', '/listings', array(
        'methods' => 'GET',
        'callback' => 'get_listings_for_flutter',
    ));
}
add_action('rest_api_init', 'register_listing_rest_route');

//Tags

function get_tags_for_flutter() {
    $args = array(
        'taxonomy' => 'rz_job-tags', // Taxonomy for your tags
        // You can add more parameters for filtering if needed
    );

    $tags = get_terms($args);

    $formatted_tags = array();

    foreach ($tags as $tag) {
        // Customize this section to structure the tag data as required for Flutter
        $formatted_tags[] = array(
            'id' => $tag->term_id,
            'name' => $tag->name,
            // Add more fields if needed
        );
    }

    return new WP_REST_Response($formatted_tags, 200);
}

function register_tags_rest_route() {
    register_rest_route('flutter/v1', '/tags', array(
        'methods' => 'GET',
        'callback' => 'get_tags_for_flutter',
    ));
}
add_action('rest_api_init', 'register_tags_rest_route');

