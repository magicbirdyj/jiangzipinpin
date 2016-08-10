// JavaScript Document
//onfocus
//onblur

$().ready(function(){
    $("a").attr('data-ajax',false);//对jquery.mobile的a标签全部重新加载页面
})
var control = navigator.control || {};
    if (control.gesture) {
        control.gesture(false);
        }