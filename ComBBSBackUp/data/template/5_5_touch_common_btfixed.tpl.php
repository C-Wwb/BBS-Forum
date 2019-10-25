<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div class="btFixed">
<ul>
<li><a class="btHome <?php if(CURSCRIPT == 'portal' && CURMODULE == 'index') { ?>cur<?php } ?>" href="portal.php"><span></span>首页</a></li>
<li><a class="btForum <?php if(CURSCRIPT == 'forum' && CURMODULE == 'index') { ?>cur<?php } ?>" href="forum.php?forumlist=1&amp;mobile=2"><span></span>论坛</a></li>
<li><a class="btPost" href="forum.php?mod=misc&amp;action=nav">发帖</a></li>
<li><a class="btSearch <?php if(CURSCRIPT == 'search') { ?>cur<?php } ?>" href="search.php?mod=forum"><span></span>搜索</a></li>
<li><a class="btPerson <?php if(CURSCRIPT == 'home') { ?>cur<?php } ?>" href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1"><span></span>我的</a></li>
</ul>
<div class="btBg"></div>
</div>

