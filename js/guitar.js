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
    
});