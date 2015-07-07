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
    <div class="add">
        <div class="body form">
            <form action="http://localhost:9990/gtp/vedio/edit/<?php echo ($vedio["id"]); ?>" method="post">
                <table>
                    <?php if (!empty($err)): ?>
                     <tr>
                        <th></th>
                        <td><span style="color: red"><?php echo ($err); ?></span></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th><i class="must">*</i>视频标题</th>
                        <td><input class="text" type="text" name="title" id="title" value="<?php echo ($vedio["title"]); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>视频截图</th>
                        <td>
                            <?php if (empty($vedio['thumb'])): ?>
                            <img src="http://localhost:9990/gtp/upload/thumb/default.jpg" name="thumb" id="thumb" alt="上传视频缩略图" width="120" height="90" />
                            <?php else: ?>
                            <img src="<?php echo ($vedio["thumb"]); ?>" name="thumb" id="thumb" alt="上传视频缩略图" width="120" height="90" />
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>截图地址</th>
                        <td><input class="text" type="text" name="thumb_value" id="thumb_value" value="<?php echo ($vedio["thumb"]); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>视频swf</th>
                        <td><input class="text" type="text" name="code" id="code" value="<?php echo ($vedio["code"]); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>音乐人</th>
                        <td><input class="text" type="text" name="artist_name" value="<?php echo ($vedio["artist_name"]); ?>" /></td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>歌曲名称</th>
                        <td><input class="text" type="text" name="song_title" value="<?php echo ($vedio["song_title"]); ?>" /></td>
                    </tr>
                    <tr>
                        <th>标&#12288;&#12288;签</th>
                        <td><input class="text" type="text" name="tags" value="<?php echo ($vedio["tags"]); ?>" /> 用空格分隔</td>
                    </tr>
                    <tr>
                        <th>摘&#12288;&#12288;要</th>
                        <td>
                            <div class="add-remark">
                                <textarea name="description"><?php echo ($vedio["description"]); ?></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td> <input class="submit" type="submit" value="提交" />
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="id" value="<?php echo ($vedio["id"]); ?>" />
            </form>
        </div>
    </div>
            
            
    <div class="home-right">
        <div class="fast">
            <dl>
                <dt>发布应用<sub>Publish</sub></dt>
                <dd>应用标识、中文描述、应用主页（以http打头）、分类和应用LOGO（不超过50K 支持JPG PNG和GIF）必须，描述和标签可选，多个标签之间用空格分隔，案例发布需要审核。</dd>
            </dl>
            <dl>
                <dt>快捷键<sub>Keyboard</sub></dt>
                <dd>选中文字内容后使用键盘快捷键<br/>CTRL+B ：字体加粗<br/>ALT + U ：添加超链接<br/> ALT + C ：插入代码</dd>
            </dl>
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
<div style="display:none">
    <script language="javascript" type="text/javascript" src="http://js.users.51.la/17745245.js"></script>
<noscript><a href="http://www.51.la/?17745245" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/17745245.asp" style="border:none" /></a></noscript>
</div>
</body>
</html>