<?php
/*
Plugin Name: Simple PODS framework UI management plugin
Plugin URI: http://www.lowgravity.pl
Description:  Manages PODS UI functionalities
Author: Kamil Grzegorczyk
Version: 1.0
Author URI: http://lowgravity.pl
*/

// add custom class
require_once('class/LGPodsAdmin.php');

//initialize plugin
add_action('init', array('LGPodsAdmin','initialize_plugin'));