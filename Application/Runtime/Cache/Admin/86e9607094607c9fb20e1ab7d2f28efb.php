<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Amaze UI Admin table Examples</title>
  <meta name="description" content="这是一个 table 页面">
  <meta name="keywords" content="table">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="http://localhost:9990/gtp/assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="http://localhost:9990/gtp/assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar admin-header">
  <div class="am-topbar-brand">
    <strong>Guitar Pro</strong> <small>后台管理</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li>
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> 管理员 <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>
          <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
          <li><a href="http://localhost:9990/gtp/user/logout"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>

<style type="text/css">
    .efile{ border: 1px solid #ccc; width:286px; padding-left: 5px; padding-top: 8px; padding-bottom: 8px; }
</style>

<div class="am-cf admin-main">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
        
      <ul class="am-list admin-sidebar-list">
    <li><a href="http://localhost:9990/gtp/admin"><span class="am-icon-home"></span>首页</a></li>
    <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}">
              <span class="am-icon-file"></span>内容管理 
              <span class="am-icon-angle-right am-fr am-margin-right"></span>
          </a>
          <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">
            <li><a href="http://localhost:9990/gtp/admin/gtp" class="am-cf"><span class="am-icon-table"></span> 吉他谱管理<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
            <li><a href="http://localhost:9990/gtp/admin/vedio"><span class="am-icon-th"></span> 视频管理</a></li>
            <li><a href="http://localhost:9990/gtp/admin/blog"><span class="am-icon-calendar"></span> Blog管理</a></li>
            <li><a href="http://localhost:9990/gtp/admin/user"><span class="am-icon-bug"></span> 会员管理</a></li>
          </ul>
    </li>
    
    <li><a href="admin-form.html"><span class="am-icon-pencil-square-o"></span>表单</a></li>
    <li><a href="http://localhost:9990/gtp/user/logout"><span class="am-icon-sign-out"></span>注销</a></li>
</ul>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-bookmark"></span> 公告</p>
          <p>时光静好，与君语；细水流年，与君同。—— Amaze UI</p>
        </div>
      </div>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> wiki</p>
          <p>Welcome to the Amaze UI wiki!</p>
        </div>
      </div>
    </div>
  </div>
  <!-- sidebar end -->

<!-- content start -->
<div class="admin-content">

  <div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑Blog信息</strong> / <small>form</small></div>
  </div>

  <div class="am-tabs am-margin" data-am-tabs>
      
    <ul class="am-tabs-nav am-nav am-nav-tabs">
      <!--<li class="am-active"><a href="#tab1">基本信息</a></li>-->
      <li><a href="#tab2">详细描述</a></li>
      <!--
      <li><a href="#tab3">SEO 选项</a></li>
      -->
    </ul>
    <form action="http://localhost:9990/gtp/admin/blog/edit" method="post" enctype="multipart/form-data" class="am-form">
    <div class="am-tabs-bd">
        
          <div class="am-tab-panel am-fade" id="tab2">
            
              <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                  文章标题
                </div>
                <div class="am-u-sm-8 am-u-md-4">
                  <input type="text" name="title" value="<?php echo ($item["title"]); ?>" class="am-input-sm">
                </div>
                <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
              </div>
    
              <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                  信息封面
                </div>
                <div class="am-u-sm-8 am-u-md-4">
                  <input type="file" name="cover" class="am-input-sm efile">
                </div>
                <div class="am-hide-sm-only am-u-md-6">选填</div>
              </div>
    
              <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                  内容摘要
                </div>
                <div class="am-u-sm-8 am-u-md-4">
                  <input type="text" name="description" value="<?php echo ($item["description"]); ?>" class="am-input-sm">
                </div>
                <div class="am-u-sm-12 am-u-md-6">不填写则自动截取内容前255字符</div>
              </div>
    
              <div class="am-g am-margin-top-sm">
                <div class="am-u-sm-12 am-u-md-2 am-text-right admin-form-text">
                  内容描述
                </div>
                <div class="am-u-sm-12 am-u-md-10">
                  <textarea rows="10" name="content" placeholder="请使用富文本编辑插件"><?php echo ($item["content"]); ?></textarea>
                </div>
              </div>
              
              <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                  文章标签
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                  <input type="text" name="tags" value="<?php echo ($item["tags"]); ?>" class="am-input-sm">
                </div>
              </div>
            
          </div>

    </div>
  </div>

  <div class="am-margin">
      <input type="hidden" name="id" value="<?php echo ($item["id"]); ?>" />
      <input type="submit" class="am-btn am-btn-primary am-btn-xs" value="提交保存" />
      <a style="color: #fff;" href="http://localhost:9990/gtp/admin/blog" type="button" class="am-btn am-btn-primary am-btn-xs">放弃保存</a>
  </div>
  </form>
  
</div>
<!-- content end -->

</div>

<a class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<footer>
  <hr>
  <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/polyfill/rem.min.js"></script>
<script src="assets/js/polyfill/respond.min.js"></script>
<script src="assets/js/amazeui.legacy.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="http://localhost:9990/gtp/assets/js/jquery.min.js"></script>
<script src="http://localhost:9990/gtp/assets/js/amazeui.min.js"></script>
<!--<![endif]-->
<script src="http://localhost:9990/gtp/assets/js/app.js"></script>
<script src="http://localhost:9990/gtp/assets/js/admin.js"></script>
<input type="hidden" name="site" id="site" value="http://localhost:9990/gtp/admin">
</body>
</html>