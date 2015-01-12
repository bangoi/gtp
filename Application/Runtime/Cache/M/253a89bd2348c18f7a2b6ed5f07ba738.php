<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title></title>
<link type="text/css" rel="stylesheet" href="__SITE__/css/mobile.css" />
<script type="text/javascript" src="__SITE__/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="__SITE__/js/global.js"></script>
<script type="text/javascript" src="__SITE__/js/m/iscroll.js"></script>

<script type="text/javascript">

var myScroll,
    pullDownEl, pullDownOffset,
    pullUpEl, pullUpOffset,
    generatedCount = 0;
    
var hasItem = false;

/*
function pullDownAction () {
    setTimeout(function () {    // <-- Simulate network congestion, remove setTimeout from production!
        var el, li, i;
        el = document.getElementById('thelist');

        for (i=0; i<3; i++) {
            li = document.createElement('li');
            li.innerHTML = '<div class="list-box"><span>2500</span><span>文字1</span><span>文字2</span><span>文字3</span><span>文字4</span><span>文字5</span><span>文字1</span><span>文字2</span><span>文字3</span><span>文字4</span><span>文字5</span><div class="list-btn">抢单</div></div>';
            el.insertBefore(li, el.childNodes[0]);
        }
        
        myScroll.refresh();     // Remember to refresh when contents are loaded (ie: on ajax completion)
    }, 1000);   // <-- Simulate network congestion, remove setTimeout from production!
}
*/
function pullUpAction () {
    setTimeout(function () {    // <-- Simulate network congestion, remove setTimeout from production!
        var current_page = $("#current_page").val();
        var next_page = parseInt(current_page) + 1;
        $("#current_page").val(next_page);
        var pageSize = 10;
        
        var uid = $("#_uid").val();
        var url = $("#site_url").val() + "/m/index/load";
        
        $.ajaxSettings.async = false;
        $.get(url, { p : next_page, uid : uid }, function(html) {
            if(html == "") {
                //pullUpEl.querySelector('.pullUpLabel').innerHTML = '已经加载全部订单...';
            } else {
                $("#thelist li:last-child").after(html);
                hasItem = true;
            }
            //alert($("#item_count").val());
            //$("#item_count").val();
        });
        
        //alert(page);
        myScroll.refresh();     // Remember to refresh when contents are loaded (ie: on ajax completion)
    }, 1000);   // <-- Simulate network congestion, remove setTimeout from production!
}

function loaded() {
    pullDownEl = document.getElementById('pullDown');
    pullDownOffset = pullDownEl.offsetHeight;
    pullUpEl = document.getElementById('pullUp');
    pullUpOffset = pullUpEl.offsetHeight;
    
    myScroll = new iScroll('wrapper', {
        useTransition: true,
        topOffset: pullDownOffset,
        onRefresh: function () {
            if (pullDownEl.className.match('loading')) {
                pullDownEl.className = '';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
            } else if (pullUpEl.className.match('loading')) {
                pullUpEl.className = '';
                if(hasItem == true)
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '已加载全部订单...';
                else
                    pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉刷新...';
            }
        },
        onScrollMove: function () {
            /*
             if (this.y > 5 && !pullDownEl.className.match('flip')) {
                pullDownEl.className = 'flip';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '放开刷新...';
                this.minScrollY = 0;
            } else if (this.y < 5 && pullDownEl.className.match('flip')) {
                pullDownEl.className = '';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                this.minScrollY = -pullDownOffset;
            } else
            */
            if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
                pullUpEl.className = 'flip';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '放开刷新...';
                this.maxScrollY = this.maxScrollY;
            } else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '';
                this.maxScrollY = pullUpOffset;
            }
        },
        onScrollEnd: function () {
            if (pullDownEl.className.match('flip')) {
                pullDownEl.className = 'loading';
                pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';                
                pullDownAction();   // Execute custom function (ajax call?)
            } else if (pullUpEl.className.match('flip')) {
                pullUpEl.className = 'loading';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';                
                pullUpAction(); // Execute custom function (ajax call?)
            }
        }
    });
    
    setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);

$(function() {
     
    $("#header .header-left").click(function(){     
        $(".pop-list").slideToggle();
    })
    
    $(".pop-list div").click(function(){
        $(this).parent(".pop-list").hide();
    })
    
    $("#imgRefresh").click(function() {
        location.reload();
    });
    
})

</script>

</head>
<body>
<input type="hidden" id="_logined" name="_logined" value="<?php echo ($_logined); ?>" />
<input type="hidden" id="_uid" name="_uid" value="<?php echo ($_uid); ?>" />
<input type="hidden" id="_tel" name="_tel" value="<?php echo ($_tel); ?>" />
<input type="hidden" id="site_url" name="site_url" value="__SITE__" />
<input type="hidden" id="current_page" name="current_page" value="1" /> 

<div id="header">
    <span class="header-left">菜单&nbsp;&nbsp;&nbsp;<img src="__SITE__/img/m/arr-down-icon.png" class="arr-down"></span><div class="left-border"></div>
    <span class="title"><a href="__SITE__/m/index/my_items">抢活神器(全部)</a></span>
    <img src="__SITE__/img/m/refresh-icon.png" id="imgRefresh" class="header-right">
    <div class="pop-list" style="display:none;">
        <div class="border-bottom" ><a href="__SITE__/m/index/my_items">全部订单</a></div>
        <div class="border-bottom" ><a href="__SITE__/m/index/my_items">已抢订单</a></div>
        <div class="border-bottom" ><a href="__SITE__/m/people/repwd">修改密码</a></div>
        <div><a href="__SITE__/m/people/logout">退出登录</a></div>
    </div>
</div>

<div id="wrapper">
    <div id="scroller">
        <div id="pullDown">
            <!--<span class="pullDownIcon"></span><span class="pullDownLabel">Pull down to refresh...</span>-->
        </div>

        <ul id="thelist">
            <?php if(is_array($items)): foreach($items as $key=>$item): ?><li>
                <div class="list-box">
    <p>
        <span><a href="#<?php echo ($item["id"]); ?>" class="mlbl">编号：DD<?php echo ($item["id"]); ?></a></span> &nbsp;&nbsp;&nbsp; 
            
        <?php if(!empty($item['price'])) { ?>
        <span><a class="mlbl">价格：</a><?php echo ($item["price"]); ?></span>
        <?php } ?>
    </p>
    
    <p>
        <br style="clear: both;" />
        <span><?php echo ($item["content"]); ?></span>
    </p>
    
    <?php if(!empty($item['address'])) { ?>
    <br style="clear: both;" />
    <p>
        <span><a class="mlbl">地点：</a><?php echo ($item["address"]); ?></span>
    </p>
    <?php } ?>
    
    <?php if(!empty($item['remark'])) { ?>
    <br style="clear: both;" />
    <p>
        <span><a class="mlbl">特殊说明：</a><?php echo ($item["remark"]); ?></span>
    </p>
    <?php } ?>
    
    <p>
        <br style="clear: both;" />
        <span><?php echo date("Y年m月d日 H:i", strtotime($item['add_time'])); ?></span>
    </p>
                    
    <?php if(!applied($item['id'], $_uid)) { ?>
    <div class="list-btn grab-list active" item_id=<?php echo ($item["id"]); ?> id="btn-<?php echo ($item["id"]); ?>" applied="false"><a href="__SITE__/m/item/apply/<?php echo ($item["id"]); ?>">抢单</a></div>
    <?php } else { ?>
    <div class="list-btn revoke-list" id="btn-<?php echo ($item["id"]); ?>" item_id=<?php echo ($item["id"]); ?> applied="true"><a href="__SITE__/m/item/withdraw/<?php echo ($item["id"]); ?>">撤单</a></div>
    <?php } ?>
                    
</div>
<div class="list-line"></div>
            </li><?php endforeach; endif; ?>
        </ul>
        
        <div id="pullUp">
            <span class="pullUpIcon"></span><span class="pullUpLabel">下拉刷新...</span>
        </div>
    </div>
</div>

<div id="footer">免费电话 <a href="tel:40005-30003"><span class="tel">40005-30003</span></a></div>

</body>
</html>