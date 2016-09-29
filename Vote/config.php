<?php
return array(
	'random'=>array(//配置在表单中的键名 ,这个会是config[random]
		'title'=>'是否开启随机:',//表单的文字
		'type'=>'radio',		 //表单的类型：text、textarea、checkbox、radio、select等
		'options'=>array(		 //select 和radion、checkbox的子选项
			'1'=>'开启',		 //值=>文字
			'0'=>'关闭',
		),
		'value'=>'1',			 //表单的默认值
	),
    'daycount'=>array(//配置在表单中的键名 ,这个会是config[random]
        'title'=>'每人每日每组投票次数:',//表单的文字
        'type'=>'text',		 //表单的类型：text、textarea、checkbox、radio、select等
        'value'=>'1',			 //表单的默认值
    ),
    'picurl' => array (
        'title' => '封面图片',
        'type' => 'picture',
        'value' => '',
        'ratio' => '2', //是否压缩数据
        'tip' => '建议宽高尺寸为600X300像素或以上',
        'config'=>array('crop'=>'2:1')//图片限制的裁切比  (宽高比）
    ),
);
					