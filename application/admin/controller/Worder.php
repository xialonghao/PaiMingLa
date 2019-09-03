<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use \think\Session;
use \think\Request;
/**
 * 工单管理
 *
 * @icon fa fa-circle-o
 */
class Worder extends Backend
{
    
    /**
     * Worder模型对象
     * @var \app\admin\model\Worder
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Worder;
        $this->project = new \app\admin\model\Project;
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
    public function worderrecord()
    {
        $id=input('get.ids');
        $admin_id=input('get.admin_id');
        $this->worder_particulars($id,$admin_id);
        $admin_username =  \think\Db::table('pml_admin')->where('id="'.$admin_id.'"')->field('nickname,avatar')->find();
        $update_admin = $this->model->where('id="'.$id.'"')->update(['admin_name'=>$admin_username['nickname'],'status'=>'1']);
        $worder_list =$this->model->where('id="'.$id.'"')->field('id,worder_sn,title,contect,create_time,status,images')->find();
        //管理员id
        $this->assign('adids',$admin_id);
        //标题
        $this->assign('list_title',$worder_list);

        $dialogue = \think\Db::table('pml_worder_comment')
            ->where('worder_id="'.$id.'"')
            ->select();
        //对话列表
        $this->assign('avatar',$admin_username['avatar']);
        $this->assign('userimage',$worder_list['images']);
        $this->assign('chatlist',$dialogue);
        return $this->view->fetch();
    }
  public function worder_particulars($id,$admin_id){
//        print_r($id);
//        echo "<pre>";
//        print_r($admin_id);die;
        $admin_username =  \think\Db::table('pml_admin')->where('id="'.$admin_id.'"')->field('nickname')->find();
        $update_admin = $this->model->where('id="'.$id.'"')->update(['admin_name'=>$admin_username['nickname'],'status'=>'1']);
        $worder_list =$this->model->where('id="'.$id.'"')->field('id,worder_sn,title,contect,create_time,status')->find();
         //print_r(json_decode(json_encode($worder_list,true),true));
       return json_encode(array('code'=>101, 'data'=>$worder_list),true);
    }

    public function worder_list(){
        $status=input('post.status');
        $creae_time = input('post.data');
         $admun_user = Session::get('admin');
        if(!empty($creae_time)){
            $hello = explode('-',$creae_time);

            $admin_list = $this->model->where('create_time>"'.$hello[0].'" and create_time<"'.$hello[1].'"')->field('id,worder_sn,title,contect,create_time,status,admin_name')->select();
//            print_r($admin_list);die;
            foreach ($admin_list as $key=>&$val){
                $val['admin_id']=$admun_user['id'];
            }
//         print_r(json_decode(json_encode($admin_list,true),true));
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'筛选获取列表成功',
                    'data'=>$admin_list,
                )
            );
        }
         if(isset($status)){
            $admin_list = $this->model->where('status="'.$status.'"')->field('id,worder_sn,title,contect,create_time,status,admin_name')->select();
             foreach ($admin_list as $key=>&$val){
                 $val['admin_id']=$admun_user['id'];
             }
//         print_r(json_decode(json_encode($admin_list,true),true));
             return json(
                 array(
                     'code'=>'200',
                     'msg'=>'筛选获取列表成功',
                     'data'=>$admin_list,
                 )
             );
         }
         $admin_list = $this->model->field('id,worder_sn,title,contect,create_time,status,admin_name')->select();
         foreach ($admin_list as $key=>&$val){
             $val['admin_id']=$admun_user['id'];
         }
//         print_r(json_decode(json_encode($admin_list,true),true));
         return json(
             array(
                 'code'=>'200',
                 'msg'=>'获取列表成功',
                 'data'=>$admin_list,
             )
         );
    }
    public function dafu(){
        $content=input('post.content');
        $adsid=input('post.adsid');
        $userid=input('post.userid');
        $admin_username =  \think\Db::table('pml_admin')->where('id="'.$adsid.'"')->field('nickname,avatar')->find();
        $gain = \think\Db::table('pml_worder')->where('id="'.$userid.'"')->find();
        $array = array(
          'worder_id' => $gain['id'],
          'worder_sn' => $gain['worder_sn'],
          'username' => $gain['username'],
          'admin_name' => $admin_username['nickname'],
          'admin_id' => $adsid,
          'contect' => $content,
          'user_id' =>$gain['user_id'],
          'adminstatus'=>1,
          'adminimage' =>$admin_username['avatar'],
//          'create_time' => date('Y-m-d i:m:s',time()),
        );
        $res = \think\Db::table('pml_worder_comment')->insert($array);
        if($res){
            return json(
                array(
                    'code'=>'200',
                    'msg'=>'提交成功',
                    'data'=>1,
                )
            );
        }else{
            return json(
                array(
                    'code'=>'500',
                    'msg'=>'提交失败',
                    'data'=>0,
                )
            );
        }


    }
    public function sousuo(){
        $worder_sn=input('post.keyword');
        $res = \think\Db::table('pml_worder')-> where('worder_sn', 'like', "%$worder_sn%")->select();
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
