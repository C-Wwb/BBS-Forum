<?php

/*
	table_dsu_paulsign By DSU_TEAM 2013-07-30
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_dsu_paulsign extends discuz_table {
	public function __construct() {
		$this->_table = 'dsu_paulsign';
		$this->_pk    = 'uid';

		parent::__construct();
	}

	public function clearmdays() {
		return DB::query('UPDATE %t SET mdays=0', array($this->_table));
	}

	public function getsignlist($type, $turn = 'DESC', $start_limit = 0, $ifgroup = '', $gids = '', $tdtime = '', $pnum = 10) {
		$turn = !empty($turn) ? $turn : 'DESC';
		if($ifgroup){
			return DB::fetch_all("SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,m.username FROM %t q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND m.groupid IN(".$gids.") ORDER BY ".$type." ".$turn." LIMIT ".$start_limit.", ".$pnum,array($this->_table));
		}else{
			$wheresql = !empty($tdtime) ? 'AND q.time >= '.$tdtime : '';
			return DB::fetch_all("SELECT q.days,q.mdays,q.time,q.qdxq,q.uid,q.todaysay,q.lastreward,q.reward,m.username FROM %t q, ".DB::table('common_member')." m WHERE q.uid=m.uid ".$wheresql." ORDER BY ".$type." ".$turn." LIMIT ".$start_limit.", ".$pnum, array($this->_table));
		}
	}

	public function getfakelist($gids, $days, $pnum) {
		$fake_dateline = TIMESTAMP - $days * 86400;
		return DB::fetch_all("SELECT m.uid FROM ".DB::table('common_member')." m, ".DB::table('common_member_status')." s WHERE s.uid=m.uid AND s.lastvisit < ".$fake_dateline." AND m.groupid IN(".$gids.") ORDER BY s.lastvisit LIMIT 0, ".$pnum,array());
	}

	public function cleartable() {
		return DB::query('TRUNCATE TABLE %t ', array($this->_table));
	}

	public function get_userinfo($uid) {
		$wheresql = 'WHERE '.DB::field('uid', $uid, '=');
		return DB::fetch_first('SELECT groupid,username FROM '.DB::table('common_member').' %i', array($wheresql));
	}

	public function getcount_customgroup($gids) {
		return DB::result_first("SELECT COUNT(*) FROM %t q, ".DB::table('common_member')." m WHERE q.uid=m.uid AND m.groupid IN(%i)", array($this->_table, $gids));
	}

	public function getcount($field = '', $val = '', $glue = '') {
		$wheresql = !empty($field) ? 'WHERE '.DB::field($field, $val, $glue) : '';
		return DB::result_first('SELECT COUNT(*) FROM %t %i ', array($this->_table, $wheresql));
	}

	public function getlasttime() {
		$ordersql =  " ORDER BY time DESC LIMIT 0, 1";
		return DB::result_first('SELECT time FROM %t %i ', array($this->_table, $ordersql));
	}

	public function getuserpost($uid) {
		$wheresql = 'WHERE '.DB::field('uid', $uid, '=');
		return DB::result_first('SELECT posts FROM '.DB::table('common_member_count').' %i', array($wheresql));
	}

	public function checktableexist() {
		$query = DB::query("SHOW TABLES LIKE '%t'", array($this->_table));
		return DB::num_rows($query);
	}

	public function fixlasted() {
		$query = DB::query("Describe %t lasted", array($this->_table));
		if(!$query) DB::query("ALTER TABLE %t ADD lasted int(5) NOT NULL DEFAULT '0'", array($this->_table));
		return;
	}

	public function update_signdata($uid, $mood, $todaysay, $credit, $islast) {
		if($islast){
			return DB::query('UPDATE %t SET days=days+1,mdays=mdays+1,time=%i,qdxq=%s,todaysay=%s,reward=reward+%i,lastreward=%i,lasted=lasted+1 WHERE uid=%d', array($this->_table, TIMESTAMP, $mood, $todaysay, $credit, $credit, $uid));
		}else{
			return DB::query('UPDATE %t SET days=days+1,mdays=mdays+1,time=%i,qdxq=%s,todaysay=%s,reward=reward+%i,lastreward=%i,lasted=1 WHERE uid=%d', array($this->_table, TIMESTAMP, $mood, $todaysay, $credit, $credit, $uid));
		}
	}

}

?>