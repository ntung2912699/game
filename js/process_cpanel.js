//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}
function readURL(input,id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#'+id).attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}
function check_link(){
    link=$('.link_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if(info.ok==1){
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                }else{
                    if($('#link_old').length>0){
                        link_old=$('#link_old').val();
                        if(link_old==info.link){
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    }else{
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function check_blank(){
    link=$('.tieude_seo').val();
    if(link.length<2){
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    }else{
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if(info.ok==1){
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                }else{
                    if($('#link_old').length>0){
                        link_old=$('#link_old').val();
                        if(link_old==info.link){
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    }else{
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function tuchoi(id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "tuchoi",
            id: id
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
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function confirm_success(id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "confirm_success",
            id: id
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
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function del(loai,id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
            id: id
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
                    $('#tr_'+id).remove();
                } else {

                }
            }, 2000);
        }

    });
}
function huy(id){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "huy",
            id: id
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
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
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
    setTimeout(function(){
        $('.loadpage').fadeOut();
        $('.page_body').fadeIn();
    },300);
    /////////////////////////////
    $('.box_right_content').on('click','.del_server',function(){
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.box_right_content').on('click','.add_server',function(){
        $('.block_bottom').before('<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>');
    });
    /////////////////////////////
    $('.mh').click(function(){
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function() {
      readURL(this,'preview-minhhoa');
    });
    $('.tieude_seo').on('paste', function(event) {
        if($(this).hasClass('uncheck_blank')){
        }else{
            setTimeout(function(){
                check_blank();
            },1000);
        }
    });
    $('input[name=slug]').on('keyup',function(){
        slug=$(this).val();
        id=$('input[name=id]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "check_slug",
                slug: slug,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.check_slug').html(info.thongbao);
            }

        });
    });
    /////////////////////////////
    $('#cat_auto').on('change',function(){
        cat_auto = $( "#cat_auto option:selected" ).text();
        text = cat_auto.replace(/[-]/g, "");
        link_copy='https://www.clipzui.com/search?k='+text.replace(/\s/g,'+');
        $('input[name=tieu_de]').val(text);
        $('input[name=link_copy]').val(link_copy);

    });
    /////////////////////////////
    $('.drop_down').on('click',function(){
        $('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).find('.drop_menu').is(':visible')) {
            $(this).find('.drop_menu').slideUp('300');
        } else {
            $(this).find('.drop_menu').slideDown('300');
        }
    });
    /////////////////////////////
    $(document).mouseup(function(e) {
        var dr = $(".drop_menu");
        if (!dr.is(e.target) && dr.has(e.target).length === 0) {
            $('.drop_menu').slideUp('300');
        }
    });
    $('input[name=input_search]').keypress(function(e) {
        if (e.which == 13) {
            key=$('input[name=input_search]').val();;
            if(key.length<2){
                $('input[name=input_search]').focus();
            }else{
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url:'/admincp/process.php',
                    type:'post',
                    data:{
                        action:'timkiem',
                        key:key
                    },
                    success: function(kq){
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        var info=JSON.parse(kq);
                        $('.list_baiviet').html(info.list);
                        $('.pagination').hide();
                    }
                });
            }
            return false;
        }
    });
    /////////////////////////////
    $('#ckOk').on('click', function() {
        if ($('#ckOk').is(":checked")) {
            $('#lbtSubmit').attr("disabled", false);
        } else {
            $('#lbtSubmit').attr("disabled", true);
        }
    });
    /////////////////////////////
    $('#txbQuery').keypress(function(e) {
        if (e.which == 13) {
            key = $('#txbQuery').val();
            type = $('input[name=search_type]:checked').val();
            link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////
    $('#btnSearch').on('click', function() {
        key = $('#txbQuery').val();
        type = $('input[name=search_type]:checked').val();
        link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $('.panel-lyrics .panel-heading').on('click', function() {
        var t = $(this);
        var p = $(this).parent().find('.panel-collapse');
        if (t.hasClass("active-panel")) {
            $(this).parent().find('.panel-collapse').slideUp();
        } else {
            $(this).parent().find('.panel-collapse').slideDown();
        }
        /*		if(p.hasClass("active-panel")){
        			setTimeout(function(){
        				$(this).parent().find('.panel-collapse').removeClass('in');
        			},1000);
        		}else{
        			setTimeout(function(){
        				$(this).parent().find('.panel-collapse').addClass('in');
        			},1000);
        		}*/
        $(this).toggleClass('active-panel');

    });
    /////////////////////////////
    $('.item-cat a').on('click', function() {
        $(this).parent().find('div').click();

    });
    /////////////////////////////
    $('.remember').on('click',function(){
        value=$(this).attr('value');
        if(value=='on'){
            $('.remember i').removeClass('fa-check-circle-o');
            $('.remember i').addClass('fa-circle-o');
            $(this).attr('value','off');
        }else{
            $('.remember i').removeClass('fa-circle-o');
            $('.remember i').addClass('fa-check-circle-o');
            $(this).attr('value','on');
        }

    });

    /////////////////////////////
    $('button[name=add_slide]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        vitri=$('select[name=vitri]').val();
        thu_tu=$('input[name=thu_tu]').val();
        active =$('input[name=active]:checked').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'add_slide');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('link', link);
        form_data.append('target', target);
        form_data.append('vitri', vitri);
        form_data.append('thu_tu', thu_tu);
        form_data.append('active', active);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=edit_slide]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        vitri=$('select[name=vitri]').val();
        thu_tu=$('input[name=thu_tu]').val();
        id=$('input[name=id]').val();
        active =$('input[name=active]:checked').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_slide');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('link', link);
        form_data.append('target', target);
        form_data.append('vitri', vitri);
        form_data.append('thu_tu', thu_tu);
        form_data.append('active', active);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.href='/admincp/list-slide';
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=edit_setting]').on('click', function() {
        name = $('input[name=id]').val();
        noidung = tinyMCE.activeEditor.getContent();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                noidung: noidung
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
                        window.location.href='/admincp/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_setting_img]').on('click',function() {
        name=$('input[name=name]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_setting_img');
        form_data.append('file', file_data);
        form_data.append('name', name);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.href='/admincp/list-setting';
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('input[name=loai]').click(function(){
        loai =$('input[name=loai]:checked').val();
        if(loai=='link'){
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').show();
        }else if(loai=='category'){
            $('#select_category').show();
            $('#select_page').hide();
            $('#input_link').hide();            
        }else if(loai=='page'){
            $('#select_category').hide();
            $('#select_page').show();
            $('#input_link').hide();
        }else{
            $('#select_category').hide();
            $('#select_page').hide();
            $('#input_link').show();
        }
    });
    /////////////////////////////
    $('#select_category select').on('change',function(){
        text=$('#select_category select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('#select_page select').on('change',function(){
        text=$('#select_page select option:selected').text();
        $('input[name=tieu_de]').val(text);
    });
    /////////////////////////////
    $('button[name=edit_naptien]').on('click', function() {
        loai = $('input[name=cat_tieude]').val();
        card_type=$('input[name=card_type]').val();
        card_pin=$('input[name=card_pin]').val();
        card_serial=$('input[name=card_serial]').val();
        card_price=$('input[name=card_price]').val();
        id=$('input[name=id]').val();
        tinh_trang=$('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_naptien",
                card_type: card_type,
                card_pin:card_pin,
                card_serial:card_serial,
                card_price:card_price,
                loai:loai,
                tinh_trang:tinh_trang,
                id:id
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
                        window.location.href='/admincp/list-naptien-moi';
                    } else {
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=add_support]').click(function(){
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        thu_tu=$('input[name=thu_tu]').val();
        if(tieu_de.length<2){
            $('input[name=tieu_de]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_support",
                    tieu_de:tieu_de,
                    link:link,
                    target:target,
                    thu_tu:thu_tu
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
                        if(info.ok==1){
                            window.location.reload();
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=edit_support]').click(function(){
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        thu_tu=$('input[name=thu_tu]').val();
        id=$('input[name=id]').val();
        if(tieu_de.length<2){
            $('input[name=tieu_de]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_support",
                    tieu_de:tieu_de,
                    link:link,
                    target:target,
                    thu_tu:thu_tu,
                    id:id
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
                        if(info.ok==1){
                            window.location.href='/admincp/list-support';
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=add_menu]').click(function(){
        loai =$('input[name=loai]:checked').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        thu_tu=$('input[name=thu_tu]').val();
        category=$('select[name=category]').val();
        vitri=$('select[name=vitri]').val();
        if(tieu_de.length<2){
            $('input[name=tieu_de]').focus();
        }else if(loai=='link' && link==''){
            $('input[name=link]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_menu",
                    loai:loai,
                    tieu_de:tieu_de,
                    link:link,
                    target:target,
                    thu_tu:thu_tu,
                    vitri:vitri,
                    category:category
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
                        if(info.ok==1){
                            window.location.reload();
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=edit_menu]').click(function(){
        loai =$('input[name=loai]:checked').val();
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        target=$('select[name=target]').val();
        thu_tu=$('input[name=thu_tu]').val();
        category=$('select[name=category]').val();
        vitri=$('select[name=vitri]').val();
        id=$('input[name=id]').val();
        if(tieu_de.length<2){
            $('input[name=tieu_de]').focus();
        }else if(loai=='link' && link==''){
            $('input[name=link]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_menu",
                    loai:loai,
                    tieu_de:tieu_de,
                    link:link,
                    target:target,
                    thu_tu:thu_tu,
                    category:category,
                    vitri:vitri,
                    id:id
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
                        if(info.ok==1){
                            window.location.href='/admincp/list-menu';
                        }
                    }, 3000);
                }
            });

        }
    });
    /////////////////////////////
    $('button[name=edit_thanhvien]').click(function(){
        accid =$('input[name=accid]').val();
        email=$('input[name=email]').val();
        coin=$('input[name=Coin]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_thanhvien",
                accid:accid,
                coin:coin,
                email:email
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
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('button[name=edit_theloai]').on('click', function() {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank=$('input[name=cat_blank]').val();
        cat_thutu=$('input[name=cat_thutu]').val();
        cat_title=$('input[name=cat_title]').val();
        link_old=$('input[name=link_old]').val();
        cat_description=$('textarea[name=cat_description]').val();
        cat_id=$('input[name=id]').val();
        cat_icon=$('input[name=cat_icon]').val();
        cat_main=$('select[name=cat_main]').val();
        cat_index =$('input[name=cat_index]:checked').val();
        if(cat_tieude.length<2){
            $('input[name=cat_tieude]').focus();
        }else if(cat_thutu==''){
            $('input[name=cat_thutu]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_theloai",
                    cat_tieude: cat_tieude,
                    cat_blank:cat_blank,
                    cat_title:cat_title,
                    cat_description:cat_description,
                    cat_thutu:cat_thutu,
                    cat_main:cat_main,
                    cat_icon:cat_icon,
                    link_old:link_old,
                    cat_index:cat_index,
                    cat_id:cat_id
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
                            window.location.href='/admincp/list-theloai';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_theloai]').on('click', function() {
        cat_tieude = $('input[name=cat_tieude]').val();
        cat_blank = $('input[name=cat_blank]').val();
        cat_thutu=$('input[name=cat_thutu]').val();
        cat_title=$('input[name=cat_title]').val();
        cat_description=$('textarea[name=cat_description]').val();
        cat_main=$('select[name=cat_main]').val();
        cat_icon=$('input[name=cat_icon]').val();
        cat_index =$('input[name=cat_index]:checked').val();
        if(cat_tieude.length<2){
            $('input[name=cat_tieude]').focus();
        }else if(cat_thutu==''){
            $('input[name=cat_thutu]').focus();
        }else{
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_theloai",
                    cat_tieude: cat_tieude,
                    cat_blank:cat_blank,
                    cat_title:cat_title,
                    cat_description:cat_description,
                    cat_main:cat_main,
                    cat_icon:cat_icon,
                    cat_index:cat_index,
                    cat_thutu:cat_thutu
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
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=login]').on('click', function() {
        password = $('input[name=password]').val();
        username = $('input[name=username]').val();
        remember=$('.remember').attr('value');
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process_login.php",
                type: "post",
                data: {
                    action: "dangnhap",
                    username: username,
                    password: password,
                    remember:remember
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
                            window.location.href='/admincp/dashboard';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=forgot_password]').on('click', function() {
        email= $('input[name=email]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "forgot_password",
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
                }, 3000);
                setTimeout(function(){
                    if (info.ok == 1) {
                        window.location.href='/forgot-password?step=2';
                    } else {

                    }
                },3500);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_naptien]').on('click', function() {
        username = $('input[name=username]').val();
        loai = $('input[name=loai]').val();
        coin = $('input[name=coin]').val();
        if (username.length < 2) {
            $('input[name=username]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_naptien",
                    username: username,
                    coin: coin,
                    loai:loai
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } else {

                    }
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('button[name=button_profile]').on('click', function() {
        name = $('input[name=name]').val();
        mobile = $('input[name=mobile]').val();
        if (name.length < 2) {
            $('input[name=name]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_profile",
                    name: name,
                    mobile: mobile
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        setTimeout(function() {
                            //window.location.reload();
                        }, 3000);
                    } else {

                    }
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('.button_change_avatar').click(function(){
    	$('#file').click();
    });
    /////////////////////////////
    $('.cover_now .button_change').click(function(){
    	$('#file_cover').click();
    });
    /////////////////////////////
    $('#register-open-avatar').click(function(){
        $('#minh_hoa').click();
    });
    /////////////////////////////
    $('button[name=add_post]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        short_description=$('textarea[name=short_description]').val();
        title=$('input[name=title]').val();
        description=$('textarea[name=description]').val();
        noidung = tinyMCE.activeEditor.getContent();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat=list_cat.toString();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'add_post');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('short_description', short_description);
        form_data.append('title', title);
        form_data.append('cat', list_cat);
        form_data.append('link', link);
        form_data.append('description', description);
        form_data.append('noidung', noidung);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_post]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        short_description=$('textarea[name=short_description]').val();
        title=$('input[name=title]').val();
        description=$('textarea[name=description]').val();
        link=$('input[name=link]').val();
        link_old=$('input[name=link_old]').val();
        noidung = tinyMCE.activeEditor.getContent();
        var list_cat = [];
        $('.li_input input:checked').each(function() {
            list_cat.push($(this).val());
        });
        list_cat=list_cat.toString();
        id=$('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_post');
        form_data.append('file', file_data);
        form_data.append('tieu_de', tieu_de);
        form_data.append('link', link);
        form_data.append('link_old', link_old);
        form_data.append('short_description', short_description);
        form_data.append('title', title);
        form_data.append('cat', list_cat);
        form_data.append('description', description);
        form_data.append('noidung', noidung);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=add_page]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        link=$('input[name=link]').val();
        title=$('input[name=title]').val();
        description=$('textarea[name=description]').val();
        noidung = tinyMCE.activeEditor.getContent();
        var form_data = new FormData();
        form_data.append('action', 'add_page');
        form_data.append('tieu_de', tieu_de);
        form_data.append('title', title);
        form_data.append('link', link);
        form_data.append('description', description);
        form_data.append('noidung', noidung);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_page]').on('click',function() {
        tieu_de=$('input[name=tieu_de]').val();
        title=$('input[name=title]').val();
        description=$('textarea[name=description]').val();
        link=$('input[name=link]').val();
        link_old=$('input[name=link_old]').val();
        noidung = tinyMCE.activeEditor.getContent();
        id=$('input[name=id]').val();
        var form_data = new FormData();
        form_data.append('action', 'edit_page');
        form_data.append('tieu_de', tieu_de);
        form_data.append('link', link);
        form_data.append('link_old', link_old);
        form_data.append('title', title);
        form_data.append('description', description);
        form_data.append('noidung', noidung);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_password]').on('click', function() {
        old_pass = $('input[name=password_old]').val();
        new_pass = $('input[name=password]').val();
        confirm = $('input[name=confirm]').val();
        if (old_pass.length < 6) {
            $('input[name=password_old]').focus();
        } else if (new_pass.length < 6) {
            $('input[name=password]').focus();
        } else if (new_pass != confirm) {
            $('input[name=confirm]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm
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
                        if(info.ok==1){
                            $('input[name=password_old]').val('');
                            $('input[name=password]').val('');
                            $('input[name=confirm]').val('');
                        }
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('input[name=goi_y]').on('keyup',function(){
        tieu_de=$(this).val();
        cat=$('select[name=category]').val();
        if(tieu_de.length<2){
        }else{
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat:cat,
                    tieu_de: tieu_de
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.khung_goi_y ul').html(info.list);
                    if(info.list.length>10){
                        $('.khung_goi_y').show();
                    }else{
                        $('.khung_goi_y').hide();

                    }
                }

            });

        }
        e.stopPropagation();
    });
    /////////////////////////////
    $('.khung_sanpham').on('click','ul li i',function(){
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.khung_goi_y').on('click','ul li',function(e){
        text=$(this).find('span').text();
        id=$(this).attr('value');
        $('.khung_sanpham ul').prepend('<li value="'+id+'"><i class="icon icofont-close-circled"></i><span>'+text+'</span></li>');
        e.stopPropagation();
    });
    /////////////////////////////
    $(document).click(function(){
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
});