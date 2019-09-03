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
                    index_url: 'cash/index?status='+status,
                    add_url: 'cash/add',
                    edit_url: 'cash/edit',
                    //del_url: 'cash/del',
                    multi_url: 'cash/multi',
                    change_url: 'cash/changestatus',
                    table: 'cash',
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
                        {field: 'user.username', title: __('User.username')},
                        {field: 'username', title: __('Username')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'status', title: __('Status'), searchList: {"-1":__('Status -1'),"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'recharge_num', title: __('Recharge_num')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'phone', title: __('Phone')},
                        {field: 'images', title: __('Images'), formatter: Table.api.formatter.images},
                        {field: 'admin.nickname', title: __('Admin.nickname')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate},
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
	                                    url: 'cash/changestatus/status/1',
	                                    confirm: __('Sure Adopt'),
	                                    success: function (data, ret) {
	                                    	 $(".btn-refresh").click();
	                                    	 Layer.alert(ret.msg);
//	                                        Layer.alert(ret.msg + JSON.stringify(data));
	                                        //如果需要阻止成功提示，则必须使用return false;
	                                        //return false;
	                                    },
	                                    error: function (data, ret) {
	                                    	$(".btn-refresh").click();
	                                        console.log(data, ret);
	                                        Layer.alert(ret.msg);
	                                        return false;
	                                    },
	                                    visible: function (row) {
	                                        //返回true时按钮显示,返回false隐藏
	                                    	return row.status == 0 ? true : false;
	                                    }
	                                },
	                                {
	                                    name: 'Reject',
	                                    text: __('Reject'),
	                                    title: __('Reject'),
	                                    classname: 'btn btn-xs btn-success btn-danger btn-ajax',
	                                    url: 'cash/changestatus/status/-1',
	                                    confirm: __('Sure Reject'),
	                                    success: function (data, ret) {
	                                    	$(".btn-refresh").click();
	                                    	 console.log(data, ret);
	                                    	 Layer.alert(ret.msg);
//	                                        Layer.alert(ret.msg + JSON.stringify(data));
	                                        //如果需要阻止成功提示，则必须使用return false;
	                                        //return false;
	                                    },
	                                    error: function (data, ret) {
	                                    	$(".btn-refresh").click();
	                                        console.log(data, ret);
	                                        Layer.alert(ret.msg);
	                                        return false;
	                                    },
	                                    visible: function (row) {
	                                        //返回true时按钮显示,返回false隐藏
	                                    	return row.status == 0 ? true : false;
	                                    }
	                                },
	                                {
	                                    name: 'Examine',
	                                    text: __('Examine'),
	                                    title: __('Examine'),
	                                    classname: 'btn btn-xs btn-success btn-danger btn-ajax',
	                                    url: 'cash/changestatus/status/2',
	                                    confirm: __('Sure Examine'),
	                                    success: function (data, ret) {
//	                                    	$(".btn-refresh").click();
	                                    	 console.log(data, ret);
	                                        Layer.alert(ret.msg + JSON.stringify(data));
	                                        //如果需要阻止成功提示，则必须使用return false;
	                                        //return false;
	                                    },
	                                    error: function (data, ret) {
	                                    	$(".btn-refresh").click();
	                                        console.log(data, ret);
	                                        Layer.alert(ret.msg);
	                                        return false;
	                                    },
	                                    visible: function (row) {
	                                    	console.log(row.status);
	                                        //返回true时按钮显示,返回false隐藏
	                                    	return row.status == 1 ? true : false;
	                                    }
	                                },
	                      	  ],
	                      	  
                      	  formatter: Table.api.formatter.buttons,}
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