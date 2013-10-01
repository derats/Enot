<?php
interface iEnot {
	public static function power();
}

class Enot implements iEnot {

	public $view;
	public $model;
	public static $memcache;
	public static $logger;
	public static $module;
	public static $action;

	public static function power() {

		self::$module = empty($_REQUEST['page']) ? 'Search' : ucfirst(trim($_REQUEST['page']));
		self::$action = empty($_REQUEST['action']) ? 'default_action' : trim($_REQUEST['action']);

		if (class_exists($controller = self::$module . '_Controller')) {
			$module = new $controller;
			if (method_exists($module, self::$action)) {
				$check = new ReflectionMethod($module, self::$action);
				if ($check->isPublic() && (!$check->isConstructor() && !$check->isDestructor())) {
					$module->{self::$action}();
				} else {
				throw new Exception('Bad request');
				}
			} else {
			throw new Exception('Method das not existen!');
			}
		} else {
			throw new Exception('Module "' . self::$module . '" das not existen!');
		}
	}

	public function __construct() {
		$this->view = View::init(strtolower(self::$module));
		if(class_exists($model = self::$module . '_Model')) {
			$this->model = new $model;
		}
		self::$logger = &Log::singleton('firebug', '',
                          'ENOT',
                          array('buffering' => true),
                          PEAR_LOG_DEBUG);
		self::$memcache = new Memcache;
		if(!self::$memcache->connect('localhost', 11211))
			throw new Exception('Memcache aus!');
	}

	public function log($msg) {
		self::$logger->log($msg);
	}

	public function default_action() {
		echo '<h1><center>ENOT POWER!</center></h1>';
	}
}
