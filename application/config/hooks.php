<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][] = array(
	'class'    => 'Checkuserloggedin',
	'function' => 'check_user_login',
	'filename' => 'Checkuserloggedin.php',
	'filepath' => 'hooks',
	'params'   => array()
);
$hook['post_controller_constructor'][] = array(
	'class'    => 'Checkadminloggedin',
	'function' => 'check_admin_login',
	'filename' => 'Checkadminloggedin.php',
	'filepath' => 'hooks',
	'params'   => array()
);
$hook['post_controller_constructor'][] = array(
	'class'    => 'Checklogisticloggedin',
	'function' => 'check_logistic_login',
	'filename' => 'Checklogisticloggedin.php',
	'filepath' => 'hooks',
	'params'   => array()
);
