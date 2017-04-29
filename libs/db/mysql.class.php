<?php
	/**
	* mysql类
	*/
	class mysql{

		/**
		 * 报错函数
		 * @param  string $error 
		 * @return string        
		 */
		function err($error){
			die('对不起,您的操作有误,错误原因为:'.$error);
		}

		/**
		 * 执行数据库连接与字符设置
		 * @param  array $config=array($dbhost,$dbuser,$dbpasw,$dbname,$con,$dbcharset)
		 */
		public function connect($config) {
			extract($config);
			if (!($con = @mysql_connect($dbhost,$dbuser.$dbpasw))) {
				// 连接数据库函数
				$this->err(mysql_error());
			}
			if (!mysql_select_db($dbname,$con)) {
				// mysql_select_db选择库的函数
				$this->err(mysql_error());
			}
			// 使用mysql_query设置编码 格式:mysql_query("set names utf8")
			mysql_query("set names".$dbcharset);
		}


		/**
		 * 执行sql语句
		 * @param  string $sql
		 * @return bool      返回执行成功资源或执行失败
		 */
		public function query($sql) {
			if (!($query = mysql_query($sql))) {
				// mysql_error 报错
				$this->err($sql."<br>".mysql_error());
			} else {
				return $query;
			}
		}

		/**
		 * 获取数据函数
		 * @param  source $query 通过查询提供的资源
		 * @return array        返回列表数组
		 */				
		public function findAll($query) {
			while ($rs = mysql_fetch_array($query,MYSQL_ASSOC)) {
				// 遍历整行数据
				$list[] = $rs;
			}
			return isset($list)?$list:"";
		}

		/**
		 * 返回一条数据
		 * @param  source $query sql查询集合
		 * @return array        返回单条信息数组
		 */
		public function findOne($query) {
			$rs = mysql_fetch_array($query);
			return $rs;
		}

		/**
		 * 查找指定字段
		 * @param  source  $query sql查询资源
		 * @param  integer $row   
		 * @param  integer $field 
		 * @return array         返回指定字段的值
		 */
		public function findResult($query,$row=0,$field=0) {
			$rs = mysql_result($query, $row, $field);
			return $rs;
		}

		/**
		 * 插入数据 包含特殊字符转义
		 * @param  string $table 表名
		 * @param  array $arr   插入值的键值对
		 * @return number        返回最后插入的数据
		 */
		public function insert($table,$arr) {
			// $sql = "insert into 表名(多个字段) values(多个值)";
			// mysql_query($sql)
			foreach ($arr as $key => $value) {
				// 防止注入非法字符
				$value = mysql_real_escape_string($value);
				$keyArr[] = "`".$key."`";
				$valueArr[] = "'".$value."'";
			}
			$keys = implode(",", $keyArr);
			$values = implode(",", $valueArr);
			$sql = "insert into ".$table."(".$keys.")values(".$values.")";
			$this->query($sql);
			return mysql_insert_id();
		}

		/**
		 * 更新数据 包含特殊字符转义
		 * @param  string $table 
		 * @param  array $arr   
		 * @param  查询条件 $where 
		 * @return NULL        
		 */
		public function update($table,$arr,$where) {
			// update 表名 set 字段值 where......
			foreach ($arr as $key => $value) {
				$value = mysql_real_escape_string($value);
				$keyAndvalueArr[] = "`".$key."`='".$value."'";
			}
			$keyAndvalues = implode(',', $keyAndvalueArr);
			// 修改操作 格式 update 表名 set 字段=值 where 条件
			$sql = "update ".$table." set ".$keyAndvalues." where ".$where;
			$this->query($sql);
		}



		/**
		* 删除函数
		*
		* @param string $table 表名
		* @param string $where 条件
		**/
		function del($table,$where){
			$sql = "delete from ".$table." where ".$where;//删除sql语句 格式：delete from 表名 where 条件
			$this->query($sql);
		}
	}
?>