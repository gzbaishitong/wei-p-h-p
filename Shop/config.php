<?php
return array (
		'title' => array (
				'title' => '封面标题',
				'type' => 'text',
				'value' => '点击进入商铺',
				'tip' => '' 
		),
                 
		'cover' => array (
				'title' => '封面图片',
				'type' => 'picture',
				'value' => '',
				'ratio' => '2', //是否压缩数据
				'tip' => '建议宽高尺寸为600X300像素或以上',
                                'config'=>array('crop'=>'2:1')//图片限制的裁切比  (宽高比）
		),
		'info' => array (
				'title' => '封面简介',
				'type' => 'textarea',
				'value' => '',
				'tip' => '' 
		),
                'logo_img' => array (
                                'title' => 'LOGO图片',
                                'type' => 'picture',
                                'value' => '',
                                'ratio' => 'false', //是否压缩数据
                                'tip' => '显示在商铺左上角及底部，建议为白色透明PNG格式图片，宽高尺寸为240X80像素或以上'
                ),
                
                'pay_type'=>array(
                    'title'=>'支付方式',
                    'type'=>'checkbox',
                    'value' => '1',
                    'tip' => '使用微信支付必须是企业服务号类型并通过微信支付接口认证',
                    'options'=>array(
                        '1'=>'微信支付',
                        '3'=>'货到付款',
                       // '4'=>'使用余额'
                    )
                ),
                'y_price' => array(
                                'title' => '基础运费',
                                'type' => 'text',
								'tip' => '可为空，支持小数点后两位，单位：元'
                ),
                'my_price' => array(
                                'title' => '免运费最低消费额',
                                'type' =>'text',
								'tip' => '可为空，支持小数点后两位，单位：元'
                ),
                
		'copyright' => array (
				'title' => '底部版权信息',
				'type' => 'text',
				'value' => '',
				'tip' => '可为空' 
		),
    'scorebili' => array(
        'title'=>'积分比例',
        'type' => 'text',
        'value' => '10',
        'tip' => '实际为1元等于多少积分'
    ),
    /*
     *
     * 'use_level'=>array(
                    'title'=>'开启会员优惠',
                    'type'=>'select',
                    'options'=>array(
                        '1'=>'开启',
                        '0'=>'关闭'
                    ),
                    'value'=>'0',
                    'tip' => '开启会员优惠后，会员将获得与等级相对应的折扣优惠'
                ),
                'template_id'=>array(
                                'title' => '订单创建成功通知',
				'type' => 'text',
				'value' => '',
				'tip' => '填写微信公众平台“模板消息”功能中的模板ID后生效' 
                )
		'code' => array (
				'title' => '统计代码:',
				'type' => 'textarea',
				'value' => '',
				'tip' => '' 
		) ,*/
);
					