<?php
	// 获取当前目录位置
	$currentdir = dirname(__FILE__);
	// 遍历和调用共用文件
	include_once($currentdir.'/include.list.php');
	foreach ($paths as $path) {
		include_once($currentdir.'/'.$path);
	}
	/**
	* 引擎类
	*/
	class PC {
		// 控制器及方法缓存
		public static $controller;
		public static $method;
		private static $config;

		/**
		 * 数据库初始化配置 连接数据库
		 * @return  NULL
		 */
		private static function init_db() {
			DB::init('mysql',self::$config['dbconfig']);
		}

		/**
		 * 初始化模板引擎 并配置参数	
		 * @return NULL
		 */
		private static function init_view() {
			VIEW::init('Smarty',self::$config['viewconfig']);
		}

		/**
		 * 控制器配置 初始化控制器 判断是否传入控制器参数没有默认index
		 * @return NULL
		 */
		private static function init_controller() {
			self::$controller = isset($_GET['controller'])?daddslashes($_GET['controller']):'index';
		}

		/**
		 * 控制器方法配置 判断是否传入参数没有则默认index
		 * @return [type] [description]
		 */
		private static function init_method() {
			self::$method = isset($_GET['method'])?daddslashes($_GET['method']):'index';	
		}

		/**
		 * 引擎运行函数
		 * @param  array $config 传入所有配置
		 * @return          
		 */
		public static function run($config) {
			self::$config = $config;
			self::init_db();
			self::init_view();
			self::init_controller();
			self::init_method();
			C(self::$controller, self::$method);
		}

	}


	
?>