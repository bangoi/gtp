<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> -->
    <?php if(!empty($title)): ?><title><?php echo ($title); ?>|__SITE_TITLE__</title>
    <?php else: ?>
    <title>__SITE_TITLE__</title><?php endif; ?>
    <meta name="keywords" content="吉他谱,吉他,吉他视频,GTP,Guitar Pro,吉他谱下载" />
    <?php if(!empty($description)): ?><meta name="description" content="<?php echo ($description); ?>,收藏自阿谱小站." />
    <?php else: ?>
    <meta name="description" content="阿谱小站,收集分享Guitar-pro吉他谱,吉他视频,为吉他爱好者打造网上资源互动社区." /><?php endif; ?>
    <link rel="alternate" type="application/rss+xml" title="阿谱小站" href="http://localhost:9990/gtp/feed" />
    <link rel="shortcut icon" href="http://localhost:9990/gtp/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="http://localhost:9990/gtp/css/concision.css" />
    <link rel="stylesheet" type="text/css" href="http://localhost:9990/gtp/css/prettify.css" />
    <script type="text/javascript" src="http://localhost:9990/gtp/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="http://localhost:9990/gtp/js/apu9.js"></script>
    <!--
    <script type="text/javascript" src="http://localhost:9990/gtp/js/prettify.js"></script>
    <script type="text/javascript" src="http://localhost:9990/gtp/js/concision.js"></script>
    -->
    <script type="text/javascript">
    $(function(){
        $(document).keyup(function(event){
            if(event.keyCode == 37){
                $('.page .prev span').click();
            }else if(event.keyCode == 39){
                $('.page .next span').click();
            }
        })
        $(':text,textarea').keyup(function(event){
            event.stopPropagation();
        })
    })
    </script>
</head>
<body>
    <div class="header">
        <div class="header-wrap wp cf">
            <h3 class="think-logo"><a href="http://localhost:9990/gtp" title="返回首页">阿谱小站</a></h3>
            <ul class="think-navg">
                <li class="title <?php if(($channel == 'home')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp">首页</a></li>
                <li class="title <?php if(($channel == 'gtp')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/gtp/">吉他谱</a></li>
                <li class="title <?php if(($channel == 'vedio')): ?>selected<?php endif; ?>"><a class="show" href="http://localhost:9990/gtp/vedio/">吉他视频</a></li>
            </ul>
            
            <p class="think-user">
                <?php if (empty($nick)): ?>
                [<a href="http://localhost:9990/gtp/user/login">登录</a><a href="http://localhost:9990/gtp/user/register">注册</a>]
                <?php else: ?>
                [ <?php echo (urldecode($nick)); ?> <a href="http://localhost:9990/gtp/user/logout">退出</a>]
                <?php endif; ?>
            </p>
        </div>
    </div>
     
<div class="contaier wp">
    <div class="think-add">
        <div class="body think-form">
            <form action="http://localhost:9990/gtp/vedio/add" method="post">
                <table>
                    <?php if (!empty($err)): ?>
                     <tr>
                        <th></th>
                        <td><span style="color: red"><?php echo ($err); ?></span></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>视频地址</th>
                        <td><input class="text" type="text" name="vedio_url" id="vedio_url" value="<?php echo ($vedio_url); ?>" /> &nbsp; <input class="submit" id="btnVedioUrl" type="button" style="height: 32px; margin-top: -4px;" value="获取" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>视频标题</th>
                        <td><input class="text" type="text" name="title" id="title" value="<?php echo ($vedio_title); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>视频截图</th>
                        <td>
                            <?php if(!empty($thumb_value)) { ?>
                            <img src="<?php echo ($thumb_value); ?>" name="thumb" id="thumb"
                                alt="上传视频缩略图" width="120" height="90" />
                            <?php } else { ?>
                            <img src="http://localhost:9990/gtp/upload/thumb/default.jpg" name="thumb" id="thumb"
                                alt="上传视频缩略图" width="120" height="90" />
                            <?php } ?>
                            <input type="hidden" name="thumb_value" id="thumb_value" value="<?php echo ($thumb_value); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>视频swf</th>
                        <td><input class="text" type="text" name="code" id="code" value="<?php echo ($code); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>音乐人</th>
                        <td><input class="text" type="text" name="artist_name" value="<?php echo ($artist_name); ?>" /></td>
                    </tr>
                    <tr>
                        <th><i class="must">*</i>歌曲名称</th>
                        <td><input class="text" type="text" name="song_title" value="<?php echo ($song_title); ?>" /></td>
                    </tr>
                    <tr>
                        <th>标&#12288;&#12288;签</th>
                        <td><input class="text" type="text" name="tags" value="<?php echo ($tags); ?>" /> 用空格分隔</td>
                    </tr>
                    <tr>
                        <th>摘&#12288;&#12288;要</th>
                        <td>
                            <div class="add-remark">
                                <textarea name="description"><?php echo ($description); ?></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td> <input class="submit" type="submit" value="提交" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
            
            
    <div class="home-right">
        <div class="think-fast">
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
            <p class="copy">&copy;ThinkPHP 2012</p>
            <p class="navg"><a href="/about/index.html">关于我们</a><a href="/about/donate.html">捐赠我们</a><a href="/update/index.html">更新列表</a><a href="/bug/index.html">BUG反馈</a><a href="/suggest/index.html">功能建议</a><a href="/link/index.html">友情链接</a></p>
            <p class="links"><a href="/donate/index.html">捐赠</a><a href="/rss/index.xml">订阅</a><a href="/about/attention.html">关注</a><a href="http://bbs.thinkphp.cn" target="_blank">论坛</a></p>
        </div>
    </div>
<div style="display:none">
    <script language="javascript" type="text/javascript" src="http://js.users.51.la/14961362.js"></script>
<noscript><a href="http://www.51.la/?14961362" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/14961362.asp" style="border:none" /></a></noscript>
</div>
</body>
</html>