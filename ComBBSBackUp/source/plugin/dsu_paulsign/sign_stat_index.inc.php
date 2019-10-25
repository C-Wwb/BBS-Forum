<?php
!defined('IN_DISCUZ') && exit('Access Denied');
!defined('IN_ADMINCP') && exit('Access Denied');
loadcache('pluginlanguage_script');
$lang = $_G['cache']['pluginlanguage_script']['dsu_paulsign'];
if($_G['adminid']!=='1')cpmsg($lang['custom_07'], '', 'error');
showtableheader($lang['statindex_01']);
$stats = C::t('#dsu_paulsign#dsu_paulsignset')->fetch('1');
echo '<tr><td class="tipsblock"><ul id="tipslis"><ul>'."
<li>{$lang[statindex_04]}: {$stats[highestq]}</li>
".'</ul></ul></td></tr>';
showtablefooter();
showtableheader($lang['statindex_05']);
echo '<tr><td align="center"><embed type="application/x-shockwave-flash" src="'.$_G['siteurl'].'source/plugin/dsu_paulsign/img/chart.swf" width="600" height="250" style="undefined" id="chart" name="chart" bgcolor="#FFFFFF" quality="high" allowscriptaccess="sameDomain" flashvars="data='.$_G['siteurl'].'plugin.php%3Fid%3Ddsu_paulsign:sign_stat_data"></td></tr>';
showtablefooter();
?>