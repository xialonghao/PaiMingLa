<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use \think\Cache;
/**
 * 订单管理
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    
    /**
     * Order模型对象
     * @var \app\admin\model\Order
     */
    protected $model = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Order;

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
        // $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {   
            $id = $this->request->param('ids');
            // dump($project_id);die;
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            if($id == ''){
                $mywhere = '';
            }else{
                $mywhere['projcet.id'] = $id;
            }

            $total = $this->model
                ->with(['user','keyword','projcet','channel'])
                ->where($where)
                ->where($mywhere)
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->with(['user','keyword','projcet','channel'])
                // ->fetchsql()
                ->where($where)
                ->where($mywhere)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            
            // dump($list);die;

            foreach ($list as $row) {
                $row->visible(['id','taday_ranking', 'star_ranking', 'amount','order_sn']);
                $row->visible(['user']);
				$row->getRelation('user')->visible(['username']);
				$row->visible(['keyword']);
				$row->getRelation('keyword')->visible(['name']);
				$row->visible(['projcet']);
				$row->getRelation('projcet')->visible(['num']);
				$row->visible(['channel']);
				$row->getRelation('channel')->visible(['name']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }    
        return $this->view->fetch();
    }
}
