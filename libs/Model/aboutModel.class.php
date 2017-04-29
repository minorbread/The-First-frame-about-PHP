<?php
	

	/**
	* 关于我们模型
	*/
	class aboutModel {
		public function aboutinfo() {
			return file_get_contents('data/about.txt');
		}
	}
?>