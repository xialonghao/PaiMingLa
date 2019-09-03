<?php

namespace app\admin\model;

use think\Model;

class Adv extends Model
{
    // 表名
    protected $name = 'adv';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'status_text'
    ];
    

    
    public function getStatusList()
    {
        return ['0' => __('Status 0'),'1' => __('Status 1')];
    }     


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function sitecategory()
    {
        return $this->belongsTo('Sitecategory', 'type_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
