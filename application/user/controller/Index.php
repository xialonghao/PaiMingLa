<?php

namespace app\user\controller;

use app\common\controller\Backend;
use think\Controller;
/**
 * 会员管理
 *
 * @icon fa fa-user
 */
class Index extends Controller
{
        public function index(){
            $this->fetch();
        }

}
?>
