/*公共js方法*/

/*验证码点图切换*/
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
/*表单提交*/
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


// $('.js_form').submit(function() {
//     var _form = $(this);
//     var _data = _form.serialize();
//     var _url = _form.attr('action');
//     $.post(_url, _data, function(res, textStatus, xhr) {
//         console.log(res);
//         if (res.code == 1) {
//             location.href = res.url;
//         } else {
//             /* TODO:错误提示*/
//             $('.js_tips').removeClass('text_success').addClass('text_error').text(res.msg);

//             /*刷新验证码*/
//             if ($('.js_verify_img') != undefined) {
//                 $('.js_verify_img').click();
//             }
//         }
//     });
//     return false;
// });

// $('.js_submit').on('click', function(event) {
//     console.log('114');
//     $(this).parents('.js_form').submit();

// });
// $('.js_form').keydown(function(event) {
//     console.log('115');
//     var e = event || window.event;
//     if (e && e.keyCode == 13) {
//         $(this).submit();

//     }

// });

/*表单提交*/