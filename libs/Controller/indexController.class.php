<?php
	/**
	* 主页控制器
	*/
	class indexController
	{	
		/**
		 * 调用关于视图与模型
		 * @return NULL
		 */
		private function showabout() {
			$data = M('about')->aboutinfo();
			VIEW::assign(array('about'=>$data));
		}

		/**
		 * 主页 调用新闻模型 并返回模型方法查询结果 输入到视图中
		 * @return [type] [description]
		 */
		public function index() {
			$newsobj = M('news');
			$data = $newsobj->get_news_list();
			$this->showabout();
			VIEW::assign(array('data'=>$data));
			VIEW::display('admin/newslist.html');
		}

		/**
		 * 前台信息展示
		 * @return  NULL
		 */
		public function newsshow() {
			$data = M('news')->getnewsinfo(intval($_GET['id']));
			$this->showabout();
			VIEW::assign(array('data'=>$data));
			VIEW::display('admin/show.html');
		}
	}
?>