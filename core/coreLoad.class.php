<?php

interface iCoreLoad {
	public static function init($vendor,$core,$modules);
	public static function load($array);
}

class CoreLoad implements iCoreLoad {
	public static function init($vendor,$core,$modules) {
		$include = array_merge($vendor,$core,$modules);
		self::load($include);
	}
	public static function load($include) {
		foreach ($include as $value) {
			if(is_file(_ROOT . $value)) {
				include_once _ROOT . $value;
			} else {
				throw new Exception('file das not exists: ' . $value);
			}
		}
	}
}