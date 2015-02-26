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
        <div class="ident">小组</div>
        <!--文章详细-->
        <div class="app-detail">
            <div class="head">
                <h1>Tommy Emmanuel</h1>
                <div class="app-info">
                        创建于：<?php echo (todate($group["add_time"])); ?>
                    <?php if($_logined){ ?>
                    <?php if (isGroupOwner($userGroup)) { ?>
                    <a href="http://localhost:9990/gtp/group/edit/<?php echo ($group["id"]); ?>">[编辑小组信息]</a> - 我是小组创建者
                    <?php } else if (isGroupAdmin($userGroup)) { ?>
                    <a href="http://localhost:9990/gtp/group/edit/<?php echo ($group["id"]); ?>">[编辑小组信息]</a> - 我是小组管理员
                    <?php } else if (isGroupMember($userGroup)) { ?>
                    - 我是小组成员
                    <?php } ?>
                    <?php } ?>
                    <div class="score">
                        <span record="37" class="score" model="45" score="0"></span>
                        <span class="total">组员：<span id="score-count"><?php echo ($group["user_num"]); ?></span>人</span> &nbsp;
                        <?php if($_logined && !isGroupOwner($userGroup)){ ?>
                        <?php if (isGroupMember($userGroup)) { ?>
                        <a href="http://localhost:9990/gtp/group/join/<?php echo ($group["id"]); ?>?type=out">[退出小组]</a>
                        <?php } else { ?>
                        <a href="http://localhost:9990/gtp/group/join/<?php echo ($group["id"]); ?>">[加入小组]</a>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="body" style="border: none;">
                <div class="app-relative" style="margin-top: 0px; color: #999;">
                    <img src="<?php echo (getgroupface($group["face"])); ?>" class="face" />
                    <br/>
                    <br/>
                    <?php echo (autolink($group["content"])); ?>
                    <br/>
                    <br/>
                    <p>
                    组长：<a href="http://localhost:9990/gtp/user/<?php getUserDomainById($group['user_id']) ?>"><?php getUserNick($group['user_id']) ?></a> &nbsp;
                    <?php if(!empty($admin_list)) { ?>
                    | 管理员：
                    <?php if(is_array($admin_list)): foreach($admin_list as $key=>$item): ?><a href="http://localhost:9990/gtp/user/<?php getUserDomain($item) ?>"><?php echo ($item["nick"]); ?></a> &nbsp;<?php endforeach; endif; ?>
                    </p>
                    <?php } ?>
                </div>
                
                <?php if (isGroupMember($userGroup)) { ?>
                <br/>
                <div style="float: right;">
                    <form action="http://localhost:9990/gtp/topic/add" method="get">
                        <input type="hidden" name="group_id" value="<?php echo ($group["id"]); ?>" />
                        <input type="submit" class="button" value="发表话题" />
                    </form>
                </div>
                <br/>
                <?php } ?>
                
                <?php if(count($topic_top_list) > 0 || count($topic_list) > 0) { ?>
                <div class="cate">
                    <ul class="item">
                    <li>
                        <div class="left">
                        </div>
                        <div class="middle">
                            <b>话题列表：</b>
                            <span class="author"></a></span>
                        </div>
                        <div class="right">
                            <span class="date"><?php echo (firendlytime($gtp["add_time"])); ?></span>
                        </div>
                    </li>
                    <?php if(is_array($topic_top_list)): foreach($topic_top_list as $key=>$item): ?><li>
                        <div class="left">
                        </div>
                        <div class="middle">
                            <span class="title">[置顶] <a href="http://localhost:9990/gtp/topic/<?php echo ($item["id"]); ?>"><?php echo ($item["title"]); ?></a></span>
                            <span class="author" style="font-size: 12px;"><a href="http://localhost:9990/gtp/user/<?php getUserDomain($item['user_id']) ?>"><?php echo ($item["nick"]); ?></a></span>
                            <?php if($item[reply_num] > 0) { ?>
                            <span>(<?php echo ($item["reply_num"]); ?>回应)</span>
                            <?php } ?>
                        </div>
                        <div class="right">
                            <span class="date"><?php echo (firendlytime($item["add_time"])); ?></span>
                        </div>
                    </li><?php endforeach; endif; ?>
                    <?php if(is_array($topic_list)): foreach($topic_list as $key=>$item): ?><li>
                        <div class="left">
                        </div>
                        <div class="middle">
                            <span class="title"><a href="http://localhost:9990/gtp/topic/<?php echo ($item["id"]); ?>"><?php echo ($item["title"]); ?></a></span>
                            <span class="author" style="font-size: 12px;"><a href="http://localhost:9990/gtp/user/<?php getUserDomain($item['user_id']) ?>"><?php echo ($item["nick"]); ?></a></span>
                            <?php if($item[reply_num] > 0) { ?>
                            <span>(<?php echo ($item["reply_num"]); ?>回应)</span>
                            <?php } ?>
                        </div>
                        <div class="right">
                            <span class="date"><?php echo (firendlytime($item["add_time"])); ?></span>
                        </div>
                    </li><?php endforeach; endif; ?>
                    </ul>
            </div>
            <br class="clear" />
            <!-- page begin -->
            <div class="manu"><?php echo ($page); ?></div>
            <!-- page end -->
            <p>
                <br/>
                <form action="http://localhost:9990/gtp/group/<?php echo ($group["id"]); ?>" class="form" method="get">
                    <b>搜索话题：</b> <input type="text" class="text" name="k" value="<?php echo ($k); ?>" /> <input type="submit" class="button" value="查询" />
                </form>
            </p>
            <?php } ?>
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