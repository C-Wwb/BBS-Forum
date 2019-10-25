<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_footer_mobile'])) echo $_G['setting']['pluginhooks']['global_footer_mobile'];?><?php $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''?><?php if(strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';?><?php } elseif(strpos($useragent, 'android') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';?><?php } elseif(strpos($useragent, 'windows phone') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';?><?php } ?>

<div id="mask" style="display:none;"></div>
<?php if(!$nofooter) { ?>
<div class="footer">
<div>
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<a href="member.php?mod=logging&amp;action=login" title="登录">登录</a> | <a href="<?php if($_G['setting']['regstatus']) { ?>member.php?mod=<?php echo $_G['setting']['regname'];?><?php } else { ?>javascript:;" style="color:#D7D7D7;<?php } ?>" title="<?php echo $_G['setting']['reglinkname'];?>">注册</a>
<?php } else { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1"><?php echo $_G['member']['username'];?></a> , <a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>" title="退出" class="dialog">退出</a>
<?php } ?>
</div>
    <div>
<a href="<?php echo $_G['setting']['mobile']['simpletypeurl']['0'];?>">标准版</a> |  
<a href="javascript:;" style="color:#D7D7D7;">触屏版</a> | 
<a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>">电脑版</a>
</div>
<p style="font-size: 12px; color: #999; margin-top: 5px;">&copy; 技术支持：<a href="<?php echo $_G['style']['网址'];?>"  target="_blank"><?php echo $_G['style']['技术支持'];?></a></p>
</div>
<?php } ?>

<nav id="mainNv" class="mainNv">
<div class="menuWarp">

<div class="userInfo cfix">
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<a href="member.php?mod=logging&amp;action=login">
<div class="avatar fl"><?php echo avatar($_G[uid]);?></div>
<h3>点击登录</h3>
<!--	<p>登录更多精彩功能！</p> -->
</a>
<?php } else { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1">
<div class="avatar fl"><?php echo avatar($_G[uid]);?></div>
<h3><?php echo $_G['member']['username'];?></h3>
<p>用户组: <?php echo $_G['group']['grouptitle'];?></p>
</a>
<?php } ?>
</div>

<ul>
<li class="nv1"><a href="portal.php">首页</a></li>
<li class="nv2"><a href="forum.php?forumlist=1&amp;mobile=2">论坛板块</a></li>
<li class="nv3"><a href="portal.php?mod=list&amp;catid=1">新闻资讯</a></li>
<li class="nv4"><a href="forum.php?mod=forumdisplay&amp;fid=41&amp;mobile=2">图片瀑布流</a></li>
<li class="nv5"><a href="forum.php?mod=guide&amp;view=newthread">导读</a></li>
<li class="nv9"><a href="misc.php?mod=tag&amp;mobile=2">标签</a></li>
<li class="nv6"><a href="search.php?mod=forum">搜索</a></li>
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<li class="nv7"><a href="member.php?mod=logging&amp;action=login">登录</a></li>
<?php } else { ?>
<li class="nv8"><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a></li>
<?php } ?>
</ul>
</div>
</nav>

</div>
 <script>
//滚动后导航固定
jQuery(function(){
jQuery(window).scroll(function(){
          height = jQuery(window).scrollTop();
   	  	  if(height > 50){
 jQuery('.header').addClass("header_fixed fadeInDown");
   	  	  }else{
 jQuery('.header').removeClass("header_fixed fadeInDown");
   	  	  };
});
});
</script>
</body>
</html><?php updatesession();?><?php if(defined('IN_MOBILE')) { output();?><?php } else { output_preview();?><?php } ?>


