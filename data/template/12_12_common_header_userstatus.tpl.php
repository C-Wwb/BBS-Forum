<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($_G['uid']) { ?>
<div id="um" class="z">
<div onmouseover="showMenu({'ctrlid':'umLogin'});" class="showmenu umLogin" id="umLogin" initialized="true">
<a class="av" href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>"><?php echo avatar($_G[uid],small);?></a>
<?php echo $_G['member']['username'];?>
<i class="arrow-w"></i>
</div>
<div id="umLogin_menu" class="p_pop" style="display:none;">
<img class="login_nrrow" src="<?php echo $_G['style']['styleimgdir'];?>header_login_ico.png" alt="" />
<div class="cl um_info">
<a class="avt" href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>"><?php echo avatar($_G[uid]);?></a>
<p class="cl">
<strong class="z vwmy<?php if($_G['setting']['connect']['allow'] && $_G['member']['conisbind']) { ?> qq<?php } ?>">
<a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" title="访问我的空间"><?php echo $_G['member']['username'];?></a>
</strong>
<?php if($_G['group']['allowinvisible']) { ?>
<span id="loginstatus" class="y">
<a id="loginstatusid" href="member.php?mod=switchstatus" title="切换在线状态" class="xi2"></a>
</span>
<?php } ?>
</p>
<a href="home.php?mod=spacecp&amp;ac=usergroup" id="g_upmine">用户组: <?php echo $_G['group']['grouptitle'];?><?php if($_G['member']['freeze']) { ?><span class="xi1">(已冻结)</span><?php } ?></a>
</div>
<div class="um_op">
<div class="y">
<div class="qq_login"><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?></div>	
<div class="wx_login"><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra4'])) echo $_G['setting']['pluginhooks']['global_usernav_extra4'];?></div>
</div>

<a href="forum.php?mod=guide&amp;view=my">帖子</a>
<a href="home.php?mod=space&amp;do=favorite&amp;view=me">收藏</a>
<a href="home.php?mod=space&amp;do=friend">好友</a>					
<a href="home.php?mod=spacecp">设置</a>
<a href="home.php?mod=space&amp;do=pm" id="pm_ntc"<?php if($_G['member']['newpm']) { ?> class="new"<?php } ?>>消息</a>
<a href="home.php?mod=space&amp;do=notice" id="myprompt" class="a showmenu<?php if($_G['member']['newprompt']) { ?> new<?php } ?>" >提醒<?php if($_G['member']['newprompt']) { ?>(<?php echo $_G['member']['newprompt'];?>)<?php } ?></a><span id="myprompt_check"></span>
<?php if(empty($_G['cookie']['ignore_notice']) && ($_G['member']['newpm'] || $_G['member']['newprompt_num']['follower'] || $_G['member']['newprompt_num']['follow'] || $_G['member']['newprompt'])) { ?><script language="javascript">delayShow($('myprompt'), function() {showMenu({'ctrlid':'myprompt','duration':3})});</script><?php } if($_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])) { ?><a href="home.php?mod=task&amp;item=doing" id="task_ntc" class="new">进行中的任务</a><?php } if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a>
<?php } if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
<a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a>
<?php } if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
<a href="admin.php" target="_blank">管理中心</a>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra3'])) echo $_G['setting']['pluginhooks']['global_usernav_extra3'];?>
<a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1" id="extcreditmenu"<?php if(!$_G['setting']['bbclosed']) { ?> <?php } ?>>积分: <?php echo $_G['member']['credits'];?></a>
<a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
</div>
</div>
</div>
<?php } elseif(!empty($_G['cookie']['loginuser'])) { ?>
<p>
<strong><a id="loginuser" class="noborder"><?php echo dhtmlspecialchars($_G['cookie']['loginuser']); ?></a></strong>
<a href="member.php?mod=logging&amp;action=login" onclick="showWindow('login', this.href)">激活</a>
<a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
</p>

<?php } elseif(!$_G['connectguest']) { ?>
<div class="y">
<div class="no_login y">
<a href="member.php?mod=logging&amp;action=login" onclick="showWindow('login', this.href)">登录</a> 
<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>"><?php echo $_G['setting']['reglinkname'];?></a>
</div>
<div class="qq_wx_icon y">
<!--hook/global_login_extra-->
<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">
    <p><a href="connect.php?mod=login&amp;op=init&amp;referer=portal.php&amp;statfrom=login_simple">QQ登录</a></p>
<p class="hm xg1" style="padding-top: 2px;">只需一步，快速开始</p>
</div>
<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">
    <p><a class="wx_icon" href="plugin.php?id=wechat:login">微信登录</a></p>
<p class="hm xg1" style="padding-top: 2px;">扫一扫，访问微社区</p>
</div>
</div>
</div>
<?php } else { ?>

<div id="um" class="y">
<div onmouseover="showMenu({'ctrlid':'umLogin'});" class="showmenu umLogin" id="umLogin" initialized="true">
<span class="av"><?php echo avatar(0,small);?></span>
<strong class="vwmy qq"><?php echo $_G['member']['username'];?></strong>
<i class="arrow-w"></i>
</div>
<div id="umLogin_menu" class="p_pop" style="display:none;">
<img class="login_nrrow" src="<?php echo $_G['style']['styleimgdir'];?>header_login_ico.png" alt="" />
<div class="cl um_info">
<a class="avt"><?php echo avatar(0,big);?></a>
</div>
<div class="um_op">
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?>
<a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1">积分: 0</a>
<a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
<div class="qq_login" style="color:#666;">用户组: <?php echo $_G['group']['grouptitle'];?></div>
</div>
</div>

</div>
<?php } ?>