<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Validate;

/**
 * 项目接口
 */
class Order extends Api
{

    protected $noNeedLogin = ['get_channel','is_contraband'];
    protected $noNeedRight = '*';
    protected $model = null;
    public function _initialize()
    {
        $this->project = new \app\admin\model\Projcet;
        $this->model = new \app\admin\model\Order;
        parent::_initialize();
    }

    
    /**
     * 新增订单
     */
    public function add_channel_order($data,$days){
        $ret = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('a.user_id="' . $data['user_id'] . '" and b.project_id="' . $data['project_id'] . '"')
            ->field('a.days,b.keyword_name,b.channel_name,b.price,b.amount,b.heat,b.conformity')
            ->select();
//        $jiage = 0;
//        foreach ($ret as $key=>$val){
//            $jiage +=$val['amount'];
//        }
        $orderdata = [
            'project_id' => $data['project_id'],
            'project_num' => $data['project_num'],
            'keyword_id' => $data['keyword_id'],
            'keyword_name'=>$data['name'],
            'user_id' => $data['user_id'],
//            'amount' =>$jiage,
        ];
        $channel = $data['channel'];
        $result= [];$i=0;
        foreach ($data['channel'] as $val){
            if(empty($val))continue;
            $orderdata['channel_id'] = $val;
            if($this->model->where($orderdata)->count())continue;
            $orderdata['channel_name'] = read_table_filed("pml_channel", "name", ['id'=>$val]);

            //价格、热度、和适度需要请求第三方接口python提供
//            $orderdata['amount'] = 123;
            $orderdata['order_sn'] = 'ZH'.date('Ymd', time()).rand(1,1000).rand(1,1000).$data['project_id'];
            $res = \think\Db::name('order')->where(['project_id'=>$data['project_id'], 'keyword_name'=>$data['name'], 'channel_name'=>$orderdata['channel_name']])->find();
            if(!$res){
                $id = $this->model->insertGetId($orderdata);
                if(!$id) {
                    $this->model->rollback();
                }
                $result[$i] = $orderdata;
                $result[$i]['id'] = $id;
                //价格、热度、和适度需要请求第三方接口python提供
                $result[$i]['hot'] = "40";
                $result[$i]['fit'] = "60";
            }
            $i++;
        }
        // dump($orderdata);
        return $result;
    }

}
