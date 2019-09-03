define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var nowurl = document.URL;
    res = nowurl.match(/ids\/(.*)\?/);
    if(res===null){
        str = '';
    }else{
        str = nowurl.match(/ids\/(.*)\?/)[1];
    }
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index?ids='+str,
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    table: 'order',
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
                        {field: 'star_ranking', title: __('Star_ranking')},
                        {field: 'taday_ranking', title: __('Taday_ranking')},
                        {field: 'amount', title: __('Amount'), operate:'BETWEEN'},
                        {field: 'order_sn', title: __('Order_sn')},
                        {field: 'user.username', title: __('User.username')},
                        {field: 'keyword.name', title: __('Keyword.name')},
                        {field: 'projcet.num', title: __('Projcet.num')},
                        {field: 'channel.name', title: __('Channel.name')},
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