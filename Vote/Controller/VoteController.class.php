<?php

namespace Addons\Vote\Controller;

use Addons\UserInfo\UserInfoAddon;
use Home\Controller\AddonsController;

class VoteController extends BaseController
{
    protected $model;
    protected $option;

    public function __construct()
    {
        parent::__construct();
        $this->model = M('Model')->getByName($_REQUEST ['_controller']);
        $this->model || $this->error('模型不存在！');

        $this->assign('model', $this->model);

        $this->option = M('Model')->getByName('vote_option');
        $this->assign('option', $this->option);
    }

    /**
     * 显示指定模型列表数据
     */
    public function lists()
    {
        $page = I('p', 1, 'intval'); // 默认显示第一页数据

        // 解析列表规则
        $list_data = $this->_list_grid($this->model);
        $grids = $list_data ['list_grids'];
        $fields = $list_data ['fields'];

        // 关键字搜索
        $map ['token'] = get_token();
        $key = $this->model ['search_key'] ? $this->model ['search_key'] : 'title';
        if (isset ($_REQUEST [$key])) {
            $map [$key] = array(
                'like',
                '%' . htmlspecialchars($_REQUEST [$key]) . '%'
            );
            unset ($_REQUEST [$key]);
        }
        // 条件搜索
        foreach ($_REQUEST as $name => $val) {
            if (in_array($name, $fields)) {
                $map [$name] = $val;
            }
        }
        $row = empty ($this->model ['list_row']) ? 20 : $this->model ['list_row'];

        // 读取模型数据列表

        empty ($fields) || in_array('id', $fields) || array_push($fields, 'id');
        $name = parse_name(get_table_name($this->model ['id']), true);
        $data = M($name)->field(empty ($fields) ? true : $fields)->where($map)->order('id DESC')->page($page, $row)->select();

        /* 查询记录总数 */
        $count = M($name)->where($map)->count();

        // 分页
        if ($count > $row) {
            $page = new \Think\Page ($count, $row);
            $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $this->assign('_page', $page->show());
        }

        $this->assign('list_grids', $grids);
        $this->assign('list_data', $data);
        $this->meta_title = $this->model ['title'] . '列表';
        $this->display(T('Addons://Vote@Vote/lists'));
    }

    public function del()
    {
        $ids = I('id', 0);
        if (empty ($ids)) {
            $ids = array_unique(( array )I('ids', 0));
        }
        if (empty ($ids)) {
            $this->error('请选择要操作的数据!');
        }

        $Model = M(get_table_name($this->model ['id']));
        $map = array(
            'id' => array(
                'in',
                $ids
            )
        );
        $map ['token'] = get_token();
        if ($Model->where($map)->delete()) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    public function edit()
    {
        // 获取模型信息
        $id = I('id', 0, 'intval');

        if (IS_POST) {
            $_POST ['mTime'] = time();

            $Model = D(parse_name(get_table_name($this->model ['id']), 1));
            // 获取模型的字段信息
            $Model = $this->checkAttr($Model, $this->model ['id']);
            if ($Model->create() && $Model->save()) {
                // 增加选项
                D('Addons://Vote/VoteOption')->set(I('post.id'), I('post.'));

                // 保存关键词
                D('Common/Keyword')->set(I('post.keyword'), 'Vote', I('post.id'));

                $this->success('保存' . $this->model ['title'] . '成功！', U('lists?model=' . $this->model ['name']));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields = get_model_attribute($this->model ['id']);

            // 获取数据
            $data = M(get_table_name($this->model ['id']))->find($id);
            $data || $this->error('数据不存在！');

            $option_list = M('vote_option')->where('vote_id=' . $id)->select();
            $this->assign('option_list', $option_list);

            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->meta_title = '编辑' . $this->model ['title'];
            $this->display(T('Addons://Vote@Vote/edit'));
        }
    }

    public function add()
    {
        if (IS_POST) {
            // 自动补充token
            $_POST ['token'] = get_token();
            $Model = D(parse_name(get_table_name($this->model ['id']), 1));
            // 获取模型的字段信息
            $Model = $this->checkAttr($Model, $this->model ['id']);
            if ($Model->create() && $vote_id = $Model->add()) {
                // 增加选项
                D('Addons://Vote/VoteOption')->set($vote_id, I('post.'));

                // 保存关键词
                D('Common/Keyword')->set(I('keyword'), 'Vote', $vote_id);

                $this->success('添加' . $this->model ['title'] . '成功！', U('lists?model=' . $this->model ['name']));
            } else {
                $this->error($Model->getError());
            }
        } else {

            $vote_fields = get_model_attribute($this->model ['id']);
            $this->assign('fields', $vote_fields);
            // 选项表
            $option_fields = get_model_attribute($this->option ['id']);
            $this->assign('option_fields', $option_fields);

            $this->meta_title = '新增' . $this->model ['title'];
            $this->display($this->model ['template_add'] ? $this->model ['template_add'] : T('Addons://Vote@Vote/add'));
        }
    }

    protected function checkAttr($Model, $model_id)
    {
        $fields = get_model_attribute($model_id, false);
        $validate = $auto = array();
        foreach ($fields as $key => $attr) {
            if ($attr ['is_must']) { // 必填字段
                $validate [] = array(
                    $attr ['name'],
                    'require',
                    $attr ['title'] . '必须!'
                );
            }
            // 自动验证规则
            if (!empty ($attr ['validate_rule']) || $attr['validate_type'] == 'unique') {
                $validate [] = array(
                    $attr ['name'],
                    $attr ['validate_rule'],
                    $attr ['error_info'] ? $attr ['error_info'] : $attr ['title'] . '验证错误',
                    0,
                    $attr ['validate_type'],
                    $attr ['validate_time']
                );
            }
            // 自动完成规则
            if (!empty ($attr ['auto_rule'])) {
                $auto [] = array(
                    $attr ['name'],
                    $attr ['auto_rule'],
                    $attr ['auto_time'],
                    $attr ['auto_type']
                );
            } elseif ('checkbox' == $attr ['type']) { // 多选型
                $auto [] = array(
                    $attr ['name'],
                    'arr2str',
                    3,
                    'function'
                );
            } elseif ('datetime' == $attr ['type']) { // 日期型
                $auto [] = array(
                    $attr ['name'],
                    'strtotime',
                    3,
                    'function'
                );
            }
        }
        return $Model->validate($validate)->auto($auto);
    }

    /**
     * **************************微信上的操作功能************************************
     */
    function show()
    {
        $openid = $_SESSION['openid'];
        $JoinInfo = D('Addons://Vote/Vote')->getInfo($openid);//查询是否是参赛者
        if ($JoinInfo) {
            redirect(U('share', array('openid' => $openid)));
        }
//		$vote_id = I ( 'id', 0, 'intval' );
        $token = get_token();
        $vote_id = M('vote')->where("token='$token'")->getField('id');
        $info = $this->_getVoteInfo($vote_id);
//		$canJoin = ! empty ( $openid ) && ! empty ( $token ) && ! ($this->_is_overtime ( $vote_id )) && ! ($this->_is_join ( $vote_id, $this->mid, $token ));
        $canJoin = !empty ($openid) && !empty ($token) && !($this->_is_overtime($vote_id));
        $this->assign('canJoin', $canJoin);
        // dump ( $canJoin );
        // dump(! empty ( $openid ));dump(! empty ( $token ));dump(! ($this->_is_overtime ( $vote_id )));dump(! ($this->_is_join ( $vote_id, $openid, $token )));
        $test_id = intval($_REQUEST ['test_id']);
        $signPackage = getjssdk();
        $this->assign('signPackage', $signPackage);
        $this->assign('appid', $this->appid);
        $this->assign('openid',$openid);
        $this->assign('event_url', event_url('投票', $vote_id));
        $this->display(T('Addons://Vote@Vote/show'));
    }

    function share()//分享页
    {
        $openid=I('openid');
        $JoinInfo = D('Addons://Vote/Vote')->getInfo($openid);//查询是否是参赛者
        if (!$JoinInfo||empty($openid)) {
            $this->error('此作品不存在');
        }
        $JoinList=D('Addons://Vote/Vote')->getList(10);//参赛者升序10条信息
        $RankList=D('Addons://Vote/Vote')->getList(120);//所有参赛者信息
        foreach($RankList as $key=>$val)
        {
            if($val['openid1']==$openid||$val['openid2']==$openid)
            {
                $rank=$key+1;
            }
        }
        $signPackage = getjssdk();
        $this->assign('openid',$openid);
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('rank',$rank);
        $this->assign('JoinList',$JoinList);
        $this->assign('JoinInfo',$JoinInfo);
        $this->display();
    }
    function votecontroller()//投票控制器
    {
        $diaoyong=new UserInfoAddon();
        $helpopenid=I('helpopenid');//投票者openid
        $openid=I('openid');//被投票者openid
        if(empty($helpopenid))
        {
            $helpopenid=$openid;
        }
        $info= $this->issubscribe($helpopenid);//查询用户是否关注
        $voteid=I('voteid');//作品id
        $vote_id=I('vote_id');//投票id
        $JoinInfo = D('Addons://Vote/Vote')->getOption($voteid);//作品信息
        if($info['subscribe']==0)
        {
            $this->error('请先关注哦',"https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode($voteid));
        }
        if(!$JoinInfo)
        {
            $this->error('此作品不存在');
        }
        if ($this->_is_overtime($vote_id)) {
            $this->error("该投票已过期");
        }
        if (($this->_is_join($vote_id, $helpopenid, get_token(), $voteid)) == 1) {
            $this->error("不能帮自己投票哦");
        } else if (($this->_is_join($vote_id, $helpopenid, get_token(), $voteid)) == 2) {
            $this->error("今天已经投了3票了哦,明天再来吧>_<");
        }
        if (empty ($voteid)) {
            $this->error("请先选择投票项");
        }
        $query=D('Addons://Vote/Vote')->saveinfo($voteid,$helpopenid,$vote_id);
        if($query)
        {
            $this->success('你已帮'.$JoinInfo['name'].'投了一票','http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }
        $this->error('投票失败');
    }

    function voteindex()//分享首页(朋友进入首页)
    {
        $openid=I('state');
        $helpopenid=$_SESSION['openid'];//朋友openid
        $JoinInfo = D('Addons://Vote/Vote')->getInfo($openid);//查询是否是参赛者
        if (!$JoinInfo||empty($openid)) {
            $this->error('此作品不存在');
        }
        $RankList=D('Addons://Vote/Vote')->getList(120);//所有参赛者信息
        foreach($RankList as $key=>$val)
        {
            if($val['openid1']==$openid||$val['openid2']==$openid)
            {
                $rank=$key+1;
            }
        }
        $signPackage = getjssdk();
        $this->assign('appid', $this->appid);
        $this->assign('signPackage', $signPackage);
        $this->assign('openid',$openid);
        $this->assign('helpopenid',$helpopenid);
        $this->assign('rank',$rank);
        $this->assign('JoinInfo',$JoinInfo);
        $this->display();
    }

    function _getVoteInfo($id)
    {
        // 检查ID是否合法
        if (empty ($id) || 0 == $id) {
            $this->error("错误的投票ID");
        }

        $map ['id'] = $map2 ['vote_id'] = intval($id);
        $info = M('vote')->where($map)->find();
        // dump(M ( 'vote' )->getLastSql());
        $this->assign('info', $info);

        // dump($info);
        $opts = M('vote_option')->where($map2)->order('id ')->select();
        foreach ($opts as $p) {
            $total += $p ['opt_count'];
        }
        foreach ($opts as &$vo) {
            $vo ['percent'] = round($vo ['opt_count'] * 100 / $total, 1);
        }
        // dump($opts);
        $this->assign('opts', $opts);
        $this->assign('num_total', $total);
        return $info;
    }
    public function issubscribe($openid)//查询用户是否关注
    {
        $access_token = D("Addons://Vote/AccessToken")->getInfo();
        $access_token=$access_token['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $info=json_decode(file_get_contents($url),true);
        if($info['errcode']!=0)
        {
            $access_token=get_access_token(get_token());
            D('Addons://Vote/AccessToken')->saveinfo($access_token,1);
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
            $info=json_decode(file_get_contents($url),true);
        }

        return $info;
    }

    // 用户投票信息
    function join()
    {
        $diaoyong=new UserInfoAddon();
        $info= $this->issubscribe();//查询用户是否关注
        $token = get_token();
//		$opts_ids = array_filter ( I ( 'post.optArr' ) );
        $opts_ids = I('optArr');
        $openid = $_SESSION['openid'];
        $opt_id = $opts_ids;
        $vote_id = intval(I('vote_id'));
        if($info['subscribe']==0)
        {
            $this->error('请先关注哦',"https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode($opt_id));
        }
        // 检查ID是否合法
        if (empty ($vote_id) || 0 == $vote_id) {
            $this->error("错误的投票ID");
        }
        if ($this->_is_overtime($vote_id)) {
            $this->error("该投票已过期");
        }
        if (($this->_is_join($vote_id, $openid, $token, $opt_id)) == 1) {
            $this->error("不能帮自己投票哦");
        } else if (($this->_is_join($vote_id, $openid, $token, $opt_id)) == 2) {
            $this->error("今天已经投过了哦,明天再来吧");
        }
        if (empty ($opts_ids)) {
            $this->error("请先选择投票项");
        }
        // 如果没投过，就添加
//		$data ["user_id"] = $this->mid;
        $data['headimgurl']=$_SESSION['userinfo']['headimgurl'];
        $data['nickname']=$_SESSION['userinfo']['nickname'];
        $data['openid'] = $openid;
        $data ["vote_id"] = $vote_id;
        $data ["token"] = $token;
        $data ["options"] = $opt_id;
        $data ["cTime"] = time();
        $data['date'] = date('Y-m-d', time());
        $addid = M("vote_log")->add($data);
        // 投票选项信息的num+1
//		foreach ( $opts_ids as $v ) {
//			$v = intval ( $v );
        $res = M("vote_option")->where('id=' . $opt_id)->setInc("opt_count");
//		}

        // 投票信息的vote_count+1
        $res = M("vote")->where('id=' . $vote_id)->setInc("vote_count");

        // 增加积分
        add_credit('vote');

        // 连续投票
        $next_id = M("vote")->where('id=' . $vote_id)->getField("next_id");
        if (!empty ($next_id)) {
            $vote_id = $next_id;
        }
        $this->success('投票成功', U('show', 'id=' . $vote_id));
//		redirect ( U ( 'show', 'id=' . $vote_id ) );
    }

    private function _is_overtime($vote_id)
    {
        // 先看看投票期限过期与否
        $the_vote = M("vote")->where("id=$vote_id")->find();
        $deadline = $the_vote ['end_date'] + 86400;
        if ($deadline <= time()) {
            return true;
        }
        return false;
    }

    private function _is_join($vote_id, $openid, $token, $opt_id)
    {
        // $vote_limit = M ( 'vote' )->where ( 'id=' . $vote_id )->getField ( 'vote_limit' );
        $localtime=date('Y-m-d',time());
        $config = get_addon_config('Vote');
        $vote_limit = $config['daycount'];
        $list = M("vote_log")->where("vote_id=$vote_id  AND openid='$openid' AND token='$token' AND date='$localtime'")->select();
        $map['id'] = $opt_id;
        $isself = M('vote_option')->where($map)->find();//当前投票信息
        if ($isself['openid1'] == $openid || $isself['openid2'] == $openid)//查看当前openid是否为参赛者,参赛者不允许帮自己投票
        {
            return 1;
        }
        $count = count($list);
        $info = array_pop($list);
        if ($info) {
            $joinData = explode(',', $info ['options']);
            $this->assign('joinData', $joinData);
        }
        if ($count >= $vote_limit) {
            return 2;
        }
        return false;
    }

    public function create()//一键生成二维码
    {
        $diaoyong=new UserInfoAddon();
        $RankList=D('Addons://Vote/Vote')->getList(120);//所有参赛者信息
        foreach($RankList as $key=>$val) {
            $id=$val['id'];
            $data['qrcode'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode($id);
            $OptMo=M('vote_option');
            $OptMo->where("id='$id'")->save($data);
        }
    }

    public function getnum()//恢复票数
    {
        $Dao=M();
        $query=$Dao->query("select count(*) as con,options   from wp_vote_log a GROUP BY options");
        $mo=M('vote_option');
        $list=$mo->select();
        foreach($list as $val)
        {
            foreach($query as $val1)
            {
                if($val['id']=$val1['options'])
                {
                    $id=$val['id'];
                    $val['opt_count']=$val1['con'];
                    $data['opt_count']=$val1['con'];
                    $mo->where("id='$id'")->save($data);
                }
            }

        }
        var_dump($query);
        exit;
    }

    public function testtask()
    {
        $vote_option=M('vote_option');
        $map['id']=113;
        $info=$vote_option->where($map)->find();
        $data['opt_count']=$info['opt_count']+1;
        $vote_option->where($map)->save($data);
    }
    function impUser(){//导入excel
        vendor("PHPExcel");
        $file_name='Uploads/Download/code.xls';
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
        for($i=1;$i<=$highestRow;$i++) {
            $data['num'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
            $data['isuse']=0;
            $data['token']='gh_4fc719089612';
            $data['addtime']=time();
            $data['product_id']=33;
            M('coupons')->add($data);
        }
    }

    public function upda()
    {
        $list=M('baozouuser')->select();
        $orderlist=M('shop_orders')->where("product_id=42 and isuse=0")->select();
        foreach($list as $val)
        {
             foreach($orderlist as $vals)
             {
                 $code=$val['oauth'];
                 $id=$val['id'];
                 $orderid=$vals['id'];//订单id
                 $data['code']=$code;
                 $query=M('shop_orders')->where("id='$orderid'")->save($data);
                 if($query)
                 {
                     $datas['isuse']=1;
                     M('baozouuser')->where("id='$id'")->save($datas);
                 }
             }
        }
    }

    public function createqrcode()
    {
        $diaoyong = new UserInfoAddon();
       var_dump("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $diaoyong->createqrcode(1));

    }

}
