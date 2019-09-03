define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
var projcet_id = $("#projcet_id").val();
	var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index',
                    add_url: 'order/add',
                    //edit_url: 'consumption/edit',
                    //del_url: 'consumption/del',
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
                        //{checkbox: true},
                        {field: 'id', title: __('Id')},
                        //{field: 'order_sn', title: __('Order_sn')},
                        //{field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'keyword.name', title: __('Keyword.name')},
                        {field: 'channel.name', title: __('Channel.name')},
                        {field: 'ranking', title: __('Ranking')},
                        {field: 'money', title: __('Yestoday')},
                        {field: 'amount', title: __('Money'), operate:'BETWEEN'},
                        //{field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        //{field: 'projcet.name', title: __('Projcet.name')},
                        //{field: 'user.username', title: __('User.username')},
                        {
                            field: 'keyword_id',
                            width: "120px",
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
					                        {
					                            name: __('Detail'),
					                            title: __('Detail'),
					                            text: __('Detail'),
					                            classname: 'btn btn-xs btn-warning btn-addtabs',
					                            //icon: 'fa fa-folder-o',
					                            url: function(data){
					                            	return 'consumption/index?keyword_id='+data.keyword_id;
					                            },
					                        }
				                        ],
				                        formatter: Table.api.formatter.operate
                        }
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
            },
        formatter: {
        	jumpurl: function (value, row, index) {
                //这里手动构造URL
                url = "consumption/index?projcet_id=" + row.id;

                //方式一,直接返回class带有addtabsit的链接,这可以方便自定义显示内容
                return '<a href="' + url + '"title="' + __("Search %s", value) + '">' + value + '</a>';
            }
        }
        }
    };
    return Controller;
});