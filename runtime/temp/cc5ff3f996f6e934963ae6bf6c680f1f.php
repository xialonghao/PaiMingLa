<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"/www/wwwroot/pml_zhihuo_com_cn/pml/public/../application/admin/view/dashboard/index.html";i:1562382847;s:77:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/layout/default.html";i:1552038988;s:74:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/meta.html";i:1552038988;s:76:"/www/wwwroot/pml_zhihuo_com_cn/pml/application/admin/view/common/script.html";i:1552038988;}*/ ?>
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
                                <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://layui.hcwl520.com.cn/layui/css/layui.css?v=201811010202">
    <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts-en.common.js"></script>
    <script src="https://layui.hcwl520.com.cn/layui-v2.4.5/layui.js?v=201811010202"></script>
    <script src="/assets/js/circleChart.min.js"></script>
    <style>
        body, a, p, h1, h2, h3, h4, h5, h6, ul, li, ol, dl, dt, dd, input, form, button {
            margin: 0;
            padding: 0;
            list-style: none;
            font-family: "微软雅黑" ，Arial, "黑体";
            font-size: 14px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        input，button {
            outline: none;
            box-sizing: content-box;
        }

        body {
            padding: 12px;
            background: #f8f9fa;
        }

        .card {
            overflow: hidden;
        }

        .card > li {
            height: 126px;
            padding: 12px;
            width: 25%;
            box-sizing: border-box;
            display: inline-block;
            float: left;
        }

        .card > li > a > div {
            height: 100%;
            padding: 26px 30px;
            box-sizing: border-box;
            background: #fff;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.06);
            color: #333;
            position: relative;
        }

        .card > li > a > div > h3 {
            font-size: 22px;
            color: #333;
        }

        .card > li > a >  div > p {
            color: #666;
        }

        .card > li > a >  div > i {
            position: absolute;
            right: 30px;
            top: 26px;
            display: block;
            font-size: 40px;
        }

        .charts_box {
            overflow: hidden;
        }

        .charts_box > li {
            height: 420px;
            padding: 12px;
            width: 50%;
            float: left;
            box-sizing: border-box;
            position: relative;
        }

        .charts_box > .last-child {
            width: 100%;
        }

        .charts_box > li > div {
            background: #fff;
            height: 100%;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.06);
            padding: 12px;
            box-sizing: border-box;
        }

        .charts_box > li > div > h3 {
            font-size: 20px;
            font-weight: bold;
        }

        .search {
            position: absolute;
            right: 36px;
            z-index: 1;
        }

        #dateScreen {
            width: 110px;
            border-radius: 4px;
        }

        #dateScreen::-ms-input-placeholder {
            text-align: center;
        }

        #dateScreen::-webkit-input-placeholder {
            text-align: center;
        }

        .layui-input-inline {
            border: 1px solid #919191;
            border-radius: 4px;
        }

        .date_input {
            display: inline-block;
            border: none;
            width: auto;
        }

        .date_icon {
            line-height: 38px;
            font-size: 28px;
            vertical-align: middle;
            margin: 10px;
        }

        .channel {
            overflow: hidden;
            text-align: center;
        }

        .channel > dd {
            display: inline-block;
            width: 20%;
            margin-top: 20px;
        }

        .channel > dd > i {
            display: block;
            font-size: 50px;
            text-align: center;
            line-height: 100px;
        }

        .channel p {
            text-align: center;
            font-size: 18px;
            margin-top: 5px;
        }

        .channel_details {
            position: absolute;
            right: 36px;
            top: 24px;
            line-height: 28px;
            cursor: pointer;
            z-index: 1;
        }

        .channel_details span {
            margin-left: 20px;
        }

        .region_date {
            width: 100px;
        }
    </style>
</head>
<body>
<ul class="card">
    <li>
        <a href="/admin/project/index?status=1">
            <div>
                <h3 class="execute_project">0</h3>
                <p>执行项目</p>
                <i class="layui-icon layui-icon-app"></i>
            </div>
        </a>
    </li>
    <li>
        <a href="/admin/project/index?status=">
        <div>
            <h3 class="expire_project">0</h3>
            <p>即将到期项目</p>
            <i class="layui-icon layui-icon-log"></i>
        </div>
        </a>
    </li>
    <li>
        <a href="/admin/worder/index">
        <div>
            <h3 class="pending_worder">0</h3>
            <p>待处理工单</p>
            <i class="layui-icon layui-icon-engine"></i>
        </div>
        </a>
    </li>
    <li>
        <a href="/admin/invoice/index">
        <div>
            <h3 class="pending_invoice">0</h3>
            <p>代开发票</p>
            <i class="layui-icon layui-icon-form"></i>
        </div>
        </a>
    </li>
</ul>
<script>
    $.ajax({
        url: 'http://pml.zhihuo.com.cn/admin/Pandect/index',
        success: function (data) {
            $('.execute_project').text(data.data.execute_project);
            $('.expire_project').text(data.data.expire_project);
            $('.pending_invoice').text(data.data.pending_invoice);
            $('.pending_worder').text(data.data.pending_worder);
        },
        error: function () {
            console.log('头部请求出错');
        }
    });
</script>
<ul class="charts_box">
    <!-- 月新增曲线 -->
    <li>
        <div>
            <div id="newly" style="width: 100%;height:100%;"></div>
            <script type="text/javascript">
                var xm = [];
                var kh = [];
                var yue1 = [];
                var myChart1 = echarts.init(document.getElementById('newly'));
                myChart1.showLoading({text: '暂无数据...'});

                function chart1() {
                    myChart1.setOption({
                        title: {
                            text: '月新增曲线'
                        },
                        // 提示
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['项目', '客户']
                        },
                        xAxis: {
                            type: 'category',
                            data: yue1
                        },
                        yAxis: [
                            {
                                name: '数量',
                                type: 'value',
                            },
                        ],
                        series: [
                            {
                                name: '项目',
                                type: 'line',
                                data: xm
                            },
                            {
                                name: '客户',
                                type: 'line',
                                data: kh
                            },
                        ]
                    });
                }

                chart1();
                // 项目
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/Pandect/month_xm',
                    dataType: 'json',
                    success: function (data) {
                        yue1 = [];
                        console.log('项目', data);
                        if (kh.length > 0) {
                            myChart1.hideLoading();
                        }
                        for (let i in data.data) {
                            data.data[i].biao = data.data[i].biao.toFixed(2);
                            xm.push(data.data[i].biao); // 每天的数据
                            yue1.push((parseInt(i) + 1) + '月'); // 天
                        }
                        chart1();
                    },
                });
                // 客户
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/Pandect/month_kh',
                    dataType: 'json',
                    success: function (data) {
                        yue1 = [];
                        console.log('客户', data);
                        if (xm.length > 0) {
                            myChart1.hideLoading();
                        }
                        for (let i in data.data) {
                            data.data[i].biao = data.data[i].biao.toFixed(2);
                            kh.push(data.data[i].biao); // 每天的数据
                            yue1.push((parseInt(i) + 1) + '月'); // 天
                        }
                        chart1();
                    },
                });

            </script>
        </div>
    </li>
    <!-- 充值、消费曲线 -->
    <li>
        <div>
            <div id="Top-up" style="width: 100%;height:100%;"></div>
            <script type="text/javascript">
                var consumption = [];
                var recharge = [];
                var yue2 = [];
                var myChart2 = echarts.init(document.getElementById('Top-up'));
                myChart2.showLoading({text: '暂无数据...'});

                function chart2() {
                    myChart2.setOption({
                        title: {
                            text: '充值/消费曲线'
                        },
                        // 提示
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['充值', '消费']
                        },
                        xAxis: {
                            type: 'category',
                            data: yue2,
                        },
                        yAxis: [
                            {
                                name: '金额',
                                type: 'value',
                            },
                        ],
                        series: [
                            {
                                name: '充值',
                                type: 'line',
                                data: recharge,
                            },
                            {
                                name: '消费',
                                type: 'line',
                                data: consumption,
                            },
                        ]
                    });
                }

                chart2();
                // 充值
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/Pandect/month_consumption',
                    dataType: 'json',
                    success: function (data) {
                        yue2 = [];
                        console.log('消费', data);
                        for (let i in data.data) {
                            data.data[i].biao = data.data[i].biao.toFixed(2);
                            consumption.push(data.data[i].biao); // 每天的数据
                            yue2.push((parseInt(i) + 1) + '月'); // 天
                        }
                        if (recharge.length > 0) {
                            myChart2.hideLoading();
                            chart2();
                        }
                    },
                });

                // 消费
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/Pandect/month_recharge',
                    dataType: 'json',
                    success: function (data) {
                        yue2 = [];

                        console.log('充值', data);
                        for (let i in data.data) {
                            data.data[i].biao = data.data[i].biao.toFixed(2);
                            recharge.push(data.data[i].biao); // 每天的数据
                            yue2.push((parseInt(i) + 1) + '月'); // 天
                        }
                        if (consumption.length > 0) {
                            myChart2.hideLoading();
                            chart2();
                        }
                    },
                });
            </script>
        </div>
    </li>
    <!-- 地区排行 -->
    <li>
        <div>
            <div class="channel_details">
                <div class="layui-input-inline">
                    <input type="text" class="layui-input date_input region_date" id="region_date" placeholder="请选择月">
                    <i class="layui-icon date_icon">&#xe637;</i>
                </div>
                <span>更多</span>
            </div>
            <div id="region" style="width: 100%;height:100%;"></div>
            <script type="text/javascript">
                layui.use('laydate', function () {
                    var laydate = layui.laydate;
                    //日期范围
                    laydate.render({
                        elem: '#region_date',
                        type: 'month',
                        done: (value, start) => {
                            let begin = start.year + '/' + start.month + '/' + start.date;
                            console.log(begin);
                        }
                    });
                });
                var myChart3 = echarts.init(document.getElementById('region'));
                myChart3.setOption(
                    {
                        title: {
                            text: '地区排行'
                        },
                        // 提示
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'shadow'
                            }
                        },
                        dataset: { // 数据
                            source: [
                                ['amount', 'product'],
                                [0, '地区'],
                            ]
                        },
                        grid: {containLabel: true},
                        xAxis: {name: ''},
                        yAxis: {type: 'category', name: '地区'},
                        visualMap: {
                            orient: 'horizontal',
                            left: 'center',
                            min: 10,
                            max: 100,
                            text: ['High Score', 'Low Score'],
                            dimension: 0,
                            inRange: {
                                color: ['#D7DA8B', '#E15457']
                            }
                        },
                        series: [
                            {
                                type: 'bar',
                                encode: {
                                    x: 'amount',
                                    y: 'product',
                                },
                            }
                        ],
                    }
                );
            </script>
        </div>
    </li>
    <!-- 优化渠道占比 -->
    <li>
        <div>
            <h3>优化渠道占比</h3>
            <dl class="channel">
                <dd>
                    <div class="baidu"></div>
                    <p>百度PC</p>
                </dd>
                <dd>
                    <div class="baiduyidong"></div>
                    <p>百度移动</p>
                </dd>
                <dd>
                    <div class="sanliuling"></div>
                    <p>360PC</p>
                </dd>
                <dd>
                    <div class="sanliulingyidong"></div>
                    <p>360移动</p>
                </dd>
                <dd>
                    <div class="shenma"></div>
                    <p>神马</p>
                </dd>
                <dd>
                    <div class="sougou"></div>
                    <p>搜狗PC</p>
                </dd>
                <dd>
                    <div class="sougouyidong"></div>
                    <p>搜狗移动</p>
                </dd>
            </dl>
            <!--<span class="channel_details">详情</span>-->

            <script>

                function circle(dom, val) {
                    dom.circleChart({
                        size: 100, // 圆形大小
                        relativeTextSize: 0.2, // 进度条中字体占比
                        color: "#E48516",
                        text: true,
                        backgroundColor: "#384E78", // 进度条之外颜色
                        widthRatio: 0.2, // 进度条宽度
                        value: val,  // 进度条占比
                        onDraw: function (el, circle) {
                            circle.text(Math.round(circle.value) + "%"); // 根据value修改text
                        }
                    });
                }

                var baiduDom = $('.baidu');
                var baiduyidongDom = $('.baiduyidong');
                var sanliulingDom = $('.sanliuling');
                var sanliulingyidongDom = $('.sanliulingyidong');
                var shenmaDom = $('.shenma');
                var sougouDom = $('.sougou');
                var sougouyidongDom = $('.sougouyidong');
                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/Pandect/channel',
                    success: function (data) {
                        console.log('渠道', data);
                        var baidu = (data.data.baidu * 100).toFixed(0);
                        var baiduyidong = (data.data.baiduyidong * 100).toFixed(0);
                        var sanliuling = (data.data.sanliuling * 100).toFixed(0);
                        var sanliulingyidong = (data.data.sanliulingyd * 100).toFixed(0);
                        var shenma = (data.data.shenma * 100).toFixed(0);
                        var sougou = (data.data.sougou * 100).toFixed(0);
                        var sougouyidong = (data.data.sougouyidong * 100).toFixed(0);
                        circle(baiduDom, baidu);
                        circle(baiduyidongDom, baiduyidong);
                        circle(sanliulingDom, sanliuling);
                        circle(sanliulingyidongDom, sanliulingyidong);
                        circle(shenmaDom, shenma);
                        circle(sougouDom, sougou);
                        circle(sougouyidongDom, sougouyidong);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            </script>
        </div>
    </li>
    <!-- 月消费变化曲线 -->
    <li class="last-child">
        <div>
            <div class="search">
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input date_input" autocomplete="off" id="dateScreen"
                               placeholder="请选择月份" style="text-align: center">
                        <i class="layui-icon date_icon">&#xe637;</i>
                    </div>
                </div>
            </div>
            <div id="consume" style="width: 100%;height:100%;"></div>
            <script type="text/javascript">
                var chartData = [];
                var day = [];
                var myChart4 = echarts.init(document.getElementById('consume'));
                myChart4.showLoading({text: '暂无数据...'});

                function chart4() {
                    myChart4.setOption({
                        title: {
                            text: '月消费变化曲线'
                        },
                        // 提示
                        tooltip: {
                            trigger: 'axis'
                        },
                        // legend: {
                        //     data: ['项目']
                        // },
                        xAxis: {
                            type: 'category',
                            data: day,
                        },
                        yAxis: [
                            {
                                name: '消费金额',
                                type: 'value',
                            },
                        ],
                        series: [
                            {
                                name: '项目',
                                type: 'line',
                                data: chartData,
                            },
                        ]
                    });
                }

                $.ajax({
                    url: 'http://pml.zhihuo.com.cn/admin/pandect/reach_graph',
                    dataType: 'json',
                    success: function (data) {
                        for (let i in data.data) {
                            data.data[i].biao = data.data[i].biao.toFixed(2);
                            chartData.push(data.data[i].biao); // 每天的数据
                            day.push(i + '日'); // 天
                        }
                        myChart4.hideLoading();
                        chart4();
                    }
                });
                let begin;
                // 时间筛选
                layui.use('laydate', function () {
                    var laydate = layui.laydate;
                    myChart4.showLoading({text: '暂无数据...'});
                    //日期范围
                    laydate.render({
                        elem: '#dateScreen',
                        type: 'month',
                        done: (value, start, over) => {
                            start.month = start.month < 10 ? '0' + start.month : start.month;
                            begin = start.year + start.month;
                            console.log(begin);
                            console.log('点击了时间筛选');
                            $.ajax({
                                url: 'http://pml.zhihuo.com.cn/admin/Pandect/sx_consumption',
                                dataType: 'json',
                                data: {
                                    staDate: begin,
                                },
                                success: function (data) {
                                    console.log('时间筛选', data.data);
                                    chartData = [];
                                    day = [];
                                    for (let i in data.data) {
                                        data.data[i].xiaofei = data.data[i].xiaofei.toFixed(2);
                                        chartData.push(data.data[i].xiaofei); // 每天的数据
                                        day.push(i + '日'); // 天
                                    }

                                    myChart4.hideLoading();
                                    chart4();
                                },
                            });
                        }
                    });
                });
            </script>
        </div>
    </li>
</ul>
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