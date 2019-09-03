<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function keyword()
    {
        return $this->belongsTo('Keyword', 'keyword_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projcet()
    {
        return $this->belongsTo('Projcet', 'project_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function channel()
    {
        return $this->belongsTo('Channel', 'channel_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
