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
                <?php if($_logined) { ?>
                    <li class="title <?php if(($channel == 'user')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/user/<?php echo (getuserdomainbyid($_uid)); ?>">我的空间</a></li>
                <?php } ?>
            </ul>
            <p class="user">
                <?php if(!$_logined) { ?>
                [<a href="http://localhost:9990/gtp/user/login">登录</a><a href="http://localhost:9990/gtp/user/register">注册</a>]
                <?php } else { ?>
                [ <?php echo (urldecode($_nick)); ?> &nbsp; <a href="http://localhost:9990/gtp/message/" class="mlr0">邮件<?php if($_msgNum > 0) { ?><span id="msg">(<?php echo ($_msgNum); ?>)</span><?php } ?></a><a href="http://localhost:9990/gtp/user/settings">设置</a> <a href="http://localhost:9990/gtp/user/logout">退出</a>]
                <?php } ?>
            </p>
        </div>
    </div>

<div class="contaier wp cf">
<div class="ident">邮件</div>
    <div class="login" style="width: 580px;margin-top: 0px;">
        
        <?php if($type=="mine"){ ?>
            <div class="slogan"><p><a href="http://localhost:9990/gtp/message/">收件箱</a> 已发送</p></div>
        <?php } else { ?>
            <div class="slogan"><p>收件箱 <a href="http://localhost:9990/gtp/message/mine">已发送</a></p></div>
        <?php } ?>
        
        <br/>
        <div class="cate">
            <ul class="item">
            <!-- title -->
            <li style="height: 35px;">
                <div class="left">
                    <span class="title" style="width: 350px;display: block; float: left;"><strong>邮件</strong></span>
                </div>
                <div class="middle">
                     <span class="title" style="width: 140px;display: block; float: right; text-align: right;"><strong>发布时间</strong></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right; color:#333;"><strong>操作</strong></span>
                </div>
            </li>
            <!-- member -->
            
            <?php if(is_array($message_list)): foreach($message_list as $key=>$item): ?><li style="height: 55px; line-height: 28px;overflow: hidden; <?php if($item['state'] == 100 && $_uid != $item['user_id']) { ?>background: #c7c7c7;<?php } ?>">
                <div class="left">
                    <span class="title" style="width: 350px;display: block; float: left;">
                        <?php if($type=="mine"){ ?>
                            收件人：<?php echo (getusernick($item["to_id"])); ?>
                        <?php } else { ?>
                            发件人：<?php echo ($item["nick"]); ?>
                        <?php } ?>
                        
                        <br />
                        <input type="checkbox" name="id[]" /><a href="http://localhost:9990/gtp/message/<?php echo ($item["id"]); ?>" ><?php echo ($item["title"]); ?></a>
                    </span>
                </div>
                <div class="middle">
                     <span class="title c6" style="width: 140px;display: block; float: right; text-align: right;"><?php echo (totime($item["add_time"])); ?></span>
                </div>
                <div class="right">
                    <span class="date" style="display: block; float: right;">
                        <a onclick="return confirm('删除邮件 ?');" href="http://localhost:9990/gtp/message/operate/<?php echo ($item["id"]); ?>?type=delete">[x]</a>
                    </span>
                </div>
            </li><?php endforeach; endif; ?>
            
            </ul>
        </div>
        
        <br/>
        <br/>
        
        
        <br class="clear" />
        <br/>
        <br/>
        
        <br class="clear" />
        <br />
       
    </div>
    
    
    <div class="login-other">
        
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