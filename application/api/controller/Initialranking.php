<?php
namespace app\api\controller;
use think\Controller;
use app\api\controller\Project;
/**
 * 项目接口noneedlogin
 */
class Initialranking extends Controller
{
    public function initial(){
            $info = new Project();
            $date = $info->paimingsta();
            return $date;
    }
}
?>