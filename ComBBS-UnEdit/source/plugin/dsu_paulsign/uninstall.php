<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsign')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsignset')."");
DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsignemot')."");
DB::query("ALTER TABLE ".DB::table('common_stat')." DROP paulsign");
DB::query("UPDATE ".DB::table('home_doing')." SET `message` = replace (`message`,'".$installlang['fromsign']."','') WHERE `message` LIKE '%".$installlang['fromsign']."%'");
$finish = TRUE;
?>