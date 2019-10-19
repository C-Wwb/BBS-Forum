<?php

//cronname:paulsignfakedata
//week:
//day:
//hour:
//minute:0,5,10,15,20,25,30,35,40,45,50,55

if(!defined('IN_DISCUZ')) exit('Access Denied');

loadcache('plugin');
if(!$_G['setting']['paulsign_faketime']) $_G['setting']['paulsign_faketime'] = '0';
if($_G['cache']['plugin']['dsu_paulsign']['cheat_radio'] && (TIMESTAMP - $_G['setting']['paulsign_faketime']) > $_G['cache']['plugin']['dsu_paulsign']['cheat_time'] * 60){
	include_once DISCUZ_ROOT.'./source/plugin/dsu_paulsign/sign.func.php';
	$gids = dimplode(unserialize($_G['cache']['plugin']['dsu_paulsign']['cheat_ug']));
	$days = $_G['cache']['plugin']['dsu_paulsign']['cheat_ld'] !== 0 ? $_G['cache']['plugin']['dsu_paulsign']['cheat_ld'] : 7;
	$pnum = $_G['cache']['plugin']['dsu_paulsign']['cheat_pnum'] !== 0 ? $_G['cache']['plugin']['dsu_paulsign']['cheat_pnum'] : 10;
	foreach(C::t('#dsu_paulsign#dsu_paulsign')->getfakelist($gids, $days, $pnum) as $mrc) {
		paulsign_do($mrc['uid'], 0, $_G['cache']['plugin']['dsu_paulsign']['cheat_reward_radio']);
	}
	C::t('common_setting')->update('paulsign_faketime', TIMESTAMP);
	updatecache('setting');
}
?>