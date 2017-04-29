<?php
	/**
	 * 控制器核心函数
	 * @param string $name   传入控制器名 对拥有该名的控制器进行调用
	 * @param string $method 
	 */
	function C($name,$method){
		require_once('/libs/Controller/'.$name.'Controller.class.php');
		$controller = $name.'Controller';
		$obj = new $controller();
		$obj->$method();
	}

	/**
	 * 模型核心函数
	 * @param string $name 传入为模型名字 对拥有该名的模型进行调用
	 */
	function M($name){
		require_once('/libs/Model/'.$name.'Model.class.php');
		$model = $name.'Model';
		$obj = new $model();
		return $obj;
	}

	/**
	 * 视图核心函数
	 * @param string $name 传入为视图 对拥有该名字的视图进行调用
	 */
	function V($name){
		require_once('/libs/View/'.$name.'View.class.php');
		$view = $name.'View';
		$obj = new $view();
		return $obj;
	}

	/**
	 * 输入数据看是否开启
	 * 所有的 ' (单引号), " (双引号), (反斜线) and 空字符会自动转为含有反斜线的溢出字符 
	 * 没有则对字符串进行转义
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	function daddslashes($str){
		return (!get_magic_quotes_gpc())?addslashes($str):$str;
	}

	/**
	 * 调用第三方插件
	 * @param string $path   第三方插件路径
	 * @param stirng $name   第三方插件名
	 * @param array  $params 第三方参数调用
	 */
	function ORG($path='', $name, $params=array()){
		// path是路径 name是第三方类名 
		// params是该类初始化的时候需要指定、负责的属性,
		// 格式为array(属性名=>属性值,属性名2=>属性值2......)
		require_once('libs/view/'.$path.$name.'.class.php');
		$obj = new $name();
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$obj->$key($value);
			}
		}
		return $obj;
	}	
?>