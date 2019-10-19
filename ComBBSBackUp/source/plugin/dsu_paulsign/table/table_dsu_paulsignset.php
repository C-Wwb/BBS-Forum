<?php

/*
	table_dsu_paulsignset By DSU_TEAM 2013-07-30
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_dsu_paulsignset extends discuz_table {
	public function __construct() {
		$this->_table = 'dsu_paulsignset';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function cleartable() {
		return DB::query('TRUNCATE TABLE %t ', array($this->_table));
	}

	public function checktableexist() {
		$query = DB::query("SHOW TABLES LIKE '%t'", array($this->_table));
		return DB::num_rows($query);
	}

	public function increase_todayq() {
		return DB::query('UPDATE %t SET todayq=todayq+1 WHERE id=1', array($this->_table));
	}

}

?>