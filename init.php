<?php
/*
   Plugin Name: Easy Analytics for the WordPress Platform
   Description: This plugin serves as a foundational framework for constructing an Analytics dashboard using a PHP Namespace along with Sample Data Generation techniques. This highlights the essential components required for fully leveraging WordPress.
   Version: 1.0
   Author: Daniel Jennings
   Author URI: https://www.jcontechnologies.com/
*/

namespace EasyAnalytics;

if (!defined('ABSPATH')) {
   return;
}
require_once __DIR__ . '/php/HooksHandler.php';
require_once __DIR__ . '/php/setup/Tables.php';
require_once __DIR__ . '/php/setup/Factory.php';
require_once __DIR__ . '/php/Api.php';
register_activation_hook(__FILE__, [__NAMESPACE__ . '\\HooksHandler', 'activate']);
register_deactivation_hook(__FILE__, [__NAMESPACE__ . '\\HooksHandler', 'deactivate']);

new HooksHandler();
new Api();