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

<div class="contaier wp cf">
<div class="ident">注册</div>
    <div class="register">
        <div class="head">
            <strong>用户注册</strong><span>已有帐号？点击<a href="http://localhost:9990/gtp/user/login">登录</a></span>
            <?php if (!empty($err)): ?><span style="color: red"><?php echo ($err); ?></span><?php endif; ?>
        </div>
        <div class="body form">
            <form action="http://localhost:9990/gtp/user/register" method="post" class="login">
                <table>
                    <tr>
                        <th>用户名</th>
                        <td>
                            <input class="text" type="text" name="nick" value="<?php echo ($nick); ?>"  />
                        </td>
                    </tr>
                    <tr>
                        <th>密码</th>
                        <td>
                            <input class="text" type="password" name="pwd" />
                        </td>
                    </tr>
                    <tr>
                        <th>确认密码</th>
                        <td>
                            <input class="text" type="password" name="re_pwd" />
                        </td>
                    </tr>
                    <tr>
                        <th>邮箱</th>
                        <td>
                            <input class="text" type="text" name="email" value="<?php echo ($email); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input class="submit" type="submit" value="完成" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="login-other">
        <div class="head">
            <strong>使用其他帐号直接登录</strong>
        </div>
        <div class="body">
            <ul class="other-account">
                <li><a class="qq" href="/oauth/index/type/qq.html">腾讯QQ登录</a></li><li><a class="tencent" href="/oauth/index/type/tencent.html">腾讯微博登录</a></li><li><a class="t163" href="/oauth/index/type/t163.html">网易微博登录</a></li><li><a class="sina" href="/oauth/index/type/sina.html">新浪微博登录</a></li>            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.reloadverify').click(function(){
            $('.verifyimg').attr('src', "/member/verify.html?" + Math.random());
        });
    })
</script>

<div class="footer">
        <div class="wp">
            <p class="copy">&copy;ThinkPHP 2012</p>
            <p class="navg"><a href="/about/index.html">关于我们</a><a href="/about/donate.html">捐赠我们</a><a href="/update/index.html">更新列表</a><a href="/bug/index.html">BUG反馈</a><a href="/suggest/index.html">功能建议</a><a href="/link/index.html">友情链接</a></p>
            <p class="links"><a href="/donate/index.html">捐赠 <?php echo ($is_mobile ? "手机浏览" : "PC浏览"); ?></a><a href="/rss/index.xml">订阅</a><a href="/about/attention.html">关注</a><a href="http://bbs.thinkphp.cn" target="_blank">论坛</a></p>
        </div>
    </div>
    <input type="hidden" name="site" id="site" value="http://localhost:9990/gtp" />
<div style="display:none">
    <script language="javascript" type="text/javascript" src="http://js.users.51.la/14961362.js"></script>
<noscript><a href="http://www.51.la/?14961362" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/14961362.asp" style="border:none" /></a></noscript>
</div>
</body>
</html>