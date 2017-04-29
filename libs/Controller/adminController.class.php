<?php

	class adminController {
		// ★★★控制器的作用是调用模型,并调用视图,将模型产生的数据传递给视图,并让相关视图去显示

		public $auth='';

		/**
		 * 构造函数 开启SESSION 调用auth模型 看用户是否登陆
		 */
		public function __construct() {
			session_start();
			// 判断当前是否已经登陆 -> auth模型处理
			// 如果不是登录页,而且没有登陆,就要跳转到登录页
			$authobj = M('auth');
			$this->auth = $authobj->getauth();
			if (empty($this->auth)&&(PC::$method!='login')) {
				$this->showmessage('请在登陆后操作!','admin.php?controller=admin&method=login');
			}
		}

		/**
		 * 弹出信息并跳转页面
		 * @param  array $info 
		 * @param  string $url  
		 * @return NULL        
		 */
		private function showmessage($info, $url){
			echo "<script>alert('$info');window.location.href='$url'</script>";
			exit;
		}

		/**
		 * 调用视图层例子
		 * @return  
		 */
		public function show() {
			// $testModel = M('test');
			// $data = $testModel->get();
			// $testView = V('test');
			// $testView->display($data);
			global $view;
			$testModel = M('test');
			$data = $testModel->get();
			$view->assign('str','这是个字符串');
			$view->display('test.tpl');
		}


		/**
		 * 方法测试
		 * @return NULL 
		 */
		public function admin() {
			echo "This is admin method";
		}

		/**
		 * 登陆验证
		 * @return  NULL
		 */
		public function login() {
			if ($_POST) {
				// 进行登陆处理
				// 登陆处理的业务逻辑放在admin auth
				// admin同表名的模型:从数据库里取用户信息
				// auth模型:进行用户信息的核对
				// -->把一系列的登陆处理操作拆分到新的方法里去
				$this->checklogin();
			} else {
				// 显示登陆界面
				VIEW::display('admin/login.html');
			}
		}

		/**
		 * 登陆验证		
		 * @return  
		 */
		private function checklogin() {
			$authobj = M('auth');
			if ($authobj->loginsubmit()) {
				$this->showmessage('登录成功!','admin.php?controller=admin&method=index');
			} else {
				$this->showmessage('登陆失败!','admin.php?controller=admin&method=login');
			}
		}

		/**
		 * index主页调用 新闻数目
		 * @return NULL
		 */
		public function index() {
			$newsobj = M('news');
			$newsnum = $newsobj->count();
			VIEW::assign(array('newsnum'=>$newsnum));
			VIEW::display('admin/index.html');
		}

		/**
		 * 用户登出
		 * @return  
		 */
		public function logout() {
			$authobj = M('auth');
			$authobj->logout();
			$this->showmessage('退出成功!','admin.php?controller=admin&method=login');			
		}

		/**
		 * 增加一条新闻 调用新闻模型
		 * @return NULL
		 */
		public function newsadd() {
			// 判断是否有post数据
			if (empty($_POST)) {
				// 没有post数据,就显示添加,修改的界面

				// 读取旧信息 需要传递新闻id $_GET['id'],如果有$_GET['id']说明是修改
				if (isset($_GET['id'])) {
					$data = M('news')->getnewsinfo($_GET['id']);
				} else {
					$data = array();
				}
				VIEW::assign(array('data'=>$data));
				VIEW::display('admin/newsadd.html');
			} else {
				// 进行添加,修改的处理程序
				// $result = M('news')->newssubmit($_POST);
				// 判断$result的值,来做相应的提示
				$this->newssubmit();
			}
		}

		 
		/**
		 * 新闻添加 返回操作结果信息并跳转页面
		 * @return NULL  
		 */
		private function newssubmit() {
			$newsobj = M('news');
			$result = $newsobj->newssubmit($_POST);
			if ($result == 0) {
				$this->showmessage('操作失败!','admin.php?controller=admin&method=newsadd&id'.$_POST['id']);
			}
			if ($result == 1) {
				$this->showmessage('添加成功!','admin.php?controller=admin&method=newslist');
			}
			if ($result == 2) {
				$this->showmessage('修改成功!','admin.php?controller=admin&method=newslist');
			}
		}

		/**
		 * 新闻列表 调用新闻模型 从数据库中获取列表
		 * @return  NULL
		 */
		public function newslist() {
			$newsobj = M('news');
			$data = $newsobj->findAll_orderby_dateline();
			VIEW::assign(array('data' => $data));
			VIEW::display('admin/newslist.html');
		}

		/**
		 * 删除新闻 返回删除信息 并跳转页面
		 * @return NULL 
		 */
		public function newsdel() {
			if (intval($_GET['id'])) {
				$newsobj = M('news');
				$newsobj->del_by_id(intval($_GET['id']));
				$this->showmessage('删除新闻成功!','admin.php?controller=admin&method=newslist');
			}
		}
	}
?>