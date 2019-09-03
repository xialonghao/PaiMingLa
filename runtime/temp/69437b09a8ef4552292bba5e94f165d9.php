<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"/www/wwwroot/pml_zhihuo_com_cn/pml/public/../application/admin/view/contraband/index.html";i:1562658805;s:77:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/layout/default.html";i:1552038988;s:74:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/meta.html";i:1552038988;s:76:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/script.html";i:1552038988;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="<?php echo $site['image']; ?>" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <!DOCTYPE html>


<html>
<head>
    <meta charset="utf-8">
    <title>排名啦</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/style/login.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/layui/css/userwill.css" media="all">

    <link rel="stylesheet" href="/assets/worder/layui-formSelects-master/dist/formSelects-v4.css"/>
    <link rel="stylesheet" href="/assets/worder/layuiadmin/layui/css/userwill.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/style/iconfont.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/style/will.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/style/iconfont.css" media="all">
    <link rel="stylesheet" href="/assets/worder/layuiadmin/layui/css/admin_will.css" media="all">
    <link rel="stylesheet" href="/assets/worder/css/will.css" media="all">
    <script src="https://cdn.staticfile.org/jquery/2.0.0/jquery.min.js"></script>
</head>
<style>
    div.layui-table-page .layui-laypage button, #LAY_app div.layui-laydate .layui-this, #layui-laypage-1 .layui-laypage-curr .layui-laypage-em {
        background: #18BC9C !important;
    }
    #layui-laydate1 .layui-this, .layui-laypage .layui-laypage-curr .layui-laypage-em{
        background: #18BC9C!important;
    }
    .layui-form-select .layui-edge {
        border-top-color: #18BC9C !important;
    }
    .layui-table-page .layui-laypage-limits .layui-form-select .layui-select-title .layui-input {
        color: #18BC9C !important;
    }
    .layui-layer-btn{
        text-align: center;
    }
    .layui-layer-btn0{
        background: #18BC9C!important;
    }
    .layui-layer-btn1{
        color: #18BC9C!important;
    }
    .layui-layer-page div.layui-layer-btn{
        padding:20px 0 ;
    }
    .layui-table-page{
        border:none!important;
    }
</style>
<body class="layui-layout-body">
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">

        <div class="" id="LAY_app_body">

            <div class="word-order-piece layui-row layui-col-space15 layui-fluid">
                <div class="layui-col-md12">
                    <div class="layui-card caiwu_diary zh_bg_white">
                        <div class="layui-card-header">
                            <h3 style="margin: 0px">违禁词</h3>
                        </div>
                        <div class="awi-list-piece-title user-list-piece-title">
                            <button class="layui-btn layuiadmin-btn-list"
                                    lay-filter="LAY-app-contlist-search" type="button" id="button" style="padding: 0 10px;
    border-radius: 5px;background: #18BC9C;height: 28px;line-height: 28px;color:#fff">+添加
                            </button>


                        </div>
                        <div class="awi-card-body-piece layui-card-body">
                            <table id="test" class="layui-hide" lay-filter="test">
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            <script type="text/html" id="deletes">
                <a class="layui-btn layui-btn-xs" lay-event="update" href="#">编辑</a>
                <a class="layui-btn layui-btn-xs" lay-event="edit" href="#">删除</a>
            </script>

            <!-- 弹窗 -->

            <!-- 弹窗结束 -->
            <!-- 辅助元素，一般用于移动设备下遮罩 -->
            <div class="layadmin-body-shade" layadmin-event="shade"></div>
        </div>
    </div>
    <div class="add_zu" style="display: none">
        <form class="layui-form rt_model">
            <ul>
                <li style="text-align: center">
                    <div class="inovice_box_text" style="padding:0 10px;display: inline-block">违禁词：</div>
                    <div class="inovice_box_input" style="padding:10px;display: inline-block">
                        <input class="layui-input" type="" name="remark" lay-verify="required" id="name"
                               style="width: 300px;"
                               maxlength="30">
                    </div>
                </li>
                <li style="text-align: center">
                    <div class="invoice_box_bor zh_clear center_sub" style="border:none;padding-top:0">
                        <button class="submit submit_btn" id="save" lay-submit lay-filter="addfllow"
                                style="background: #18BC9C;margin:0 auto">添加
                        </button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
    <!---->
    <div class="editword" style="display: none">
        <form class="layui-form rt_model">
            <ul>
                <li style="text-align: center">
                    <div class="inovice_box_text" style="padding:0 10px;display: inline-block">违禁词：</div>
                    <div class="inovice_box_input" style="padding:10px;display: inline-block">
                        <input type="text" id="idone" name="pk" style="display: none">
                        <input class="layui-input" type="text" name="word" id="ci" lay-verify="required" maxlength="30"
                               style="width: 300px;">
                    </div>
                </li>
                <li style="text-align: center">
                    <div class="invoice_box_bor zh_clear center_sub" style="border:none;padding-top:0">
                        <button class="submit submit_btn" id="saves" lay-submit lay-filter="addfllows"
                                style="background: #18BC9C;margin:0 auto">修改
                        </button>
                    </div>
                </li>
            </ul>
        </form>
    </div>
    <!---->
    <script src="/assets/worder/layuiadmin/layui/layui.js "></script>
    <script>

        layui.config({
            base: '/assets/worder/layuiadmin/'//静态资源所在路径

        }).extend({
            index: 'lib/index'//主入口模块

        }).use(['index', 'laypage', 'laydate', 'form', 'table'], function () {
            var $ = layui.$
                , admin = layui.admin
                , element = layui.element
                , layer = layui.layer
                , form = layui.form
                , laydate = layui.laydate
                , table = layui.table;

            laydate.render({
                elem: '#test-laydate-range-date',
                type: 'datetime',
                range: '-',
                format: 'yyyy/MM/dd'
                , done: function (value) {
                    data = {
                        "data": value,
                        'type': 'list',
                        'csrfmiddlewaretoken': '{{ csrf_token }}'
                    };
                    $.ajax({
                        url: 'http://pml.zhihuo.com.cn/admin/worder/',
                        type: 'POST',
                        data: data,
                        success: function (resp) {
                            if (resp.code == '200') {
                                table.reload('test', {'data': resp.data, page: {curr: 1}});
                            } else if (resp.msg == '401') {
                                table.reload('test', {'data': resp.data, page: {curr: 1}});
                                layer.alert('没有查找到任何工单', {icon: 2})
                            }
                        }
                    });
                }
            });

            // 渲染列表
            function formdata() {
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/contraband/lists',
                    type: 'GET',
                    success: function (resp) {
                        // console.log(resp);die;
                        table.render({
                            elem: '#test',
                            cellMinWidth: 86
                            , cols: [[
                                {field: 'pk', title: 'id', align: 'center', unresize: true}
                                , {field: 'word', title: '关键词', align: 'center', minWidth: 120, unresize: true}
                                , {field: 'create_time', title: '时间', align: 'center', minWidth: 120, unresize: true}
                                , {title: '操作', toolbar: '#deletes', align: 'center', unresize: true}
                            ]]
                            , data: resp.data
                            , page: {
                                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                                , limits: [10, 30, 50, 100]
                                , groups: 3

                            }
                        });
                        if (resp.data.length == 0) {
                            $(".empty-piece").attr('placeholder', '');
                        }
                    },
                    error: function (resp) {
                        console.log(resp);
                        alert('失败');
                    }
                });
            }

            formdata();

            // 违禁词添加
            form.on('submit(addfllow)', function (data) {
                event.preventDefault();
                var word = data.field;
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/contraband/adds',
                    type: 'POST',
                    data: {word},
                    success: function (res) {
                        console.log(res);
                        if (res.code == '200') {
                            $('.add_zu').css({display:'none'});
                            formdata();
                            layer.msg(res.msg);
                            layer.closeAll();
                        } else if (res.code == '500') {
                            layer.msg(res.msg);
                        }
                    }
                })
            });

            $('#button').click(function () {
                layer.open({
                    title: '添加',
                    type: 1,
                    area: '430px',
                    shadeClose: true,
                    content: $(".add_zu")
                });
            });


            table.on('tool(test)', function (obj) {
                var data = obj.data;
                var ids = data.pk;
                if (obj.event === 'edit') {
                    layer.confirm('确定要删除吗？',
                        function (index) {
                            $.ajax({
                                url: 'http://pml.zhihuo.com.cn/admin/contraband/dels',
                                type: 'get',
                                data: {ids: ids},
                                success: function (res) {
                                    if (res.code == '200') {
                                        layer.msg(res.msg);
                                    }else{
                                        layer.open({
                                            type: 1,
                                            content: '<div style="padding: 20px 100px 0;">删除成功</div>'
                                            , btn: '关闭'
                                            ,btnAlign: 'c' //按钮居中
                                            , yes: function (index) {
                                                layer.close(index);
                                            }
                                        });
                                    }
                                }
                            })
                            obj.del();
                            layer.close(index);
                        });
                } else if (obj.event === 'update') {
                    $('#ci').val(data.word);
                    $('#idone').val(data.pk);
                    layer.open({
                        title: '编辑',
                        type: 1,
                        area: '430px',
                        shadeClose: true,
                        content: $(".editword")
                    });
                }
            });
            form.on('submit(addfllows)', function (data) {
                event.preventDefault();

                var word = data.field.word;
                var ids = data.field.pk;

                $.ajax({
                    url: "http://pml.zhihuo.com.cn/admin/contraband/updatas",
                    type: 'post',
                    data: {ids: ids, words: word},
                    success: function (res) {
                        if (res.code == '200') {
                            formdata();
                            $('.editword').css({display:'none'});
                            layer.msg(res.msg);
                            layer.closeAll();
                        } else if (res.code == '500') {
                            layer:msg(res.msg);
                        }
                    }
                })
            });

        })
    </script>

</body>
</html>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>