layui.config({
    base: '/static/layuiadmin/'
}).use(['jquery', 'element', 'form', 'xlsx'], function () {
    var $ = layui.$
        , element = layui.element
        , form = layui.form
        , layer = layui.layer;
    var words = eval($('#words').val()), positive_word = [], negative_word = [], keywords = [];
    if (words) {
        for (var i = 0; i < words.length; i++) {
            keywords.push(words[i].key);
            positive_word = $.merge(positive_word, words[i].positive);
            negative_word = $.merge(negative_word, words[i].negative);
        }
        positive_word = $.unique(positive_word);
        negative_word = $.unique(negative_word);
    }
    $(document).on('click', '#word li', function () {
        if ($(this).hasClass('on')) {
            $(this).removeClass('on');
        } else {
            $(this).addClass('on');
        }
    });

    function add_word(keyword) {
        var word = {};
        if (keyword) {
            if (!(keyword in keywords)) {
                keywords.push(keyword);
                word.key = keyword;
                word.positive = positive_word.slice(0);
                word.negative = negative_word.slice(0);
                console.log(word);
                if (word.positive.length > 0) {
                    for (var i = 0; i <= word.positive.length - 1; i++) {
                        $('#word').append("<li class='block'><input type='checkbox' title='" + word.key + "&" + word.positive[i] +
                            "' lay-skin='primary' lay-filter='choose'></li>")
                    }
                }
                if (word.negative.length > 0) {
                    for (var i = 0; i <= word.negative.length - 1; i++) {
                        $('#word').append("<li class='block'><input type='checkbox' title='" + word.key + "&" + word.negative[i] +
                            "' lay-skin='primary' lay-filter='choose'></li>")
                    }
                }
                if (word.positive == 0 && word.negative == 0) {
                    $('#word').append("<li class='block'><input type='checkbox' title='" + word.key +
                        "' lay-skin='primary' lay-filter='choose'></li>")
                }
                form.render();
                words.push(word);
            }
        }
    }

    function add_positive(positive) {
        if (positive) {
            if (positive_word.length == 0 && negative_word.length == 0) {
                $('#word').children().remove();
            }
            if (!(positive in positive_word)) {
                positive_word.push(positive);
                console.log(words);
                for (var i = 0; i < words.length; i++) {
                    console.log(i);
                    console.log(words[i]);
                    if (!(positive in words[i].positive)) {
                        $('#word').append("<li class='block'><input type='checkbox' title='" + words[i].key + "&" + positive +
                            "' lay-skin='primary' lay-filter='choose'></li>");
                        words[i].positive.push(positive);
                    }
                }
                form.render();
            }
        }
    }

    function add_negative(negative) {
        if (negative) {
            if (positive_word.length == 0 && negative_word.length == 0) {
                $('#word').children().remove();
            }
            if (!(negative in negative_word)) {
                negative_word.push(negative);
                for (var i = 0; i <= words.length - 1; i++) {
                    if (!(negative in words[i].negative)) {
                        $('#word').append("<li class='block'><input type='checkbox' title='" + words[i].key + "&" + negative +
                            "' lay-skin='primary' lay-filter='choose'></li>");
                        words[i].negative.push(negative)
                    }
                }
                form.render();
            }
        }
    }

    // 批量导入关键词
    $('#file').change(function (e) {
        var files = e.target.files;
        var name = files[0].name.split('.')[1];
        // console.log(typeof(name));return;

        if (name === 'xls' || name === 'xlsx') {
            $('.add_key_name').html(files[0].name)
            var fileReader = new FileReader();
            fileReader.onload = function (ev) {
                try {
                    var data = ev.target.result,
                        workbook = XLSX.read(data, {
                            type: 'binary'
                        }), // 以二进制流方式读取得到整份excel表格对象
                        persons = []; // 存储获取到的数据
                } catch (e) {
                    layer.alert('文件类型不正确！', {
                        icon: 2,
                        title: '错误提示'
                    });
                    return;
                }

                // 表格的表格范围，可用于判断表头是否数量是否正确
                var fromTo = '';
                // 遍历每张表读取
                for (var sheet in workbook.Sheets) {
                    if (workbook.Sheets.hasOwnProperty(sheet)) {
                        fromTo = workbook.Sheets[sheet]['!ref'];
                        console.log(fromTo);
                        persons = persons.concat(XLSX.utils.sheet_to_json(workbook.Sheets[sheet]));
                        break; // 如果只取第一张表，就取消注释这行
                    }
                }
                for (var j = 0; j < persons.length; j++) {
                    var positive = persons[j]['正面情感词'], negative = persons[j]['负面情感词'],
                        keyword = persons[j]['关键词'];
                    add_word(keyword);
                    add_positive(positive);
                    add_negative(negative);
                }
            };

            // 以二进制方式打开文件
            fileReader.readAsBinaryString(files[0]);
        } else {
            layer.alert('文件类型不正确,请按模板上传.xls或.xlsx文件！', {
                icon: 2,
                title: '错误提示'
            });
            return false;
        }
        // if('xls'!= name || 'xlsx'!= name){
        //     alert(1);return;
        // }

    });
    // 批量导入关键词结束

    $('.add_key_parts').on('click', function () {
        $('input.keyword').each(function () {
            var keyword = $(this).val();
            add_word(keyword);
        });
        $('input.keyword').val('');

        $('input.negative').each(function () {
            var negative = $(this).val();
            add_negative(negative);
        });
        $('input.negative').val('');
        $('input.positive').each(function () {
            var positive = $(this).val();
            add_positive(positive);
        });
        $('input.positive').val('');
    });

    $('.add_key_del').on('click', function () {
        var key = [];
        $('#word li').each(function (index, item) {
            if (item.children[0].checked) {
                key.push(item.children[0].title);
                // var keys = item.children[0].title.split('&');
            }
        });
        console.log(key);
        var text = key.join(';');
        if (key.length > 0) {
            layer.confirm(text, {
                btn: ['确定', '取消'],
                title: '关键词组删除确认'
            }, function (index, layero) {
                $('#word li').each(function (index, item) {
                    if (item.children[0].checked) {
                        var keys = item.children[0].title.split('&');
                        for (var j = 0; j <= words.length - 1; j++) {
                            if (words[j].key == keys[0]) {
                                if (words[j].positive.indexOf(keys[1]) >= 0) {
                                    words[j].positive.splice(words[j].positive.indexOf(keys[1]), 1);
                                    positive_word.splice(words[j].positive.indexOf(keys[1]), 1);
                                } else if (words[j].negative.indexOf(keys[1]) >= 0) {
                                    words[j].negative.splice(words[j].negative.indexOf(keys[1]), 1);
                                    negative_word.splice(words[j].positive.indexOf(keys[1]), 1);
                                }
                            }
                            if (words[j].positive.length == 0 && words[j].negative == 0) {
                                words.splice(j, 1)
                            }
                        }
                        item.remove();
                    }
                    form.render();
                });
                layer.close(index);
            });
        } else {
            layer.confirm('请选择要删除的关键词！', {
                icon: 0,
                title: '提示'
            });
        }
    });

    $('#back').on('click', function () {
        window.location.href = '/project/' + window.location.pathname.replace(/[^0-9]/ig, "") + '/edit/';
    });
    form.on('submit(component-form-demo1)', function () {
        if (words.length > 0) {
            console.log(JSON.stringify(words));
            var data = {
                "csrfmiddlewaretoken": $('input[name="csrfmiddlewaretoken"]').val(),
                "words": JSON.stringify(words)
            };
            $.ajax({
                url: window.location.pathname,
                type: 'POST',
                traditional: true,
                data: data,
                dataType: "json",
                success: function (res) {
                    console.log(res);
                    if (res.code == 1) {
                        window.location.href = '/project/' + window.location.pathname.replace(/[^0-9]/ig, "") + '/setting/';
                    } else if (res.code == 0) {
                        layer.alert('该项目不存在或项目已经开始执行！', {
                            icon: 2,
                            title: '错误提示'
                        });
                    } else if (res.code == 4) {
                        layer.alert('系统错误！请联系管理员。', {
                            icon: 2,
                            title: '错误提示'
                        });
                    }
                }
            });
        } else {
            layer.alert('请添加关键词！', {
                icon: 2,
                title: '错误提示'
            });
        }
        return false;
    });

// will
// 添加关键词
    $(".add_project_key .layui-btn").on('click', function () {
        $(this).parent().before("<li><input type='text' autocomplete='off' class='" + $(this).parent().prev().children().prop("className") + "'></li>");
        $('input.layui-input').attr('maxlength', '30');
    });
    $('input.layui-input').attr('maxlength', '30');
    // $('input.layui-input').bind('keyup', function () {
    //     this.value = this.value.replace(/\s+/g, '')
    // });
// 添加关键词结束
// 批量导入关键词
// if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE9.0") {
//     $(document).on('change', 'input[type="file"]', function () {
//         var type = this.value.substring(this.value.lastIndexOf(".") + 1).toLowerCase();
//         var regval = this.value.substring(this.value.lastIndexOf("\\") + 1).toLowerCase();
//         if ('xls' != type && 'xlsx' != type) {
//             $(this).val('');
//             layer.alert('请上传.xls,.xlsx文件', {
//                 title: '错误提示',
//                 icon: 2
//             });
//         } else {
//             $(this).parent().prev().html(regval);
//             $(this).parents('.clear').children('input[type="text"]').attr('value', regval)
//         }
//     })
// } else {
//     $(document).on('change', 'input[type="file"]', function () {
//         var file = $(this).get(0).files[0];
//         console.log(file['type']);
//         if ('application/vnd.ms-excel' != file['type'] && 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' != file['type']) {
//             $(this).val('');
//             layer.alert('请上传.xls,.xlsx文件', {
//                 title: '错误提示',
//                 icon: 2
//             });
//         } else {
//             $(this).parent().prev().html(file['name']);
//             $(this).parents('.clear').children('input[type="text"]').attr('value', file['name'])
//
//         }
//     });
// }
// 批量导入关键词结束
// 全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('.add_project_check').find('input[type="checkbox"]');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
// 通过判断机构是否全部选中来确定全选按钮是否选中
    form.on("checkbox(choose)", function (data) {
        var child = $(data.elem).parents('.add_project_confirm').find('input[type="checkbox"]');
        var childChecked = $(data.elem).parents('.add_project_confirm').find('input[type="checkbox"]:checked')
        if (childChecked.length == child.length) {
            $(data.elem).parents('.add_project_check').find('input#allChoose').get(0).checked = true;
        } else {
            $(data.elem).parents('.add_project_check').find('input#allChoose').get(0).checked = false;
        }
        form.render('checkbox');
    })
// 全选结束
})
;
