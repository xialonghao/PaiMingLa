<?php
namespace app\admin\controller;
use app\common\controller\Backend;
use \think\Cache;
/**
 * 总览
 *
 * @icon fa fa-circle-o
 */
class Pandect extends Backend
{
    /**
     * Worder模型对象
     * @var \app\admin\model\Worder
     */
    protected $model = null;
    public function _initialize()
    {
        $this->project = new \app\admin\model\Projcet;
        $this->model = new \app\admin\model\Worder;
        parent::_initialize();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index(){
        $execute_project =$this->project->where('status="1" and pay_status="1"')->count();
        //即将到期时间
        $newtime = date('Y-m-d',strtotime("-7 day")).' 23:59:59';
        $newstime = date('Y-m-d',time()).' 23:59:59';
        $expire_project = $this->project->select();

        $i='0';
        foreach($expire_project as $key=>$val){
            if(date('Y-m-d',strtotime($val['endtime'])-7 * 24 * 3600).' 23:59:00' <= date('Y-m-d',time()).' 00:00:00'){
                $i++;
            }
        }
        //待处理工单
        $pending_worder = $this->project->where('status=1')->count();
        $pending_invoice=\think\Db::table('pml_invoice')->where('status=1')->count();
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>array('execute_project'=>$execute_project,'expire_project'=>$i,'pending_worder'=>$pending_worder,'pending_invoice'=>$pending_invoice),
        ));
    }
    //渠道
    public function channel(){
        // Cache::clear();
        // $percentages = Cache::get('percentages');
        // dump($percentages);
        // if(empty($percentages)){
            $project=\think\Db::table('pml_order')->count();
            $project_baidu = \think\Db::table('pml_order')->where('channel_name="百度PC"')->count();
            $project_bdyd = \think\Db::table('pml_order')->where('channel_name="百度移动"')->count();
            $project_sougou = \think\Db::table('pml_order')->where('channel_name="搜狗PC"')->count();
            $project_sgyd = \think\Db::table('pml_order')->where('channel_name="搜狗移动"')->count();
            $project_snaliuling= \think\Db::table('pml_order')->where('channel_name="360PC"')->count();
            $project_snaliulingyd= \think\Db::table('pml_order')->where('channel_name="360移动"')->count();
            $project_shenma = \think\Db::table('pml_order')->where('channel_name="神马"')->count();
            $baidu = $project_baidu/$project;
            $baiduyidong = $project_bdyd/$project;
            $sougou = $project_sougou/$project;
            $sougouyidong = $project_sgyd/$project;
            $sanliuling = $project_snaliuling/$project;
            $sanliulingyd = $project_snaliulingyd/$project;
            $shenma =    $project_shenma/$project;
            $percentages  = array(
                'baidu'=>$baidu,
                'baiduyidong'=>$baiduyidong,
                'sougou'=>$sougou,
                'sougouyidong'=>$sougouyidong,
                'sanliuling'=>$sanliuling,
                'sanliulingyd'=>$sanliulingyd,
                'shenma'=>$shenma,

            );
            // echo 1111;
        //     $times = mktime(23,59,59) - mktime(date('H'),date('i'),date('s'));
        //     Cache::set('percentages',$percentages,$times);
        // }
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$percentages ,
        ));
    }
    public function reach_graph(){

        // $yue = Cache::get('yue');
        // if(empty($yue)){
            //本月
            $staDate=date('Y-m-01', strtotime(date("Y-m-d")));
            $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
            $m = substr($endDate,5,2);

            $d = substr($endDate,8);
            $year = date('Y');
            // echo $year;die;
            for($i=1;$i<=$d;$i++){
                $wher_count[$i] = \think\Db::table('pml_consumption')
                    ->where("'".$year.'-'.$m.'-'.$i." 00:00:00"."'".'< create_time and create_time < '."'".$year.'-'.$m.'-'.$i." 23:59:59"."'")
                    ->sum('money');
               $yue[$i]['biao'] = $wher_count[$i];
            }
        //     $times = mktime(23,59,59) - mktime(date('H'),date('i'),date('s'));
        //     Cache::set('yue',$yue,$times);
        // }
        
        // dump($yue);die;
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$yue ,
        ));
    }
    //筛选消费曲线
    public function sx_consumption(){
        //获取年月
        // echo date("t",strtotime("201906"));die;
        $staDates = $this->request->request('staDate');
        if(empty($staDates)){
            $staDates = date('Ym');
        }
        //截取年份
        $year = substr($staDates,0,4);
        //截取月份
        $month = substr($staDates,4,2);
        //计算月天数
        $day = date("t",strtotime($year.$month.'01'));
        for($i=1;$i<=$day;$i++){
            $wher_count[$i] = \think\Db::table('pml_consumption')
                ->where("'".$year.'-'.$month.'-'.$i." 00:00:00"."'".'< create_time and create_time < '."'".$year.'-'.$month.'-'.$i." 23:59:00"."'")
                ->sum('money');

            $whats[$i]['xiaofei']=  $wher_count[$i];
        }
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$whats ,
        ));
    }
    //消费
    public function month_consumption(){
        // $consumption = Cache::get('consumption');
        // if(empty($consumption)){
            //关键词总数
            // $key_sumcount =\think\Db::table('pml_consumption')->count();
            //本月
            $staDate=date('Y-m-01', strtotime(date("Y-m-d")));
            $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
            $yue = array('01','02','03','04','05','06','07','08','09','10','11','12');
            $year = date('Y');
            for($i=0;$i<=count($yue);$i++){
                $wher_count = \think\Db::table('pml_consumption')
                ->where("'".$year.'-'.$yue[$i].'-01'." 00:00:00"."'".'< create_time and create_time < '."'".$year.'-'.$yue[$i].'-31'." 23:59:59"."'")
                ->where('status', 1)
                ->sum('money');
                $consumption[$i]['biao'] = $wher_count;
                if($yue[$i]==12){ break;}
            }
        //     $times = mktime(23,59,59) - mktime(date('H'),date('i'),date('s'));
        //     Cache::set('consumption',$consumption,$times);
        // }
        
        // dump($chongzhi);die;
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$consumption,
        ));
    }

    //充值
    public function month_recharge(){
        // $recharge = Cache::get('recharge');
        // if(empty($recharge)){
            // $key_sumcount =\think\Db::table('pml_recharge')->count();
            // dump($key_sumcount);die;
            $staDate=date('Y-m-01', strtotime(date("Y-m-d")));
            $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
            $yue = array('01','02','03','04','05','06','07','08','09','10','11','12');
            $year = date('Y');
            for($i=0;$i<=count($yue);$i++){

                $wher_count = \think\Db::table('pml_recharge')
                    ->where("'".$year.'-'.$yue[$i].'-01'." 00:00:00"."'".'< create_time and create_time < '."'".$year.'-'.$yue[$i].'-31'." 23:59:59"."'")
                    ->where('status', 1)
                    ->sum('money');

                $recharge[$i]['biao'] =  $wher_count;

                if($yue[$i]==12){ break;}
            }
        //     $times = mktime(23,59,59) - mktime(date('H'),date('i'),date('s'));
        //     Cache::set('recharge',$recharge,$times);
        // }
        
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$recharge,
        ));
    }

    //项目
    public function month_xm(){
        // $xm = Cache::get('xm');
        // if(empty($xm)){
            // $key_sumcount =$this->project->count();
            $staDate=date('Y-m-01', strtotime(date("Y-m-d")));
            $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
            $yue = array('01','02','03','04','05','06','07','08','09','10','11','12');
            $year = date('Y');
            for($i=0;$i<=count($yue);$i++){
                $wher_count = $this->project
                    ->where("'".$year.'-'.$yue[$i].'-01'." 00:00:00"."'".'< create_time and create_time < '."'".$year.'-'.$yue[$i].'-31'." 23:59:59"."'")
                    ->select();
                $num=count( $wher_count);
                $xm[$i]['biao'] =  $num;
                if($yue[$i]==12){ break;}
            }
        //     $times = mktime(23,59,59) - mktime(date('H'),date('i'),date('s'));
        //     Cache::set('xm',$xm,$times);
        // }
        
        // dump($chongzhi);die;
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$xm,
        ));
    }

    //客户
    public function month_kh(){
        // $kh = Cache::get('kh');
        // if(empty($kh)){
            // $key_sumcount =\think\Db::table('pml_user')->count();
            $staDate=date('Y-m-01', strtotime(date("Y-m-d")));
            $endDate= date('Y-m-d', strtotime("$staDate +1 month -1 day"));
            // dump(substr($endDate,8));die;
            $yue = array('01','02','03','04','05','06','07','08','09','10','11','12');
            $year = date('Y');
            for($i=0;$i<=count($yue);$i++){
                $long = date("t",strtotime($year.'-'.$yue[$i].'-01'));
                $wher_count = \think\Db::table('pml_user')
                    ->where("'".strtotime($year.'-'.$yue[$i].'-01'." 00:00:00")."'".'< createtime and createtime < '."'".strtotime($year.'-'.$yue[$i].'-'.$long." 23:59:59")."'")
                    ->select();
                $num=count( $wher_count);
     
                $kh[$i]['biao'] = $num;
                if($yue[$i]==12){ break;}
            }
        //     $times = mktime(23,59,59) - mktime(date('H'),date('i'),date('s'));
        //     Cache::set('kh',$kh,$times);
        // }
        
        // dump($kh);die;
        return json(array(
            'code'=>1,
            'msg'=>'成功',
            'data'=>$kh,
        ));
    }

}
