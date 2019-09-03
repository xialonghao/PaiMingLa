<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 项目管理
 *
 * @icon fa fa-circle-o
 */
class Project extends Backend
{
    
    /**
     * Project模型对象
     * @var \app\admin\model\Project
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Project;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("payStatusList", $this->model->getPayStatusList());
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
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {   
            // return 3333;
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $status = $this->request->request('status');
            if($status == ''){
                $mywhere = '';
            }else{
                $mywhere['project.status'] = strval($status);
            }
            $total = $this->model
                ->with(['admin','user'])
                ->where($where)
                ->where($mywhere)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['admin','user'])
                ->where($where)
                // ->fetchsql()
                ->where($mywhere)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            // dump($list);die;
            foreach ($list as $row) {
                $row->visible(['id','num','name','create_time','address','status','days','amount','pay_status']);
                $row->visible(['admin']);
				$row->getRelation('admin')->visible(['username']);
				$row->visible(['user']);
				$row->getRelation('user')->visible(['username']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 获取用户数据
     */
    public function get_user()
    {
        $res = Db::name('user')->field('id,username,mobile,createtime')->select();
        if(!$res){
            return json(array(
                'error_code'=>0,
                'msg'=>'暂无数据',
            ));
        }
        return json(array(
                'error_code'=>1,
                'msg'=>'成功',
                'data'=>$res,
        ));
    }

    /**
     * 获取某个用户的所有项目
     */
    public function get_project()
    {
        $uid = $this->request->request('user_id');
        if(empty($uid)){
            return json(array(
                'error_code'=>0,
                'msg'=>'参数为空',
            ));
        }
        $res = Db::name('projcet')
                    ->field('id,name,num,pay_status,create_time,address')
                    ->where('user_id',$uid)
                    ->select();
        if(!$res){
            return json(array(
                'error_code'=>0,
                'msg'=>'暂无数据',
            ));
        }
        return json(array(
                'error_code'=>1,
                'msg'=>'成功',
                'data'=>$res,
        ));
    }

    /**
     * 获取某个项目下的关键词
     */
    public function get_keyword()
    {
        $project_id = $this->request->request('project_id');
        if(empty($project_id)){
            return json(array(
                'error_code'=>0,
                'msg'=>'参数为空',
            ));
        }
        $res = Db::name('order')
                    ->field('project_id,keyword_id,keyword_name,channel_name,star_ranking,taday_ranking,complete_days,complete_status,money')
                    ->where('project_id',$project_id)
                    ->select();
        if(!$res){
            return json(array(
                'error_code'=>0,
                'msg'=>'暂无数据',
            ));
        }
        return json(array(
                'error_code'=>1,
                'msg'=>'成功',
                'data'=>$res,
        ));
    }

    /**
     * 修改项目关键词排名接口
     */
    public function edit_order()
    {
        $id = $this->request->request('id');
        $taday_ranking = $this->request->request('taday_ranking');
        if(empty($id)){
            return json(array(
                'error_code'=>0,
                'msg'=>'参数为空',
            ));
        }
        if(empty($taday_ranking)){
            return json(array(
                'error_code'=>0,
                'msg'=>'参数为空',
            ));
        }
        $res = Db::name('order')
                ->where('id',$id)
                ->update(['taday_ranking' => $taday_ranking]);
        if(!$res){
            return json(array(
                'error_code'=>0,
                'msg'=>'暂无数据',
            ));
        }
        return json(array(
                'error_code'=>1,
                'msg'=>'成功',
                'data'=>$res,
        ));
    }

    /**
     * 根据日期筛选关键词订单
     */
    public function search_order()
    {
        $create_time = $this->request->request('create_time');
        if(empty($create_time)){
            $create_time = date('Y-m-d');
        }
        $res = Db::name('order')
                    ->alias('o')
                    ->field('o.id oid,p.name pname, keyword_name,taday_ranking,star_ranking,channel_name')
                    ->join('projcet p','o.project_id = p.id')
                    ->where("'".$create_time." 00:00:00"."'".'< o.create_time and o.create_time < '."'".$create_time." 23:59:59"."'")
                    ->select();
        if(!$res){
            return json(array(
                'error_code'=>0,
                'msg'=>'暂无数据',
            ));
        }
        return json(array(
                'error_code'=>1,
                'msg'=>'成功',
                'data'=>$res,
        ));
    }
    
}
