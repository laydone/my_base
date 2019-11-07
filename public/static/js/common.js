;;;;
/* 公共js方法 */

/* 验证码点图切换 Start */
$('.js_verify_img').on('click', function(event) {
    var _this = $(this);
    var _url = _this.data('change_url');
    $.get(_url, function(res) {
        if (res.code == 1) {
            _this.attr('src', res.url);
            _this.parents('.js_verify_group').find('.js_verify_input').val('');
        }
    });
});
/* 验证码点图切换 End */
/* 表单提交 Start */
let $form = $('.js_form');
$form.on('submit', function() {
    var _data = $form.serialize();
    var _url = $form.attr('action');
    $.post(_url, _data, function(res, textStatus, xhr) {
        console.log(res);
        if (res.code == 1) {
            location.href = res.url;
        } else {
            /* TODO:错误提示*/
            $('.js_tips').removeClass('text_success').addClass('text_error').text(res.msg);

            /*刷新验证码*/
            if ($('.js_verify_img') != undefined) {
                $('.js_verify_img').click();
            }
        }
    });
    return false;
}).on('keydown', function(evenet) {
    var e = event || window.event;
    if (e && e.keyCode == 13) {
        $form.submit();
        return false;
    }
}).find('.js_submit').on('click', function() {
    $form.submit();
});
/* 表单提交 End */

/* 列表全选 Start */
let $check_table = $('.js_checked_table');
$check_table.on('click', '.js_checked_all', function(event) {
    if ($(this).prop('checked') == true) {
        $check_table.find('.js_checked_item').each(function() {
            $(this).prop('checked', true);
        });
    } else {
        $check_table.find('.js_checked_item').each(function() {
            $(this).prop('checked', false);
        });
    }
});
/* 列表全选 End*/

/* 每页显示条数选择 Start */
let $page_length = $('.js_page_length');
$page_length.on('change', '.js_page_select', function(event) {
    var _form_data = $page_length.serialize();
    var _url = $page_length.attr('action');
    $.post(_url, _form_data, function(data, textStatus, xhr) {
        if (textStatus == 'success') {
            location.href = _url;
        }
    });
});
/* 每页显示条数选择 End */

/* 无刷新按钮 Start */
let $ajax_post = $('.js_ajax_get');
$ajax_post.on('click', function(event) {
    var _url;
    if ($(this).attr('href') != undefined) {
        _url = $(this).attr('href');
    } else if ($(this).data('url') != undefined) {
        _url = $(this).data('url');
    }
    if (_url == undefined) {
        return false;
    }

    console.log(_url);
    $.get(_url, function(data) {
        /*TODO:ajax请求返回结果提示*/
        console.log(data);
    });
    return false;
});
/* 无刷新按钮 End */