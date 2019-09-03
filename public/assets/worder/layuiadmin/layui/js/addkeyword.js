layui.use(['jquery', 'element', 'form'], function () {
    var $ = layui.$
        , element = layui.element
        , form = layui.form
        ,layer = layui.layer;
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
    // $('#keyword').on('click', function () {
    //     $('input.keyword').each(function () {
    //         var word = {};
    //         var keyword = $(this).val();
    //         if (keyword) {
    //             if (!(keyword in keywords)) {
    //                 keywords.push(keyword);
    //                 word.key = keyword;
    //                 word.positive = positive_word.slice(0);
    //                 word.negative = negative_word.slice(0);
    //                 console.log(word);
    //                 if (word.positive.length > 0) {
    //                     for (var j = 0; j <= word.positive.length - 1; j++) {
    //                         $('#word').append("<li class='block'><span class='my-spen'>" + word.key + "&" + word.positive[j] + "</span>" +
    //                             "<i class=\"layui-icon-close-fill layui-icon my-icon\"></i>\n" +
    //                             "  <i class=\"layui-icon-ok-circle layui-icon my-icon\"></i></li>")
    //                     }
    //                 }
    //                 if (word.negative.length > 0) {
    //                     for (var i = 0; i <= word.negative.length - 1; i++) {
    //                         $('#word').append("<li class='block'><span class='my-spen'>" + word.key + "&" + word.negative[i] + "</span>" +
    //                             "<i class=\"layui-icon-close-fill layui-icon my-icon\"></i>\n" +
    //                             " <i class=\"layui-icon-ok-circle layui-icon my-icon\"></i></li>")
    //                     }
    //                 }
    //                 if (word.positive == 0 && word.negative == 0) {
    //                     $('#word').append("<li class='block'><span class='my-spen'>" + word.key + "</span>" +
    //                         "<i class=\"layui-icon-close-fill layui-icon my-icon\"></i>\n" +
    //                         " <i class=\"layui-icon-ok-circle layui-icon my-icon\"></i></li>")
    //                 }
    //                 words.push(word);
    //             }
    //         }
    //     });
    //     console.log(words);
    //     $('input.keyword').val('')
    // });
    // $('#positive').on('click', function () {
    //     console.log($('input.positive'));
    //     $('input.positive').each(function () {
    //         var positive = $(this).val();
    //         if (positive) {
    //             if (positive_word.length == 0 && negative_word.length == 0) {
    //                 $('#word').children().remove();
    //             }
    //             if (!(positive in positive_word)) {
    //                 positive_word.push(positive);
    //                 console.log(words);
    //                 for (var i = 0; i < words.length; i++) {
    //                     console.log(i);
    //                     console.log(words[i]);
    //                     if (!(positive in words[i].positive)) {
    //                         $('#word').append("<li class='block'><span class='my-spen'>" + words[i].key + "&" + positive + "</span>" +
    //                             "<i class=\"layui-icon-close-fill layui-icon my-icon\"></i>\n" +
    //                             "                            <i class=\"layui-icon-ok-circle layui-icon my-icon\"></i></li>");
    //                         words[i].positive.push(positive);
    //                     }
    //                 }
    //             }
    //         }
    //     });
    //     $('input.positive').val('');
    // });
    // $('#negative').on('click', function () {
    //     console.log($('input.negative'));
    //     $('input.negative').each(function () {
    //         var negative = $(this).val();
    //         if (negative) {
    //             if (positive_word.length == 0 && negative_word.length == 0) {
    //                 $('#word').children().remove();
    //             }
    //             if (!(negative in negative_word)) {
    //                 negative_word.push(negative);
    //                 for (var i = 0; i <= words.length - 1; i++) {
    //                     if (!(negative in words[i].negative)) {
    //                         $('#word').append("<li class='block'><span class='my-spen'>" + words[i].key + "&" + negative + "</span>" +
    //                             "<i class=\"layui-icon-close-fill layui-icon my-icon\"></i>\n" +
    //                             "                            <i class=\"layui-icon-ok-circle layui-icon my-icon\"></i></li>");
    //                         words[i].negative.push(negative)
    //                     }
    //                 }
    //             }
    //         }
    //     });
    //     $('input.negative').val('');
    // });
    // form.on('checkbox(form-checkbox)', function (data) {
    //     if (data.elem.checked) {
    //         $('#btn').show();
    //         $('#word').removeClass();
    //         $('#word li').removeClass('on');
    //         if (data.elem.id == 'all_choose') {
    //             $('#choose').removeAttr('checked');
    //             $('#del').removeAttr('checked');
    //             form.render();
    //             $('#word').addClass('choose');
    //             $('#word li').addClass('on');
    //         } else if (data.elem.id == 'del') {
    //             $('#choose').removeAttr('checked');
    //             $('#all_choose').removeAttr('checked');
    //             form.render();
    //             $('#word').addClass('del');
    //         } else if (data.elem.id == 'choose') {
    //             $('#del').removeAttr('checked');
    //             $('#all_choose').removeAttr('checked');
    //             form.render();
    //             $('#word').addClass('choose');
    //         }
    //     } else {
    //         $('#btn').hide();
    //         if (data.elem.id == 'all_choose') {
    //             $('#word').removeClass('choose');
    //             $('#word li').removeClass('on');
    //         } else if (data.elem.id == 'del') {
    //             $('#word').removeClass('del');
    //         } else if (data.elem.id == 'choose') {
    //             $('#word').removeClass('choose');
    //         }
    //     }
    // });
    $('#btn').on('click', function () {
        if ($('#word').is('.del')) {
            $('#word li').each(function () {
                if ($(this).hasClass('on')) {
                    var keys = $(this).children('span').text().split('&');
                    for (var j = 0; j <= words.length - 1; j++) {
                        if (words[j].key == keys[0]) {
                            if (words[j].positive.indexOf(keys[1]) >= 0) {
                                words[j].positive.splice(words[j].positive.indexOf(keys[1]), 1);
                            } else if (words[j].negative.indexOf(keys[1]) >= 0) {
                                words[j].negative.splice(words[j].negative.indexOf(keys[1]), 1);
                            }
                        }
                        if (words[j].positive.length == 0 && words[j].negative == 0) {
                            words.splice(j, 1)
                        }
                    }
                    $(this).remove();
                }
            })
        } else if ($('#word').is('.choose')) {
            $('#word li').each(function () {
                if (!($(this).hasClass('on'))) {
                    var keys = $(this).children('span').text().split('&');
                    for (var j = 0; j <= words.length - 1; j++) {
                        if (words[j].key == keys[0]) {
                            if (words[j].positive.indexOf(keys[1]) >= 0) {
                                words[j].positive.splice(words[j].positive.indexOf(keys[1]), 1);
                            } else if (words[j].negative.indexOf(keys[1]) >= 0) {
                                words[j].negative.splice(words[j].negative.indexOf(keys[1]), 1);
                            }
                        }
                        if (words[j].positive.length == 0 && words[j].negative == 0) {
                            words.splice(j, 1)
                        }
                    }
                    $(this).remove();
                }
            })
        }
        $('#word').removeClass();
        $('#word li').removeClass('on');
        $('#inp input').removeAttr('checked');
        form.render();
        $('#btn').hide();
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
                    }
                }
            });
        } else {

        }
        return false;
    });

    // will
    // 添加关键词
    $(".add_project_key .layui-btn").on('click',function(){
        $(this).parent().before("<li><input type='text' autocomplete='off' class='layui-input keyword'></li>");
    })
    // 添加关键词结束
    // 批量导入关键词
    if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE9.0"){
        $(document).on('change', 'input[type="file"]', function () {
            var type = this.value.substring(this.value.lastIndexOf(".")+1).toLowerCase();
            var regval = this.value.substring(this.value.lastIndexOf("\\")+1).toLowerCase();
            if ('xls' != type && 'xlsx' != type) {
                $(this).val('');
                layer.alert('请上传.xls,.xlsx文件', {
                    title: '错误提示',
                    icon: 2
                });
            }else{
                $(this).parent().prev().html(regval);
                $(this).parents('.clear').children('input[type="text"]').attr('value',regval)
            }
        })
    }else{
        $(document).on('change', 'input[type="file"]', function () {
            var file = $(this).get(0).files[0];
            console.log(file['type']);
            if ('application/vnd.ms-excel' != file['type'] && 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' != file['type']) {
                $(this).val('');
                layer.alert('请上传.xls,.xlsx文件', {
                    title: '错误提示',
                    icon: 2
                });
            } else {
                $(this).parent().prev().html(file['name']);
                $(this).parents('.clear').children('input[type="text"]').attr('value',file['name'])

            }
        });
    }
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
});
