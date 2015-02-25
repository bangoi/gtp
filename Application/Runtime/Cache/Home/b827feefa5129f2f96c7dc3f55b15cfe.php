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

<div class="contaier wp">
    <div class="channel-left">
        
        <div class="search cf">
    <form action="http://localhost:9990/gtp/<?php echo get_channel($channel); ?>search" method="get">
        <input class="text" type="text" name="k" value="<?php echo ($k); ?>" placeholder="输入关键字..." value="" />
        <input class="submit" type="submit" value="搜索" />
    </form>
</div>
        
        <div class="ident">小组</div>
        
        <div class="slogan">
            <?php if($type=="mine"){ ?>
                <p>我的话题 <a href="http://localhost:9990/gtp/group/">小组话题</a></p>
            <?php } else { ?>
                <p>小组话题 <a href="http://localhost:9990/gtp/group/mine">我的话题</a></p>
            <?php } ?>
        </div>
        
        <div class="cate">
            <ul class="item">
            <?php if(is_array($topic_list)): foreach($topic_list as $key=>$item): ?><li>
                <div class="left">
                </div>
                <div class="middle">
                    <span class="author"><a href="http://localhost:9990/gtp/group/<?php echo ($item["group_id"]); ?>">[<?php echo ($item["group_title"]); ?>]</a></span>
                    <span class="title"><a href="http://localhost:9990/gtp/topic/<?php echo ($item["id"]); ?>"><?php echo ($item["title"]); ?></a></span>
                    <span class="author"><?php if($item["reply_num"] > 0) { ?>(<?php echo ($item["reply_num"]); ?>回复)<?php } ?></span>
                </div>
                <div class="right">
                    <span class="date"><?php echo (firendlytime($item["last_reply_time"])); ?></span>
                </div>
            </li><?php endforeach; endif; ?>
            </ul>
    </div>
    
    <!-- page begin -->
    <div class="manu"><?php echo ($page); ?></div>
    <!-- page end -->
    
    </div>
    <!-- right begin --> 
    <div class="channel-right">
        
        <div class="toper">
    <dl>
        <dt>搜索<sub>Search</sub></dt>
        <dd>
        <div class="search-form">
            <form method="get" id="channelForm" action="http://localhost:9990/gtp/<?php echo get_channel($channel); ?>search/">
                <input type="text" class="text" style="width:125px" name="k" id="txtK" value="<?php echo ($k); ?>">
                <select name="type" id="channelType">
                    <option value="gtp" <?php if($channel == "gtp") { ?>selected="selected"<?php } ?>>谱子</option>
                    <option value="vedio" <?php if($channel == "vedio") { ?>selected="selected"<?php } ?>>视频</option>
                </select>
                <input class="submit" type="submit" value="搜索">
            </form>
        </div>
        </dd>
    </dl>
    <!--
    <dl class="attent">
        <dt>关注<sub>Attention</sub></dt>
        <dd class="cf">
        <a class="tencen" href="http://t.qq.com/topthink" target="_blank">腾讯微博</a>
        <a class="sina" href="http://weibo.com/thinkphp" target="_blank">新浪微博</a>
        </dd>
    </dl>
    -->
</div>
        
        <div class="sort">
            <ul class="cf">
                <li class="selected"><a href="http://localhost:9990/gtp/gtp/">吉他谱</a></li>
            </ul>
        </div>
        
        <div class="fast" style="background: #F1F1F1; margin-top: -10px">
            
           <dl>
    <dt>首字母<sub>Initial</sub></dt>
    <dd>
    <?php $letters = array("#", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"); ?>
    <?php if(is_array($letters)): foreach($letters as $key=>$item): if($item == '#'){ ?>
        <a href="http://localhost:9990/gtp/gtp/?start=number">#</a>
    <?php } else { ?>
        <a href="http://localhost:9990/gtp/gtp/?start=<?php echo ($item); ?>"><?php echo (strtoupper($item)); ?></a>
    <?php } endforeach; endif; ?>
        </dd>
</dl>
            
            <dl>
            <dt>音乐人<sub>Musician</sub></dt>
            <dd>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=陈绮贞">陈绮贞</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=张震岳">张震岳</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=曹方">曹方</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=卢广仲">卢广仲</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=方大同">方大同</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=蔡健雅">蔡健雅</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=张悬">张悬</a>
            </dd>
            </dl>
            
            <dl>
            <dt>指弹大师<sub>Master</sub></dt>
            <dd>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=Tommy+Emmanuel">Tommy Emmanuel</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=押尾桑">押尾桑</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=Andy+McKee">Andy McKee</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=Antoine+Dufour">Antoine Dufour</a>
                <a href="http://localhost:9990/gtp/gtp/?artist_name=岸部真明">岸部真明</a>
            </dd>
            </dl>
            
            <dl>
                <dt>订阅<sub>Subscribe</sub></dt>
                <dd class="rss-form">
                <form method="post" target="_blank" action="http://list.qq.com/cgi-bin/qf_compose_send">
                    <input type="hidden" value="qf_booked_feedback" name="t">
                    <input type="hidden" value="99e976340812fea881e5cfac31c46b1dbb5b5aa8bfe415f5" name="id">
                    <input class="text" type="text" value="" placeholder="请输入邮件地址..." class="rsstxt" name="to" id="to">
                    <input class="submit" type="submit" value="订阅">
                </form>
                </dd>
                <dd>
                    <a class="rss" href="/Rss/index.xml" target="_blank">RSS订阅</a>
                    <a href="/info/175.html" target="_blank">什么是RSS？</a>
                </dd>
            </dl>
        </div>
        
        <?php if(1==0){ ?>
        <div class="sort">
            <ul class="cf">
                <li class="selected"><a href="/extend/index.html">全部</a></li>
                <li><a href="/extend/engine.html">引擎</a></li>
                <li><a href="/extend/example.html">示例</a></li>
                <li><a href="/extend/mode.html">模式</a></li>
                <li><a href="/extend/behavior.html">行为</a></li>
                <li><a href="/extend/model.html">模型</a></li>
                <li><a href="/extend/action.html">控制器</a></li>
                <li><a href="/extend/driver.html">驱动</a></li>
                <li><a href="/extend/library.html">类库</a></li>
                <li><a href="/extend/function.html">函数</a></li>
                <li><a href="/extend/others.html">其他</a></li>        
            </ul>
        </div>
        <div class="hot-rank thinkphp-box1">
            <div class="head"><strong>热门应用排行</strong></div>
            <div class="body">
                <ul>
                    <li>1、<a title="微购社会化导购系统" href="/app/wego.html">微购社会化导购系统</a></li>
                    <li>2、<a title="ShuipFCMS内容管理系统" href="/app/shuipfcms.html">ShuipFCMS内容管理系统</a></li>
                    <li>3、<a title="CMSHead内容管理系统" href="/app/cmshead.html">CMSHead内容管理系统</a></li>
                    <li>4、<a title="简单CMS(JDCMS)" href="/app/jdcms.html">简单CMS(JDCMS)</a></li>
                    <li>5、<a title="ThinkPHP助手" href="/app/tphelper.html">ThinkPHP助手</a></li>
                    <li>6、<a title="艾米网站管理工具" href="/app/aimee.html">艾米网站管理工具</a></li>
                    <li>7、<a title="SibohCRM企业管理平台" href="/app/sibohcrm.html">SibohCRM企业管理平台</a></li>
                    <li>8、<a title="方维购物分享系统" href="/app/fangweshare.html">方维购物分享系统</a></li>
                    <li>9、<a title="ThinkSNS微博系统" href="/app/thinksns.html">ThinkSNS微博系统</a></li>
                    <li>10、<a title="光线cms" href="/app/gxcms.html">光线cms</a></li>
                </ul>
            </div>
        </div>
        <?php } ?>
        
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