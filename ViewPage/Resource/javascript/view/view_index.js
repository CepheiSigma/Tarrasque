/**
 * Created by cephei on 3/8/16.
 */

$("[data-url]").on("click",function(e){
    var el = e.currentTarget;
    $("#right_frame").prop("src",$(el).data("url"));
});

$("#right_frame").on("load",function(e){
    $("#right_frame").css("height",$(".content-wrapper").height());
});

$("body").on("resize",function(){
    $("#right_frame").css("height",$(".content-wrapper").height());
});