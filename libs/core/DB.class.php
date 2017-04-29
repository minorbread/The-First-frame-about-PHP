<?php
	
	/**
	* 	工厂数据库类 数据库接口 接口对象封装好的类 类DBO类 
	*/
	class DB {

		// 数据库缓存
		public static $db;

		/**
		 * 初始化数据库类型
		 * @param  string $dbtype 
		 * @param  array $config 
		 * @return          
		 */
		public static function init($dbtype, $config) {
			self::$db = new $dbtype;
			self::$db->connect($config);
		}

		/**
		 * 语句执行函数
		 * @param  string $sql 查询语句
		 * @return source      查询所得资源
		 */
		public static function query($sql) {
			return self::$db->query($sql);
		}

		/**
		 * 查询整行数据
		 * @param  string $sql 查询语句
		 * @return source      返回所有资源
		 */
		public static function findAll($sql) {
			$query = self::$db->query($sql);
			return self::$db->findAll($query);
		}

		/**
		 * 查询单条语句
		 * @param  string $sql 从洗衣机
		 * @return source      单条资源
		 */
		public static function findOne($sql) {
			$query = self::$db->query($sql);
			return self::$db->findOne($query);
		}

		/**
		 * 查询指定数据	
		 * @param  string  $sql   查询语句
		 * @param  integer $row   行数
		 * @param  integer $field 列数
		 * @return source         返回指定资源
		 */
		public static function findResult($sql, $row=0, $field=0) {
			$query = self::$db->query($sql);
			return self::$db->findResult($query, $row, $field);
		}

		/**
		 * 插入语句
		 * @param  string $table 插入表名
		 * @param  array $arr   键值对 
		 * @return num        插入ID号
		 */
		public static function insert($table, $arr) {
			return self::$db->insert($table,$arr);
		}

		/**
		 * 跟新数据
		 * @param  string $table 插入表名
		 * @param  array $arr   键值对
		 * @param  string $where 查询条件
		 * @return NULL
		 */
		public static function update($table, $arr, $where) {
			return self::$db->update($table, $arr, $where);
		}

		/**
		 * 删除数据
		 * @param  string $table 插入表名
		 * @param  string $where 删除条件
		 * @return NULL
		 */
		public static function del($table, $where) {
			return self::$db->del($table, $where);
		}
	}

?>