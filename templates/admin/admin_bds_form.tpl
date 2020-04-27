<div class="row">
    <div class="tabbable">
        <div class="row">
            <div class="col-xs-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Thông tin bất động sản</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                {if !$admin->admin_site_default}
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-site-id-project-id"> Thuộc site/Dự án </label>
                                        <div class="col-sm-4">
                                            <select name="bds_site_id" class="form-control required">
                                                <option value="0"{if $item->data.bds_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
                                                {foreach from=$sites key=s item=site}
                                                    <option value="{$s}"{if $s == $item->data.bds_site_id} selected="selected"{/if}>{$site}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select name="bds_project_id" class="form-control required">
                                                <option value="0"{if $item->data.bds_project_id == 0} selected="selected"{/if}>-- Lựa chọn dự án --</option>
                                                {foreach from=$_p_list key=p item=project}
                                                    <option value="{$project.bds_project_id}"{if $project.bds_project_id == $item->data.bds_project_id} selected="selected"{/if}>{$project.bds_project_name}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                {else}
                                    <div class="form-group">
                                        <input type="hidden" name="bds_site_id" value="{$admin->admin_site_default.site_id}" />
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-project-id"> Chọn dự án </label>
                                        <div class="col-sm-8">
                                            <select name="bds_project_id" class="form-control required">
                                                <option value="0"{if $item->data.bds_project_id == 0} selected="selected"{/if}>-- Lựa chọn dự án --</option>
                                                {foreach from=$_p_list key=p item=project}
                                                    <option value="{$project.bds_project_id}"{if $project.bds_project_id == $item->data.bds_project_id} selected="selected"{/if}>{$project.bds_project_name}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                {/if}
                                {literal}
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $('select[name=bds_project_id]').change(function(){
                                                var val = $(this).val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "admin_bds.php",
                                                    data: {action: 'bds', ajax:1, task: 'change_option_utilities', project_id: val},
                                                    dataType: "json",
                                                    success: function(xmlhttp) {
                                                        var objData = xmlhttp;
                                                        if ( objData.isOk == true || objData.isOK == 'true' ) {
                                                            $('.bds_option').each(function() {
                                                                var value_option = $(this).val();
                                                                if( $.inArray(value_option, objData.option) !== -1){
                                                                    $(this).attr('checked','checked');
                                                                }
                                                            });
                                                            $('.bds_utilities').each(function() {
                                                                var value_utilities = $(this).val();
                                                                if( $.inArray(value_utilities, objData.utilities) !== -1){
                                                                    $(this).attr('checked','checked');
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                {/literal}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> Tiêu đề bất động sản</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bds_title" class="form-control required" maxlength="255" value="{$item->data.bds_title}" placeholder="Tiêu đề bất động sản" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-section-type"> Nhu cầu/Loại bất động sản </label>
                                    <div class="col-sm-4">
                                        {*<select size="1" class="form-control" name="bds_section" onchange="changeDynaList( 'bds_price_range', arrPriceRange, document.adminForm.bds_section.options[document.adminForm.bds_section.selectedIndex].value, 0, 0);">*}
                                        <select size="1" class="form-control required" name="bds_section">
                                            <option value=""{if $item->data.bds_section==0} selected="selected"{/if}>-- Lựa chọn nhu cầu --</option>
                                            {foreach from=$_bds_sections key=s item=section}
                                                <option value="{$s}"{if $item->data.bds_section==$s} selected="selected"{/if}>{$section}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" name="bds_category_id">
                                            <option value=""{if $item->data.bds_category_id==0} selected="selected"{/if}>-- Lựa chọn loại bất động sản --</option>
                                            {foreach from=$_bds_types key=t item=types}
                                                {foreach from=$types key=kt item=type}
                                                    <option value="{$t}"{if $item->data.bds_category_id==$t} selected="selected"{/if}>{$type}</option>
                                                {/foreach}
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-bedroom-price-range"> Số phòng ngủ/Hướng nhà </label>
                                    <div class="col-sm-2">
                                        <select size="1" class="form-control required" name="bds_number_bedroom">
                                            <option value=""{if $item->data.bds_number_bedroom==0} selected="selected"{/if}>-- Số phòng ngủ --</option>
                                            {foreach from=$_bds_bedrooms key=b item=bedroom}
                                                <option value="{$b}"{if $item->data.bds_number_bedroom==$b} selected="selected"{/if}>{$bedroom}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select size="1" class="form-control" name="bds_number_bathroom">
                                            <option value=""{if $item->data.bds_number_bathroom==0} selected="selected"{/if}>-- Số phòng tắm --</option>
                                            {foreach from=$_bds_bathrooms key=b item=bathroom}
                                                <option value="{$b}"{if $item->data.bds_number_bathroom==$b} selected="selected"{/if}>{$bathroom}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" name="bds_view">
                                            <option value=""{if $item->data.bds_view==0} selected="selected"{/if}>-- Hướng nhà --</option>
                                            {foreach from=$_bds_views key=v item=view}
                                                <option value="{$view}"{if $item->data.bds_view==$view} selected="selected"{/if}>{$view}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-area"> Diện tích/Khoảng giá </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_area" class="form-control required" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" maxlength="4" value="{$item->data.bds_area}" placeholder="Diện tích (m2)" />
                                        {*<select size="1" class="form-control" name="bds_area">*}
                                            {*<option value=""{if $item->data.bds_area==0} selected="selected"{/if}>-- Diện tích --</option>*}
                                            {*{foreach from=$_bds_areas key=a item=area}*}
                                                {*<option value="{$a}"{if $item->data.bds_area==$a} selected="selected"{/if}>{$area}</option>*}
                                            {*{/foreach}*}
                                        {*</select>*}
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_price_range" class="form-control required" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" maxlength="15" value="{$item->data.bds_price_range}" placeholder="Định giá bất động sản" />
                                        {*<select size="1" class="form-control" id="bds_price_range" name="bds_price_range">*}
                                            {*<option value=""{if $item->data.bds_price_range==0} selected="selected"{/if}>-- Khoảng giá --</option>*}
                                            {*{foreach from=$_bds_price_ranges_selected key=p item=price}*}
                                                {*<option value="{$p}"{if $item->data.bds_price_range==$p} selected="selected"{/if}>{$price}</option>*}
                                            {*{/foreach}*}
                                        {*</select>*}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Vị trí địa lý - Vị trí tra cứu google</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-city-id"> Thành phố/Tỉnh - Quận/Huyện </label>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" id="bds_city_id" name="bds_city_id" onchange="changeDynaList( 'bds_district_id', arrDistrict, document.adminForm.bds_city_id.options[document.adminForm.bds_city_id.selectedIndex].value, 0, 0);">
                                            <option value=""{if $item->data.bds_city_id==0} selected="selected"{/if}>Chọn thành phố</option>
                                            {foreach from=$listCity key=c item=city}
                                                <option value="{$city.ma_tinh}"{if $item->data.bds_city_id==$city.ma_tinh} selected="selected"{/if}>{$city.ten_tinh}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select size="1" class="form-control required" id="bds_district_id" name="bds_district_id">
                                            <option value=""{if $item->data.bds_district_id==0} selected="selected"{/if}>Chọn quận/huyện</option>
                                            {foreach from=$listDistrictSelected key=d item=district}
                                                <option value="{$district.ma_huyen}"{if $item->data.bds_district_id==$district.ma_huyen} selected="selected"{/if}>{$district.ten_huyen}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-address"> Địa chỉ tên đường</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bds_address" class="form-control required" maxlength="255" value="{$item->data.bds_address}" placeholder="Địa chỉ tên đường phố..." />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-location-lat-long"> Vị trí tra cứu google </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_location_lat" class="col-xs-12 " maxlength="255" value="{$item->data.bds_location_lat}" placeholder="Kinh độ bản đồ (lat)..." />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_location_long" class="col-xs-12 " maxlength="255" value="{$item->data.bds_location_long}" placeholder="Vĩ độ bản đồ (long)..." />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-allow-show-address"> Cho phép hiển thị </label>
                                    <div class="col-sm-2">
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_address_show" value="1"{if $item->data.bds_address_show == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Địa chỉ</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_district_show" value="1"{if $item->data.bds_district_show == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Tên huyện</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_city_show" value="1"{if $item->data.bds_city_show == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Tên tỉnh</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Căn góc / Tiện ích kèm theo / Đặc điểm xã hội</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-corner"> Căn góc </label>
                                    <div class="col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_corner" value="1"{if $item->data.bds_corner == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Căn góc</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-option"> Tiện ích kèm theo </label>
                                    <div class="col-sm-8">
                                        {foreach from=$_bds_options key=o item=option}
                                            <div class="checkbox">
                                                <label>
                                                    <input name="bds_option[]" value="{$o}"{if $o|in_array:$item->data.bds_option} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option">
                                                    <span class="lbl"> {$option}</span>
                                                </label>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-utilities"> Đặc điểm xã hội </label>
                                    <div class="col-sm-8">
                                        {foreach from=$_bds_utilities key=u item=util}
                                            <div class="checkbox">
                                                <label>
                                                    <input name="bds_utilities[]" value="{$u}"{if $u|in_array:$item->data.bds_utilities} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace bds_utilities">
                                                    <span class="lbl"> {$util}</span>
                                                </label>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Tiện nghi</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-cozy"> &nbsp;</label>
                                    <div class="col-sm-4">
                                        {foreach from=$_bds_cozys key=co item=cozy}
                                            <div class="checkbox">
                                                <label>
                                                    <input name="bds_cozy[]" value="{$co}"{if $co|in_array:$item->data.bds_cozy} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option">
                                                    <span class="lbl"> {$cozy}</span>
                                                </label>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
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
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-groups"> Nhóm bất động sản </label>
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_vip" value="1"{if $item->data.bds_vip == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> VIP</span>
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_special" value="1"{if $item->data.bds_special == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Nổi bật</span>
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_hot" value="1"{if $item->data.bds_hot == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Đang rất hot</span>
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="bds_care" value="1"{if $item->data.bds_care == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                                                <span class="lbl"> Được quan tâm nhiều</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-ordering"> Thứ tự sắp xếp</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_ordering" onkeypress="return numberOnly(this, event);" class="form-control" value="{$item->data.bds_ordering}" placeholder="Thứ tự sắp xếp" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-status"> Trạng thái</label>
                                    <div class="col-sm-8">
                                        <label>
                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="bds_status"{if $item->data.bds_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <input type="text" name="bds_metatitle" class="form-control" maxlength="500" value="{$item->data.bds_metatitle}" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-keyword"> Meta Keyword</label>
                                    <div class="col-sm-9">
                                        <textarea cols="50" rows="5" class="form-control" maxlength="500" name="bds_metakey">{$item->data.bds_metakey}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-description"> Meta Description</label>
                                    <div class="col-sm-9">
                                        <textarea cols="50" rows="5" class="form-control" name="bds_metadesc">{$item->data.bds_metadesc}</textarea>
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
                                                    {if $item->data.bds_image_thumbnail.0}
                                                        <img src="{$item->data.bds_image_thumbnail.0}" border="0" />
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
                                                    {if $item->data.bds_image_thumbnail.1}
                                                        <img src="{$item->data.bds_image_thumbnail.1}" border="0" />
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
                                                    {if $item->data.bds_image_thumbnail.2}
                                                        <img src="{$item->data.bds_image_thumbnail.2}" border="0" />
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
                                                    {if $item->data.bds_image_thumbnail.3}
                                                        <img src="{$item->data.bds_image_thumbnail.3}" border="0" />
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
                                                    {if $item->data.bds_image_thumbnail.4}
                                                        <img src="{$item->data.bds_image_thumbnail.4}" border="0" />
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
                                                    {if $item->data.bds_image_thumbnail.5}
                                                        <img src="{$item->data.bds_image_thumbnail.5}" border="0" />
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
                                                    {if $item->data.bds_image_thumbnail.6}
                                                        <img src="{$item->data.bds_image_thumbnail.6}" border="0" />
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
                        <h4>Nội thất</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-furniture"> &nbsp;</label>
                                    <div class="col-sm-6">
                                        {foreach from=$_bds_furniture_keys key=fu item=furniture}
                                            <div class="checkbox checkbox_parent">
                                                <label>
                                                    <input name="bds_furniture[]" value="{$fu}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{if $ifu == $fu} checked="checked"{/if}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_parent">
                                                    <span class="lbl"> {$furniture}</span>
                                                </label>
                                                {foreach from=$_bds_furniture_values key=v_fu item=v_furniture}
                                                    {if $fu == $v_fu}
                                                        {foreach from=$v_furniture key=v item=f_item}
                                                            <div class="checkbox" style="padding-left: 25px;">
                                                                <label>
                                                                    <input name="bds_furniture[]" value="{$v}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{foreach from=$ffu key=_iv item=i_fu}{if $ifu == $fu && $i_fu == $v} checked="checked"{/if}{/foreach}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_child">
                                                                    <span class="lbl"> {$f_item}</span>
                                                                </label>
                                                            </div>
                                                        {/foreach}
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        {/foreach}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Thông tin thành viên đăng</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-choose-user"> Tên thành viên </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_user_name" class="form-control required" maxlength="255" value="{$item->d.user_fullname}" placeholder="Chọn tên thành viên" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_user_id" class="form-control required" value="{$item->data.bds_user_id}" placeholder="ID thành viên" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-date-created"> Ngày bắt đầu hiển thị </label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="text" data-date-format="dd/mm/yyyy" name="bds_user_date_created[]" class="form-control datetime" value="{if $task == 'add'}{$smarty.now|date_format:"%d/%m/%Y"}{else}{$item->data.bds_user_date_created|date_format:"%d/%m/%Y"}{/if}" />
                                                    <span class="input-group-addon">
                                                        <i class="icon-calendar bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group bootstrap-timepicker">
                                                    <input type="text" name="bds_user_date_created[]" class="form-control timepicker" size="12" value="{if $task == 'add'}{$smarty.now|date_format:"%H:%M:%S"}{else}{$item->data.bds_user_date_created|date_format:"%H:%M:%S"}{/if}" />
                                                    <span class="input-group-addon">
                                                        <i class="icon-time bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-date-expired"> Ngày kết thúc hiển thị </label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="text" data-date-format="dd/mm/yyyy" name="bds_user_date_expired[]" class="form-control datetime" value="{if $task == 'add'}{$smarty.now|date_format:"%d/%m/%Y"}{else}{$item->data.bds_user_date_expired|date_format:"%d/%m/%Y"}{/if}" />
                                                    <span class="input-group-addon">
                                                        <i class="icon-calendar bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group bootstrap-timepicker">
                                                    <input type="text" name="bds_user_date_expired[]" class="form-control timepicker" size="12" value="{if $task == 'add'}{$smarty.now|date_format:"%H:%M:%S"}{else}{$item->data.bds_user_date_expired|date_format:"%H:%M:%S"}{/if}" />
                                                    <span class="input-group-addon">
                                                        <i class="icon-time bigger-110"></i>
                                                    </span>
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
                                        <textarea cols="75" rows="30" name="bds_info" class="required" id="fulltext">{$item->data.bds_info}</textarea>
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