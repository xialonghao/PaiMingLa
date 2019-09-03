<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Validate;
use think\Controller;
use think\Collection;
use app\api\controller\Order;
use app\admin\controller\Contraband;
use fast\Http;
/**
 * 项目接口noneedlogin
 */
class Pandect extends Api
{

    protected $noNeedLogin = ['key_number','key_percentage'];
    protected $noNeedRight = '*';
    protected $project = null;
//
    public function _initialize(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: toresetpwdken, Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
        $this->project = new \app\admin\model\Projcet;
        $this->Consumption = new \app\admin\model\Consumption;
        parent::_initialize();
    }
    /**
     * 账户总余额
     */
    public function aggregate_money(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $user_money = \think\Db::table('pml_user')->where('id="'.$user['user_id'].'"')->field('money')->find();
        $project_money =  $this->project->where('user_id="'.$user['user_id'].'" and status="1"')->select();
        $sum_money = $user_money['money'];
        foreach($project_money as $key=>$val){
            $sum_money += $val['amount'];
        }
        $this->success(__('Successful'), ['sum_money'=>$sum_money]);
    }
    /**
     * 账户冻结金额
     */
    public function freeze_money(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $project_money =  $this->project->where('user_id="'.$user['user_id'].'" and status="1"')->select();
        $freeze_money = '0';
        foreach($project_money as $key=>$val){
            $freeze_money += $val['amount'];
        }
        $this->success(__('Successful'), ['freeze_money'=>$freeze_money]);
    }
    /**
     * 可用余额
     */
    public function usable_money(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $user_money = \think\Db::table('pml_user')->where('id="'.$user['user_id'].'"')->find();
        $this->success(__('Successful'), ['usable_money'=>$user_money['money']]);
    }
    /**
     * 消费金额
     */
    public function consume_money(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $consumemoney = $this->Consumption->where('user_id="'.$user['user_id'].'"')->sum('money');
        // $consumemoney = 0;
        // foreach($consumptiion_money as $key=>$val){
        //     $consumemoney +=$val['money'];
        // }
//        print_r(json_decode(json_encode($consumptiion_money,true),true));
        $this->success(__('Successful'), ['consume_money'=>$consumemoney]);
    }
    /**
     * 关键词展示个数
     */
    public function key_number(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        $key_sum = \think\Db::table('pml_order')->where('user_id="'.$user['user_id'].'"')->count();

        $stop = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('a.status="2" and b.user_id="'.$user['user_id'].'"')
            ->count();

        $optimize = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('a.status="1" and b.user_id="'.$user['user_id'].'"')
            ->count();
//                print_r(json_decode(json_encode($optimize,true),true));
        $data = array(
            'key_sum'=>$key_sum,
            'stop'=>$stop,
            '$optimize'=>$optimize,
        );
        $this->success(__('Successful'),$data);
    }
    /**
     * 关键词百分比
     */
        public function key_percentage(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        //所有关键词百分比完成率
        $percentage_sum = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'"')
            ->field('a.days,b.reach_count')
            ->select();
            $days = '0';
            $reacg_sum = '0';
            foreach($percentage_sum as $key=>$val){
                $days += $val['days'];
                $reacg_sum +=$val['reach_count'];
            }
            if($days=='0' ||$reacg_sum=='0'){
                $reacg_result=array('val'=>0,'key'=>'');

            }else{
                $reacg_result=array('val'=>$reacg_sum/$days,'key'=>'');
            }
            /**
             * 1=百度pc
             * 2=搜狗
             * 3=百度移动
             * 4=搜狗移动
             * 5=360
             * 6=神马
             */
        $baidu_percentage = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'" and channel_id=1')
            ->field('a.days,b.reach_count,b.channel_name')
            ->select();
            if(empty($baidu_percentage)){
                $this->success('没有渠道',0);
            }
            $baidu_days = '0';
            $baidu_reacg = '0';
            foreach($baidu_percentage as $key=>$val){
                $baidu_days += $val['days'];
                $baidu_reacg +=$val['reach_count'];
            }
            if($baidu_days=='0'){
                $baidu_reacgresult=array('val'=>0,'key'=>$baidu_percentage[0]['channel_name']);
            }else{

                $baidu_reacgresult=array('val'=>$baidu_reacg/$baidu_days,'key'=>$baidu_percentage[0]['channel_name']);
            }

        /**
         * 搜狗百分比
         */
        $sougou_percentage = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'" and channel_id=2')
            ->field('a.days,b.reach_count,b.channel_name')
            ->select();
            $sougou_days = '0';
            $sougou_reacg = '0';
            foreach($sougou_percentage as $key=>$val){
                $sougou_days += $val['days'];
                $sougou_reacg +=$val['reach_count'];
            }
            if($sougou_days=='0'){
                $sougou_reacgresult=array('val'=>0,'key'=>$sougou_percentage[0]['channel_name']);
            }else{

                $sougou_reacgresult=array('val'=>$sougou_reacg/$sougou_days,'key'=>$sougou_percentage[0]['channel_name']);
            }

        /**
         * 百度移动百分比
         */
        $baiduyidong_percentage = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'" and channel_id=3')
            ->field('a.days,b.reach_count,b.channel_name')
            ->select();
            $baiduyidong_days = '0';
            $baiduyidong_reacg = '0';
            foreach($baiduyidong_percentage as $key=>$val){
                $baiduyidong_days += $val['days'];
                $baiduyidong_reacg +=$val['reach_count'];

            }
            if($baiduyidong_days=='0'){
                $baiduyidong_reacgresult=array('val'=>0,'key'=>$baiduyidong_percentage[0]['channel_name']);
            }else{

                $baiduyidong_reacgresult=array('val'=>$baiduyidong_reacg/$baiduyidong_days,'key'=>$baiduyidong_percentage[0]['channel_name']);
            }

        /**
         * 搜狗移动百分比
         */
        $sougouyidong_percentage = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'" and channel_id=4')
            ->field('a.days,b.reach_count,b.channel_name')
            ->select();
            $sougouyidong_days = '0';
            $sougouyidong_reacg = '0';
            foreach($sougouyidong_percentage as $key=>$val){
                $sougouyidong_days += $val['days'];
                $sougouyidong_reacg +=$val['reach_count'];
            }
            if($sougouyidong_days=='0'){
                $sougouyidong_reacgresult=array('val'=>0,'key'=>$sougouyidong_percentage[0]['channel_name']);
            }else{

                $sougouyidong_reacgresult=array('val'=>$sougouyidong_reacg/$sougouyidong_days,'key'=>$sougouyidong_percentage[0]['channel_name']);
            }

        /**
         * 360百分比
         */
        $sanliuling_percentage = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'" and channel_id=5')
            ->field('a.days,b.reach_count,b.channel_name')
            ->select();
            $sanliuling_days = '0';
            $sanliuling_reacg = '0';
            foreach($sanliuling_percentage as $key=>$val){
                $sanliuling_days += $val['days'];
                $sanliuling_reacg +=$val['reach_count'];
            }
            if($sanliuling_days=='0'){
                $sanliuling_reacgresult=array('val'=>0,'key'=>$sanliuling_percentage[0]['channel_name']);
            }else{

                $sanliuling_reacgresult=array('val'=>$sanliuling_reacg/$sanliuling_days,'key'=>$sanliuling_percentage[0]['channel_name']);
            }

        /**
         * 神马百分比
         */
        $shenma_percentage = $this->project->alias('a')
            ->join('pml_order b', 'a.id=b.project_id')
            ->where('b.user_id="'.$user['user_id'].'" and channel_id=6')
            ->field('a.days,b.reach_count,b.channel_name')
            ->select();
            $shenma_days = '0';
            $shenma_reacg = '0';
            foreach($shenma_percentage as $key=>$val){
                $shenma_days += $val['days'];
                $shenma_reacg +=$val['reach_count'];
            }
            if($shenma_days=='0'){
                $shenma_reacgresult = array('val'=>0,'key'=>$shenma_percentage[0]['channel_name']);
            }else{

                $shenma_reacgresult = array('val'=>$shenma_reacg/$shenma_days,'key'=>$shenma_percentage[0]['channel_name']);
            }
            /**
             * 360移动
             */
            $sanios_percentage = $this->project->alias('a')
                ->join('pml_order b', 'a.id=b.project_id')
                ->where('b.user_id="'.$user['user_id'].'" and channel_id=7')
                ->field('a.days,b.reach_count,b.channel_name')
                ->select();
            $sanios_days = '0';
            $sanios_reacg = '0';
            foreach($sanios_percentage as $key=>$val){
                $sanios_days += $val['days'];
                $sanios_reacg +=$val['reach_count'];
            }
            if($sanios_days=='0'){
                $sanios_reacgresult = array('val'=>0,'key'=>$sanios_percentage[0]['channel_name']);
            }else{

                $sanios_reacgresult = array('val'=>$sanios_reacg/$sanios_days,'key'=>$sanios_percentage[0]['channel_name']);
            }
//        if(empty($percentage_sum)){$baidu_reacgresult = '0';}else if(empty($sougou_percentage)){$sougou_reacgresult= '0';}else if(empty($baiduyidong_percentage)){$baiduyidong_reacgresult= '0';}else if(empty($sougouyidong_percentage)){$sougouyidong_reacgresult= '0';}else if(empty($sanliuling_percentage)){$sanliuling_reacgresult= '0';}else if(empty($shenma_percentage)){$shenma_reacgresult= '0';}
//        print_r($shenma_days);
//            print_r(json_decode(json_encode($shenma_percentage,true),true));die;

        $this->success(__('Successful'),array('reacg_result'=>$reacg_result,'baidu_reacgresult'=>$baidu_reacgresult,'sougou_reacgresult'=>$sougou_reacgresult,'baiduyidong_reacgresult'=>$baiduyidong_reacgresult,'sougouyidong_reacgresult'=>$sougouyidong_reacgresult,'sanliuling_reacgresult'=>$sanliuling_reacgresult,'shenma_reacgresult'=>$shenma_reacgresult,'$sanios_reacgresult'=>$sanios_reacgresult));

    }
    /**
     *
     */
    public function reach_graph(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        //关键词总数
        $key_sumcount =\think\Db::table('pml_order')->where('user_id="'.$user['user_id'].'"')->count();
        // dump($key_sumcount);die;
        //本月
        $staDate=date('Y-m-01', strtotime(date("Y-m-d")));
        $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
        $m = substr($endDate,5,2);

        for($i=1;$i<=substr($endDate,8);$i++){
//            print_r($i);
            $res = \think\Db::table('pml_consumption')
                ->where('user_id="'.$user['user_id'].'" and '."'".date('Y-'.$m.'-'.$i." 00:00:00", strtotime(date("Y-m-d")))."'".'< create_time and create_time < '."'".date('Y-'.$m.'-'.$i." 23:59:00", strtotime(date("Y-m-d")))."'")
                ->select();

            $num=count($res);
            if($key_sumcount=='0'||$num=='0'){
                $wher_count[$i]['biao']=  0;
            }else{
                $wher_count[$i]['biao']=  round(($num/$key_sumcount)*100, 2);
            }

        }
        // dump($wher_count);die;


        $this->success(__('Successful'),$wher_count);
    }
    public function reach_lastgraph(){
        $token = $this->request->request('token');
        $user = \app\common\library\Token::get($token);
        //关键词总数
        $key_sumcount =\think\Db::table('pml_order')->where('user_id="'.$user['user_id'].'"')->count();

        //上月
        $staDate=date('Y-m-01', strtotime("-1 month"));
        $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
//        print_r($staDate);
        $m = substr($endDate,5,2);
        for($i=1;$i<=substr($endDate,8);$i++){
//            print_r($i);
            $res = \think\Db::table('pml_consumption')
                ->where('user_id="'.$user['user_id'].'" and '."'".date('Y-'.$m.'-'.$i." 00:00:00", strtotime(date("Y-m-d")))."'".'< create_time and create_time < '."'".date('Y-'.$m.'-'.$i." 23:59:00", strtotime(date("Y-m-d")))."'")
                ->select();

            $num=count($res);
            if($key_sumcount=='0'||$num=='0'){
                $wher_count[$i]['biao']=  0;
            }else{
                $wher_count[$i]['biao']=  round(($num/$key_sumcount)*100, 2);
            }

        }
        $this->success(__('Successful'),$wher_count);
    }

}
