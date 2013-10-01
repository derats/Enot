<?php
class Statical {

	static $files = array();
	static $_staticDir = 'static/';

	static function load($module, $request) {
		$result = null;
		$files = explode(',', $request);
		if(empty(self::$files)) {
			self::_rglob(_ROOT . '/' . self::$_staticDir . '*');
		}
		foreach ($files as $file) {
			if(array_key_exists($key = self::_key($module, $file), self::$files)) {
				$result .= self::_html($key);
			} elseif(array_key_exists($key = self::_key('vendor', $file), self::$files)) {
				$result .= self::_html($key);
			} elseif(array_key_exists($key = $file, self::$files)) {
				$result .= self::_html($key);
			} else {
				throw new Exception('Statical load failure: ' . $file . print_r(self::$files, 1));
			}
		}
		return $result;		
	}

	static function _key($dir, $file) {
		return $dir . '/' . $file;
	}

	static function _html($key) {
		switch (pathinfo(self::$files[$key], PATHINFO_EXTENSION)) {
			case 'css':
				return '<link rel="stylesheet" type="text/css" href="' . self::$_staticDir . $key . '" />' . "\n";
			case 'js':
				return '<script src="' . self::$_staticDir . $key . '"></script>' . "\n";
			default:
				throw new Exception('Unknown extension on file: ' . $file);
		}
	}


	static function _rglob($path) {
		foreach (glob($path) as $element) {
			if(is_dir($element)) {
				self::_rglob($element . '/*');
			}
			if(is_file($element)) {
				$key = self::_key(basename(dirname($element)), basename($element));
				self::$files[$key] = $element;
			}
		}
	}

}
