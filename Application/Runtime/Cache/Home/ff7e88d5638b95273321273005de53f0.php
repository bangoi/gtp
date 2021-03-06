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

<div class="contaier thinkphp-app wp">
    <div class="app-left">
        <div class="ident">话题</div>
        <!--文章详细-->
        <div class="app-detail">
            <h1><?php echo ($message["title"]); ?></h1>
            <div class="body">
                <div style="margin-top: 0px; color: #999;">
                    <div style="width: 100%;">
                        <div style="float: left">
                            <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($message['user_id']); ?>"><img src="<?php getUserFaceById($message['user_id'], 's'); ?>" class="face" /></a>
                        </div>
                        <div style="float: left; margin-left: 10px;">
                                  来自：<a href="http://localhost:9990/gtp/user/<?php getUserDomainById($message['user_id']); ?>"><?php echo ($message["nick"]); ?></a>
                           <p style="line-height: 30px;"><?php echo (totime($message["add_time"])); ?></p>
                        </div>
                    </div>
                    <br class="clear" />
                    <br/>
                    <div style="line-height: 200%; color: #333;">
                        <?php echo (autolink($message["content"])); ?>    
                    </div>
                </div>
            </div>
        </div>
        <!--/文章详细-->
        
        <!-- reply list -->
        <div class="review">
        <?php  $item_type = "topic"; $item_id = $topic['id']; ?>
        <ul id="comment_list">
            <?php if(is_array($message_list)): foreach($message_list as $key=>$comment): ?><li id="comment-<?php echo ($comment["id"]); ?>">
                <div class="comm_l">
                    <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($comment['user_id']) ?>"><img src="<?php getUserFaceById($comment['user_id']); ?>" class="face" /></a>
                </div>
                <div class="comm_r">
                    <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($comment['user_id']) ?>" id="comm-nick-<?php echo ($comment["id"]); ?>"><?php echo ($comment["nick"]); ?></a> &nbsp; <span class="c7"><?php echo (firendlytime($comment["add_time"])); ?></span>
                    <p id="comm-cnt-<?php echo ($comment["id"]); ?>"><?php echo (autolink($comment["content"])); ?></p>
                </div>
                <div class="c_opt">
                    <?php if($comment["user_id"] == $_uid) { ?>
                    <a href="javascript:void(0);" class="doDelete" cid="<?php echo ($comment["id"]); ?>">删除</a> &nbsp;
                    <?php } ?>
                </div>
                <br class="clear" />
            </li><?php endforeach; endif; ?>
        </ul>
        <!-- page begin -->
        <div class="manu"><?php echo ($page); ?></div>
        <!-- page end -->
        </div>
        <!-- add reply -->
        <br/>
        <div class="review">
            <div id="commentPanel">
            <div class="trhead">
                <a name="review"></a>
                <strong>回复</strong>
            </div>
            <ul>
                <li style="border: none;">
                    <div class="comm_l">
                        <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($_uid); ?>"><img src="<?php getUserFaceById($_uid, 's'); ?>" class="face" /></a>
                    </div>
                    <div class="comm_r">
                        <form class="form" action="http://localhost:9990/gtp/message/reply" method="post">
                        <textarea name="content" id="txtContent" class="textarea"></textarea>
                        <input type="hidden" name="parent_id" value="<?php echo ($message["id"]); ?>" />
                        <input type="hidden" name="to_id" value="<?php echo ($to_id); ?>" />
                        <input type="submit" class="button" style="margin-top: 5px;" value="回复" />
                        </form>
                    </div>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <!-- right begin --> 
    <div class="channel-right">
        <script type="text/javascript"> 
        alimama_pid="mm_10574926_3506959_11486840"; 
        alimama_width=300; 
        alimama_height=250; 
        </script> 
        <script src="http://a.alimama.cn/inf.js" type="text/javascript"> 
        </script>
    </div>
    <!-- right end -->
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