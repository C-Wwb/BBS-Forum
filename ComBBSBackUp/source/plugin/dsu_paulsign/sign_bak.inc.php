<?php
//CopyRight By Kookxiang.
!defined('IN_DISCUZ') && exit('Access Denied');
!defined('IN_ADMINCP') && exit('Access Denied');
loadcache('pluginlanguage_script');
$lang = $_G['cache']['pluginlanguage_script']['dsu_paulsign'];
if(submitcheck('backup')){
	if(preg_match('/[^A-Za-z0-9_]/', $_GET['filename'])) cpmsg($lang['bak_01']);
	$file = DISCUZ_ROOT."./data/paulsign_bak/{$_GET[filename]}.pb";
	@touch($file);
	if(!is_writeable($file)) cpmsg($lang['bak_02']);
	$out_arr = array();
	$out_arr['main'] = C::t('#dsu_paulsign#dsu_paulsign')->fetch_all();
	$out_arr['set'] = C::t('#dsu_paulsign#dsu_paulsignset')->fetch_all();
	$out_arr['emot'] = C::t('#dsu_paulsign#dsu_paulsignemot')->fetch_all();
	$output = serialize($out_arr);
	file_put_contents($file, $output);
	cpmsg($lang['bak_03'], '', 'succeed');
	dexit();
}elseif(submitcheck('restore', 1)){
	$file = DISCUZ_ROOT."./data/paulsign_bak/{$_GET[filename]}";
	if(!file_exists($file)) cpmsg($lang['bak_04']);
	$data_str = file_get_contents($file);
	$data = unserialize($data_str);
	$main = $data['main'];
	$set = $data['set'];
	$emot = $data['emot'];
	C::t('#dsu_paulsign#dsu_paulsign')->cleartable();
	C::t('#dsu_paulsign#dsu_paulsignset')->cleartable();
	C::t('#dsu_paulsign#dsu_paulsignemot')->cleartable();
	foreach ($main as $line){
		C::t('#dsu_paulsign#dsu_paulsign')->insert($line);
	}
	foreach ($set as $line){
		C::t('#dsu_paulsign#dsu_paulsignset')->insert($line);
	}
	foreach ($emot as $line){
		C::t('#dsu_paulsign#dsu_paulsignemot')->insert($line);
	}
	require_once libfile('function/cache');
	$cacheechos = array();
	$cacheechokeys = array();
	$query = C::t('#dsu_paulsign#dsu_paulsignemot')->getemotdata();
	foreach($query as $cacheecho) {
		$cacheechos[$cacheecho['qdxq']] = $cacheecho;
		$cacheechokeys[] = $cacheecho['qdxq'];
	}
	C::t('common_setting')->update('paulsign_emot', $cacheechos);
	updatecache('setting');
	cpmsg($lang['bak_05'], '', 'succeed');
	dexit();
}
showtableheader($lang['bak_06']);
showformheader("plugins&operation=config&identifier=dsu_paulsign&pmod=sign_bak");
showsetting($lang['bak_07'], 'filename', random(10), 'text', '', '', $lang['bak_08'].' /data/paulsign_bak/ '.$lang['bak_09']);
showsubmit('backup', $lang['bak_10']);
showformfooter();
showtablefooter();
showtableheader($lang['bak_11']);
if(!is_dir(DISCUZ_ROOT.'./data/paulsign_bak/')) {
	@mkdir(DISCUZ_ROOT.'./data/paulsign_bak/', 0777);
	@touch(DISCUZ_ROOT."./data/paulsign_bak/index.htm");
}
$backup_dir = @dir(DISCUZ_ROOT.'./data/paulsign_bak/');
$flag = false;
while(false !== ($entry = $backup_dir->read())) {
	$file = pathinfo($entry);
	if($file['extension'] == 'pb' && $file['basename']) {
		showtablerow('', '', array(
			$lang['bak_12'].$file['basename'],
			dgmdate(filemtime(DISCUZ_ROOT."./data/paulsign_bak/{$file[basename]}"), 'u'),
			'<a href="?action=plugins&operation=config&identifier=dsu_paulsign&pmod=sign_bak&filename='.$file['basename'].'&restore=yes&formhash='.FORMHASH.'">'.$lang['bak_13'].'</a>',
		));
		$flag = true;
	}
}
if(!$flag) showtablerow('', '', array('<font color="red">'.$lang['bak_14'].'</font>'));
showtablefooter();
?>