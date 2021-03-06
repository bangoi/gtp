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

<script type="text/javascript" src="http://localhost:9990/gtp/js/jquery.uploadify.min.js"></script>
<script src="http://localhost:9990/gtp/js/jquery.Jcrop.js"></script>

<script type="text/javascript">
  jQuery(function($){

    // Create variables (in this scope) to hold the API and image size
    var jcrop_api,
        boundx,
        boundy,

        // Grab some information about the preview pane
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();
    
    $('#target').Jcrop({
      onChange: updatePreview,
      onSelect: updatePreview,
      setSelect: [ 100, 100, 0, 0 ],
      aspectRatio: xsize / ysize
    },function(){
      // Use the API to get the real image size
      var bounds = this.getBounds();
      boundx = bounds[0];
      boundy = bounds[1];
      // Store the API in the jcrop_api variable
      jcrop_api = this;

      // Move the preview into the jcrop container for css positioning
      //$preview.appendTo(jcrop_api.ui.holder);
    });

     function updatePreview(c)
    {
      if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;

        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
        
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
      }
    };

  });
</script>

<link rel="stylesheet" href="http://localhost:9990/gtp/css/jquery.Jcrop.css" type="text/css" />
<style type="text/css">

/* Apply these styles only when #preview-pane has
   been placed within the Jcrop widget */
.jcrop-holder #preview-pane {
  
  position: absolute;
  z-index: 2000;
  top: 0px;
  right: -86px;
  padding: 2px;
  border: 1px rgba(0,0,0,.4) solid;
  background-color: white;
}

/* The Javascript code will set the aspect ratio of the crop
   area based on the size of the thumbnail preview,
   specified here */
#preview-pane .preview-container {
  width: 50px;
  height: 50px;
  overflow: hidden;
}


</style>

<div class="contaier wp cf">
<div class="ident">头像</div>
    <div class="login" style="width: 580px;">
        <div class="head">
            <strong>1. 添加或更改你的头像</strong>
            <?php if (!empty($err)): ?><span style="color: red"><?php echo ($err); ?></span><?php endif; ?>
            <?php if (!empty($notice)): ?><span style="color: #fff;background: green; padding: 3px 10px 3px 10px;"><?php echo ($notice); ?></span><?php endif; ?>
        </div>
        <div class="body form " style="margin-top: -30px;">
            <form action="http://localhost:9990/gtp/user/face" method="post" class="login" enctype="multipart/form-data">
            
            <div style="width: 230px; float: left;">
                <img src="http://localhost:9990/gtp/<?php getImgName($face, 'm'); ?>" style="width:200px; height: 200px;" class="jcrop-preview" id="target" alt="Preview" />
            </div>
            <div style="width: 330px; float: left;">
                <span class="c9 f14">从电脑中选择你喜欢的照片:</span>
                <br />
                <span class="c9 f14">你可以上传JPG、JPEG、GIF、或PNG文件。</span>
                <div style="margin-top: 10px;">
                    <input type="file" name="face" id="faceFile" class="text" />
                </div>
                <div style="margin-top: 5px;">
                    <input class="submit" type="submit" value="更新头像" /> &nbsp; <a href="http://localhost:9990/gtp/user/settings" style="line-height: 30px;">返回</a>    
                </div>
            </div>
            </form>
            <br class="clear" />
            <br/>
            <div class="head">
                <strong>2. 设置你的小头像图标</strong>
            </div>
            <div id="preview-pane" style="margin-top: 15px; float: left;">
                <div class="preview-container" >
                    <img src="http://localhost:9990/gtp/<?php getImgName($face, 'm'); ?>" class="jcrop-preview" alt="Preview" />
                </div>
            </div>
            <div style="margin: 13px; float: left;">
                <span class="c9 f16">随意拖拽或缩放大图中的虚线方格，<br/>预览的小图即为保存后的小头像图标。</span>
            </div>
            
            <br class="clear" />
            
            <form action="http://localhost:9990/gtp/user/crop" method="post">
            <div style="margin-top: 10px;">
                <input type="hidden" id="x" name="x" />  
                <input type="hidden" id="y" name="y" />  
                <input type="hidden" id="w" name="w" />  
                <input type="hidden" id="h" name="h" />
                <input type="submit" class="submit" value="保存小头像设置" /> &nbsp; <a href="http://localhost:9990/gtp/user/settings" style="line-height: 30px;">返回</a>
            </div>
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