# ZenoApi Plugin

The ZenoApi plugin is a WordPress plugin that adds custom login and registration endpoints to the WordPress REST API. This allows developers to have more control over the authentication and user registration process in their WordPress projects.

## Installation

1. Download the plugin files and place them in the `/wp-content/plugins/zeno-api` directory of your WordPress installation.

2. Activate the ZenoApi plugin through the WordPress admin interface.

## Usage

Once the ZenoApi plugin is activated, the following endpoints will be available in the WordPress REST API:

### Login Endpoint

- Endpoint: `https://example.com/wp-json/zeno-api/v1/login`
- Method: POST
- Arguments:
  - `email` (required, email): The user's email address.
  - `password` (required): The user's password.

### Registration Endpoint

- Endpoint: `https://example.com/wp-json/zeno-api/v1/register`
- Method: POST
- Arguments:
  - `name` (required): The user's name.
  - `username` (required, unique): The desired username for the user. Must be unique.
  - `email` (required, email, unique): The user's email address. Must be unique.
  - `password` (required): The user's password.

Please note that the registration endpoint requires unique usernames and email addresses to avoid conflicts with existing users in the WordPress database.

## Customization

If you need to customize the validation rules or add additional functionality to the login and registration endpoints, you can modify the `ZenoApi` class in the `zeno-api.php` file. Refer to the plugin's source code for more details on how to make these modifications.

## Contributions

Contributions to the ZenoApi plugin are welcome! If you find any issues or have suggestions for improvements, please submit an issue or pull request on the [GitHub repository](https://github.com/iamdastani/ZenoApi-Wordpress-Plugin).

## License

The ZenoApi plugin is licensed under the [MIT License](LICENSE.txt).

## Author

The ZenoApi plugin is developed and maintained by [Dastani Ferdinandi](https://github.com/iamdastani).

## Support

If you need assistance or have any questions, please contact [iamdastani@zeno.co.tz](mailto:iamdastani@zeno.co.tz).

