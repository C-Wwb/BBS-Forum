<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('forumdisplay');?><?php include template('touch/common/header'); ?><!-- header start -->
<header class="header">
<a href="forum.php?forumlist=1" class="goBack fl">返回</a>
<?php if(($subexists && $_G['page'] == 1) || ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0) { ?>
<a class="topSort fr" href="#subMenu">子版块</a>
<h1><?php echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];?></h1>
<div id="subMenu" class="subMenu">
<div class="subMenuBox">
<h3>子版块</h3>
<ul><?php if(is_array($sublist)) foreach($sublist as $sub) { ?><li><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $sub['fid'];?>"><?php echo $sub['name'];?></a></li>
<?php } ?>
</ul>
<h3>主题分类</h3>
<?php if(($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0) { ?>
<ul id="thread_types">
<li id="ttp_all" <?php if(!$_GET['typeid'] && !$_GET['sortid']) { ?>class="a"<?php } ?>>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?><?php if($_G['forum']['threadsorts']['defaultshow']) { ?>&amp;filter=sortall&amp;sortall=1<?php } if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>">全部分类
<span class="num">(<?php echo $_G['forum']['threads'];?>)</span>
</a>
</li>
<?php if($_G['forum']['threadtypes']) { if(is_array($_G['forum']['threadtypes']['types'])) foreach($_G['forum']['threadtypes']['types'] as $id => $name) { if($_GET['typeid'] == $id) { ?>
<li class="a"><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?><?php if($_GET['sortid']) { ?>&amp;filter=sortid&amp;sortid=<?php echo $_GET['sortid'];?><?php } if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>"><?php if($_G['forum']['threadtypes']['icons'][$id] && $_G['forum']['threadtypes']['prefix'] == 2) { ?><img class="vm" src="<?php echo $_G['forum']['threadtypes']['icons'][$id];?>" alt="" /> <?php } ?><?php echo $name;?><?php if($showthreadclasscount['typeid'][$id]) { ?><span class="num"><?php echo $showthreadclasscount['typeid'][$id];?></span><?php } ?></a></li>
<?php } else { ?>
<li><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=typeid&amp;typeid=<?php echo $id;?><?php echo $forumdisplayadd['typeid'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>"><?php if($_G['forum']['threadtypes']['icons'][$id] && $_G['forum']['threadtypes']['prefix'] == 2) { ?><img class="vm" src="<?php echo $_G['forum']['threadtypes']['icons'][$id];?>" alt="" /> <?php } ?><?php echo $name;?><?php if($showthreadclasscount['typeid'][$id]) { ?><span class="num"><?php echo $showthreadclasscount['typeid'][$id];?></span><?php } ?></a></li>
<?php } } } if($_G['forum']['threadsorts']) { if($_G['forum']['threadtypes']) { ?><li><span class="pipe">|</span></li><?php } if(is_array($_G['forum']['threadsorts']['types'])) foreach($_G['forum']['threadsorts']['types'] as $id => $name) { if($_GET['sortid'] == $id) { ?>
<li class="a"><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?><?php if($_GET['typeid']) { ?>&amp;filter=typeid&amp;typeid=<?php echo $_GET['typeid'];?><?php } if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>"><?php echo $name;?><?php if($showthreadclasscount['sortid'][$id]) { ?><span class="xg1 num"><?php echo $showthreadclasscount['sortid'][$id];?></span><?php } ?></a></li>
<?php } else { ?>
<li><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=sortid&amp;sortid=<?php echo $id;?><?php echo $forumdisplayadd['sortid'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>"><?php echo $name;?><?php if($showthreadclasscount['sortid'][$id]) { ?><span class="xg1 num"><?php echo $showthreadclasscount['sortid'][$id];?></span><?php } ?></a></li>
<?php } } } ?>
</ul>
<?php } ?>
</div>
</div>
<script type="text/javascript">
$(function() {
$('#subMenu').mmenu({
autoHeight	: true,
navbar		: {
title 	: false
},
offCanvas	: {
position	: "right",
zposition	: "front",
modal		: true
}
});
});
</script>
<?php } else { ?>
<h1><?php echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];?></h1>
<?php } ?>

</header>
<!-- header end -->

<div class="forumListHeader cfix <?php if($_G['forum']['icon']) { ?>hasIcon<?php } ?>">
<?php if($_G['forum']['icon']) { ?>
<div class="fl_icon fl"><img src="data/attachment/common/<?php echo $_G['forum']['icon'];?>" alt="<?php echo $_G['forum']['name'];?>" /></div>
<?php } ?>
<h3><?php echo $_G['forum']['name'];?></h3>
<p>
<?php if(!$subforumonly) { ?>
<span>今日: <?php echo $_G['forum']['todayposts'];?></span>
<span>主题: <?php echo $_G['forum']['threads'];?></span>
<?php if($_G['forum']['rank']) { ?>
<span title="上次排名:<?php echo $_G['forum']['oldrank'];?>">排名: <?php echo $_G['forum']['rank'];?></span>
<?php } } ?>
</p>
<a class="fa_fav" href="home.php?mod=spacecp&amp;ac=favorite&amp;type=forum&amp;id=<?php echo $_G['fid'];?>&amp;handlekey=favoriteforum&amp;formhash=<?php echo FORMHASH;?>" id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);">收藏<strong class="xi1" id="number_favorite" <?php if(!$_G['forum']['favtimes']) { ?> style="display:none;"<?php } ?>>(<span id="number_favorite_num"><?php echo $_G['forum']['favtimes'];?></span>)</strong></a>
</div>

<div class="forumListTab cfix">
<ul>
<li>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=<?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>" class="<?php if($_GET['filter'] == '') { ?>cur<?php } ?>">全部</a>
</li>
<li>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=lastpost&amp;orderby=lastpost<?php echo $forumdisplayadd['lastpost'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>" class="<?php if($_GET['filter'] == 'lastpost') { ?>cur<?php } ?>">最新</a>
</li>
<li>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=heat&amp;orderby=heats<?php echo $forumdisplayadd['heat'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>" class="<?php if($_GET['filter'] == 'heat') { ?>cur<?php } ?>">热门</a>
</li>
<li>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=digest&amp;digest=1<?php echo $forumdisplayadd['digest'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>" class="<?php if($_GET['filter'] == 'digest') { ?>cur<?php } ?>">精华</a>
</li>
</ul>
</div>

<?php if(!$subforumonly) { ?> 
<div class="threadlist">
<?php if($_G['forum_threadcount']) { ?> <!--如果 帖子总数不为 false 或 0-->
    <?php if($ceo_piclistopen) { ?> <!--如果 图文列表打开状态-->
        <!--如果打开图文列表--><?php include template('forum/forumdisplay_imglist'); ?>    <?php } else { ?>
        <!--如果未打开图文列表--><?php include template('forum/forumdisplay_txtlist'); ?>    <?php } ?> 
<?php } else { ?>  <!--如果 帖子总数是 false 或 0-->
<ul>
<li class="noData">本版块或指定的范围内尚无主题</li>
</ul>
<?php } ?> 
</div>
<?php } ?>

<div class="pullrefresh" style="display:none;"></div>
<style>

</style><?php include template('common/btfixed'); include template('common/nav'); include template('touch/common/footer'); ?>