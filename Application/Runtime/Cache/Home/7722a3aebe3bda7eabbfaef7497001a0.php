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
    <?php if(!empty($description)): ?><meta name="description" content="<?php echo ($description); ?>,收藏自阿谱小站." />
    <?php else: ?>
    <meta name="description" content="Guitar-pro,收集分享Guitar-pro吉他谱,吉他视频,为吉他爱好者打造网上资源互动社区." /><?php endif; ?>
    <link rel="alternate" type="application/rss+xml" title="阿谱小站" href="http://localhost:9990/gtp/feed" />
    <link rel="shortcut icon" href="http://localhost:9990/gtp/favicon.png" type="image/x-icon" />
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
                <li class="title <?php if(($channel == 'Home')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp">首页</a></li>
                <li class="title <?php if(($channel == 'Gtp')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/gtp/">吉他谱</a></li>
                <li class="title <?php if(($channel == 'Vedio')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/vedio/">吉他视频</a></li>
                <li class="title <?php if($channel == "Group" || $channel == "Topic") { ?>selected<?php } ?>"><a class="show" href="http://localhost:9990/gtp/group/">小组</a></li>
            </ul>
            <p class="user">
                <?php if(!$_logined) { ?>
                [<a href="http://localhost:9990/gtp/user/login">登录</a><a href="http://localhost:9990/gtp/user/register">注册</a>]
                <?php } else { ?>
                [ <?php echo (urldecode($_nick)); ?> <a href="http://localhost:9990/gtp/user/settings">设置</a> <a href="http://localhost:9990/gtp/user/logout">退出</a>]
                <?php } ?>
            </p>
        </div>
    </div>

<div class="contaier wp cf">
<div class="ident">小组</div>
    <div class="login" style="width: 580px; margin-top: 0px;">
        
        <div class="slogan"><p>违禁词</p></div>
        <br/>
        <form class="form" action="http://localhost:9990/gtp/dirty/add" method="post">
            <input type="text" name="name" placeholder="添加违禁词" class="text" />
            <input type="hidden" name="group_id" value="<?php echo ($group_id); ?>">
            <input type="submit" class="button" value="添加" />
        </form>
        <div class="cate">
            <ul class="item">
            <li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><strong>违禁词</strong></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 150px;display: block; float: left;"><strong>创建人</strong></span>
                     <span class="title" style="width: 180px;display: block; float: left;"><strong>添加时间</strong></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: left; color:#333;"><strong>删除</strong></span>
                </div>
            </li>
            <?php if(is_array($dirty_list)): foreach($dirty_list as $key=>$item): ?><li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><?php echo ($item["name"]); ?></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 150px;display: block; float: left;"><a href="http://localhost:9990/gtp/user/<?php echo (getuserdomain($item["user_id"])); ?>"><?php echo ($item["nick"]); ?></a></span>
                     <span class="title" style="width: 180px;display: block; float: left;"><?php echo (todate($item["add_time"])); ?></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right;"><a onclick="return confirm('删除 ?');" href="http://localhost:9990/gtp/dirty/delete/<?php echo ($item["id"]); ?>?group_id=<?php echo ($group_id); ?>">[x]</a></span>
                </div>
            </li><?php endforeach; endif; ?>
            </ul>
        </div>
        
        <br/>
        <br/>
        
        <div class="slogan"><p>黑名单</p></div>
        <br/>
        <div class="cate">
            <ul class="item">
            <li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><strong>用户名</strong></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 150px;display: block; float: left;"><strong></strong></span>
                     <span class="title" style="width: 180px;display: block; float: right;"><strong>添加时间</strong></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: left; color:#333;"><strong>解禁</strong></span>
                </div>
            </li>
            <?php if(is_array($ban_list)): foreach($ban_list as $key=>$item): ?><li>
                <div class="left">
                    <span class="title" style="width: 150px;display: block; float: left;"><a href="http://localhost:9990/gtp/user/<?php echo (getuserdomain($item["user_id"])); ?>"><?php echo ($item["nick"]); ?></a></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 150px;display: block; float: left;"></span>
                     <span class="title" style="width: 180px;display: block; float: right;"><?php echo (todate($item["add_time"])); ?></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right;"><a onclick="return confirm('解禁 ?');" href="http://localhost:9990/gtp/group/role/<?php echo ($item["id"]); ?>?type=group_unban">[x]</a></span>
                </div>
            </li><?php endforeach; endif; ?>
            </ul>
        </div>
        
        <br/>
        
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
            <p class="copy">&copy;ThinkPHP 2012</p>
            <p class="navg"><a href="/about/index.html">关于我们</a><a href="/about/donate.html">捐赠我们</a><a href="/update/index.html">更新列表</a><a href="/bug/index.html">BUG反馈</a><a href="/suggest/index.html">功能建议</a><a href="/link/index.html">友情链接</a></p>
            <p class="links"><a href="/donate/index.html">捐赠 <?php echo ($is_mobile ? "手机浏览" : "PC浏览"); ?></a><a href="/rss/index.xml">订阅</a><a href="/about/attention.html">关注</a><a href="http://bbs.thinkphp.cn" target="_blank">论坛</a></p>
        </div>
    </div>
    <input type="hidden" name="site" id="site" value="http://localhost:9990/gtp" />
<div style="display:none">
    
</div>
</body>
</html>