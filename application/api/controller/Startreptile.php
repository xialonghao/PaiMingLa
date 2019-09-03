<?php

namespace app\api\controller;

use think\Controller;
use app\api\controller\Project;
/**
 * 项目接口noneedlogin
 */
class Startreptile extends Controller
{

    public function index(){
       $a = new Project();
       $b = $a->countpay_king();
       return $b;
    }

}
