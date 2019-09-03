<?php

namespace app\api\controller;

use think\Controller;
use app\api\controller\Project;
/**
 * 项目接口noneedlogin
 */
class Startreptile extends Controller
{

//    protected $noNeedLogin = ['index', 'is_contraband', 'add_project_2','countpay_king','countproject_particular'];
//    protected $noNeedRight = '*';
//    protected $project = null;
//    public function _initialize()
//    {
//        header('Access-Control-Allow-Origin: *');
//        header("Access-Control-Allow-Headers: toresetpwdken, Origin, X-Requested-With, Content-Type, Accept, Authorization");
//        header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
//        $this->project = new \app\admin\model\Projcet;
//        parent::_initialize();
//    }
    public function index(){
       $a = new Project();
       $b = $a->countpay_king();
       return $b;
    }

}
