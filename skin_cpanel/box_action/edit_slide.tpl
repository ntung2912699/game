<!-- <script type="text/javascript" src="/tinymce/js/tinymce/tinymce.min.js"></script> -->
<script type="text/javascript" src="/tinymce_4.4.3/tinymce.min.js"></script>
<!-- <script type="text/javascript" src="/tinymce_4.4.3/jquery.tinymce.min.js"></script> -->
<script type="text/javascript">
tinymce.init({
    selector: '#edit_textarea',
    mode: "exact",
    theme: "modern",
    image_advtab: true,
    menubar: false,
    height: "250px",
    tabindex: 2,
    relative_urls: false,
    browser_spellcheck: true,
    forced_root_block: false,
    entity_encoding: "raw",
    content_css: "/tinymce_4.4.3/content.css",
    fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
    plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
    toolbar1: "undo redo forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | link unlink | bullist numlist | image searchreplace code | removeformat fullscreen",
    file_picker_callback: function(callback, value, meta) {
        // File type
        if (meta.filetype == "media" || meta.filetype == "image") {
            // Trigger click on file element
            $("#fileupload").trigger("click");
            $("#fileupload").unbind('change');
            // File selection
            $("#fileupload").on("change", function() {
                var file = this.files[0];
                var reader = new FileReader();
                // FormData
                var fd = new FormData();
                var files = file;
                fd.append("action", "upload_tinymce");
                fd.append("file", files);
                // AJAX
                $.ajax({
                    url: "/google/process.php",
                    type: "post",
                    data: fd,
                    contentType: false,
                    processData: false,
                    async: false,
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        filename = info.minh_hoa;
                    }
                });
                reader.onload = function(e) {
                    callback(filename);
                };
                reader.readAsDataURL(file);
            });
        }
    }
});
</script>
<script type="text/javascript">
tinymce.init({
    selector: '#edit_short',
    mode: "exact",
    theme: "modern",
    image_advtab: true,
    menubar: false,
    height: "250px",
    tabindex: 2,
    relative_urls: false,
    browser_spellcheck: true,
    forced_root_block: false,
    entity_encoding: "raw",
    content_css: "/tinymce_4.4.3/content.css",
    fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
    plugins: "advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace",
    toolbar1: "undo redo forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | link unlink | removeformat fullscreen",
});
</script>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chỉnh sửa slide</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_50">
                <div class="form_group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form_control" name="tieu_de" value="{tieu_de}" placeholder="Nhập tiêu đề...">
                </div>
                <div class="form_group">
                    <label for="">Minh họa</label>
                    <div style="clear: both;"></div>
                    <input type="file" id="minh_hoa" class="form_control" name="minh_hoa" placeholder="Nhập link ảnh minh họa">
                </div>
                <div class="form_group">
                    <label for="">Link</label>
                    <input type="text" class="form_control" name="link" value="{link}" placeholder="Nhập link...">
                </div>
                <div class="form_group">
                    <label for="">Kiểu mở</label>
                    <select name="target" class="form_control">
                        <option value="_blank">Cửa sổ mới</option>
                        <option value="">Cửa số hiện tại</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Vị trí</label>
                    <select name="vitri" class="form_control">
                        <option value="1">Slide home 1</option>
                        <option value="2">Slide home 2</option>
                        <option value="3">Slide detail</option>
                    </select>
                </div>
                <div class="form_group">
                    <label for="">Thứ tự</label>
                    <input type="text" class="form_control" name="thu_tu" value="{thu_tu}" placeholder="Nhập thứ tự hiển thị..">
                </div>
                <div class="form_group">
                    <label for="">Hiển thị</label>
                    <div style="clear: both;"></div>
                    <input type="radio" name="active" value="1" checked="checked"> Có <input type="radio" name="active" value="0"> Không
                </div> 
            </div>
            <div style="clear: both;"></div>
            <div class="form_group">
                <input type="hidden" name="id" value="{id}">
                <button class="button_all" name="edit_slide"> Hoàn thành </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var vitri='{vitri}';
    var active ='{active}';
    var target = '{target}'
    $('select[name=target]').val(target);
    $('select[name=vitri]').val(vitri);
    $("input[name=active][value=" + active + "]").prop('checked', true);
</script>