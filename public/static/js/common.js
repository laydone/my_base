;;;;
/*公共js方法*/

/*验证码点图切换 Start*/
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
/*验证码点图切换 End*/
/*表单提交 Start*/
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
/*表单提交 End*/

/*列表全选 Start*/
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
