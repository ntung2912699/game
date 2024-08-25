<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa menu</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="">kiểu menu</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="loai" value="link" checked="checked">Liên kết ngoài  <input type="radio" name="loai" value="category"> Danh mục
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Thuộc menu</label>
                    <select class="form_control" name="vitri">
                        <option value="">Vui lòng chọn</option>
                        <option value="menu_left">Bên trái logo</option>
                        <option value="menu_right">Bên phải logo</option>
                        <option value="footer">Cuối trang</option>
                    </select>
                </div> 
                <div class="form_group" style="display: none;" id="select_category">
                    <label for="">Chọn thể loại</label>
                    <select class="form_control" name="category">
                        <option>Chọn thể loại</option>
                    	{option_category}
                    </select>
                </div> 
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="{menu_tieude}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group" id="input_link">
                    <label for="">Link</label>
                    <input type="text" class="form_control" name="link" value="{menu_link}" placeholder="Nhập title...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu mở</label>
                    <select class="form_control" name="target">
                        <option value="">Cửa sổ hiện tại</option>
                        <option value="_blank">Cửa sổ mới</option>
                    </select>
                </div>               
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{menu_thutu}" placeholder="Nhập thứ tự...">
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{menu_id}">
                <button name="edit_menu" class="button_all"> Lưu lại </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var loai ='{menu_loai}';
    var menu_cat='{menu_cat}';
    var menu_vitri='{menu_vitri}';
    var menu_link='{menu_link}';
    var target = '{menu_target}';
    if(loai=='link'){
        $('#select_category').hide();
        $('#input_link').show();
    }else if(loai=='category'){
        $('#select_category').show();
        $('#input_link').hide();
        $('select[name=category]').val(menu_cat);            
    }else{
        $('#select_category').hide();
        $('#input_link').show();
    }
    $('select[name=target]').val(target);
    $('select[name=vitri]').val(menu_vitri);
    $("input[name=loai][value=" + loai + "]").prop('checked', true);
</script>