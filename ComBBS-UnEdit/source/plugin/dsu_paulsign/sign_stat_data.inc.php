<?php
if(!defined('IN_DISCUZ') || $_G['adminid']!=='1') exit('Access Denied');
for($i=1;$i<15;$i++){
	$day_display[$i]=dgmdate(TIMESTAMP - 86400*(14-$i), 'm-d');
	$day_array[]=dgmdate(TIMESTAMP - 86400*(14-$i), 'Ymd');
}
foreach(C::t('common_stat')->fetch_all(dgmdate(TIMESTAMP - 86400*14, 'Ymd'),dgmdate(TIMESTAMP, 'Ymd'),'daytime,paulsign,login') as $result){
	$paulsign[$result['daytime']]=$result['paulsign'];
	$login[$result['daytime']]=$result['login'];
}
$stats = C::t('#dsu_paulsign#dsu_paulsignset')->fetch('1');
$today = dgmdate(TIMESTAMP, 'Ymd');
$paulsign[$today]=$stats['todayq'];
foreach($day_array as $day){
	$paulsign_display[]=intval($paulsign[$day]);
	$login_display[]=intval($login[$day]);
}
$max=intval(max(max($paulsign_display),max($login_display))*1.2);
echo "&title=PaulSign+Statistic,{font-size:26px;}&
&x_axis_steps=1&
&y_ticks=5,10,5&
&line=1,0x1CA9F4,Login,12,5&
&line_2=2,0xF2A63E,Sign,12,5&
&values=".implode(',',$login_display)."&
&values_2=".implode(',',$paulsign_display)."&
&x_labels=".implode(',',$day_display)."&
&y_min=0&
&y_max={$max}&
&tool_tip=Num+%3A+%23val%23&";

?>