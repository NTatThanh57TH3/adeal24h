<div class="row">
    <div class="tabbable">
        <div class="row">
            <div class="col-xs-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Thông tin dự án</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                {if $task == 'edit'}
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-view">&nbsp; </label>
                                        <div class="col-sm-8">
                                            <a style="font-size: 16px; color: red;" target="_blank" href="{$item->data.link}"><i class="icon-double-angle-right"></i> Xem nhanh bài viết</a>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                {/if}
                                {if !$admin->admin_site_default}
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-site-id-cate-id"> Thuộc site/Danh mục </label>
                                        <div class="col-sm-4">
                                            <select name="construction_design_site_id" class="form-control required">
                                                <option value="0"{if $item->data.construction_design_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
                                                {foreach from=$sites key=s item=site}
                                                    <option value="{$s}"{if $s == $item->data.construction_design_site_id} selected="selected"{/if}>{$site}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select name="construction_design_category_id" class="form-control required">
                                                <option value="0"{if $item->data.construction_design_category_id == 0} selected="selected"{/if}>-- Lựa chọn danh mục --</option>
                                                {$listItems}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                {else}
                                    <div class="form-group">
                                        <input type="hidden" name="construction_design_site_id" value="{$admin->admin_site_default.site_id}" />
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-cate-id"> Chọn danh mục </label>
                                        <div class="col-sm-8">
                                            <select name="construction_design_category_id" class="form-control required">
                                                <option value="0"{if $item->data.construction_design_category_id == 0} selected="selected"{/if}>-- Lựa chọn danh mục --</option>
                                                {$listItems}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                {/if}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> Tên dự án thi công</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="construction_design_name" class="form-control required" maxlength="255" value="{$item->data.construction_design_name}" placeholder="Tên dự án thiết kế - thi công" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-investor-floors"> Chủ đầu tư/ Phong cách/ Mã</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="construction_design_investor" class="form-control" maxlength="255" value="{$item->data.construction_design_investor}" placeholder="Chủ đàu tư dự án" />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="construction_design_style" class="form-control" maxlength="255" value="{$item->data.construction_design_style}" placeholder="Phong cách thiết kế" />
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" name="construction_design_code"{if $task == 'edit'} disabled{/if} class="form-control " maxlength="50" value="{$item->data.construction_design_code}" placeholder="Mã dự án" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-area"> Mặt tiền/Chiều sâu/Số tầng</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="construction_design_facade" class="form-control " maxlength="100" value="{$item->data.construction_design_facade}" placeholder="Mặt tiền dự án" />
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="construction_design_depth" class="form-control " maxlength="100" value="{$item->data.construction_design_depth}" placeholder="Chiều sâu dự án" />
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="construction_design_number_floors" class="form-control">
                                            <option value="0">-- Chọn số tầng</option>
                                            <option value="1"{if $item->data.construction_design_number_floors == 1} selected="selected"{/if}>1 tầng</option>
                                            <option value="2"{if $item->data.construction_design_number_floors == 2} selected="selected"{/if}>2 tầng</option>
                                            <option value="3"{if $item->data.construction_design_number_floors == 3} selected="selected"{/if}>3 tầng</option>
                                            <option value="4"{if $item->data.construction_design_number_floors == 4} selected="selected"{/if}>4 tầng</option>
                                            <option value="5"{if $item->data.construction_design_number_floors == 5} selected="selected"{/if}>5 tầng</option>
                                            <option value="6"{if $item->data.construction_design_number_floors == 6} selected="selected"{/if}>6 tầng</option>
                                            <option value="7"{if $item->data.construction_design_number_floors == 7} selected="selected"{/if}>7 tầng</option>
                                            <option value="8"{if $item->data.construction_design_number_floors == 8} selected="selected"{/if}>8 tầng</option>
                                            <option value="9"{if $item->data.construction_design_number_floors == 9} selected="selected"{/if}>9 tầng</option>
                                            <option value="10"{if $item->data.construction_design_number_floors == 6} selected="selected"{/if}>10 tầng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group" id="desc-floors" style="display:none;">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-area"> Mô tả từng tầng</label>
                                    <div class="col-sm-8" id="desc_info_text"></div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-architec-years"> Kiến trúc sư/Năm thi công</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="construction_design_architect" class="form-control " maxlength="255" value="{$item->data.construction_design_architect}" placeholder="Kiến trúc sư dự án" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="construction_design_years_of_construction" onkeypress="return numberOnly(this, event);" class="form-control" maxlength="10" value="{$item->data.construction_design_years_of_construction}" placeholder="Năm thi công dự án" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-city-id"> Thành phố/Tỉnh - Quận/Huyện </label>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" id="construction_design_city_id" name="construction_design_city_id" onchange="changeDynaList( 'construction_design_district_id', arrDistrict, document.adminForm.construction_design_city_id.options[document.adminForm.construction_design_city_id.selectedIndex].value, 0, 0);">
                                            <option value=""{if $item->data.construction_design_city_id==0} selected="selected"{/if}>Chọn thành phố</option>
                                            {foreach from=$listCity key=c item=city}
                                                <option value="{$city.ma_tinh}"{if $item->data.construction_design_city_id==$city.ma_tinh} selected="selected"{/if}>{$city.ten_tinh}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" id="construction_design_district_id" name="construction_design_district_id">
                                            <option value=""{if $item->data.construction_design_district_id==0} selected="selected"{/if}>Chọn quận/huyện</option>
                                            {foreach from=$listDistrictSelected key=d item=district}
                                                <option value="{$district.ma_huyen}"{if $item->data.construction_design_district_id==$district.ma_huyen} selected="selected"{/if}>{$district.ten_huyen}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-address"> Địa chỉ tên đường</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="construction_design_address" class="form-control" maxlength="255" value="{$item->data.construction_design_address}" placeholder="Địa chỉ tên đường phố..." />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-content-short-description"> Mô tả ngắn </label>
                                    <div class="col-sm-8">
                                        <textarea cols="75" rows="5" name="construction_design_short_desc" class="wysiwyg required">{$item->data.construction_design_short_desc}</textarea>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-ordering"> Thứ tự sắp xếp</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="construction_design_ordering" onkeypress="return numberOnly(this, event);" class="form-control" value="{$item->data.construction_design_ordering}" placeholder="Thứ tự sắp xếp" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-hot"> Nhóm hot</label>
                                    <div class="col-sm-8">
                                        <label>
                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="construction_design_hot"{if $item->data.construction_design_hot == 1} checked="checked"{/if} value="1">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-status"> Trạng thái</label>
                                    <div class="col-sm-8">
                                        <label>
                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="construction_design_status"{if $item->data.construction_design_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {literal}
                <script type="text/javascript">
                    var value_floor =  $('select[name=construction_design_number_floors').val();
                    var arrData = false;
                    arrData = {/literal}{if $item->data.desc_floor_script}{$item->data.desc_floor_script}{else}''{/if}{literal};
                    //console.log(arrData)

                    desc_floor(value_floor, arrData);
                    $('select[name=construction_design_number_floors').change(function(){
                        value_floor = $(this).val();
                        desc_floor(value_floor, arrData);
                    });
                    function desc_floor(number, arrayData){
                        if ( number ){
                            $('#desc-floors').show();
                            var html = '';
                            if ( arrayData && $.isArray(arrayData) ){
                                for (i = 0; i < number; i++) {
                                    html += '<input type="text" name="construction_design_desc_number_floors[]" style="margin-bottom:5px;" class="form-control" value="'+(arrayData[i] ? arrayData[i] : '')+'" placeholder="Mô tả tầng ' + (i+1) + '" />';
                                }
                            }else {
                                for (i = 1; i <= number; i++) {
                                    html += '<input type="text" name="construction_design_desc_number_floors[]" style="margin-bottom:5px;" class="form-control" value="" placeholder="Mô tả tầng ' + i + '" />';
                                }
                            }
                            $('#desc_info_text').html(html);
                        }
                    }
                </script>
                {/literal}
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
                                        <input type="text" name="construction_design_metatitle" class="form-control" maxlength="500" value="{$item->data.construction_design_metatitle}" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-keyword"> Meta Keyword</label>
                                    <div class="col-sm-9">
                                        <textarea cols="50" rows="5" class="form-control" maxlength="500" name="construction_design_metakey">{$item->data.construction_design_metakey}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-description"> Meta Description</label>
                                    <div class="col-sm-9">
                                        <textarea cols="50" rows="5" class="form-control" name="construction_design_metadesc">{$item->data.construction_design_metadesc}</textarea>
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                                <div id="image-holder-1" class="box-item-image">
                                                    {if $item->data.construction_design_image_thumbnail.0}
                                                        <img src="{$item->data.construction_design_image_thumbnail.0}" border="0" />
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
                                                    {if $item->data.construction_design_image_thumbnail.1}
                                                        <img src="{$item->data.construction_design_image_thumbnail.1}" border="0" />
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
                                                    {if $item->data.construction_design_image_thumbnail.2}
                                                        <img src="{$item->data.construction_design_image_thumbnail.2}" border="0" />
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
                                                    {if $item->data.construction_design_image_thumbnail.3}
                                                        <img src="{$item->data.construction_design_image_thumbnail.3}" border="0" />
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
                                                    {if $item->data.construction_design_image_thumbnail.4}
                                                        <img src="{$item->data.construction_design_image_thumbnail.4}" border="0" />
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
                                                    {if $item->data.construction_design_image_thumbnail.5}
                                                        <img src="{$item->data.construction_design_image_thumbnail.5}" border="0" />
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
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="tabbable">
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Mô tả chi tiết dự án</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-8">
                                        <textarea cols="75" rows="30" class="required" name="construction_design_info" id="fulltext">{$item->data.construction_design_info}</textarea>
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