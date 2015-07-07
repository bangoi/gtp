<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> -->
    <?php if(!empty($title)): ?><title><?php echo ($title); ?>|Guitar Pro</title>
    <?php else: ?>
    <title>Guitar Pro</title><?php endif; ?>
    <meta name="keywords" content="吉他谱,吉他,吉他视频,GTP,Guitar Pro,吉他谱下载" />
    <?php if(!empty($description)): ?><meta name="description" content="<?php echo ($description); ?>,收藏自Guitar-Pro.cn." />
    <?php else: ?>
    <meta name="description" content="Guitar-pro,收集分享Guitar-pro吉他谱,吉他视频,为吉他爱好者打造网上资源互动社区." /><?php endif; ?>
    <link rel="alternate" type="application/rss+xml" title="阿谱小站" href="http://localhost:9990/gtp/feed" />
    <link rel="shortcut icon" href="http://localhost:9990/gtp/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="http://localhost:9990/gtp/css/concision.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost:9990/gtp/css/prettify.css" />
    <script type="text/javascript" src="http://localhost:9990/gtp/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="http://localhost:9990/gtp/js/guitar.js"></script>
</head>
<body>
    <div class="header">
        <div class="header-wrap wp cf">
            <h3 class="logo"><a href="http://localhost:9990/gtp" title="返回首页">Guitar Pro</a></h3>
            <ul class="navg">
                <li class="title <?php if((CONTROLLER_NAME == 'Index')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp">首页</a></li>
                <li class="title <?php if((CONTROLLER_NAME == 'Gtp')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/gtp/">吉他谱</a></li>
                <li class="title <?php if(($channel == 'Vedio')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/vedio/">吉他视频</a></li>
                <!--
                <li class="title <?php if($channel == "Group" || $channel == "Topic") { ?>selected<?php } ?>"><a class="show" href="http://localhost:9990/gtp/group/">小组</a></li>
                <?php if($_logined) { ?>
                    <li class="title <?php if(($channel == 'user')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/user/<?php echo (getuserdomainbyid($_uid)); ?>">我的空间</a></li>
                <?php } ?>
                -->
            </ul>
            <p class="user">
                <?php if(!$_logined) { ?>
                [<a href="http://localhost:9990/gtp/user/login">登录</a><a href="http://localhost:9990/gtp/user/register">注册</a>]
                <?php } else { ?>
                [ <?php echo (urldecode($_nick)); ?> &nbsp; 
                <!--
                <a href="http://localhost:9990/gtp/message/" class="mlr0">邮件<?php if($_msgNum > 0) { ?><span id="msg">(<?php echo ($_msgNum); ?>)</span><?php } ?></a>
                -->
                <a href="http://localhost:9990/gtp/user/settings">设置</a> <a href="http://localhost:9990/gtp/user/logout">退出</a>]
                <?php } ?>
            </p>
        </div>
    </div>

<div class="contaier wp cf">
<div class="ident">小组</div>
    <div class="login" style="width: 580px;margin-top: 0px;">
        
        
        <div class="slogan"><p>成员管理</p></div>
        <br/>
        <form class="form" action="http://localhost:9990/gtp/group/member/<?php echo ($group_id); ?>" method="get">
            <input type="text" name="nick" placeholder="输入小组成员昵称" value="<?php echo ($nick); ?>" class="text" />
            <input type="submit" class="button" value="查找" />
        </form>
        <div class="cate">
            <ul class="item">
            <!-- title -->
            <li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><strong>用户名</strong></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 100px;display: block; float: left;"><strong>角色</strong></span>
                     <span class="title" style="width: 180px;display: block; float: left;"><strong>加入时间</strong></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: left; color:#333;"><strong>操作</strong></span>
                </div>
            </li>
            <!-- owner -->
            <?php if(!empty($owner)) { ?>
            <li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><a href="http://localhost:9990/gtp/user/<?php echo (getuserdomain($owner)); ?>"><?php echo ($owner["nick"]); ?></a></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 100px;display: block; float: left;">创建人</span>
                     <span class="title" style="width: 180px;display: block; float: left;"><?php echo (totime($group["add_time"])); ?></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right;"></span>
                </div>
            </li>
            <?php } ?>
            <!-- admin -->
            <?php if(is_array($admin_list)): foreach($admin_list as $key=>$item): ?><li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><a href="http://localhost:9990/gtp/user/<?php echo (getuserdomain($item)); ?>"><?php echo ($item["nick"]); ?></a></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 100px;display: block; float: left;">管理员</span>
                     <span class="title" style="width: 180px;display: block; float: left;"><?php echo (totime($item["add_time"])); ?></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right;"><a onclick="return confirm('取消管理员 ?');" href="http://localhost:9990/gtp/group/role/<?php echo ($item["ug_id"]); ?>?type=admin_cancel">[取消]</a></span>
                </div>
            </li><?php endforeach; endif; ?>
            <!-- member -->
            
            <?php if(is_array($member_list)): foreach($member_list as $key=>$item): ?><li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><a href="http://localhost:9990/gtp/user/<?php echo (getuserdomain($item)); ?>"><?php echo ($item["nick"]); ?></a></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 100px;display: block; float: left;">成员</span>
                     <span class="title" style="width: 180px;display: block; float: left;"><?php echo (totime($item["add_time"])); ?></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right;">
                        <a onclick="return confirm('提升为管理员 ?');" href="http://localhost:9990/gtp/group/role/<?php echo ($item["ug_id"]); ?>?type=admin_add">[管理员]</a>
                        <a onclick="return confirm('加入黑名单 ?');" href="http://localhost:9990/gtp/group/role/<?php echo ($item["ug_id"]); ?>?type=group_ban">[黑名单]</a>
                    </span>
                </div>
            </li><?php endforeach; endif; ?>
            </ul>
        </div>
        
        <br/>
        <br/>
        
        
        
        
        
         <div class="head">
            <strong>创建人</strong>
        </div>
        <br />
        <ul class="member-list">
            <li>
                <div class="pic">
                <a href="http://localhost:9990/gtp/user/<?php getUserDomain($owner); ?>"><img src="<?php getUserFace($owner, 's'); ?>" /></a>
                </div>
                <div class="name">
                    <a href="http://localhost:9990/gtp/user/<?php getUserDomain($owner); ?>" class=""><?php echo ($owner["nick"]); ?></a>
                </div>
            </li>
        </ul>
        
        <br class="clear" />
        <br/>
        <br/>
        <br/>
        
        <div class="head">
            <strong>版主</strong>
        </div>
        <br />
        <form action="http://localhost:9990/gtp/group/role" method="post">
        <ul class="member-list">
            <?php if(is_array($admin_list)): foreach($admin_list as $key=>$item): ?><li>
                <div class="pic">
                <img id="imgAdmin-<?php echo ($item["id"]); ?>" src="<?php getUserFace($item, 's'); ?>" state="0" class="adminCheck" />
                <input type="checkbox" name="member_id[]" class="chk" id="chkAdmin-<?php echo ($item["id"]); ?>" checked="true" value="-1" />
                </div>
                <div class="name">
                    <a href="http://localhost:9990/gtp/user/<?php getUserDomain($item); ?>" class=""><?php echo ($item["nick"]); ?></a>
                </div>
            </li><?php endforeach; endif; ?>
        </ul>
        <br class="clear" />
        <br/>
        <input type="hidden" name="group_id" value="<?php echo ($group_id); ?>" />
        <input type="hidden" name="type" value="cancel_admin" />
        <input type="submit" value="取消版主" class="button" />
        </form>
        <br class="clear" />
        <br/>
        <br/>
        <br/>
        
        <div class="head">
            <strong>小组成员</strong>
        </div>
        <br />
        <form id="groupMemberForm" action="http://localhost:9990/gtp/group/role" method="post">
        <ul class="member-list">
            <?php if(is_array($member_list)): foreach($member_list as $key=>$item): ?><li>
                <div class="pic">
                    <img id="imgMember-<?php echo ($item["id"]); ?>" src="<?php getUserFace($item, 's'); ?>" state="0" class="memberCheck" />
                    <input type="checkbox" name="member_id[]" class="chk" id="chkMember-<?php echo ($item["id"]); ?>" checked="true" value="-1" />
                </div>
                <div class="name">
                    <a href="http://localhost:9990/gtp/user/<?php getUserDomain($item); ?>" class=""><?php echo ($item["nick"]); ?></a>
                </div>
            </li><?php endforeach; endif; ?>
        </ul>
        <br class="clear" />
        <br/>
        
        <input type="hidden" name="group_id" value="<?php echo ($group_id); ?>" />
        <input type="hidden" id="groupRoleAction" name="type" value="" />
        
        <input type="button" id="btnAdmin" value="设为版主" class="button" /> &nbsp;
        <input type="button" id="btnRemove" value="加入黑名单" class="button" /> &nbsp;
        </form>
        
        <br class="clear" />
        <br/>
        <br/>
        
        <br class="clear" />
        <br />
        
       
    </div>
    
    
    <div class="login-other">
        <div class="head">
            <strong>使用其他帐号直接登录</strong>
        </div>
        <div class="body">
            <ul class="other-account">
    <li><a href="http://localhost:9990/gtp/group/edit/<?php echo ($group_id); ?>">小组信息管理</a></li>
    <li><a href="http://localhost:9990/gtp/group/member/<?php echo ($group_id); ?>">小组成员管理</a></li>
    <li><a href="http://localhost:9990/gtp/group/topic/<?php echo ($group_id); ?>">小组话题管理</a></li>
</ul>
        </div>
    </div>
</div>

<div class="footer">
        <div class="wp">
            <p class="copy" style="">&copy;<a href="http://localhost:9990/gtp">Guitar-Pro.cn</a> 2012 &nbsp; </p>
            <p class="navg"><a href="http://localhost:9990/gtp/blog/1">关于我们</a><a href="http://localhost:9990/gtp/blog/2">更新列表</a><a href="http://localhost:9990/gtp/blog/3">BUG反馈</a><a href="http://localhost:9990/gtp/blog/4">功能建议</a><a href="http://localhost:9990/gtp/blog/5">友情链接</a></p>
            <p class="links"></p>
        </div>
    </div>
    <input type="hidden" name="site" id="site" value="http://localhost:9990/gtp" />
    <script type="text/javascript">(function(){document.write(unescape('%3Cdiv id="bdcs"%3E%3C/div%3E'));var bdcs = document.createElement('script');bdcs.type = 'text/javascript';bdcs.async = true;bdcs.src = 'http://znsv.baidu.com/customer_search/api/js?sid=14009195900081859174' + '&plate_url=' + encodeURIComponent(window.location.href) + '&t=' + Math.ceil(new Date()/3600000);var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(bdcs, s);})();</script>
    <div style="display:none">
    <script language="javascript" type="text/javascript" src="http://js.users.51.la/17745245.js"></script>
    <noscript><a href="http://www.51.la/?17745245" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/17745245.asp" style="border:none" /></a></noscript>
    </div>
</body>
</html>