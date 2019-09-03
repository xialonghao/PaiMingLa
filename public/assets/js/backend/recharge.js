define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var nowurl = document.URL;
    res = nowurl.match(/status=(.*)/);
    // console.log(res);
    if(res===null){
        status = '';
    }else{
        status = nowurl.match(/status=(.*)/)[1];
    }
    var lis = $('.nav-tabs > li >a');

    for (var i = 0; i < lis.length; i++) {
        if($(lis[i]).attr('data-value') == status){
            $(lis[i]).parent().siblings().removeClass('active');
            $(lis[i]).parent().addClass('active');
        } 
    }
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'recharge/index?status='+status,
                    add_url: 'recharge/add',
                    edit_url: 'recharge/edit',
                    del_url: 'recharge/del',
                    multi_url: 'recharge/multi',
                    table: 'recharge',
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
                        {field: 'recharge_num', title: __('Recharge_num')},
                        {field: 'user.username', title: __('User.username')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1'),"2":__('Type 2')}, formatter: Table.api.formatter.normal},
                        {field: 'create_time', title: __('Create_time')},
                        {field: 'admin.username', title: __('Admin.username')},
                        {field: 'images', title: __('Images'), formatter: Table.api.formatter.images},
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