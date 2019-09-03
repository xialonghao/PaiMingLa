<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 发票管理
 *
 * @icon fa fa-circle-o
 */
class Invoice extends Backend
{
    
    /**
     * Invoice模型对象
     * @var \app\admin\model\Invoice
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Invoice;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("companyList", $this->model->getCompanyList());
        $this->view->assign("invoiceTypeList", $this->model->getInvoiceTypeList());
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
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['Useraddress'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['Useraddress'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['id','amount','type','status','create_time','head','Useraddress','username','invoice_type']);
				$row->visible(['useraddress']);
                // $row->getRelation('Useraddress');
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 修改状态
     */
    public function changestatus()
    {
        $data = $this->request->route();
        if(empty($data['ids'])) $this->error(__("Error Data"));
        //订单信息
        $order = $this->model->where(['id'=>$data['ids']])->find();
        
        //用户账户余额
        //$user = \think\Db::table("pml_user")->where('id',$order['user_id'])->find();
        
        if($order['status'] === $data['status']) $this->error(__("Error Operation"));
        $res = $this->model->where(['id'=>$data['ids']])->update(['status'=>$data['status']]);
/*         //扣除个人账户余额
        if($data['status'] == 2){
            $user = \think\Db::table("pml_user")->where('id',$order['user_id'])->setDec('money',$order['money']);
        } */
        $res ? $this->success(__("Operation completed")) : $this->error(__("Operation failed"));
    }
}
