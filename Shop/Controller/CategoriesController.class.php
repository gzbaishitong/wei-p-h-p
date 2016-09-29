<?php

namespace Addons\Shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 商铺订单控制器控制器
 * 
 */
class CategoriesController extends BaseController{
    public $model;
    //初始化
    function _initialize() {
        $this->model = $this->getModel ( 'shop_categories' );
        parent::_initialize ();
    }
    /*
     * 后台功能部分
     */
    //列表
    public function lists() {
        $categoriesDB = D ( 'Addons://Shop/Categories' );
        // 解析列表规则
        $list_data = $this->_list_grid ( $this->model );
        $fields = $list_data ['fields'];
        // 搜索条件
        $map = $this->_search_map ( $this->model, $fields );
        $list_data ['list_data'] = $categoriesDB->cgetList( $map );
        $this->assign ( $list_data );
        $this->display ();
    }
    //新增
    public function add() {
        $categoriesDB = D ( 'Addons://Shop/Categories' );
        $model = $this->model;
        is_array ( $model ) || $model = $this->getModel ( $model );
        if(IS_POST){
                // 获取模型的字段信息
                $categoriesDB = $this->checkAttr ( $categoriesDB, $model ['id'] );
                $result = $categoriesDB->create ();
                if ($categoriesDB->add ()) {
                    $this->success ( '添加' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'], $this->get_param ) );
                } else {
                    $this->error ( $categoriesDB->getError () );
                }
            } else {
              
                
                $tempextra="0:无\r\n";
                $map['token'] = $this->use_token;
                $map['pid'] = 0;
                $list = $categoriesDB->getList($map);
                foreach ($list as $v){
                        $tempextra .= $v ['id'] . ':' . $v ['name'] . "\r\n";
                }
                $fields = get_model_attribute ( $this->model ['id'] );
                if (!empty( $tempextra )) {
                     foreach($fields[1] as &$vo){
                            if($vo['name']!='pid') continue;
                            $vo['extra'] .= "\r\n" . $tempextra;
                    }
                }

                $this->assign ( 'fields', $fields );
                $this->meta_title = '新增' . $model ['title'];
                $templateFile || $templateFile = $model ['template_add'] ? $model ['template_add'] : '';
                $this->display ( $templateFile );
                    
            }
    }
    //删除
    public function del() {
        parent::del($this->model);
    }
    //改查
    public function edit(){
        
        $categoriesDB = D ( 'Addons://Shop/Categories' );
        $id = I ( 'id' );

        if (IS_POST) {
            // 获取模型的字段信息
            $categoriesDB = $this->checkAttr ( $categoriesDB, $this->model ['id'] );
            if ($categoriesDB->create () && $categoriesDB->save ()) {
                $this->success ( '保存' . $this->model ['title'] . '成功！', U ( 'lists?model=' . $this->model ['name'] ) );
            } else {
                $this->error ( $Model->getError () );
            }
        } else {
            
            // 获取一级菜单
            $tempextra="0:无\r\n";
            $map['token'] = $this->use_token;
            $map['pid'] = 0;
            $list = $categoriesDB->getList($map);
            foreach ($list as $v){
                $tempextra .= $v ['id'] . ':' . $v ['name'] . "\r\n";
            }
            $fields = get_model_attribute ( $this->model ['id'] );
            if (!empty( $tempextra )) {
                 foreach($fields[1] as &$vo){
                        if($vo['name']!='pid') continue;
                        $vo['extra'] .= "\r\n" . $tempextra;
                }
            }
            // 获取数据
            $map2['id'] = $id;
            $data = $categoriesDB->getInfo($map2);
            $data || $this->error ( '数据不存在！' );

            $token = get_token ();
            if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
                    $this->error ( '非法访问！' );
            }

            $this->assign ( 'fields', $fields );
            $this->assign ( 'data', $data );
            $this->meta_title = '编辑' . $this->model ['title'];

            $this->display ();
        }
    }
    
    /*
     * 前台功能部分
     */
}
