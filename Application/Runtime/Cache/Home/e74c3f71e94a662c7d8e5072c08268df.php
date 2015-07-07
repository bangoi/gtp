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

<div class="contaier thinkphp-app wp">
    <div class="app-left">
        <div class="ident">吉他视频</div>
        <!--文章详细-->
        <div class="app-detail">
            <div class="head">
                <h1><?php echo ($vedio["title"]); ?></h1>
                <div class="app-info">
                    <span class="date"><?php echo (todate($vedio["add_time"],'Y-m-d H:i')); ?></span>
                    <a class="author" href="http://localhost:9990/gtp/vedio/?artist_name=<?php echo (urlencode($vedio["artist_name"])); ?>"><?php echo ($vedio["artist_name"]); ?>吉他视频</a>
                    <span class="version"><a href="http://localhost:9990/gtp/user/<?php getUserDomain($user); ?>"><?php echo ($user["nick"]); ?></a>发布</span>
                    <a class="class" href="http://localhost:9990/gtp/vedio/">[ 吉他视频 ]</a>
                    <?php if ($can_edit) { ?>
                    <a href="http://localhost:9990/gtp/vedio/edit/<?php echo ($vedio["id"]); ?>">[编辑]</a>
                    <?php } ?>
                    <div class="score">
                        <span record="37" class="score" model="45" score="0"></span>
                        <span class="total">(共<span id="score-count"><?php echo ($vedio["view_num"]); ?></span>人看过)</span>
                    </div>
                </div>
            </div>
            <div class="body">
                
                <div class="app-summary">
                    <embed src="<?php echo ($vedio["code"]); ?>" quality="high" width="540" height="450" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>
                </div>
                
                <br />
                
                <?php if(count($gtps) > 0): ?>
                <div class="relation">
                    <div class="trhead">
                        <b><?php echo ($vedio["song_title"]); ?> 吉他谱下载</b>
                    </div>
                    <ul>
                        <?php if(is_array($gtps)): foreach($gtps as $key=>$gtp): ?><li><a href="http://localhost:9990/gtp/gtp/<?php echo ($gtp["id"]); ?>"><?php echo ($gtp["song_title"]); ?>-<?php echo ($gtp["artist_name"]); ?></a> 下载：<?php echo ($gtp["download_num"]); ?>次</li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <?php if(count($vedioes) > 0): ?>
                <div class="app-summary v_list">
                    <b>更多<?php echo ($vedio["artist_name"]); ?>吉他视频</b>
                    <br />
                    <br />
                    <ul>
                        <?php if(is_array($vedioes)): foreach($vedioes as $key=>$vedio): ?><li class="item">
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
                
                <p>
                        <br/>
                        <b>搜索更多：</b> <a href="http://localhost:9990/gtp/vedio/?artist_name=<?php echo (urlencode($vedio["artist_name"])); ?>"><?php echo ($vedio["artist_name"]); ?>吉他视频</a>
                </p>
                
            </div>
        </div>
        <!--/文章详细-->
        <!--文章评论-->
        
        <div class="review">
            
            <?php if($_logined == false) { ?>
            <?php $goto = "vedio/".$blog['id']."#comments"; ?>
            <div class="trbody">
    <div class="login-tip">
     您需要登录后才可以评论 <a href="javascript:void(0);" id="doLogin">登录</a> | <a href="http://localhost:9990/gtp/user/register?page=<?php echo ($page); ?>" id="doRegister">立即注册</a>
    </div>
</div>
            
<div class="body form " id="loginForm">
<form action="http://localhost:9990/gtp/user/login" method="post" class="login">
<div style="float: right; margin-top: -40px; margin-right: -20px;">
    <img src="http://localhost:9990/gtp/img/cancel.png" id="loginExit" />        
</div>
<table>
    <tr>
        <th>用户名</th>
        <td>
            <input class="text" type="text" name="nick" />
        </td>
    </tr>
    <tr>
        <th>密&#12288;码</th>
        <td>
            <input class="text" type="password" name="pwd" />
        </td>
    </tr>
    <tr>
        <th>&nbsp;</th>
            <td>
                <input type="hidden" name="page" value="<?php echo ($goto); ?>" />
                <input class="submit" type="submit" value="登录" /> &nbsp;
                <a href="http://localhost:9990/gtp/user/register?page=<?php echo ($page); ?>">注册</a>
            </td>
    </tr>
</table>
</form>
</div>
            <?php } ?>
            
            <?php  $item_type = "vedio"; $item_id = $vedio['id']; ?>
            
            <ul id="comment_list">
                <?php if(is_array($comment_list)): foreach($comment_list as $key=>$comment): ?><li id="comment-<?php echo ($comment["id"]); ?>">
    <div class="comm_l">
        <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($comment['user_id']) ?>"><img src="<?php getUserFaceById($comment['user_id']); ?>" class="face" /></a>
    </div>
    <div class="comm_r">
        <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($comment['user_id']) ?>" id="comm-nick-<?php echo ($comment["id"]); ?>"><?php echo ($comment["nick"]); ?></a> &nbsp; <span class="c7"><?php echo (firendlytime($comment["add_time"])); ?></span>
        <?php if(!empty($comment['parent_id']) && $comment['parent_id'] > 0) { ?>
        <?php $p_comment = getCommentById($comment['parent_id']); ?>
        <?php if(empty($p_comment) || $p_comment["state"] == -1) { ?>
            <p class="quote_item" style="color: #999;">该评论已被删除</p>
        <?php } else { ?>
            <p class="quote_item"><?php getParentUser($comment['parent_id']); ?>：<?php echo $p_comment['content']; ?></p>
        <?php } ?>
        <?php } ?>
        <p id="comm-cnt-<?php echo ($comment["id"]); ?>"><?php echo (autolink($comment["content"])); ?></p>
    </div>
    <div class="c_opt">
        <?php if(isTopicOwnerById($item_id, $_uid) || isCommentOwner($comment['id'], $_uid)) { ?>
        <a href="javascript:void(0);" class="doDelete" cid="<?php echo ($comment["id"]); ?>">删除</a> &nbsp;
        <?php } ?>
        <a href="javascript:void(0);" class="doQuote" cid="<?php echo ($comment["id"]); ?>">回应</a>
    </div>
    <br class="clear" />
</li><?php endforeach; endif; ?>
            </ul>
            
            <!-- page begin -->
            <div class="manu"><?php echo ($page); ?></div>
            <!-- page end -->
            
            <br/>
            <?php if($_logined == true) { ?>
<div id="commentPanel">
<div class="trhead">
    <a name="review"></a>
    <strong>我的评论</strong> <span style="color: red;" id="lblErr"></span>
</div>
<ul>
    <li style="border: none;">
        <div class="comm_l">
            <a href="http://localhost:9990/gtp/user/<?php getUserDomainById($_uid); ?>"><img src="<?php getUserFaceById($_uid, 's'); ?>" class="face" /></a>
        </div>
        <div class="comm_r">
            <div id="comm_quote">
                <div style="float: left; width: 95%;" id="quote_cnt_p">
                    <a id="quote_nick"></a> : <p id="quote_cnt"></p>
                </div>
                <div style="float: right; width: 3%;"><a href="javascript:void(0);" id="quote_cancel">x</a></div>
                <br class="clear" />
            </div>
            <form class="form">
            <textarea name="content" id="txtContent" class="textarea"></textarea>
            <input type="hidden" id="itemType" name="item_type" value="<?php echo ($item_type); ?>" />
            <input type="hidden" id="itemId" name="item_id" value="<?php echo ($item_id); ?>" />
            <input type="hidden" id="parentId" name="parent_id" value="-1" />
            <input type="button" id="btnComment" class="button" style="margin-top: 5px;" value="回复" />
            </form>
        </div>
    </li>
</ul>
</div>
<?php } ?>
            
        </div>
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