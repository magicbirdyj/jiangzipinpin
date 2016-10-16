// JavaScript Document
    //if(is_huodong){
        //fenxiang_title='['+tuan_number+'人团]'+'真的只需要'+price+'元：'+title;
    //}else{
        fenxiang_title= '【酱紫拼拼】'+'乐享价：'+price+'元 '+title;
    //}
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