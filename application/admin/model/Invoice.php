<?php

namespace app\admin\model;

use think\Model;

class Invoice extends Model
{
    // 表名
    protected $name = 'invoice';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'type_text',
        'company_text',
        'invoice_type_text'
    ];
    

    
    public function getTypeList()
    {
        return ['0' => __('Type 0'),'1' => __('Type 1')];
    }     

    public function getCompanyList()
    {
        return ['0' => __('Company 0'),'1' => __('Company 1'),'2' => __('Company 2')];
    }     

    public function getInvoiceTypeList()
    {
        return ['0' => __('Invoice_type 0'),'1' => __('Invoice_type 1')];
    }     


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCompanyTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['company']) ? $data['company'] : '');
        $list = $this->getCompanyList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getInvoiceTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['invoice_type']) ? $data['invoice_type'] : '');
        $list = $this->getInvoiceTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function Useraddress()
    {
        return $this->belongsTo('Useraddress', 'address_id', 'id')->setEagerlyType(0);
    }


    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
