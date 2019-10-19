<?php
function setthreadpic($tid,$num,$type=''){
	if($type == 'piccount') {
		return count(DB::fetch_all('SELECT tableid FROM '.DB::table('forum_attachment').' WHERE tid = '.$tid));
	}
	foreach (DB::fetch_all('SELECT tableid FROM '.DB::table('forum_attachment').' WHERE tid = '.$tid) as $setthread){
		foreach ($getdata = DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment_'.$setthread['tableid'].'').' WHERE tid = '.$tid . '  LIMIT  0 ,'.$num) as $setthreadpic){
			
			if($type == 'piclist'){
				$setthreadpicarray[$setthreadpic['aid']] = getforumimg($setthreadpic['aid'],'0','500','500');
			}else{
				$setthreadpicarray[$setthreadpic['aid']] = getforumimg($setthreadpic['aid'],'0','160','160');
			}
		}
		break;
	}
	return $setthreadpicarray;
}

?>


