<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use fast\Random;
/**
 * 充值记录
 *
 * @icon fa fa-circle-o
 */
class Recharge extends Backend
{
    
    /**
     * Recharge模型对象
     * @var \app\admin\model\Recharge
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Recharge;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("typeList", $this->model->getTypeList());
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
            $status = $this->request->request('status');
            if($status == ''){
                $mywhere = '';
            }else{
                $mywhere['recharge.status'] = strval($status);
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
                    ->where($mywhere)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                $row->visible(['id','money','status','recharge_num','images','type','admin_id','create_time']);
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
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
                    $admin = $this->get_admin();
                    $params['admin_id'] = $admin['id'];
                    $params['username'] = read_table_filed('pml_user','username',array('id'=>$params['user_id']));
                    $params['status'] = 1;
                    $params['type'] = 0;
                    $params['account_money'] = read_table_filed('pml_user','money',array('id'=>$params['user_id'])) + $params['money'];
                    $params['recharge_num'] = 'RE' . time() . $params['user_id'] . Random::alnum(4);
                    $result = $this->model->allowField(true)->save($params);
                    if ($result == false) {
                        $this->model->rollback();
                    } else {
                        //修改账户余额
                        $params['account_money'];
                        $res = \think\Db::table('pml_user')->where(array('id'=>$params['user_id']))->setInc('money',$params['money']);
                        if(!$res){
                            \think\Db::table('pml_user')->rollback();
                        }
                        $this->success();
                    }
                } catch (\think\exception\PDOException $e) {
                    $this->error($e->getMessage());
                } catch (\think\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }
}
