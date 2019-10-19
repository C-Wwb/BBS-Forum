<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('index');
block_get('30,24,31,32,25,27,26,34,28');?><?php include template('common/header'); ?><header class="header p_header">
<a class="topMenu fl" href="#mainNv">菜单</a>
<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<a class="topLogin fr" href="member.php?mod=logging&amp;action=login"></a>
<?php } else { ?>
<a class="topLogin fr" href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1"><?php echo avatar($_G[uid]);?></a>
<?php } ?>
<h1 class="logo"><img  src="template/xinrui_iuni_mobile/touch/images/img/logo.png"></h1>
</header>
<div class="container">
<script src="template/xinrui_iuni_mobile/touch/images/js/TouchSlide.1.1.js" type="text/javascript" type="text/javascript"></script>
<!--二级导航-->
<div class="nvBar">
<div class="subNv"><?php block_display('30');?></div>
</div>

<!--焦点图-->
<div class="xrSlider" id="xrSlider"><?php block_display('24');?></div>
<script type="text/javascript">
TouchSlide({ 
slideCell:"#xrSlider",
titCell:".sliderNum li",
mainCell:".sliderCon ul", 
effect:"leftLoop",
autoPlay:true //自动播放
});
</script>
<!-- 栏目导航 -->
<div class="cNav cfix pb"><?php block_display('31');?></div>
<!-- 首页广告1 -->
<div class="adPic pb"><?php block_display('32');?></div>

<!--热帖推荐-->
<div class="hotPosts cfix pb"><?php block_display('25');?></div>

<!--图文精选-->
<div class="pb">
<div class="hdTit cfix">
<h2>图文精选</h2>
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


<!--最新主题-->
<div class="pb">
<div class="hdTit cfix">
<h2>最新主题</h2>
<span><a href="forum.php?mod=guide&amp;view=newthread">更多&gt;&gt;</a></span>
</div>
<div class="newPosts"><?php block_display('26');?></div>
</div>


<!-- 图片广告2 -->
<div class="adPic pb"><?php block_display('34');?></div>

<!--版块导航-->
<div class="pb">
<div class="hdTit cfix">
<h2>版块导航</h2>
<span><a href="forum.php?forumlist=1&amp;mobile=2">更多&gt;&gt;</a></span>
</div>
<div class="coluNv cfix"><?php block_display('28');?></div>
</div>

<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<div class="pb indexLogin">
<p>登录之后可以体验更多功能！</p>
<a href="member.php?mod=logging&amp;action=login">立即登录</a>
</div>
<?php } ?>
</div><?php include template('common/btfixed'); include template('common/footer'); ?>