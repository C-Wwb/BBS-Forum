<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('index');
block_get('30,24,31,32,25,27,26,34,28');?><?php include template('common/header'); ?><header class="header p_header">
<a class="topMenu fl" href="#mainNv">�˵�</a>
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<a class="topLogin fr" href="member.php?mod=logging&amp;action=login"></a>
<?php } else { ?>
<a class="topLogin fr" href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1"><?php echo avatar($_G[uid]);?></a>
<?php } ?>
<h1 class="logo"><img  src="template/xinrui_iuni_mobile/touch/images/img/logo.png"></h1>
</header>
<div class="container">
<script src="template/xinrui_iuni_mobile/touch/images/js/TouchSlide.1.1.js" type="text/javascript" type="text/javascript"></script>
<!--��������-->
<div class="nvBar">
<div class="subNv"><?php block_display('30');?></div>
</div>

<!--����ͼ-->
<div class="xrSlider" id="xrSlider"><?php block_display('24');?></div>
<script type="text/javascript">
TouchSlide({ 
slideCell:"#xrSlider",
titCell:".sliderNum li",
mainCell:".sliderCon ul", 
effect:"leftLoop",
autoPlay:true //�Զ�����
});
</script>
<!-- ��Ŀ���� -->
<div class="cNav cfix pb"><?php block_display('31');?></div>
<!-- ��ҳ���1 -->
<div class="adPic pb"><?php block_display('32');?></div>

<!--�����Ƽ�-->
<div class="hotPosts cfix pb"><?php block_display('25');?></div>

<!--ͼ�ľ�ѡ-->
<div class="pb">
<div class="hdTit cfix">
<h2>ͼ�ľ�ѡ</h2>
</div>
<div class="ausPt cfix" id="ausPt"><?php block_display('27');?></div>
<script type="text/javascript">
TouchSlide({ 
slideCell:"#ausPt",
titCell:".ausPtNum li",
mainCell:".ausPtCon", 
effect:"leftLoop"
});
</script>
</div>


<!--��������-->
<div class="pb">
<div class="hdTit cfix">
<h2>��������</h2>
<span><a href="forum.php?mod=guide&amp;view=newthread">����&gt;&gt;</a></span>
</div>
<div class="newPosts"><?php block_display('26');?></div>
</div>


<!-- ͼƬ���2 -->
<div class="adPic pb"><?php block_display('34');?></div>

<!--��鵼��-->
<div class="pb">
<div class="hdTit cfix">
<h2>��鵼��</h2>
<span><a href="forum.php?forumlist=1&amp;mobile=2">����&gt;&gt;</a></span>
</div>
<div class="coluNv cfix"><?php block_display('28');?></div>
</div>

<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<div class="pb indexLogin">
<p>��¼֮�����������๦�ܣ�</p>
<a href="member.php?mod=logging&amp;action=login">������¼</a>
</div>
<?php } ?>
</div><?php include template('common/btfixed'); include template('common/footer'); ?>