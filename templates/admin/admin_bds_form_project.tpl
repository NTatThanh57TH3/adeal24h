<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="tabbable">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTabSettingSiteContent">
                                <li class="active">
                                    <a data-toggle="tab" href="#OVERVIEW" aria-expanded="true">TỔNG QUAN</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#LIST_TYPE" aria-expanded="true">CHỦNG LOẠI</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#LOCATION" aria-expanded="false">VỊ TRÍ ĐỊA LÝ</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#AMENITIES" aria-expanded="false">TIỆN ÍCH</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#FEATURE" aria-expanded="false">ĐẶC ĐIỂM</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#PRICE" aria-expanded="false">GIÁ BÁN</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#FEES" aria-expanded="false">CHI PHÍ</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="OVERVIEW" class="tab-pane active">
                                    {include file = 'admin_bds_form_project_overview.tpl'}
                                </div>
                                <div id="LIST_TYPE" class="tab-pane">
                                    {include file = 'admin_bds_form_project_type.tpl'}
                                </div>
                                <div id="LOCATION" class="tab-pane">
                                    {include file = 'admin_bds_form_project_location.tpl'}
                                </div>
                                <div id="AMENITIES" class="tab-pane">
                                    {include file = 'admin_bds_form_project_amenities.tpl'}
                                </div>
                                <div id="FEATURE" class="tab-pane">
                                    {include file = 'admin_bds_form_project_feature.tpl'}
                                </div>
                                <div id="PRICE" class="tab-pane">
                                    {include file = 'admin_bds_form_project_price.tpl'}
                                </div>
                                <div id="FEES" class="tab-pane">
                                    {include file = 'admin_bds_form_project_fees.tpl'}
                                </div>
                            </div>
                            {literal}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('.bds_child').click(function(){
                                        if ($(this).is(':checked')) {
                                            $(this).closest('.checkbox_parent').find('.bds_parent').attr("checked", "checked");
                                        }
                                    });
                                });
                            </script>
                            {/literal}
                        </div>
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>SEO - Thông tin thẻ Meta</h4>
                            </div>
                            <div class="widget-body">
                                <div class="widget-body-inner">
                                    <div class="widget-main">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-title"> Meta Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="bds_project_metatitle" class="form-control" maxlength="500" value="{$item->data.bds_project_metatitle}" />
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-keyword"> Meta Keyword</label>
                                            <div class="col-sm-9">
                                                <textarea cols="50" rows="5" class="form-control" maxlength="500" name="bds_project_metakey">{$item->data.bds_project_metakey}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-description"> Meta Description</label>
                                            <div class="col-sm-9">
                                                <textarea cols="50" rows="5" class="form-control" name="bds_project_metadesc">{$item->data.bds_project_metadesc}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {include file = 'admin_keyword_integrated.tpl'}
                    </div>
                    <div class="col-xs-6">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Ảnh mô tả</h4>
                            </div>
                            <div class="widget-body">
                                <div class="widget-body-inner" style="display: block;">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_max} x {$setting.resize_image_max_height})</b></p>
                                                        <div id="image-holder-demo" class="box-item-image-demo">
                                                            {if $item->data.bds_project_image_thumbnail.0}
                                                                <img src="{$item->data.bds_project_image_thumbnail.0}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload-demo" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                        <div id="image-holder-1" class="box-item-image">
                                                            {if $item->data.bds_project_image_thumbnail.1}
                                                                <img src="{$item->data.bds_project_image_thumbnail.1}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload1" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                        <div id="image-holder-2" class="box-item-image">
                                                            {if $item->data.bds_project_image_thumbnail.2}
                                                                <img src="{$item->data.bds_project_image_thumbnail.2}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload2" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                        <div id="image-holder-3" class="box-item-image">
                                                            {if $item->data.bds_project_image_thumbnail.3}
                                                                <img src="{$item->data.bds_project_image_thumbnail.3}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload3" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                        <div id="image-holder-4" class="box-item-image">
                                                            {if $item->data.bds_project_image_thumbnail.4}
                                                                <img src="{$item->data.bds_project_image_thumbnail.4}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload4" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                        <div id="image-holder-5" class="box-item-image">
                                                            {if $item->data.bds_project_image_thumbnail.5}
                                                                <img src="{$item->data.bds_project_image_thumbnail.5}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload5" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                        <div id="image-holder-6" class="box-item-image">
                                                            {if $item->data.bds_project_image_thumbnail.6}
                                                                <img src="{$item->data.bds_project_image_thumbnail.6}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 ace-file-input">
                                                        <div class="col-sm-12">
                                                            <input size="20" type="file" id="fileUpload6" name="image[]" class="input-file-image" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {literal}
                                            <script>
                                                $("#fileUpload-demo").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-demo");
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
                                                $("#fileUpload1").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-1");
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
                                                $("#fileUpload2").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-2");
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
                                                $("#fileUpload3").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-3");
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
                                                $("#fileUpload4").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-4");
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
                                                $("#fileUpload5").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-5");
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
                                                $("#fileUpload6").on('change', function () {
                                                    //Get count of selected files
                                                    var countFiles = $(this)[0].files.length;

                                                    var imgPath = $(this)[0].value;
                                                    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                                                    var image_holder = $("#image-holder-6");
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
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Nhóm - Thứ tự sắp xếp - Hiển thị</h4>
                            </div>
                            <div class="widget-body">
                                <div class="widget-body-inner">
                                    <div class="widget-main">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-groups"> Nhóm dự án </label>
                                            <div class="col-sm-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="bds_project_hot" value="1"{if $item->data.bds_project_hot == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                        <span class="lbl"> Dự án hot</span>
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="bds_project_new" value="1"{if $item->data.bds_project_new == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                        <span class="lbl"> Dự án mới</span>
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="bds_project_is_open_for_sale" value="1"{if $item->data.bds_project_is_open_for_sale == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                        <span class="lbl"> Đang mở bán</span>
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="bds_project_about_to_for_sale" value="1"{if $item->data.bds_project_about_to_for_sale == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                        <span class="lbl"> Sắp mở bán</span>
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="bds_project_being_traded" value="1"{if $item->data.bds_project_being_traded == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                        <span class="lbl"> Đang giao dịch</span>
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="bds_project_high_level" value="1"{if $item->data.bds_project_high_level == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                        <span class="lbl"> Dự án cao cấp</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-ordering"> Thứ tự sắp xếp</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="bds_project_ordering" onkeypress="return numberOnly(this, event);" class="form-control" value="{$item->data.bds_project_ordering}" placeholder="Thứ tự sắp xếp" />
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-status"> Trạng thái</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" class="ace ace-switch ace-switch-4" name="bds_project_status"{if $item->data.bds_project_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="tabbable">
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Mô tả chi tiết(Sơ đồ tổng thể) dự án</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-8">
                                        <textarea cols="75" rows="30" name="bds_project_info" class="required" id="fulltext">{$item->data.bds_project_info}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>