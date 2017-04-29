<?php
	/**
	* 用户处理模型
	*/
	class authModel {
		
		// 当前登陆管理员的信息
		private $auth = '';
		
		/**
		 * 看是SESSION的用户是否放置有则缓存
		 */
		function __construct() {
			if (isset($_SESSION['auth'])&&(!empty($_SESSION['auth']))) {
				$this->auth = $_SESSION['auth'];
			}
		}

		/**
		 * 提交后登陆验证
		 * @return boolean 
		 */
		public function loginsubmit() {
			// 进行登陆验证的一系列业务逻辑

			// 判断用户和密码是否为空
			if (empty($_POST['username'])||empty($_POST['password'])) {
				return false;
			}

			// 用户和密码特殊字符转义
			$username = addslashes($_POST['username']);
			$password = addslashes($_POST['password']);

			// 用户的验证操作->拆分到另外一个方法里面去写了,减少这个方法的代码量
			if ($this->auth = $this->checkuser($username,$password)) {
				$_SESSION['auth'] = $this->auth;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * 得到私有用户数据
		 * @return SESSION 
		 */
		public function getauth() {
			return $this->auth;
		}

		/**
		 * 登出操作 清除内置数据
		 * @return NULL
		 */
		public function logout() {
			unset($_SESSION['auth']);
			$this->auth = '';
		}

		/**
		 * 检查用户是否存在密码舒服正确
		 * @param  string $username 
		 * @param  string $password 
		 * @return bollean or auth's source
		 */
		private function checkuser($username, $password) {
			$adminobj = M('admin');
			$auth = $adminobj->findOne_by_username($username);
			if ((!empty($auth))&&$auth['password']==$password) {
				return $auth;
			} else {
				return false;
			}
		}



	}
?>