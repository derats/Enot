<?php
 /**
 * Example Application
 * @package Example-application
 */

header('Content-Type: text/html; charset=utf-8');

define('_ROOT', __DIR__);
define('_TMP', _ROOT . '/tmp');

include_once 'routes.php';
include_once _ROOT . '/core/coreLoad.class.php';

session_save_path(_TMP . '/sessions');
session_start();

try {
	CoreLoad::init($vendor, $core, $modules);
	Enot::power();
} catch (Exception $e) {
	echo '<h1>' . $e->getMessage() . "</h1>\n";
	echo '<pre>';
	print_r($e->getTrace());
}
