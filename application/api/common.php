<?php
if(!function_exists('read_table_filed')){
    /**
     * 读取表指定字段
     * @param string $tab 表名
     * @param string $field 需要读取字符串
     * @param string $id 条件字段
     * @return string
     */
    function read_table_filed($tab,$filed,$where){
        $data = \think\Db::table($tab)->fieldRaw($filed)->where($where)->find();
        return $data[$filed];
    }
}