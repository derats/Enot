<?php

class View extends Smarty {

	static $self   = null;
	static $module = null;
	static $script = false;

	static function init($module) {
		if(self::$self === NULL) {
			self::$self = new self($module);
		}
		return self::$self;
	}

	public function __construct($module) {
		parent::__construct();
		$this->force_compile = true; //!
		$this->debugging = false;
		$this->caching = true;
		$this->cache_lifetime = 120;
		$this->plugins_dir = array_merge($this->plugins_dir, array(_ROOT . '/core/'));
		$this->setTemplateDir(_ROOT . '/templates/' . $module)
       		 ->setCompileDir(_TMP . '/templates_c')
       		 ->setCacheDir(_TMP . '/cache');
       	self::$module = $module;
       	$this->assign('module', $module);
	}

	public function display($tpl) {
		self::$script = true;
		$this->assign('func', list(, $caller) = debug_backtrace(false));
		parent::display($tpl . '.tpl');
	}

	public function jquery($selector) {
		return new jquery($selector);
	}

	public function js($src) {
		jquery::$output .= $src;
	}

	public function __destruct() {
		if(!empty(jquery::$output)) {
			if(self::$script) {
				echo "<script>\n",
					 "$(document).ready(function() {\n",
						jquery::$output,
					 "});\n</script>";
			} else {
				//Enot::$logger->flush(); // !!!!
				echo "(function(){ \n" . jquery::$output . "})();\n";
			}
		}
	}
}

class jquery {

	public $selector;
	public $buffer;
	public static $output;

	public function __construct($selector) {
		$this->selector = $selector;
		return $this;
	}

	public function __call($method,$params) {
		$all = null;
		foreach ($params as $value) {
			if($method == 'click') {
				$all .= ','.$value;
				continue;
			}
			if(is_string($value)) {
				$all .= ','.json_encode($value);
			} elseif (is_bool($value)) {
				$all .= $value ? ',true' : ',false';	
			} elseif (is_array($value)) {
				foreach ($value as $_key => $_value) {
					$_all .= '\''.$_key.'\':\''.$_value.'\',';
				}
				$all .= ',{'.trim($_all,',').'}';
				unset($_all);
			}
			 else {
				$all .= ','.$value;	
			}
		}
		$all = trim($all, ',');
		$this->buffer .= empty($this->buffer) ?	"$(\"$this->selector\").$method($all)" : ".$method($all)";
		return $this;
	}
	
	public function __destruct() {
		jquery::$output .= $this->buffer . ";\n";
	}
}