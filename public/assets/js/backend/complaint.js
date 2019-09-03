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
                    index_url: 'complaint/index?status='+status,
                    add_url: 'complaint/add',
                    edit_url: 'complaint/edit',
                    del_url: 'complaint/del',
                    multi_url: 'complaint/multi',
                    table: 'complaint',
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
                        {field: 'num', title: __('Num')},
                        {field: 'title', title: __('Title')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'phone', title: __('Phone')},
                        {field: 'user.username', title: __('User.username')},
                        {field: 'images', title: __('Images'), formatter: Table.api.formatter.images},
                        {field: 'status', title: __('Status'), searchList: {"-1":__('Status -1'),"0":__('Status 0'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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