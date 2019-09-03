<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Request;

/**
 * 消费记录
 *
 * @icon fa fa-circle-o
 */
class Consumption extends Backend
{
    
    /**
     * Consumption模型对象
     * @var \app\admin\model\Consumption
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Consumption;
        $this->view->assign("isQualifiedList", $this->model->getIsQualifiedList());
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
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            $where1 = [];
            if($this->request->request('projcet_id')){
                $where1=['consumption.projcet_id'=>$this->request->request('projcet_id')];
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams('projcet_id');
            $total = $this->model
                    ->with(['channel','keyword','projcet','user'])
                    ->where($where)
                    ->where($where1)
                    ->order($sort, $order)
                    ->count();
            $list = $this->model
                    ->with(['channel','keyword','projcet','user'])
                    ->where($where)
                    ->where($where1)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            foreach ($list as $row) {
                $row->visible(['id','order_sn','create_time','ranking','money','status']);
                $row->visible(['channel']);
				$row->getRelation('channel')->visible(['name']);
				$row->visible(['keyword']);
				$row->getRelation('keyword')->visible(['name']);
				$row->visible(['projcet']);
				$row->getRelation('projcet')->visible(['name']);
				$row->visible(['user']);
				$row->getRelation('user')->visible(['username']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        !empty($_GET['keyword_id']) ? $this->assign('keyword_id',$_GET['keyword_id']) : $this->assign('keyword_id','');
        return $this->view->fetch();
    }
    
}
