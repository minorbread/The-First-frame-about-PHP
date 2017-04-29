<?php
	
	/**
	* 新闻模型
	*/
	class newsModel {
		
		// 新闻表
		public $_table = 'news';

		/**
		 * 查询并提取文章数目
		 * @return source 
		 */
		function count() {
			$sql = 'select count(*) from '.$this->_table;
			return DB::findResult($sql, 0, 0);
		}

		/**
		 * 根据id得到新闻信息
		 * @param  string $id 
		 * @return source
		 */
		public function getnewsinfo($id) {
			if (empty($id)) {
				return array();
			} else {
				$id = intval($id);
				$sql= 'select * from '.$this->_table.' where id = '.$id;
				return DB::findOne($sql);
			}
		}

		/**
		 * 插入新新闻的提交
		 * @param  array $data 
		 * @return number       
		 */
		public function newssubmit($data) {
			extract($data);
			if (empty($title)||empty($content)) {
				return 0;
			}
			$title = addslashes($title);
			$content = addslashes($content);
			$author = addslashes($author);
			$form = addslashes($form);
			$data = array(
				'title' => $title,
				'content' => $content,
				'author' => $author,
				'form' => $form,
				'dateline' => time()
			);
			if ($_POST['id'] != '') {
				DB::update($this->_table,$data,'id='.$id);
				return 2;
			} else {
				DB::insert($this->_table,$data);
				return 1;
			}
		}

		/**
		 * 按时间倒序查询信息
		 * @return source 
		 */
		public function findAll_orderby_dateline() {
			$sql = 'select * from '.$this->_table.' order by dateline desc';
			return DB::findAll($sql);
		}

		/**
		 * 根据id删除条目
		 * @param  string $id 
		 * @return num 删除的id号
		 */
		public function del_by_id($id) {
			return DB::del($this->_table,'id='.$id);
		}

		/**
		 * 得到新闻列表 并格式化信息 200字以内
		 * @return array 所有新闻信息 
		 */
		public function get_news_list() {
			$data = $this->findAll_orderby_dateline();
			foreach ($data as $k => $news) {
				$data[$k]['content'] = mb_substr(strip_tags($data[$k]['content']),0,200);
				$data[$k]['dateline'] = date("Y-m-d H:i:s",$data[$k]['dateline']);
			}
			return $data;
		}
	}

?>