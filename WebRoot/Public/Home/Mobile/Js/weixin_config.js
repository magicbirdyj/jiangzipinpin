// JavaScript Document
var img=$('#lunbo_div img:first').attr('src');
    var title=$('.titile').html();
    var price=$('.price_strong').html();
    var yuan_price=$('.yuan_price').html();
    var desc=yuan_price+','+tuan_number+'人团价'+price+'元：'+$('#title1_1').html();
    var is_huodong=$('#huodong_guize').html();
    if(is_huodong){
        fenxiang_title='['+tuan_number+'人团]'+'真的只需要'+price+'元：'+title;
    }else{
        fenxiang_title= '【酱紫拼拼】'+tuan_number+'人团：'+price+'元 '+title;
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