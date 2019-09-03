<?php

namespace app\api\controller;

use think\Controller;
use app\api\controller\Project;
/**
 * 项目接口noneedlogin
 */
class Startranking extends Controller
{

    public function index(){
        $a = new Project();
        $b = $a->countproject_particular();
        return $b;
    }
    public function paiming(){
        $a = new Project();
        $b = $a->paimingsta();
        return $b;
}

}
