<?php

namespace app\admin\model;

use think\Model;
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: toresetpwdken, Origin, X-Requested-With, Content-Type, Accept, Authorization");
header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
class Consumption extends Model
{

    // 表名
    protected $name = 'consumption';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'is_qualified_text'
    ];
    

    
    public function getIsQualifiedList()
    {
        return ['0' => __('Is_qualified 0'),'1' => __('Is_qualified 1')];
    }     

    public function getStatusList()
    {
        return ['0' => __('Status 0'),'1' => __('Status 1')];
    }     
    
    public function getIsQualifiedTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['is_qualified']) ? $data['is_qualified'] : '');
        $list = $this->getIsQualifiedList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function channel()
    {
        return $this->belongsTo('Channel', 'channel_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function keyword()
    {
        return $this->belongsTo('Keyword', 'keyword_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function projcet()
    {
        return $this->belongsTo('Projcet', 'projcet_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
