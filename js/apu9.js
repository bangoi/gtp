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
    })
});