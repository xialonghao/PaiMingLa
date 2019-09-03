<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"/www/wwwroot/pml_zhihuo_com_cn/pml/public/../application/admin/view/worder/index.html";i:1562661366;s:77:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/layout/default.html";i:1552038988;s:74:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/meta.html";i:1552038988;s:76:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/script.html";i:1552038988;}*/ ?>
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
    .user-list-piece-title .layui-inline button,.caiwu_usertime span, .alluser-input-inline .time-icon, .alluser-input-inline span{
        color:#18bc9c;
    }
    .layui-table-page{
        border:none !important;
    }
    .layui-table-page .layui-laypage-limits .layui-form-select .layui-select-title .layui-input{
        color:#18bc9c!important;
    }
    .layui-form-select .layui-edge{
        border-top-color: #18bc9c !important;
    }
    .layui-table-page i.layui-icon{
        color: #18bc9c !important;
    }
    #LAY_app div.layui-laydate .layui-this, #layui-laypage-1 .layui-laypage-curr .layui-laypage-em{
        background: #18bc9c !important;
    }
    .layui-table-page i.layui-icon{
        color: #18bc9c !important;
    }
    div.layui-table-page .layui-laypage button{
        background: #18bc9c !important;
    }
</style>
<body class="layui-layout-body">
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <!--&lt;!&ndash; 侧边菜单 &ndash;&gt;-->
        <!--<div class="layui-side layui-side-menu">-->
            <!--<div class="layui-side-scroll">-->
                <!--<a href="javascript:;" layadmin-event="flexible" title="侧边伸缩" class="nav_click">-->
                    <!--<i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>-->
                <!--</a>-->
                <!--<div class="layui-logo zh_clear">-->
                    <!--<a href="/user/index/"><span class="user_logo"></span></a>-->
                <!--</div>-->
                <!--<ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu"-->
                    <!--lay-filter="layadmin-system-side-menu">-->
                    <!--<li data-name="总览概况" class="layui-nav-item">-->
                        <!--<a href="/" lay-tips="总览概况" lay-direction="2">-->
                            <!--<em>&#xeb8f;</em>-->
                            <!--<cite>总览概况</cite>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li data-name="项目列表" class="layui-nav-item">-->
                        <!--<a href="javascript:;" lay-tips="项目列表" lay-direction="2">-->
                            <!--<em>&#xeb61;</em>-->
                            <!--<cite>项目列表</cite>-->
                        <!--</a>-->
                        <!--<dl class="layui-nav-child">-->
                            <!--<dd data-name="执行项目">-->
                                <!--<a href="/project/running/">执行项目</a>-->
                            <!--</dd>-->
                            <!--<dd data-name="历史项目">-->
                                <!--<a href="/project/history/">历史项目</a>-->
                            <!--</dd>-->
                            <!--<dd data-name="创建项目">-->
                                <!--<a href="/project/created/">新建项目</a>-->
                            <!--</dd>-->
                            <!--<dd data-name="订单管理">-->
                                <!--<a href="/project/indent/">订单管理</a>-->
                            <!--</dd>-->
                        <!--</dl>-->
                    <!--</li>-->
                    <!--<li data-name="项目报告" class="layui-nav-item">-->
                        <!--<a href="/project/report/" lay-tips="项目报告" lay-direction="2">-->
                            <!--<em>&#xeb95;</em>-->
                            <!--<cite>项目报告</cite>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li data-name="预警记录" class="layui-nav-item">-->
                        <!--<a href="/project/warn/" lay-tips="预警记录" lay-direction="2">-->
                            <!--<em>&#xec34;</em>-->
                            <!--<cite>预警记录</cite>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li data-name="财务管理" class="layui-nav-item">-->
                        <!--<a href="javascript:;" lay-tips="财务管理" lay-direction="2">-->
                            <!--<em>&#xe604;</em>-->
                            <!--<cite>财务管理</cite>-->
                        <!--</a>-->
                        <!--<dl class="layui-nav-child">-->
                            <!--<dd data-name="充值中心">-->
                                <!--<a href="/alipy/top/?online=1">充值中心</a>-->
                            <!--<dd data-name="财务记录">-->
                                <!--<a href="/alipy/order/numbers/">财务记录</a>-->
                            <!--</dd>-->
                            <!--<dd data-name="发票管理">-->
                                <!--<a href="/alipy/invoiceInfo/?invoiceLine=1&code=200">发票管理</a>-->
                            <!--</dd>-->
                        <!--</dl>-->
                    <!--</li>-->
                    <!--<li data-name="授权管理" class="layui-nav-item">-->
                        <!--<a href="/project/accredit/" lay-tips="授权管理" lay-direction="2">-->
                            <!--<em>&#xeb63;</em>-->
                            <!--<cite>授权管理</cite>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li data-name="工单管理" class="layui-nav-item">-->
                        <!--<a href="javascript:;" lay-tips="工单管理" lay-direction="2">-->
                            <!--<em>&#xec37;</em>-->
                            <!--<cite>工单管理</cite>-->
                        <!--</a>-->
                        <!--<dl class="layui-nav-child">-->
                            <!--<dd data-name="我的工单">-->
                                <!--<a href="/user/allworkorder/">我的工单</a>-->
                            <!--</dd>-->
                            <!--<dd data-name="创建工单">-->
                                <!--<a href="/user/createworkorder/">创建工单</a>-->
                            <!--</dd>-->
                        <!--</dl>-->
                    <!--</li>-->
                    <!--<li data-name="个人中心" class="layui-nav-item">-->
                        <!--<a href="/user/centerinfo/" lay-tips="个人中心" lay-direction="2">-->
                            <!--<em>&#xe642;</em>-->
                            <!--<cite>个人中心</cite>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li data-name="投诉建议" class="layui-nav-item">-->
                        <!--<a href="/user/createSuggestion/" lay-tips="个人中心" lay-direction="2">-->
                            <!--<em>&#xec7f;</em>-->
                            <!--<cite>投诉建议</cite>-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
        <!--</div>-->
        <!--&lt;!&ndash; 导航栏 &ndash;&gt;-->
        <!--<div class="layui-header zh_clear">-->
            <!--<div class="zh_head_tit zh_clear zh_left layui-nav layui-layout-left">-->
                <!--财务管理 > 发票管理 > 发票信息模板-->
            <!--</div>-->
            <!--<div class="zh_head_right zh_right zh_clear">-->
                <!--<div class="zh_head_img">-->
                    <!--<a href="/user/centerinfo/" class="user_img"><img-->
                            <!--src="http://47.101.201.10/static/images/userhandimg/691d6f8644defaultpic.gif"-->
                            <!--id="handimg"></a>-->
                    <!--<dl class="layui-nav-child layui-anim layui-anim-upbit zh_head_nav">-->
                        <!--<dd><a href="/user/centerinfo/" class="user_nav_name">will</a>-->
                        <!--</dd>-->
                        <!--<dd><a href="/user/centerinfo/" class="user_nav_cen">个人中心</a></dd>-->
                        <!--<dd><a href="/user/logout/" class="user_nav_edit">退出登录</a></dd>-->
                    <!--</dl>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="zh_head_mess zh_right">-->
                <!--<ul class="layui-nav" lay-filter="component-nav">-->
                <!--</ul>-->
                <!--<p class="zh_head_mess_img">-->
                    <!--<a href="/user/acceptMessage/?online=6" class="head_mess_img">-->
                        <!--&#xec36;-->
                        <!--<em>...</em>-->
                    <!--</a>-->
                <!--</p>-->
            <!--</div>-->
        <!--</div>-->
        <!-- 主体内容 -->
        <div class="" id="LAY_app_body">

            <div class="word-order-piece layui-row layui-col-space15 layui-fluid">
                <div class="layui-col-md12">
                    <div class="layui-card caiwu_diary zh_bg_white">
                        <div class="layui-card-header">
                            <h3 style="margin: 0px">工单系统</h3>
                        </div>
                        <div class="awi-list-piece-title user-list-piece-title">
                            <div class="layui-input-inline">
                                <input type="text" name="keywork" title="请输入工单编号" autocomplete="off"
                                       class="empty-piece layui-input" id="keywork" >

                            </div>
                            <div class="layui-inline">
                                <button class="layui-btn layuiadmin-btn-list" lay-submit
                                        lay-filter="LAY-app-contlist-search" type="button" id="button">
                                    &#xe60d;
                                </button>
                            </div>
                            <div class="layui-form" wid100 style="float: right">
                                <div class="layui-form-item">
                                    <div class="layui-inline">
                                        <label class="layui-form-label"><a href="javascript:;"
                                                                           id="demos">待处理</a></label>
                                        <label class="layui-form-label"><a href="javascript:;"
                                                                           id="demo1">处理中</a></label>
                                        <label class="layui-form-label"><a href="javascript:;"
                                                                           id="demo2">已解决</a></label>
                                         <label class="layui-form-label">日期范围</label>
                                        <div class="alluser-input-inline layui-input-inline">
                                            <input type="text" class="empty-piece layui-input"
                                                   id="test-laydate-range-date"
                                                   title="开始时间" value="">
                                            <span class="time-icon">&#xe600;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="awi-card-body-piece layui-card-body">
                            <table id="test" class="layui-hide" lay-filter="test">
                            </table>
                        </div>
                        <span class="number-piece">待处理的工单数：0</span>

                    </div>
                </div>
            </div>
            <script type="text/html" id="barDemo">
                <a class="layui-btn layui-btn-xs" lay-event="edit" href="#">查看</a>
            </script>
            <script type="text/html" id="barDemos">

                {{#if(d.status == 0){ }}
                待处理
                {{#} else if(d.status == 1){ }}
                处理中
                {{# } else { }}
                已解决
                {{# } }}


        </script>

            <!-- 弹窗 -->

            <!-- 弹窗结束 -->
            <!-- 辅助元素，一般用于移动设备下遮罩 -->
            <div class="layadmin-body-shade" layadmin-event="shade"></div>
        </div>
    </div>

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
                            url: 'http://pml.zhihuo.com.cn/admin/worder/worder_list',
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
            $('#demos').click(function () {
                console.log(222222);
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/worder/worder_list',
                    type: 'POST',
                    data: {status:'0'},
                    success: function (resp) {

                        if (resp.code == '200') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                        } else if (resp.msg == '401') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                            layer.alert('没有查找到任何工单', {icon: 2})
                        }
                    }
                })
            });
            $('#demo1').click(function () {
                console.log(11111);
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/worder/worder_list',
                    type: 'POST',
                    data: {status:'1'},
                    success: function (resp) {

                        if (resp.code == '200') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                        } else if (resp.msg == '401') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                            layer.alert('没有查找到任何工单', {icon: 2})
                        }
                    }
                })
            });
            $('#demo2').click(function () {
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/worder/worder_list',
                    type: 'POST',
                    data: {status:'2'},
                    success: function (resp) {

                        if (resp.code == '200') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                        } else if (resp.msg == '401') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                            layer.alert('没有查找到任何工单', {icon: 2})
                        }
                    }
                })
            });
            $('#button').click(function () {
                var keyword = $('#keywork').val()
                var regs = ' ';
                if (keyword.indexOf(regs) != -1) {
                    layer.alert('查询不能为空格！', {
                        icon: 2,
                        title: '错误提示'
                    });
                    return false;
                }
                data = {
                    "keyword": keyword,
                    'type': 'list',
                    'csrfmiddlewaretoken': '{{ csrf_token }}'
                };
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/worder/sousuo',
                    type: 'POST',
                    data: data,
                    success: function (resp) {

                        if (resp.msg == '200') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                        } else if (resp.msg == '401') {
                            table.reload('test', {'data': resp.data, page: {curr: 1}});
                            layer.alert('没有查找到任何工单', {icon: 2})
                        }
                    }
                })
                return false;
            })

            $.ajax({
                url: 'http://pml.zhihuo.com.cn/admin/worder/worder_list',
                type: 'POST',
                success: function (resp) {

                    table.render({
                        elem: '#test',
                        cellMinWidth: 86
                        , cols: [[
                            {field: 'worder_sn', title: '工单编号', align: 'center', unresize: true}
                            , {field: 'title', title: '工单标题', align: 'center', minWidth: 120, unresize: true}
                            , {field: 'contect', title: '分类', align: 'center', unresize: true}
                            // , {field: 'work_created_user__username', title: '所属项目', align: 'center', unresize: true}
                            , {
                                field: 'create_time',
                                title: '提交时间',
                            }
                            , {field: 'status', title: '状态', align: 'center', unresize: true, toolbar: '#barDemos'}
                            , {field: 'admin_id', title: '处理人', align: 'center', unresize: true}
                                , {title: '操作', toolbar: '#barDemo', align: 'center', unresize: true}
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
                error:function(resp){
                    console.log(resp);
                    alert('失败');
                }

            })

            table.on('tool(test)', function (obj) {
                var data = obj.data;
                // console.log(id);return;
                window.location.href= "http://pml.zhihuo.com.cn/admin/worder/worderrecord?ids="+data.id+"&admin_id="+data.admin_id;
                // window.open('http://pml.zhihuo.com.cn/admin/worderrecord?ref=addtabs&id="'+id+'"');
                // self.location.href="http://pml.zhihuo.com.cn/admin/worderrecord?ref=addtabs";
            })
            //搜索
            table.render({
                elem: '#test',
                cellMinWidth: 86
                , cols: [[
                    {field: 'work_id', title: '工单编号', align: 'center', unresize: true}
                    , {field: 'work_title', title: '工单标题', align: 'center', minWidth: 120, unresize: true}
                    , {
                        field: 'created_time',
                        title: '提交时间',
                        align: 'center',
                        unresize: true,
                        templet: '<div>{{ layui.util.toDateStr' +
                            'ing(d.created_time,"yyyy/MM/dd HH:mm") }}</div>',
                    }
                    , {field: 'status', title: '状态', align: 'center', unresize: true, toolbar: '#barDemos'}
                    , {field: 'work_created_user__username', title: '创建人', align: 'center', unresize: true}
                    , {field: 'work_dispose_user', title: '处理人', align: 'center', unresize: true}
                    , {title: '操作', toolbar: '#barDemo', align: 'center', unresize: true}
                ]]
                , data: []
                , page: {
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    , limits: [10, 30, 50, 100]
                    , groups: 3

                }
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