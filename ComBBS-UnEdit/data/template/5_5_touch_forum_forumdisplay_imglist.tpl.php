<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if(empty($_G['forum']['picstyle']) || $_G['cookie']['forumdefstyle']) { if(!$subforumonly) { ?>
<div class="threadlist">
<ul>                
<?php if($_G['forum_threadcount']) { if(is_array($_G['forum_threadlist'])) foreach($_G['forum_threadlist'] as $key => $thread) { if(!$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0) { continue;?><?php } if($thread['displayorder'] > 0 && !$displayorder_thread) { $displayorder_thread = 1;?><?php } if($thread['moved']) { $thread[tid]=$thread[closed];?><?php } $piccount = setthreadpic($thread[tid],1,'piccount');?><li>
<a class="forumDisplayImgList" href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>">
<?php if($piccount !== 1) { ?>
<div class="threadListTit">
<div class="h_avatar"><?php echo avatar($thread[authorid],small);?></div>
<h4>
<div class="count y">
<span class="views icon"><?php if($thread['isgroup'] != 1) { ?><?php echo $thread['views'];?><?php } else { ?><?php echo $groupnames[$thread['tid']]['views'];?><?php } ?></span>
<span class="replies icon"><?php echo $thread['replies'];?></span>
</div>
<?php echo $thread['author'];?>
</h4>
<p>发布于 <?php echo $thread['dateline'];?></p>
</div>
<h3 class="threadSubject">
<?php if($thread['special'] == 1) { ?>
<span class="threadType">投票</span>
<?php } elseif($thread['special'] == 2) { ?>
<span class="threadType">商品</span>
<?php } elseif($thread['special'] == 3) { ?>
<span class="threadType">悬赏</span>
<?php } elseif($thread['special'] == 4) { ?>
<span class="threadType">活动</span>
<?php } elseif($thread['special'] == 5) { ?>
<span class="threadType">辩论</span>
<?php } elseif(in_array($thread['displayorder'], array(1, 2, 3, 4))) { ?>
<span class="threadAttr"><?php echo $_G['setting']['threadsticky'][3-$thread['displayorder']];?></span>
<?php } elseif($thread['digest'] > 0) { ?>
<span class="threadAttr">精华</span>
<?php } ?>
<span  <?php echo $thread['highlight'];?>><?php echo $thread['subject'];?></span>
</h3>
<?php } if($piccount >= 2) { $width=$piccount==2?'300':'200';?><?php $height=$piccount==2?'180':'200';?><div class="forumImgList <?php if($piccount == 2) { ?>two<?php } ?> mt20">
<ul class="cfix"><?php $piclist=setthreadpic($thread[tid],3,'piclist');?><?php $i=1;?> <?php if(is_array($piclist)) foreach($piclist as $key) { ?>                        
<li><span><img src="<?php echo $key;?>" ></span></li><?php $i++;?> 
<?php } ?>
</ul>
</div>
<?php } elseif($piccount == 1) { ?>
<div class="oneImgList cfix">
<div class="oneCon fl">
<h3 class="threadSubject">
<?php if($thread['special'] == 1) { ?>
<span class="threadType">投票</span>
<?php } elseif($thread['special'] == 2) { ?>
<span class="threadType">商品</span>
<?php } elseif($thread['special'] == 3) { ?>
<span class="threadType">悬赏</span>
<?php } elseif($thread['special'] == 4) { ?>
<span class="threadType">活动</span>
<?php } elseif($thread['special'] == 5) { ?>
<span class="threadType">辩论</span>
<?php } elseif(in_array($thread['displayorder'], array(1, 2, 3, 4))) { ?>
<span class="threadAttr"><?php echo $_G['setting']['threadsticky'][3-$thread['displayorder']];?></span>
<?php } elseif($thread['digest'] > 0) { ?>
<span class="threadAttr">精华</span>
<?php } ?>
<span  <?php echo $thread['highlight'];?>><?php echo $thread['subject'];?></span>
</h3>
<div class="oneInfo"><?php echo $thread['author'];?> 发布于  <?php echo $thread['dateline'];?></div>
</div>
<div class="oneImg fr"><?php $piclist=setthreadpic($thread[tid],1,'piclist');?><img src="<?php echo current($piclist); ?>" />
</div>
</div>
<?php } else { } ?>
</a>
</li>
<?php } } else { ?>
<li class="noData">本版块或指定的范围内尚无主题</li>
<?php } ?>
</ul>
</div>
<?php echo $multipage;?>
<?php } } else { ?>

<div class="xr_waterfall cfix">
<script src="template/xinrui_iuni_mobile/touch/images/js/jquery.masonry.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
var container = $('#waterfall');
container.imagesLoaded(function() {
container.masonry({
itemSelector: '.imgItem',
isResizableL: true,
});
});
});
</script>	
<div id="waterfall" class="waterfall cfix"><?php if(is_array($_G['forum_threadlist'])) foreach($_G['forum_threadlist'] as $key => $thread) { if($_G['hiddenexists'] && $thread['hidden']) { continue;?><?php } if(!$thread['forumstick'] && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { if($thread['related_group'] == 0 && $thread['closed'] > 1) { $thread[tid]=$thread[closed];?><?php } } $waterfallwidth = $_G[setting][forumpicstyle][thumbwidth] + 24;?><div class="imgItem">
<a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;<?php if($_GET['archiveid']) { ?>archiveid=<?php echo $_GET['archiveid'];?>&amp;<?php } ?>extra=<?php echo $extra;?>">
<div class="img" >
<?php if($thread['cover']) { ?>
<img src="<?php echo $thread['coverpath'];?>" alt="<?php echo $thread['subject'];?>" width="<?php echo $_G['setting']['forumpicstyle']['thumbwidth'];?>"/>
<?php } else { ?>
<span class="no_pic"></span>
<?php } ?>
</div>
<h3>
<?php echo $thread['subject'];?>
</h3>
<div class="desc cfix">
<?php echo $thread['author'];?>
<span class="fr">
<span class="views icon"><?php echo $thread['views'];?></span>
<span class="replies icon"><?php echo $thread['replies'];?></span>
</span>
</div>
</a>

</div>
<?php } ?>
</div>
<div id="tmppic" style="display: none;"></div>
</div>
<?php echo $multipage;?>
<?php } ?>

