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

<div class="contaier wp">
    <div class="channel-left">
        
        <div class="search cf">
    <form action="http://localhost:9990/gtp/<?php echo get_channel($channel); ?>search" method="get">
        <input class="text" type="text" name="k" value="<?php echo ($k); ?>" placeholder="输入关键字..." value="" />
        <input class="submit" type="submit" value="搜索" />
    </form>
</div>
        
        <div class="ident">首页</div>
        
        <div class="slogan"><a class="post" href="http://localhost:9990/gtp/gtp/add">发布吉他谱</a><p>吉他谱 <A href="http://localhost:9990/gtp/gtp/?p=2">More</A></p></div>
        
        <div class="cate">
            <ul class="item">
            <?php if(is_array($gtp_list)): foreach($gtp_list as $key=>$gtp): ?><li>
                <div class="left">
                </div>
                <div class="middle">
                    <span class="title"> <a href="http://localhost:9990/gtp/gtp/<?php echo ($gtp["id"]); ?>"><?php echo ($gtp["song_title"]); ?></a></span>
                    <span class="author"> <a href="http://localhost:9990/gtp/gtp/?artist_name=<?php echo (urlencode($gtp["artist_name"])); ?>"><?php echo ($gtp["artist_name"]); ?></a></span>
                </div>
                <div class="right">
                    <span class="date"><?php echo (firendlytime($gtp["add_time"])); ?></span>
                </div>
            </li><?php endforeach; endif; ?>
            </ul>
    </div>
    
    <!--
    <div class="slogan"><a class="post" href="http://localhost:9990/gtp/vedio/add">发布吉他视频</a><p>吉他视频 <A href="http://localhost:9990/gtp/vedio/?p=2">More</A></p></div>
    <div class="cate">
        <ul class="item">
        <?php if(is_array($vedio_list)): foreach($vedio_list as $key=>$vedio): ?><li>
            <div class="left">
                <span class="sort"></span>
            </div>
            <div class="middle">
                <span class="title"> <a href="http://localhost:9990/gtp/vedio/<?php echo ($vedio["id"]); ?>"><?php echo ($vedio["title"]); ?></a></span>
                <span class="down">[ 播放： <?php echo ($vedio["view_num"]); ?> ]</span>
                <span class="comment"></span>
                <span class="author"><a href="http://localhost:9990/gtp/vedio/?artist_name=<?php echo (urlencode($vedio["artist_name"])); ?>"><?php echo ($vedio["artist_name"]); ?></a></span>
            </div>
            <div class="right">
                <span class="date"><?php echo (firendlytime($vedio["add_time"])); ?></span>
            </div>
        </li><?php endforeach; endif; ?>
        </ul>
    </div>
    -->
    
    </div>
    <!-- right begin --> 
    <div class="channel-right">
        
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