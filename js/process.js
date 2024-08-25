//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}
function getCookies() {
    var c = document.cookie,
        v = 0,
        cookies = {};
    if (document.cookie.match(/^\s*\$Version=(?:"1"|1);\s*(.*)/)) {
        c = RegExp.$1;
        v = 1;
    }
    if (v === 0) {
        c.split(/[,;]/).map(function(cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function($0, $1) {
            var name = $0,
                value = $1.charAt(0) === '"' ?
                $1.substr(1, -1).replace(/\\(.)/g, "$1") :
                $1;
            cookies[name] = value;
        });
    }
    return cookies;
}

function get_cookie(name) {
    return getCookies()[name];
}
$(document).ready(function() {
    if($('.box_page_content').length>0){
        // $([document.documentElement, document.body]).animate({
        //     scrollTop: $(".box_page_content").offset().top
        // }, 700);
    }
    $('.list_tab .tab').click(function(){
        id=$(this).attr('id');
        $('.list_tab').find('.tab').removeClass('active');
        $('.list_box_tab').find('.box_tab').removeClass('active');
        $('.list_box_tab').find('#box_'+id).addClass('active');
        $(this).addClass('active');

    });
    $('input[name=input_search]').on('keyup',function() {
        key=$(this).val();
        if(key.length<2){
            $('.kq_search').hide();
        }else{
            $('.kq_search').show();
            $('.kq_search').html('<center><img src="/images/loading.gif"></center>');
            $.ajax({
                url:'/process.php',
                type:'post',
                data:{
                    action:'goi_y',
                    key:key
                },
                success: function(kq){
                    var info=JSON.parse(kq);
                    $('.kq_search').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    $('input[name=input_search]').keypress(function(e) {
        if (e.which == 13) {
            key = $('input[name=input_search]').val();
            link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
            if(key.length<2){
                $('input[name=input_search]').focus();
            }else{
                window.location.href = link;
            }
            return false;
        }
    });
    /////////////////////////////
    $('.box_search button').click(function() {
        key = $('input[name=input_search]').val();
        link = '/tim-kiem.html?key=' + encodeURI(key).replace(/%20/g, '+');
        if(key.length<2){
            $('input[name=input_search]').focus();
        }else{
            window.location.href = link;
        }
    });
    ////////////////////////
    $("body").keydown(function(e) {
        if($('.content_view_chap').length>0){
            if(e.keyCode == 37) {
                if($('.link-prev-chap').length>0){
                    link=$('.link-prev-chap').attr('href');
                    window.location.href=link;

                }
            }else if(e.keyCode == 39) {
                if($('.link-next-chap').length>0){
                    link=$('.link-next-chap').attr('href');
                    window.location.href=link;
                }
            }
        }else{

        }
    });
    //////////////////////
    $('#button_forgot').on('click', function() {
        email = $('input[name=email]').val();
        if (email.length < 5) {
            $('input[name=email]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "quen_matkhau",
                    email: email
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href='/dang-nhap.html';
                        } else {

                        }
                    }, 3000);
                }

            });

        }
    });
    //////////////////////
    $('#button_login').on('click', function() {
        password = $('input[name=password]').val();
        username = $('input[name=username]').val();
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process_login.php",
                type: "post",
                data: {
                    username: username,
                    password: password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href='/thong-tin.html';
                        } else {

                        }
                    }, 3000);
                }

            });

        }
    });
    //////////////////////
    $('#button_dangky').on('click', function() {
        email = $('input[name=email]').val();
        password = $('input[name=password]').val();
        username = $('input[name=username]').val();
        ma_bao_mat = $('input[name=ma_bao_mat]').val();
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        }else if (email.length<5) {
            $('input[name=email]').focus();
        }else if (ma_bao_mat.length<4) {
            $('input[name=ma_bao_mat]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "register",
                    username: username,
                    password: password,
                    ma_bao_mat:ma_bao_mat,
                    email: email
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $("#captcha").attr('src', 'napthe/securimage/securimage_show.php?sid=' + Math.random());
                        if (info.ok == 1) {
                            window.location.href='/dang-nhap.html';
                        } else {

                        }
                    }, 3000);
                }

            });

        }
    });
    ////////////////////
    $('#btn_napthe').on('click',function(){
        card_type_id=$('select[name=card_type_id]').val();
        price_guest=$('select[name=price_guest]').val();
        pin=$('input[name=pin]').val();
        seri=$('input[name=seri]').val();
        ma_bao_mat=$('input[name=ma_bao_mat]').val();
        if (pin=='') {
            $('input[name=pin]').focus();
        }else if (seri=='') {
            $('input[name=seri]').focus();
        }else if (ma_bao_mat.length<4) {
            $('input[name=ma_bao_mat]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "napthe",
                    card_type_id: card_type_id,
                    price_guest: price_guest,
                    pin: pin,
                    seri:seri,
                    ma_bao_mat:ma_bao_mat
                },
                success: function(kq) {
                    var info=JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.msg);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $("#captcha").attr('src', '/napthe/securimage/securimage_show.php?sid=' + Math.random());
                        if (info.code == 0) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    ////////////////////
    $('#btn_profile').on('click',function(){
        email=$('input[name=email]').val();
        cmnd=$('input[name=cmnd]').val();
        if (email=='') {
            $('input[name=email]').focus();
        }else if (cmnd=='') {
            $('input[name=cmnd]').focus();
        }else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "profile",
                    email: email,
                    cmnd:cmnd
                },
                success: function(kq) {
                    var info=JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $("#captcha").attr('src', 'napthe/securimage/securimage_show.php?sid=' + Math.random());
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    ////////////////////
    $('#btn_password').on('click',function(){
        password_old=$('input[name=password_old]').val();
        password_new=$('input[name=password_new]').val();
        password_new2=$('input[name=password_new2]').val();
        if (password_old.length<6) {
            $('input[name=password_old]').focus();
        }else if (password_new.length<6) {
            $('input[name=password_new]').focus();
        }else if (password_new!=password_new2) {
            $('input[name=password_new2]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "doi_matkhau",
                    password_old: password_old,
                    password_new:password_new,
                    password_new2:password_new2
                },
                success: function(kq) {
                    var info=JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    ////////////////////
});