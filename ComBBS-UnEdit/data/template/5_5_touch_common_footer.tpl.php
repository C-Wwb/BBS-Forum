<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_footer_mobile'])) echo $_G['setting']['pluginhooks']['global_footer_mobile'];?><?php $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''?><?php if(strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';?><?php } elseif(strpos($useragent, 'android') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';?><?php } elseif(strpos($useragent, 'windows phone') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';?><?php } ?>

<div id="mask" style="display:none;"></div>
<?php if(!$nofooter) { ?>
<div class="footer">
<div>
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<a href="member.php?mod=logging&amp;action=login" title="��¼">��¼</a> | <a href="<?php if($_G['setting']['regstatus']) { ?>member.php?mod=<?php echo $_G['setting']['regname'];?><?php } else { ?>javascript:;" style="color:#D7D7D7;<?php } ?>" title="<?php echo $_G['setting']['reglinkname'];?>">ע��</a>
<?php } else { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1"><?php echo $_G['member']['username'];?></a> , <a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>" title="�˳�" class="dialog">�˳�</a>
<?php } ?>
</div>
    <div>
<a href="<?php echo $_G['setting']['mobile']['simpletypeurl']['0'];?>">��׼��</a> |  
<a href="javascript:;" style="color:#D7D7D7;">������</a> | 
<a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>">���԰�</a>
</div>
<p style="font-size: 12px; color: #999; margin-top: 5px;">&copy; ����֧�֣�<a href="<?php echo $_G['style']['��ַ'];?>"  target="_blank"><?php echo $_G['style']['����֧��'];?></a></p>
</div>
<?php } ?>

<nav id="mainNv" class="mainNv">
<div class="menuWarp">

<div class="userInfo cfix">
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<a href="member.php?mod=logging&amp;action=login">
<div class="avatar fl"><?php echo avatar($_G[uid]);?></div>
<h3>�����¼</h3>
<!--	<p>��¼���ྫ�ʹ��ܣ�</p> -->
</a>
<?php } else { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1">
<div class="avatar fl"><?php echo avatar($_G[uid]);?></div>
<h3><?php echo $_G['member']['username'];?></h3>
<p>�û���: <?php echo $_G['group']['grouptitle'];?></p>
</a>
<?php } ?>
</div>

<ul>
<li class="nv1"><a href="portal.php">��ҳ</a></li>
<li class="nv2"><a href="forum.php?forumlist=1&amp;mobile=2">��̳���</a></li>
<li class="nv3"><a href="portal.php?mod=list&amp;catid=1">������Ѷ</a></li>
<li class="nv4"><a href="forum.php?mod=forumdisplay&amp;fid=41&amp;mobile=2">ͼƬ�ٲ���</a></li>
<li class="nv5"><a href="forum.php?mod=guide&amp;view=newthread">����</a></li>
<li class="nv9"><a href="misc.php?mod=tag&amp;mobile=2">��ǩ</a></li>
<li class="nv6"><a href="search.php?mod=forum">����</a></li>
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<li class="nv7"><a href="member.php?mod=logging&amp;action=login">��¼</a></li>
<?php } else { ?>
<li class="nv8"><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">�˳�</a></li>
<?php } ?>
</ul>
</div>
</nav>

</div>
 <script>
//�����󵼺��̶�
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


