var shareData = {
    img_url: "http://baozou.gzbaishitong.com/game/source/furious/share.jpg",
    site_link: "http://baozou.gzbaishitong.com/game/source/furious/index.php",
    messageDesc: "���ڶ����������л��600�֣�����NO. 20���������ȱȣ�",
    circleDesc: "���ڶ����������л��600�֣�����NO. 20���������ȱȣ�",
    title: "���ݰ���ͨ ����������",
    backFun: "",
    cancelFun: ""
};

function setShareData(score,rank) {

    wx.onMenuShareTimeline({
        title: score==""?shareData.circleDesc: "���ڶ����������л��"+score+"�֣�����NO. "+rank+"��������ս��" ,
        link: shareData.site_link,
        imgUrl: shareData.img_url,
        trigger: function (res) {
         //   $("#popupshare").hide();
          //  $("#popupfavor").hide();
            gotoga('/qing')
            // ��Ҫ������trigger��ʹ��ajax�첽�����޸ı��η�������ݣ���Ϊ�ͻ��˷��������һ��ͬ����������ʱ��ʹ��ajax�Ļذ��ỹû�з���
            //alert('�û������������Ȧ');
        },
        success: function (res) {
            gotoga('/qok')
          //  alert('�ѷ���');
        },
        cancel: function (res) {
            gotoga('/qcancle')
           // alert('��ȡ��');
        },
        fail: function (res) {
            //  alert(JSON.stringify(res));
        }
    });
    wx.onMenuShareAppMessage({
        title: shareData.title,
        desc:  score==""?shareData.circleDesc: "���ڶ����������л��"+score+"�֣�����NO. "+rank+"��������ս��" ,
        link: shareData.site_link,
        imgUrl: shareData.img_url,
        type: "",
        dataUrl: "",
        success: function () {
            gotoga('/friendok')
            // �û�ȷ�Ϸ����ִ�еĻص�����
        },
        trigger: function (res) {
            
            gotoga('/friending')
            // ��Ҫ������trigger��ʹ��ajax�첽�����޸ı��η�������ݣ���Ϊ�ͻ��˷��������һ��ͬ����������ʱ��ʹ��ajax�Ļذ��ỹû�з���
            //alert('�û������������Ȧ');
        },
        cancel: function () {
            gotoga('/friendcancel')
            // �û�ȡ�������ִ�еĻص�����
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