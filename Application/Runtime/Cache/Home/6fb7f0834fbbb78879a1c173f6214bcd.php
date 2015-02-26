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
<div class="ident">设置</div>
    <div class="login" style="width: 580px;">
        <div class="head" style="height: 0px;">
            <?php if (!empty($err)): ?><span style="color: red"><?php echo ($err); ?></span><?php endif; ?>
            <?php if (!empty($notice)): ?><span style="color: #fff;background: green; padding: 3px 10px 3px 10px;"><?php echo ($notice); ?></span><?php endif; ?>
        </div>
        <div class="body form ">
            <form action="http://localhost:9990/gtp/user/settings" method="post" class="login">
                <table style="width: 580px;">
                    <tr>
                        <th>昵&#12288;称</th>
                        <td>
                            <input class="text" type="text" name="nick" value="<?php echo ($user["nick"]); ?>" disabled="true" style="width: 150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th>头&#12288;像</th>
                        <td>
                            <img src="http://localhost:9990/gtp/<?php getImgName($user['face'], 's'); ?>" class="face" /> <a href="http://localhost:9990/gtp/user/face" style="line-height: 50px;">设置</a>
                        </td>
                    </tr>
                    <tr>
                        <th>域&#12288;名</th>
                        <td>
                            <?php if(empty($user['domain'])) { ?>
                            <span class="c6">http://localhost:9990/gtp/</span><input class="text" type="text" name="domain" style="width: 100px;" />
                            <?php } else { ?>
                            <span class="c6">http://localhost:9990/gtp/</span><input class="text" type="text" name="domain" value="<?php echo ($user["domain"]); ?>" disabled="true" style="width: 100px;" />
                            <?php } ?>
                            <br/>
                            <span class="c9 f14" style="line-height: 28px;">个性域名只能由4-20个字母或数字组成，且第一位不能为数字，只能修改一次！</span>
                        </td>
                    </tr>
                    <tr>
                        <th>所在地</th>
                        <td>
                            <select name="province_code" id="sltProvince">
                                <option value="-1">-所在省-</option>
                                <?php if(is_array($province_list)): foreach($province_list as $key=>$item): ?><option value="<?php echo ($item["code"]); ?>" <?php if($user["province_code"] == $item["code"]) { ?>selected="selected"<?php } ?>><?php echo ($item["name"]); ?></option><?php endforeach; endif; ?>
                            </select>&nbsp;
                            <select name="city_code" id="sltCity">
                                <option value="-1">-所在市-</option>
                                <?php if(!empty($city)){ ?>
                                    <option value="<?php echo ($city["code"]); ?>" selected="selected"><?php echo ($city["name"]); ?></option>
                                <?php } ?>
                                <?php if(!empty($city_list)){ ?>
                                    <?php if(is_array($city_list)): foreach($city_list as $key=>$item): ?><option value="<?php echo ($item["code"]); ?>" <?php if($user["city_code"] == $item["code"]) { ?>selected="selected"<?php } ?>><?php echo ($item["name"]); ?></option><?php endforeach; endif; ?>
                                <?php } ?>    
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>签&#12288;名</th>
                        <td>
                            <textarea name="signature" class="textarea" rows="5" cols="50"><?php echo (br2nl($user["signature"])); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="hidden" name="page" value="<?php echo ($page); ?>" />
                            <input class="submit" type="submit" value="编辑" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="login-other" style="width: 230px;padding-left: 20px; min-width: 0px;">
        <div class="head">
    <strong>使用其他帐号直接登录</strong>
</div>
<div class="body">
    <ul class="other-account">
        <li><a href="http://localhost:9990/gtp/user/settings">用户信息设置</a></li>
        <li><a href="http://localhost:9990/gtp/user/face">用户头像设置</a></li>
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