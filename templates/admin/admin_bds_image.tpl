<div class="row">
    <div class="col-xs-12 col-sm-7">
        <div class="widget-box">
            <div class="widget-header">
                <h4>Ảnh mô tả sản phẩm</h4>
            </div>
            <div class="widget-body">
                <div class="widget-body-inner" style="display: block;">
                    <div class="widget-main">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <p>(Kích thước ảnh: <b>{$setting.resize_image_normal}
                                        x {$setting.resize_image_normal_height})</b></p>
                                <div id="image-holder">

                                    <img src="{$bdsById[0].imageurl}" border="0"/>
                                    <input type="hidden" name="imageold" value="{$bdsById[0].imagename}">
                                </div>
                            </div>

                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="ace ace-checkbox-2" name="changeimage" value="1"/>
                                        <span class="lbl"> Thay ảnh đại diện</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <div id="show_pic" style="display: none;" class="col-sm-12 ace-file-input">
                                        <input size="20" type="file" id="fileUpload" name="image"
                                               class="input-file-image"/>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div id="show_pic_large" style="display: none;" class="col-sm-12 ace-file-input">
                                        <input size="20" type="file" id="fileUploadLarge" name="image_large"
                                               class="input-file-image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {literal}
                            <script>
                                $("#fileUploadLarge").on('change', function () {
                                    //Get count of selected files
                                    var countFiles = $(this)[0].files.length;

                                    var imgPath = $(this)[0].value;
                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                    var image_holder = $("#image-holder-large");
                                    image_holder.empty();

                                    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                                        if (typeof (FileReader) != "undefined") {

                                            //loop for each file selected for uploaded.
                                            for (var i = 0; i < countFiles; i++) {

                                                var reader = new FileReader();
                                                reader.onload = function (e) {
                                                    $("<img />", {
                                                        "src": e.target.result,
                                                        "class": "thumb-image"
                                                    }).appendTo(image_holder);
                                                }

                                                image_holder.show();
                                                reader.readAsDataURL($(this)[0].files[i]);
                                            }

                                        } else {
                                            alert("This browser does not support FileReader.");
                                        }
                                    } else {
                                        alert("Please select only images");
                                    }
                                });
                            </script>
                        {/literal}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{literal}
<script language="javascript">
    //Change Image
    $('input[name=changeimagelarge]').change(function () {
        if ($(this).is(':checked')) {
            $('#show_pic_large').show();
        } else {
            $('#show_pic_large').hide();
        }
    });
    var task = '{/literal}{$task}{literal}';
    /*
     * TASK: EDIT
     * Xử lý nút xóa các ảnh có sẵn và thêm ảnh trong trường hợp edit
     */
    if (task == 'edit') {
        var listScrFile = '{/literal}{$thisProduct->data.images_list_dir}{literal}';
        // Xóa thì trừ chuỗi
        $('.ls-pic .ax-remove').click(function () {
            divparent = $(this).parent().parent();
            file_name = getFileNameForFolder(divparent.find('img').attr('src'));
            listScrFile = listScrFile.replace(file_name + '|', "");
            divparent.remove();
            $('#listFileName').val(listScrFile);

            // Xóa ảnh
            $.ajax({
                url: window.location.pathname.split('/').pop() + '?task=unlinkFile',
                data: {
                    filenameRemove: file_name,
                    field: 'photo_images',
                    value: listScrFile,
                    table: 'tbl_photos',
                    where: 'photo_product_id={/literal}{$thisProduct->data.product_id}{literal}'
                },
                type: 'post',
                success: function (output) {
                    //alert(output);
                    $('#demo1-message').show();
                    $('#demo1-message').css('color', 'red');
                    $('#demo1-message').append(output);
                    setTimeout('$("#demo1-message").hide()', 5000);
                }
            });
        });
    }
</script>
{/literal}