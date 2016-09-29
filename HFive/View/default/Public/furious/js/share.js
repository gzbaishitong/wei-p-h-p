var shareData = {
    img_url: "http://baozou.gzbaishitong.com/game/source/furious/share.jpg",
    site_link: "http://baozou.gzbaishitong.com/game/source/furious/index.php",
    messageDesc: "我在端午龙舟赛中获得600分，排名NO. 20，够胆来比比！",
    circleDesc: "我在端午龙舟赛中获得600分，排名NO. 20，够胆来比比！",
    title: "广州百事通 端午龙舟赛",
    backFun: "",
    cancelFun: ""
};

function setShareData(score,rank) {

    wx.onMenuShareTimeline({
        title: score==""?shareData.circleDesc: "我在端午龙舟赛中获得"+score+"分，排名NO. "+rank+"，不服来战！" ,
        link: shareData.site_link,
        imgUrl: shareData.img_url,
        trigger: function (res) {
         //   $("#popupshare").hide();
          //  $("#popupfavor").hide();
            gotoga('/qing')
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            //alert('用户点击分享到朋友圈');
        },
        success: function (res) {
            gotoga('/qok')
          //  alert('已分享');
        },
        cancel: function (res) {
            gotoga('/qcancle')
           // alert('已取消');
        },
        fail: function (res) {
            //  alert(JSON.stringify(res));
        }
    });
    wx.onMenuShareAppMessage({
        title: shareData.title,
        desc:  score==""?shareData.circleDesc: "我在端午龙舟赛中获得"+score+"分，排名NO. "+rank+"，不服来战！" ,
        link: shareData.site_link,
        imgUrl: shareData.img_url,
        type: "",
        dataUrl: "",
        success: function () {
            gotoga('/friendok')
            // 用户确认分享后执行的回调函数
        },
        trigger: function (res) {
            
            gotoga('/friending')
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            //alert('用户点击分享到朋友圈');
        },
        cancel: function () {
            gotoga('/friendcancel')
            // 用户取消分享后执行的回调函数
        }
    })

}
wx.ready(function ()
{
    setShareData("","")
});
$.ajax({
    type: "post",
    url: "js_jdk.php",
    dataType: "text",
    data: {
        type: "signature",
        url: window.location.href.split("#")[0],
    },
    async: false,
    cache: false,
    success: function (result) {
        result = $.parseJSON(result);
        wx.config({
            debug: false,
            appId: "wx807f16d8a8046457",
            timestamp: result.timestamp,
            nonceStr: result.nonceStr,
            signature: result.signature,
            jsApiList: ["onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo"]
        })
    }, fail: function (e) { }
});