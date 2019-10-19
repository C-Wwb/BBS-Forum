<?php
/**
 * DSU_Paulsign Sign Func Lib
 * 
 * @copyright (c) 2013 DSU Team. (http://www.dsu.me)
 * @author BranchZero <branchzero@gmail.com> 
 * @LastModTime 2013-10-15 00:20:16Z BranchZero
 */

function paulsign_do($uid, $signmode, $ifreward = TRUE){
	global $_G, $_GET;
	loadcache('pluginlanguage_script');
	$var = $_G['cache']['plugin']['dsu_paulsign'];
	$lang = $_G['cache']['pluginlanguage_script']['dsu_paulsign'];
	$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
	$htime = dgmdate($_G['timestamp'], 'H',$var['tos']);
	$qiandaodb = C::t('#dsu_paulsign#dsu_paulsign')->fetch($uid);
	$userinfo = C::t('#dsu_paulsign#dsu_paulsign')->get_userinfo($uid);
	$groupid = $userinfo['groupid'];
	$username = $userinfo['username'];
	if($signmode == 1){
		if($_GET['formhash'] != FORMHASH) {
			showmessage('undefined_action', NULL);
		}
	}
	if($var['timeopen']) {
		if ($htime < $var['stime']) {
			return paulsign_result($signmode, "{$lang['ts_timeearly1']}{$var[stime]}{$lang['ts_timeearly2']}");
		} elseif ($htime > $var['ftime']) {
			return paulsign_result($signmode, $lang['ts_timeov']);
		}
	}
	if(!in_array($groupid, unserialize($var['groups']))) return paulsign_result($signmode, $lang['ts_notallow']);
	if($var['mintdpost'] > C::t('#dsu_paulsign#dsu_paulsign')->getuserpost($uid)) return paulsign_result($signmode, "{$lang['ts_minpost1']}{$var[mintdpost]}{$lang['ts_minpost2']}");
	if(in_array($uid,explode(",",$var['ban']))) return paulsign_result($signmode, $lang['ts_black']);
	if($qiandaodb['time']>$tdtime) return paulsign_result($signmode, $lang['ts_yq']);
	if($signmode == 1){
		if(!array_key_exists($_GET['qdxq'],unserialize($_G['setting']['paulsign_emot']))) return paulsign_result($signmode, $lang['ts_xqnr']);
		$mood = $_GET['qdxq'];
	}else{
		$mood = array_rand(unserialize($_G['setting']['paulsign_emot']));
	}
	if(!$var['sayclose'] && $signmode == 1){
		if($_GET['qdmode']=='1'){
			$todaysay = dhtmlspecialchars($_GET['todaysay']);
			if($todaysay=='') return paulsign_result($signmode, $lang['ts_nots']);
			if(strlen($todaysay) > 100) return paulsign_result($signmode, $lang['ts_ovts']);
			if(strlen($todaysay) < 6) return paulsign_result($signmode, $lang['ts_syts']);
			if (!preg_match("/[^A-Za-z0-9.,]/",$todaysay)) return paulsign_result($signmode, $lang['ts_saywater']);
			if(censormod($todaysay)) return paulsign_result($signmode, $lang['ts_illegaltext']);
		} elseif ($_GET['qdmode']=='2') {
			$fastreplytexts = explode("/hhf/", str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['fastreplytext']));
			$todaysay = $fastreplytexts[$_GET['fastreply']];
		} elseif($_GET['qdmode']=='3') {
			$todaysay = "{$lang['wttodaysay']}";
		}
	}else{
		$todaysay = "{$lang['wttodaysay']}";
	}
	if($var['lockopen']){
		while(discuz_process::islocked('dsu_paulsign', 5)) usleep(100000);
	}
	$credit = mt_rand($var['mincredit'],$var['maxcredit']);
	if(in_array($groupid,  unserialize($var['jlxgroups'])) && $var['jlx'] !== '0') $credit = $credit * $var['jlx'];
	if(($tdtime - $qiandaodb['time']) < 86400 && $var['lastedop'] && $qiandaodb['lasted'] !== '0'){
		$randlastednum = mt_rand($var['lastednuml'],$var['lastednumh']);
		$randlastednum = sprintf("%03d", $randlastednum);
		$randlastednum = '0.'.$randlastednum;
		$randlastednum = $randlastednum * $qiandaodb['lasted'];
		$credit = round($credit*(1+$randlastednum));
	}
	$num = C::t('#dsu_paulsign#dsu_paulsign')->getcount('time', $tdtime, '>=');
	if(!$qiandaodb['uid']) C::t('#dsu_paulsign#dsu_paulsign')->insert(array('uid'=>$uid,'time'=>$_G['timestamp']));
	$islast = ($tdtime - $qiandaodb['time']) < 86400 && $var['lastedop'] ? TRUE : FALSE;
	C::t('#dsu_paulsign#dsu_paulsign')->update_signdata($uid, $mood, $todaysay, $credit, $islast);
	if($ifreward) updatemembercount($uid, array($var['nrcredit'] => $credit));
	$another_vip = '';
	if(@include_once DISCUZ_ROOT.'./source/plugin/dsu_kkvip/extend/sign.api.php'){
		if($rewarddays || $growupnum) $another_vip=lang('plugin/dsu_paulsign', 'another_vip', array('rewarddays' => intval($rewarddays), 'growupnum' => intval($growupnum)));
	}
	require_once libfile('function/post');
	require_once libfile('function/forum');
	if($signmode == 1){
		if($var['sync_say'] && $_GET['qdmode'] =='1') {
			$setarr = array(
				'uid' => $uid,
				'username' => $username,
				'dateline' => $_G['timestamp'],
				'message' => $todaysay.$lang['fromsign'],
				'ip' => $_G['clientip'],
				'status' => 0,
			);
			$doid = C::t('home_doing')->insert($setarr, 1);
			$setarr2 = array(
				'appid' => '',
				'icon' => 'doing',
				'uid' => $uid,
				'username' => $username,
				'dateline' => $_G['timestamp'],
				'title_template' => lang('feed', 'feed_doing_title'),
				'title_data' => daddslashes(serialize(dstripslashes(array('message'=>$todaysay.$lang['fromsign'])))),
				'body_template' => '',
				'body_data' => '',
				'id' => $doid,
				'idtype' => 'doid'
			);
			C::t('home_doing')->insert($setarr2, 1);
		}
		if($var['sync_follow'] && $_GET['qdmode']=='1' && $_G['setting']['followforumid']) {
			$tofid = $_G['setting']['followforumid'];
			$thread_param = array(
				'isgroup' => '0',
				'status' => '512',
				'closed' => '1',
				'highlight' => '1',
				'moderated' => '1',
				'attachment' => '0',
				'special' => '0',
				'digest' => '0',
				'displayorder' => '0',
				'lastposter' => $username,
				'lastpost' => $_G['timestamp'],
				'dateline' => $_G['timestamp'],
				'subject' => $todaysay,
				'authorid' => $uid,
				'author' => $username,
				'sortid' => '0',
				'typeid' => '0',
				'price' => '0',
				'readperm' => '0',
				'posttableid' => '0',
				'fid' => $tofid
			);
			$synctid = C::t('forum_thread')->insert($thread_param, true);
			$syncpid = insertpost(array('fid' => $tofid,'tid' => $synctid,'first' => '1','author' => $username,'authorid' => $uid,'subject' => $todaysay,'dateline' => $_G['timestamp'],'message' => $todaysay,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0'));
			updatepostcredits('+', $uid, 'post', $_G['setting']['followforumid']);
			updateforumcount($_G['setting']['followforumid']);
			$feedcontent = array(
				'tid' => $synctid,
				'content' => $todaysay,
			);
			C::t('forum_threadpreview')->insert($feedcontent);
			$followfeed = array(
				'uid' => $uid,
				'username' => $username,
				'tid' => $synctid,
				'note' => '',
				'dateline' => TIMESTAMP
			);
			C::t('home_follow_feed')->insert($followfeed, true);
			C::t('common_member_count')->increase($uid, array('feeds'=>1));
		}
		if($var['sync_sign'] && $_G['group']['maxsigsize']) {
			$signhtml = cutstr(strip_tags($todaysay.$lang['fromsign']), $_G['group']['maxsigsize']);
			C::t('common_member_field_forum')->update($uid, array('sightml' => $signhtml));
		}
	}
	$extreward = explode("/hhf/", str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['jlmain']));
	$extreward_num = count($extreward);
	if($num <= ($extreward_num - 1) ) {
		list($exacr,$exacz) = explode("|", $extreward[$num]);
		$psc = $num+1;
		if($exacr && $exacz && $ifreward) updatemembercount($uid, array($exacr => $exacz));
	}
	$stats = C::t('#dsu_paulsign#dsu_paulsignset')->fetch('1');
	if($var['qdtype'] == '2') {
		$thread = C::t('forum_thread')->fetch($var['tidnumber']);
		$hft = dgmdate($_G['timestamp'], 'Y-m-d H:i',$var['tos']);
		if($num >=0 && ($num <= ($extreward_num - 1)) && $exacr && $exacz) {
			$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$psc}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][color=gray]{$lang[tsn_17]}[/color] [color=gray]{$_G[setting][extcredits][$exacr][title]} [/color][color=darkorange]{$exacz}[/color][color=gray]{$_G[setting][extcredits][$exacr][unit]}.{$another_vip}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
		} else {
			$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_09]}{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}.{$another_vip}[/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
		}
		$pid = insertpost(array('fid' => $thread['fid'],'tid' => $var['tidnumber'],'first' => '0','author' => $username,'authorid' => $uid,'subject' => '','dateline' => $_G['timestamp'],'message' => $message,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0'));
		C::t('forum_thread')->update($var['tidnumber'], array('lastposter'=>$username,'lastpost'=>$_G['timestamp']));
		C::t('forum_thread')->increase($var['tidnumber'], array('replies'=>1));
		updatepostcredits('+', $uid, 'reply', $thread['fid']);
		$lastpost = "$thread[tid]\t".addslashes($thread['subject'])."\t$_G[timestamp]\t$username";
		C::t('forum_forum')->update($thread['fid'], array('lastpost' => $lastpost));
		C::t('forum_forum')->update_forum_counter($thread['fid'], 0, 1, 1);
		$tidnumber = $var['tidnumber'];
	} elseif($var['qdtype'] == '3') {
		if($num=='0' || $stats['qdtidnumber'] == '0') {
			$subject=str_replace(array('{m}','{d}','{y}','{bbname}','{author}'),array(dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos']),$_G['setting']['bbname'],$username),$var['title_thread']);
			$hft = dgmdate($_G['timestamp'], 'Y-m-d H:i',$var['tos']);
			if($exacr && $exacz) {
				$message = "[quote][size=2][color=dimgray]{$lang[tsn_10]}[/color][url={$_G[siteurl]}plugin.php?id=dsu_paulsign:sign][color=darkorange]{$lang[tsn_11]}[/color][/url][color=dimgray]{$lang[tsn_12]}[/color][/size][/quote][quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$lang[tsn_13]}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][color=gray]{$lang[tsn_17]}[/color] [color=gray]{$_G[setting][extcredits][$exacr][title]} [/color][color=darkorange]{$exacz}[/color][color=gray]{$_G[setting][extcredits][$exacr][unit]}.{$another_vip}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
			} else {
				$message = "[quote][size=2][color=dimgray]{$lang[tsn_10]}[/color][url={$_G[siteurl]}plugin.php?id=dsu_paulsign:sign][color=darkorange]{$lang[tsn_11]}[/color][/url][color=dimgray]{$lang[tsn_12]}[/color][/size][/quote][quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$lang[tsn_13]}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}.{$another_vip}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
			}
			$thread_param = array(
				'isgroup' => '0',
				'status' => '0',
				'closed' => '1',
				'highlight' => '1',
				'moderated' => '1',
				'attachment' => '0',
				'special' => '0',
				'digest' => '0',
				'displayorder' => '0',
				'lastposter' => $username,
				'lastpost' => $_G['timestamp'],
				'dateline' => $_G['timestamp'],
				'subject' => $subject,
				'authorid' => $uid,
				'author' => $username,
				'sortid' => '0',
				'typeid' => $var['qdtypeid'],
				'price' => '0',
				'readperm' => '0',
				'posttableid' => '0',
				'fid' => $var['fidnumber']
			);
			$tid = C::t('forum_thread')->insert($thread_param, true);
			C::t('#dsu_paulsign#dsu_paulsignset')->update('1', array('qdtidnumber'=>$tid));
			$pid = insertpost(array('fid' => $var['fidnumber'],'tid' => $tid,'first' => '1','author' => $username,'authorid' => $uid,'subject' => $subject,'dateline' => $_G['timestamp'],'message' => $message,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
			$expiration = $_G['timestamp'] + 86400;
			$threadmod_param1 = array(
				'tid' => $tid,
				'uid' => $uid,
				'username' => $username,
				'dateline' => $_G['timestamp'],
				'action' => 'EHL',
				'expiration' => $expiration,
				'status' => '1'
			);
			$threadmod_param2 = array(
				'tid' => $tid,
				'uid' => $uid,
				'username' => $username,
				'dateline' => $_G['timestamp'],
				'action' => 'CLS',
				'expiration' => '0',
				'status' => '1'
			);
			C::t('forum_threadmod')->insert($threadmod_param1);
			C::t('forum_threadmod')->insert($threadmod_param2);
			updatepostcredits('+', $uid, 'post', $var['fidnumber']);
			$lastpost = "$tid\t".addslashes($subject)."\t$_G[timestamp]\t$username";
			C::t('forum_forum')->update($var['fidnumber'], array('lastpost' => $lastpost));
			C::t('forum_forum')->update_forum_counter($var['fidnumber'], 1, 1, 1);
			$tidnumber = $tid;
		} else {
			$tidnumber = $stats['qdtidnumber'];
			$thread = C::t('forum_thread')->fetch($tidnumber);
			$hft = dgmdate($_G['timestamp'], 'Y-m-d H:i',$var['tos']);
			if($num >=1 && ($num <= ($extreward_num - 1)) && $exacr && $exacz) {
				$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_02]}[color=red]{$lang[tsn_03]}[/color][color=darkorange]{$lang[tsn_04]}{$psc}{$lang[tsn_05]}[/color]{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit}[/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][color=gray]{$lang[tsn_17]}[/color] [color=gray]{$_G[setting][extcredits][$exacr][title]} [/color][color=darkorange]{$exacz}[/color][color=gray]{$_G[setting][extcredits][$exacr][unit]}[/color][/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
			} else {
				$message = "[quote][size=2][color=gray][color=teal] [/color][color=gray]{$lang[tsn_01]}[/color] [color=darkorange]{$hft}[/color] {$lang[tsn_09]}{$lang[tsn_06]} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][title]} [/color][color=darkorange]{$credit} [/color][color=gray]{$_G[setting][extcredits][$var[nrcredit]][unit]}[/color][/size][/quote][size=3][color=dimgray]{$lang[tsn_07]}[color=red]{$todaysay}[/color]{$lang[tsn_08]}[/color][/size]";
			}
			$pid = insertpost(array('fid' => $var['fidnumber'],'tid' => $tidnumber,'first' => '0','author' => $username,'authorid' => $uid,'subject' => '','dateline' => $_G['timestamp'],'message' => $message,'useip' => $_G['clientip'],'invisible' => '0','anonymous' => '0','usesig' => '0','htmlon' => '0','bbcodeoff' => '0','smileyoff' => '0','parseurloff' => '0','attachment' => '0',));
			C::t('forum_thread')->update($tidnumber, array('lastposter'=>$username,'lastpost'=>$_G['timestamp']));
			C::t('forum_thread')->increase($tidnumber, array('replies'=>1));
			updatepostcredits('+', $uid, 'reply', $var['fidnumber']);
			$lastpost = "$tidnumber\t".addslashes($thread['subject'])."\t$_G[timestamp]\t$username";
			C::t('forum_forum')->update($var['fidnumber'], array('lastpost' => $lastpost));
			C::t('forum_forum')->update_forum_counter($var['fidnumber'], 0, 1, 1);
		}
	}
	if(memory('check')) memory('set', 'dsu_pualsign_'.$uid, $_G['timestamp'], 86400);
	if($num ==0) {
		if($stats['todayq'] > $stats['highestq']) C::t('#dsu_paulsign#dsu_paulsignset')->update('1', array('highestq'=>$stats['todayq']));
		include_once libfile('function/stat');
		updatestat('paulsign');
		C::t('#dsu_paulsign#dsu_paulsignset')->update('1', array('yesterdayq'=>$stats['todayq'],'todayq'=>'1'));
		C::t('#dsu_paulsign#dsu_paulsignemot')->clearcount();
	} else {
		C::t('#dsu_paulsign#dsu_paulsignset')->increase_todayq();
	}
	C::t('#dsu_paulsign#dsu_paulsignemot')->updatebyqdxq($mood);
	if($var['lockopen']) discuz_process::unlock('dsu_paulsign');
	if($var['tzopen']) {
		if($exacr && $exacz) {
			return paulsign_result($signmode, "{$lang[tsn_14]}{$lang[tsn_03]}{$lang[tsn_04]}{$psc}{$lang[tsn_15]}{$lang[tsn_06]} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]} {$lang[tsn_16]} {$_G[setting][extcredits][$exacr][title]} {$exacz} {$_G[setting][extcredits][$exacr][unit]}.".$another_vip,"forum.php?mod=redirect&tid={$tidnumber}&goto=lastpost#lastpost");
		} else {
			return paulsign_result($signmode, "{$lang[tsn_18]} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]}.".$another_vip,"forum.php?mod=redirect&tid={$tidnumber}&goto=lastpost#lastpost");
		}
	} else {
		if($exacr && $exacz) {
			return paulsign_result($signmode, "{$lang[tsn_14]}{$lang[tsn_03]}{$lang[tsn_04]}{$psc}{$lang[tsn_15]}{$lang[tsn_06]} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]} {$lang[tsn_16]} {$_G[setting][extcredits][$exacr][title]} {$exacz} {$_G[setting][extcredits][$exacr][unit]}.".$another_vip,"plugin.php?id=dsu_paulsign:sign");
		} else {
			return paulsign_result($signmode, "{$lang[tsn_18]} {$_G[setting][extcredits][$var[nrcredit]][title]} {$credit} {$_G[setting][extcredits][$var[nrcredit]][unit]}.".$another_vip,"plugin.php?id=dsu_paulsign:sign");
		}
	}
}

function paulsign_result($signmode, $msg, $treferer = ''){
	global $_G;
	if($signmode == 1){
		if(defined('IN_MOBILE')) {
			include template('dsu_paulsign:float');
			dexit();
		}else{
			include template('dsu_paulsign:float');
			dexit();
		}
	}else{
		return $msg;
	}
}

?>