<?php

namespace app\common\controller;
use think\Response;
class CrossDomain
{

    public function appInit(){
        return header('Access-Control-Allow-Origin: *').';'.header("Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept, Authorization").';'.header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
    }
}


?>