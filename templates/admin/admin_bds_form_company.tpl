<div class="row">
    <div class="tabbable">
        <div class="row">
            <div class="col-xs-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Thông tin cơ bản công ty hợp tác</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-partner-category-id"> Tên đối tác/đơn vị </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="alias" name="company_name" class="form-control col-xs-12 required" value="{$item->data.company_name}" placeholder="Tên Đối tác/Tên công ty" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-partner-city-id"> Thành phố - Quận huyện</label>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" id="company_city_id" name="company_city_id" onchange="changeDynaList( 'company_district_id', arrDistrict, document.adminForm.company_city_id.options[document.adminForm.company_city_id.selectedIndex].value, 0, 0);">
                                            <option value=""{if $item->data.company_city_id==0} selected="selected"{/if}>Chọn thành phố</option>
                                            {foreach from=$listCity key=c item=city}
                                                <option value="{$city.ma_tinh}"{if $item->data.company_city_id==$city.ma_tinh} selected="selected"{/if}>{$city.ten_tinh}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" id="company_district_id" name="company_district_id">
                                            <option value=""{if $item->data.company_district_id==0} selected="selected"{/if}>Chọn quận/huyện</option>
                                            {foreach from=$listDistrictSelected key=d item=district}
                                                <option value="{$district.ma_huyen}"{if $item->data.company_district_id==$district.ma_huyen} selected="selected"{/if}>{$district.ten_huyen}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-address"> Địa chỉ đường</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="company_address" class="form-control col-xs-12 required" value="{$item->data.company_address}" placeholder="Nhập tên địa chỉ, đường phố" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-phone-website"> Điện thoại - Website</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="company_telephone" class="form-control col-xs-12 required" onkeypress="return numberOnly(this, event);" value="{$item->data.company_telephone}" placeholder="Số điện thoại liên hệ" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="company_website" class="form-control col-xs-12" value="{$item->data.company_website}" placeholder="http://abc.com" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-career-name"> Lĩnh vực hoạt động</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="company_career_name" class="form-control col-xs-12 required" value="{$item->data.company_career_name}" placeholder="Lĩnh vực hoạt động kinh doanh" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-ordering-status"> Thứ tự/Trạng thái</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="company_ordering" onkeypress="return numberOnly(this, event);" class="form-control" value="{$item->data.company_ordering}" placeholder="Thứ tự sắp xếp" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="company_status"{if $item->data.company_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
                                            <span class="lbl">&nbsp;Hiển thị</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Logo công ty</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <p>(Kích thước ảnh: <b>{$setting.resize_image_normal} x {$setting.resize_image_normal_height})</b></p>
                                        <div id="image-holder-demo" class="box-item-image">
                                            {if $item->data.logo}
                                                <img src="{$item->data.logo}" border="0" />
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 ace-file-input">
                                        <div class="col-sm-4">
                                            <input size="20" type="file" id="fileUpload-demo" name="image" class="input-file-image" />
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