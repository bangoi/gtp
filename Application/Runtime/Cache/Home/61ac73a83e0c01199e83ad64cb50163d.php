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
                <li class="title <?php if(($channel == 'home')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp">首页</a></li>
                <li class="title <?php if(($channel == 'gtp')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/gtp/">吉他谱</a></li>
                <li class="title <?php if(($channel == 'vedio')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/vedio/">吉他视频</a></li>
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

<div class="contaier thinkphp-app wp">
    <div class="app-left">
        <div class="ident">吉他谱</div>
        <!--文章详细-->
        <div class="app-detail">
            <div class="head">
                <h1><?php echo ($gtp["artist_name"]); ?>-<?php echo ($gtp["song_title"]); ?> 吉他谱下载</h1>
                <div class="app-info">
                    <span class="date"><?php echo (todate($gtp["add_time"],'Y-m-d H:i')); ?></span>
                    <a class="author" href="http://localhost:9990/gtp/gtp/?artist_name=<?php echo (urlencode($gtp["artist_name"])); ?>"><?php echo ($gtp["artist_name"]); ?>的吉他谱</a>
                    <span class="version"><a href="http://localhost:9990/gtp/user/<?php get_domain($user); ?>"><?php echo ($user["nick"]); ?></a>上传</span>
                    <a class="class" href="http://localhost:9990/gtp/gtp/">[ 吉他谱 ]</a>
                    <?php if ($can_edit) { ?>
                    <a href="http://localhost:9990/gtp/gtp/edit/<?php echo ($gtp["id"]); ?>">[编辑]</a>
                    <?php } ?>
                    <div class="score">
                        <span record="37" class="score" model="45" score="0"></span>
                        <span class="total">(共<span id="score-count"><?php echo ($gtp["download_num"]); ?></span>人下载)</span>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="app-relative">
                    <a href="http://localhost:9990/gtp/gtp/download/<?php echo ($gtp["id"]); ?>" target="_blank">下载吉他谱</a>
                    <i class="line">&nbsp;</i><?php echo ($gtp["download_num"]); ?>人下载过
                </div>
                
                <?php if(count($song_title_gtps) > 0): ?>
                <div class="relation">
                    <div class="trhead">
                        <b><?php echo ($gtp["song_title"]); ?> 其他吉他谱下载</b>
                    </div>
                    <ul>
                        <?php if(is_array($song_title_gtps)): foreach($song_title_gtps as $key=>$gtp): ?><li><a href="http://localhost:9990/gtp/gtp/<?php echo ($gtp["id"]); ?>"><?php echo ($gtp["song_title"]); ?>-<?php echo ($gtp["artist_name"]); ?></a> <?php echo (todate($gtp["add_time"],'Y-m-d H:i')); ?></li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <?php if(count($artist_name_gtps) > 0): ?>
                <div class="relation">
                    <div class="trhead">
                        <b><?php echo ($gtp["artist_name"]); ?>吉他谱下载</b>
                    </div>
                    <ul>
                        <?php if(is_array($artist_name_gtps)): foreach($artist_name_gtps as $key=>$g): ?><li><a href="http://localhost:9990/gtp/gtp/<?php echo ($g["id"]); ?>"><?php echo ($g["song_title"]); ?>-<?php echo ($g["artist_name"]); ?></a> 下载：<?php echo ($g["download_num"]); ?>次</li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <p>
                        <br/>
                        <b>搜索更多：</b> <a href="http://localhost:9990/gtp/gtp/?artist_name=<?php echo (urlencode($gtp["artist_name"])); ?>"><?php echo ($gtp["artist_name"]); ?>的吉他谱</a>
                </p>
                
                <br/>
                
                <?php if(count($vedioes) > 0): ?>
                <div class="app-summary v_list">
                    <b><?php echo ($gtp["artist_name"]); ?>-<?php echo ($gtp["song_title"]); ?> 吉他视频</b>
                    <br />
                    <br />
                    <ul>
                        <?php if(is_array($vedioes)): foreach($vedioes as $key=>$vedio): ?><li class="vitem">
                        <ul>
                            <li><a href="http://localhost:9990/gtp/vedio/<?php echo ($vedio["id"]); ?>"><img src="<?php echo ($vedio["thumb"]); ?>" alt="<?php echo ($vedio["song_title"]); ?>" /></a></li>
                            <li><a href="http://localhost:9990/gtp/vedio/<?php echo ($vedio["id"]); ?>"><?php echo ($vedio["song_title"]); ?></a></li>
                            <li>发布：<?php echo (firendlytime($vedio["add_time"])); ?></li>
                            <li>播放：<?php echo ($vedio["view_num"]); ?></li>
                        </ul>
                        </li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
            </div>
            
            <!--
            <div class="foot">
                <span class="fpage">
                    <a class="prev" href="/app/jdcms.html" title="上一篇"><span>上一篇</span></a>                <a class="dir" href="http://localhost:9990/gtp/gtp/" title="返回目录">返回目录</a>
                <a class="next" href="/app/efucms.html" title="下一篇"><span>下一篇</span></a>                </span>
                <span class="share">
                    <b>分享到：</b>
                    <a class="sina" href="javascript:;">新浪微博</a>
                    <a class="tencent" href="javascript:;">腾讯微博</a>
                </span>
            </div>
            -->
            
        </div>
        <!--/文章详细-->
        <!--文章评论-->
        
        <!--
        <div class="review">
            <div class="trhead">
                <a name="review"></a>
                <strong>评论</strong>共<span class="review-count"><?php echo ($gtp["comment_num"]); ?></span>条
            </div>
            <div class="trbody">
                <div class="review-users"></div>
                <div class="review-more">
                    <a href="javascript:get_review();">查看更多评论↓</a>
                </div>
                <div class="review-form cf">
                    <form action="/review/update.html" method="post">
                        <span class="textarea"><textarea name="content"></textarea></span>
                        <input type="hidden" value="45" name="model_id" />
                        <input type="hidden" value="37" name="record_id" />
                        <input type="hidden" value="0" name="review_id" />
                        <input class="submit" type="submit" value="评论" />
                        <span class="strleng">评论支持使用[code][/code]标签添加代码</span>
                        <span class="syn">同步到：<a href="#">新浪微博</a><a href="#">腾讯微博</a></span>
                    </form>
                </div>
                <div class="login-tip">
                    您需要登录后才可以评论 <a href="/member/login.html">登录</a> | <a href="/member/register.html">立即注册</a>
                </div>
            </div>
        </div>
        -->
        
        <!--/文章评论-->
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
            <p class="links"><a href="/donate/index.html">捐赠</a><a href="/rss/index.xml">订阅</a><a href="/about/attention.html">关注</a><a href="http://bbs.thinkphp.cn" target="_blank">论坛</a></p>
        </div>
    </div>
    <input type="hidden" name="site" id="site" value="http://localhost:9990/gtp" />
<div style="display:none">
    <script language="javascript" type="text/javascript" src="http://js.users.51.la/14961362.js"></script>
<noscript><a href="http://www.51.la/?14961362" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/14961362.asp" style="border:none" /></a></noscript>
</div>
</body>
</html>