<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:92:"/www/wwwroot/pml_zhihuo_com_cn/pml/public/../application/admin/view/worder/worderrecord.html";i:1562661559;s:77:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/layout/default.html";i:1552038988;s:74:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/meta.html";i:1552038988;s:76:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/script.html";i:1552038988;}*/ ?>
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
        <div class="layui-body" id="LAY_app_body" style="margin: 0;padding:0">

            <div class="checkworkorder-piece layui-fluid layui-row layui-col-space15">
                <div class="caiwu_diary layui-col-md12 zh_bg_white layui-form">
                    <!--<div class="reply_nav">-->
                        <!--<ul>-->
                            <!--<li>-->
                                <!--<span>1</span>-->
                                <!--<em>待处理</em>-->
                            <!--</li>-->
                            <!--<li class="active">-->
                                <!--<span>2</span>-->
                                <!--<em>处理中</em>-->
                            <!--</li>-->
                            <!--<li>-->
                                <!--<span>3</span>-->
                                <!--<em>已解决</em>-->
                            <!--</li>-->
                        <!--</ul>-->
                    <!--</div>-->
                    <div class="reply_navmess">

                        <p>工单编号:<?php echo $list_title['worder_sn']; ?></p>
                        <ul class="clear layui-row">
                            <li class="layui-col-md3">标题：<?php echo $list_title['title']; ?></li>
                            <li class="layui-col-md3">分类：<?php echo $list_title['contect']; ?></li>
                            <li class="layui-col-md3">提交时间<?php echo $list_title['create_time']; ?></li>
                            <li class="layui-col-md3">状态：<?php switch($list_title['status']): case "-1": ?>驳回
                                    <?php case "0": ?>未处理<?php break; case "1": ?>处理中<?php break; case "2": ?>已完成<?php break; endswitch; ?></li></li>
                            <li class="zh_right layui-col-md3">
                                <a href="" id="end_worder">结束工单</a></li>
                        </ul>
                    </div>
                    <!-- 沟通记录 -->
                    <div class="reply_record">
                        <div class="title">沟通记录</div>
                        <!-- 用户信息 -->
                        <?php if(is_array($chatlist) || $chatlist instanceof \think\Collection || $chatlist instanceof \think\Paginator): if( count($chatlist)==0 ) : echo "" ;else: foreach($chatlist as $key=>$val): ?>
                        <div class="reoly_record_mess zh_clear">
                            <div class="zh_left uesrimg">
                                <?php if($val['adminstatus'] == 1): ?>
                                <img src="<?php echo $avatar; ?>" alt="">
                                <?php elseif($val['adminstatus'] == 0): ?>
                                <img src="<?php echo $userimage; ?>" alt="">
                                <?php endif; ?>
                            </div>

                            <div class="zh_left usertext">
                                <?php if($val['adminstatus'] == 1): ?>
                                <p><?php echo $val['admin_name']; ?></p>
                                <?php elseif($val['adminstatus'] == 0): ?>
                                <p><?php echo $val['username']; ?></p>
                                <?php endif; ?>
                                <!--<p <?php if($val['adminstatus'] == 1): endif; ?>><?php echo $val['admin_name']; ?></p>-->
                                <!--<p <?php if($val['adminstatus'] == 0): endif; ?>><?php echo $val['username']; ?></p>-->
                                <span><?php echo $val['contect']; ?></span>
                                <em><?php echo $val['create_time']; ?></em>
                                </span>
                            </div>

                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <!-- 沟通记录结束 -->
                    <div id="adids" style="display: none"><?php echo $adids; ?></div>
                    <div id="userid" style="display: none"><?php echo $list_title['id']; ?></div>
                    <div class="reply_form">
                            <div class="title">我要答复</div>
                            <p>答复</p>
                            <textarea name="remarks" id="conts" placeholder="管理员回复信息" style="vertical-align: bottom;"></textarea>
                        <button id="submit" style="background: #18bc9c;">提交答复</button>
                    </div>
                </div>
            </div>
            <script type="text/html" id="barDemo">
                <a class="layui-btn layui-btn-xs" lay-event="edit" href="#">查看</a>
            </script>

            <!-- 弹窗 -->


            <!-- 弹窗结束 -->
            <!-- 辅助元素，一般用于移动设备下遮罩 -->
            <div class="layadmin-body-shade" layadmin-event="shade"></div>
        </div>
    </div>

    <script src="/assets/worder/layuiadmin/layui/layui.js "></script>

    <script>

        $('#submit').click(function() {

            var content = $('#conts').val();
            var admin_id = $('#adids').text();
            var user_id = $('#userid').text();
            // console.log($content);
            // console.log($admin_id);return;
            $.ajax({
                url: "http://pml.zhihuo.com.cn/admin/worder/dafu",  //数据传输的控制器方法
                type: 'POST',
                data: {content:content,adsid:admin_id,userid:user_id},
                success: function (data) {
                    alert(data.msg);
                    location.reload();
                },
                error: function (data) {
                    alert(data.msg);
                }
            });
        });
    </script>
</div>
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