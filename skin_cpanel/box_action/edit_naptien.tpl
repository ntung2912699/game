<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa nạp tiền</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Loại</label>
                    <input type="text" class="form_control" name="loai" value="{loai}" placeholder="Phương thức...">
                </div>
                <div class="form_group">
                    <label for="">Card Type</label>
                    <input type="text" class="form_control" name="card_type" value="{card_type}" placeholder="Số loại thẻ...">
                </div>
                <div class="form_group">
                    <label for="">Card Pin</label>
                    <input type="text" class="form_control" name="card_pin" value="{card_pin}" placeholder="Nhập Mã thẻ...">
                </div>
                <div class="form_group">
                    <label for="">Serial</label>
                    <input type="text" class="form_control" name="card_serial" value="{card_serial}" placeholder="Nhập số Serial...">
                </div>
                <div class="form_group">
                    <label for="">Price</label>
                    <input type="text" class="form_control" name="card_price" value="{card_price}" placeholder="Nhập số tiền...">
                </div>
                <div class="form_group">
                    <label for="">Tình trạng</label>
                    <select name="status" class="form_control">
                        <option value="">Chọn tình trạng</option>
                        {option_active}
                    </select>
                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button name="edit_naptien" class="button_all"> Lưu lại </button>
            </div>
        </div>
    </div>
</div>