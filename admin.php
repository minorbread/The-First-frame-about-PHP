<?php
	header("Content-type:text/html;charset=utf-8");
	// 调用配置文件
	require_once('config.php');
	// 调用引擎文件
	require_once('pc.php');
	// 跑动引擎
	PC::run($config);

?>