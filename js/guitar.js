$(document).ready(function () {
    $("#btnVedioUrl").click(function () {
        var vedio_url = $("#vedio_url").val();
        $.post("../vedio/addVedio", { 'vedioUrl': vedio_url }, function (data) {
        	var dataObj=eval("("+data+")");
        	$("#title").attr("value", dataObj.data.title);
        	$("#thumb").attr("src", dataObj.data.img);
        	$("#thumb_value").attr("value", dataObj.data.img);
        	$("#code").attr("value", dataObj.data.swf);
        })
    });
    
    $("#channelType").change(function() {
        var channel = $("#channelType").val();
        var action_url = $("#site").val();
        if(channel == "gtp")
            action_url += "/gtp/search";
        else if(channel == "vedio")
            action_url += "/vedio/search";
        else
            action_url += "/search";
        $("#channelForm").attr("action", action_url);
    });
    
    $("#sltProvince").change(function() {
        var province_code = $("#sltProvince").val();
        var url = $("#site").val() + "/user/get_city";
        $.getJSON(url, { province_code: province_code }, function(json) {
            $("#sltCity").empty();
            var noticeOption = $("<option>").val(0).text("-所在市-"); 
                $("#sltCity").append(noticeOption);
                $(json).each(function(i) {
                    var option = $("<option>").val(json[i].code).text(json[i].name); 
                    $("#sltCity").append(option);
               });
        });
    });
    
    $("#doLogin").click(function(event){
        var e = window.event || event;
        if(e.stopPropagation)
            e.stopPropagation();
        else
            e.cancelBubble = true;
        $("#loginForm").show();
        
        var docheight = $(document).height();
        $("body").append("<div id='greybackground'></div>");
        $("#greybackground").css({ "opacity": "0.5", "height": docheight });
        
    });
    
    $("#loginExit").click(function(event){
        var e = window.event || event;
        if(e.stopPropagation)
            e.stopPropagation();
        else
            e.cancelBubble = true;
        $("#loginForm").hide();
        $("#greybackground").remove();
    });
    
    $("#btnComment").click(function() {
        var url = $("#site").val() + "/comment/add";
        
        var content = $("#txtContent").val();
        if(content == "") {
            $("#lblErr").html("评论内容必须填写");
            $("#txtContent").focus();
            return;
        }
            
        var itemType = $("#itemType").val();
        var itemId = $("#itemId").val();
        var parentId = $("#parentId").val();
        
        var data = { item_type : itemType, item_id : itemId, parent_id : parentId, content : content };
        $.post(url, data, function(result) {
            try {
                var json = jQuery.parseJSON(result);
                if(json.code == -1) {
                    $("#lblErr").html(json.data);
                } else {
                    $("#lblErr").html("回复失败");
                }
            } catch(e) {
                $("#comment_list").append(result);
                $("#commentPanel").slideUp();
            }
        });
    });
    
    $(".doDelete").click(function() {
        if(confirm("删除 ?")) {
            var id = $(this).attr("cid");
            var url = $("#site").val() + "/comment/delete/" + id;
            var type = $(this).attr("type");
            var data = { id : id, type : type }
            $.get(url, data, function(result) {
                var json = jQuery.parseJSON(result);
                if(json.code == -1) {
                    alert(json.data);
                } else if(json.code == 100) {
                    $("#comment-" + id).slideUp();
                } else {
                    alert("回复删除失败");
                }
            });
        }
    });
    
    $(".doQuote").click(function() {
        var id = $(this).attr("cid");
        var nick = $("#comm-nick-" + id).html();
        var cnt = $("#comm-cnt-" + id).html();
        $("#parentId").val(id);
        $("#quote_nick").html(nick);
        $("#comm_quote").show();
        $("#quote_cnt").html(cnt);
    });
        
    $("#quote_cancel").click(function() {
        $("#parentId").val(-1);
        $("#comm_quote").slideUp();
    });
    
    $(".adminCheck").click(function() {
        var id = $(this).attr("id").split("-")[1];
        if($("#imgAdmin-" + id).attr("state") == "0") {
            $("#imgAdmin-" + id).addClass("face");
            $("#imgAdmin-" + id).attr("state", "1");
            $("#imgAdmin-" + id).attr("checked",'true');
            $("#chkAdmin-" + id).val(id);
        } else {
            $("#imgAdmin-" + id).removeClass("face");
            $("#imgAdmin-" + id).attr("state", "0");
            $("#chkAdmin-" + id).removeAttr("checked");
        }
    });
    
    $(".memberCheck").click(function() {
        var id = $(this).attr("id").split("-")[1];
        if($("#imgMember-" + id).attr("state") == "0") {
            $("#imgMember-" + id).addClass("face");
            $("#imgMember-" + id).attr("state", "1");
            $("#imgMember-" + id).attr("checked",'true');
            $("#chkMember-" + id).val(id);
        } else {
            $("#imgMember-" + id).removeClass("face");
            $("#imgMember-" + id).attr("state", "0");
            $("#chkMember-" + id).removeAttr("checked");
        }
    });
    
    $("#btnAdmin").click(function() {
        $("#groupRoleAction").val("add_admin");
        $("#groupMemberForm").submit();
    });
    
    $("#btnRemove").click(function() {
        $("#groupRoleAction").val("group_remove");
        $("#groupMemberForm").submit();
    });
    
    jQuery.extend({
        isJson:function(obj) {
            var isJson = typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;    
            return isJson;
        }
    });
    
});