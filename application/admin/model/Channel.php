<?php

namespace app\admin\model;

use think\Model;

class Channel extends Model
{
    // 表名
    protected $name = 'channel';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    

    public function getStatusList()
    {
        return ['0' => __('Status 0'),'1' => __('Status 1')];
    }  







}
