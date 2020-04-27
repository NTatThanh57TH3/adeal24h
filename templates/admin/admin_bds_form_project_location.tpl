<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-city-id"> Thành phố/Tỉnh - Quận/Huyện </label>
    <div class="col-sm-4">
        <select size="1" class="form-control required" id="bds_project_city_id" name="bds_project_city_id" onchange="changeDynaList( 'bds_project_district_id', arrDistrict, document.adminForm.bds_project_city_id.options[document.adminForm.bds_project_city_id.selectedIndex].value, 0, 0);">
            <option value=""{if $item->data.bds_project_city_id==0} selected="selected"{/if}>Chọn thành phố</option>
            {foreach from=$listCity key=c item=city}
                <option value="{$city.ma_tinh}"{if $item->data.bds_project_city_id==$city.ma_tinh} selected="selected"{/if}>{$city.ten_tinh}</option>
            {/foreach}
        </select>
    </div>
    <div class="col-sm-4">
        <select size="1" class="form-control required" id="bds_project_district_id" name="bds_project_district_id">
            <option value=""{if $item->data.bds_project_district_id==0} selected="selected"{/if}>Chọn quận/huyện</option>
            {foreach from=$listDistrictSelected key=d item=district}
                <option value="{$district.ma_huyen}"{if $item->data.bds_project_district_id==$district.ma_huyen} selected="selected"{/if}>{$district.ten_huyen}</option>
            {/foreach}
        </select>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-address"> Địa chỉ tên đường</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_address" class="form-control required" maxlength="255" value="{$item->data.bds_project_address}" placeholder="Địa chỉ tên đường phố..." />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-location-lat-long"> Vị trí tra cứu google </label>
    <div class="col-sm-4">
        <input type="text" name="bds_project_location_lat" class="col-xs-12 " maxlength="255" value="{$item->data.bds_project_location_lat}" placeholder="Kinh độ bản đồ (lat)..." />
    </div>
    <div class="col-sm-4">
        <input type="text" name="bds_project_location_long" class="col-xs-12 " maxlength="255" value="{$item->data.bds_project_location_long}" placeholder="Vĩ độ bản đồ (long)..." />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-groups"> Vị trí dự án </label>
    <div class="col-sm-8">
        <div class="checkbox">
            <label>
                <input name="bds_project_location_corner" value="1"{if $item->data.bds_project_location_corner == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> Lô góc</span>
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_location_parkside" value="1"{if $item->data.bds_project_location_parkside == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> Gần công viên</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_location_parkside_name[]" class="form-control" value="" placeholder="Nhập tên công viên" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_location_parkside_name[]" class="form-control" value="" placeholder="Nhập tên công viên" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_location_lakeside" value="1"{if $item->data.bds_project_location_lakeside == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> Ven hồ</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_location_lakeside_name[]" class="form-control" value="" placeholder="Nhập tên hồ" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_location_lakeside_name[]" class="form-control" value="" placeholder="Nhập tên hồ" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_location_riverside" value="1"{if $item->data.bds_project_location_riverside == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace">
                <span class="lbl"> Ven sông</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_location_riverside_name[]" class="form-control" value="" placeholder="Nhập tên sông" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_location_riverside_name[]" class="form-control" value="" placeholder="Nhập tên sông" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_close_to_school" value="1"{if $item->data.bds_project_close_to_school == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace ace_extend">
                <span class="lbl"> Gần trường học</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_school[]" class="form-control" value="" placeholder="Nhập tên trường" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_school[]" class="form-control" value="" placeholder="Nhập tên trường" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_school[]" class="form-control" value="" placeholder="Nhập tên trường" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_close_to_hospital" value="1"{if $item->data.bds_project_close_to_hospital == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace ace_extend">
                <span class="lbl"> Gần bệnh viện</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_hospital_name[]" class="form-control" value="" placeholder="Nhập tên bệnh viện" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_hospital_name[]" class="form-control" value="" placeholder="Nhập tên bệnh viện" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_hospital_name[]" class="form-control" value="" placeholder="Nhập tên bệnh viện" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_close_to_shopping_center" value="1"{if $item->data.bds_project_close_to_shopping_center == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace ace_extend">
                <span class="lbl"> Gần trung tâm mua sắm</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_shopping_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm mua sắm" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_shopping_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm mua sắm" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_shopping_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm mua sắm" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_close_to_ecreation_center" value="1"{if $item->data.bds_project_close_to_ecreation_center == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace ace_extend">
                <span class="lbl"> Gần trung tâm giải trí</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_ecreation_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm giải trí" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_ecreation_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm giải trí" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_ecreation_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm giải trí" />
                    </div>
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input name="bds_project_close_to_sports_center" value="1"{if $item->data.bds_project_close_to_sports_center == 1} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace ace_extend">
                <span class="lbl"> Gần trung tâm thể thao</span>
            </label>
            <div style="display: block; padding: 3px; padding-left: 15px;">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_sports_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm thể thao" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_sports_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm thể thao" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" name="bds_project_close_to_sports_center_name[]" class="form-control" value="" placeholder="Nhập tên trung tâm thể thao" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>