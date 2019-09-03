<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use \think\Session;
use \think\Request;
use fast\Random;
/**
 * 充值管理
 *
 * @icon fa fa-circle-o
 */
class Redeem extends Backend
{

    /**
     * Worder模型对象
     * @var \app\admin\model\Worder
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\User;

        $this->view->assign("statusList", $this->model->getStatusList());
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 查看
     */
    public function index()
    {

        return $this->view->fetch();
    }
    public function redeem_list(){
        $red_list = $this->model->select();

        return json(
            array(
                'code'=>'200',
                'msg'=>'筛选获取列表成功',
                'data'=>$red_list,
            )
        );
    }
    public function affirms(){
        $res = input('post.');
        $into = \think\Db::table('pml_user')->where('id="'.$res['ids'].'"')->find();
//        print_r($into);die;
		if(!is_numeric($res['money']) || $res['money'] < 0){
			$this->error('请填写正确的金额');
		}
        $data = array(
            'user_id'=>$into['id'],
            'username'=>$into['username'],
            'money'=>$res['money'],
            'status'=>1,
            'account_money'=>$into['money']+$res['money'],
            'recharge_num'=>'RE'.date('YmdHis', time())."_".Random::alnum().'Vbj',
            'remarks'=>'在线充值',
            'type'=>'0',
//          'create_time'=>$post_data['timestamp'],
        );
        $date = array(
            'id'=>$res['ids'],
            'money'=>$res['money']+$into['money'],
//          'create_time'=>$post_data['timestamp'],
        );
        $res = \think\Db::table("pml_recharge")->insert($data);
        $res1 = \think\Db::table("pml_user")->update($date);
		//dump($res1);die;
        if($res1){
            $this->Success('充值成功');
        }else{
            $this->error('充值失败');
        }
    }
    public function sousuo(){
        $worder_sn=input('post.mobile');
//        print_r($worder_sn);die;
        $res = $this->model-> where('mobile', 'like', "%$worder_sn%")->select();
        if($res){
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'200',
                    'data'=>$res,
                )
            );
        }
    }

}
