// JavaScript Document
var img=$('#lunbo_div img:first').attr('src');
    var title=$('.titile').html();
    var price=$('.price_strong').html();
    var desc='赶紧拉朋友一起拼团吧：'+$('#title1_1').html();
    var is_huodong=$('#huodong_guize').html();
    if(is_huodong){
        fenxiang_title='真的只需要'+price+'元：'+title;
    }else{
        fenxiang_title= '【酱紫拼拼】：'+price+'元 '+title;
    }
    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: fenxiang_title, // 分享标题
            imgUrl: 'http://m.jiangzipinpin.com'+img // 分享图标
        });
        wx.onMenuShareAppMessage({
            title: fenxiang_title, // 分享标题
            desc:  desc, // 分享描述
            imgUrl: 'http://m.jiangzipinpin.com'+img // 分享图标
        });
        wx.onMenuShareQQ({
            title:  fenxiang_title, // 分享标题
            desc: desc, // 分享描述
            imgUrl: 'http://m.jiangzipinpin.com'+img // 分享图标
        });
        wx.onMenuShareQZone({
            title:fenxiang_title, // 分享标题
            desc:desc, // 分享描述
            imgUrl:  'http://m.jiangzipinpin.com'+img // 分享图标
        });
    });