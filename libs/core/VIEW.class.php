<?php
	
/**
* 视图类
*/
class VIEW {
	
	public static $view;

	public static function init($viewtype, $config) {
		self::$view = new $viewtype;
		foreach ($config as $key => $value) {
			self::$view->$key($value);
		}
	}

	public static function assign($data) {
		foreach ($data as $key => $value) {
			self::$view->assign($key,$value);
		}
	}

	public static function display($template) {
		self::$view->display($template);
	}

}

?>