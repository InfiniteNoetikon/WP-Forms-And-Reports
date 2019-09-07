<?php
/*
* @package WP_Forms_and_Reports
*/

/*
Plugin Name: WP Forms and Reports
Plugin URI: #
Description: This form allows you to make beautiful forms and create reports on those form responses. Make sure to read the full documentation page in order to fully understand how to use the plugin.
Version: 1.0.0
Author: Timothy Altemus
Author URI: http://www.LinkedIn.com/in/tdaltemus
License: GNUGPLv3 or Later
Text Domain: Forms-and-Reports
*/

/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <https://www.gnu.org/licenses/>.

Copyright 2019 Timothy Altemus
*/

defined('ABSPATH') or die;

require_once plugin_dir_path(__FILE__) . 'includes/init.php';
if (class_exists('init'))
{
	init::register_service();
}

function activate()
{
	flush_rewrite_rules();
}

function deactivate()
{
	flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'activate');

register_deactivation_hook(__FILE__, 'deactivate');