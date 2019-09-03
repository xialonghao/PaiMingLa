<?php

namespace app\admin\model;

use think\Model;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: toresetpwdken, Origin, X-Requested-With, Content-Type, Accept, Authorization");
header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
class Projcet extends Model
{
    // 表名
    protected $name = 'projcet';
    
}
