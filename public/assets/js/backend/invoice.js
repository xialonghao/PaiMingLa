define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'invoice/index',
                    add_url: 'invoice/add',
                    edit_url: 'invoice/edit',
                    del_url: 'invoice/del',
                    multi_url: 'invoice/multi',
                    table: 'invoice',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1')}, formatter: Table.api.formatter.normal},
                        {field: 'head', title: __('Head')},
                        {field: 'amount', title: __('Amount')},
                        {field: 'invoice_type', title: __('Invoice_type'), searchList: {"0":__('Invoice_type 0'),"1":__('Invoice_type 1')}, formatter: Table.api.formatter.normal},
                        {field: 'useraddress.city', title: __('City')},
                        {field: 'useraddress.street', title: __('Street')},

                        {field: 'username', title: __('username'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'buttons', title: __('Remittance'), 
                            width: "120px",
                            table: table, 
                            events: Table.api.events.operate,
                              buttons: [
                                    {
                                        name: 'Adopt',
                                        text: __('Adopt'),
                                        title: __('Adopt'),
                                        classname: 'btn btn-xs btn-success btn-magic btn-ajax',
                                        url: 'invoice/changestatus/status/1',
                                        confirm: __('Sure Adopt'),
                                        success: function (data, ret) {
                                             $(".btn-refresh").click();
//                                          Layer.alert(ret.msg + JSON.stringify(data));
                                            //如果需要阻止成功提示，则必须使用return false;
                                            //return false;
                                        },
                                        error: function (data, ret) {
                                            $(".btn-refresh").click();
                                            console.log(data, ret);
//                                          Layer.alert(ret.msg);
                                            return false;
                                        },
                                        visible: function (row) {
                                            //返回true时按钮显示,返回false隐藏
                                            return row.status == 0 ? true : false;
                                        }
                                    },
                              ],
                              
                          formatter: Table.api.formatter.buttons,}
                        //{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});