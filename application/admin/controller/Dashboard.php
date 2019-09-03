<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];
        for ($i = 0; $i < 7; $i++)
        {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $createlist[$day] = mt_rand(20, 200);
            $paylist[$day] = mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');
        $this->view->assign([
            //执行中项目数量
            'totaluser'        => $this->get_projectnum(1),
            //即将到期的项目
            'totalviews'       => $this->get_projectend(7),
            //待处理工单
            'totalorder'       => $this->get_worder(0),
            //待开发票
            'totalorderamount' => $this->get_invoice(0),
            //月统计客户数
            
            //月统计项目数
            'todayuserlogin'   => 321,
            'todayusersignup'  => 430,
            'todayorder'       => 2324,
            'unsettleorder'    => 132,
            'sevendnu'         => '80%',
            'sevendau'         => '32%',
            'paylist'          => $paylist,
            'createlist'       => $createlist,
            'addonversion'       => $addonVersion,
            'uploadmode'       => $uploadmode
        ]);

        return $this->view->fetch();
    }

    /**
     * 
     * @param number $status 项目状态:0=待审核,1=执行中,2=已完成,-1=已驳回
     */
    private function get_projectnum($status=1){
        $map = [];
        $map['status']=$status;
        $map['pay_status']=1;
        return \think\Db::table('pml_projcet')->where($map)->count();
    }
    
    /**
     *
     * @param number $status 项目状态:0=待审核,1=执行中,2=已完成,-1=已驳回
     */
    private function get_projectend($time=7){
        $map = [];
        $map['status']=1;
        $map['pay_status']=1;
//         $times = 7 * 24 * 60 *60;
        //时间处理
        $startime = date('Y-m-d',time());
        $endtime = date('Y-m-d', strtotime('+1 week'));
        return \think\Db::table('pml_projcet')->where($map)->whereTime('endtime', 'between', [$startime, $endtime])->count();
        
    }
    
    /**
     *
     * @param number $status 工单状态:-1=驳回,0=未处理,1=处理中,2=已完成
     */
    private function get_worder($status=0){
        $map = [];
        $map['status']=$status;
        return \think\Db::table('pml_worder')->where($map)->count();
    }
    
    /**
     *
     * @param number $status 发票状态:0=未开,1=已开
     */
    private function get_invoice($status=0){
        $map = [];
        $map['status']=$status;
        return \think\Db::table('pml_invoice')->where($map)->count();
    }
    
}
