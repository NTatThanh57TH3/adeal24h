<link rel="stylesheet" href="../templates/admin/css/autosuggest.css" />
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> Tên dự án</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_name" class="form-control required" maxlength="255" value="{$item->data.bds_project_name}" placeholder="Tên dự án" />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-investor"> Chủ đầu tư</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_investor" class="form-control required" maxlength="255" value="{$item->data.bds_project_investor}" placeholder="Chủ đàu tư dự án" />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group suggest_find_data">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-architect"> Đơn vị thiết kế kiến trúc</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_architect_name" id="bds_project_architect_name" onkeyup="suggest_company(this.value, 'suggest_architect', 'suggestionsArchitectList', 'bds_project_architect', 'architect');" onblur="fill_company();" class="form-control required" maxlength="255" value="{$item->data.bds_project_architect_name}" placeholder="Đơn vị thiết kế kiến trúc" />
        <input type="hidden" name="bds_project_architect" id="bds_project_architect" value="{$item->data.bds_project_architect}" />
        <div class="suggestionsBox" id="suggest_architect" style="display: none;">
            <img src="{$PG_URL_HOMEPAGE}/templates/admin/images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div class="suggestionList" id="suggestionsArchitectList">&nbsp;</div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group suggest_find_data">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-landscape-designer"> Đơn vị thiết kế cảnh quan</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_landscape_designer_name" id="bds_project_landscape_designer_name" onkeyup="suggest_company(this.value, 'suggest_landscape_designer', 'suggestionsLandscapeDesignerList', 'bds_project_landscape_designer', 'landscape_designer');" onblur="fill_company();" class="form-control required" maxlength="255" value="{$item->data.bds_project_landscape_designer_name}" placeholder="Đơn vị thiết kế cảnh quan" />
        <input type="hidden" name="bds_project_landscape_designer" id="bds_project_landscape_designer" value="{$item->data.bds_project_landscape_designer}" />
        <div class="suggestionsBox" id="suggest_landscape_designer" style="display: none;">
            <img src="{$PG_URL_HOMEPAGE}/templates/admin/images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div class="suggestionList" id="suggestionsLandscapeDesignerList">&nbsp;</div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group suggest_find_data">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-interior-designer"> Đơn vị thiết kế nội thất</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_interior_designer_name" id="bds_project_interior_designer_name" onkeyup="suggest_company(this.value, 'suggest_interior_designer', 'suggestionsInteriorDesignerList', 'bds_project_interior_designer', 'interior_designer');" onblur="fill_company();" class="form-control required" maxlength="255" value="{$item->data.bds_project_interior_designer_name}" placeholder="Đơn vị thiết kế nội thất" />
        <input type="hidden" name="bds_project_interior_designer" id="bds_project_interior_designer" value="{$item->data.bds_project_interior_designer}" />
        <div class="suggestionsBox" id="suggest_interior_designer" style="display: none;">
            <img src="{$PG_URL_HOMEPAGE}/templates/admin/images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div class="suggestionList" id="suggestionsInteriorDesignerList">&nbsp;</div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group suggest_find_data">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-builder"> Nhà thầu thi công</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_builder_name" id="bds_project_builder_name" onkeyup="suggest_company(this.value, 'suggest_builder', 'suggestionsBuilderList', 'bds_project_builder', 'builder');" onblur="fill_company();" class="form-control required" maxlength="255" value="{$item->data.bds_project_builder_name}" placeholder="Nhà thầu thi công" />
        <input type="hidden" name="bds_project_builder" id="bds_project_builder" value="{$item->data.bds_project_builder}" />
        <div class="suggestionsBox" id="suggest_builder" style="display: none;">
            <img src="{$PG_URL_HOMEPAGE}/templates/admin/images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div class="suggestionList" id="suggestionsBuilderList">&nbsp;</div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-managed-by"> Đơn vị quản lý</label>
    <div class="col-sm-8">
        <input type="text" name="bds_project_managed_by_name" id="bds_project_managed_by_name" onkeyup="suggest_company(this.value, 'suggest_managed_by_name', 'suggestionsManagedBbyNameList', 'bds_project_managed_by', 'managed_by');" onblur="fill_company();" class="form-control required" maxlength="255" value="{$item->data.bds_project_managed_by_name}" placeholder="Đơn vị quản lý" />
        <input type="hidden" name="bds_project_managed_by" id="bds_project_managed_by" value="{$item->data.bds_project_managed_by}" />
        <div class="suggestionsBox" id="suggest_managed_by_name" style="display: none;">
            <img src="{$PG_URL_HOMEPAGE}/templates/admin/images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div class="suggestionList" id="suggestionsManagedBbyNameList">&nbsp;</div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-year"> Năm khởi công/Hoàn thành/Bàn giao</label>
    <div class="col-sm-2">
        <input type="text" name="bds_project_commencement_year" class="form-control datepicker_only_year required" maxlength="255" value="{$item->data.bds_project_commencement_year}" placeholder="Năm khởi công" />
    </div>
    <div class="col-sm-2">
        <input type="text" name="bds_project_completion_year" class="form-control datepicker_only_year required" maxlength="255" value="{$item->data.bds_project_completion_year}" placeholder="Năm hoàn thành" />
    </div>
    <div class="col-sm-4">
        <input type="text" name="bds_project_date_hand_over" class="form-control datetime required" maxlength="255" value="{$item->data.bds_project_date_hand_over|date_format:"%d/%m/%Y"}" placeholder="Thời gian bàn giao" />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-area"> Tổng diện tích/Quy mô dự án</label>
    <div class="col-sm-2">
        <input type="text" name="bds_project_total_area" onkeypress="return numberOnly(this, event);" onkeyup="core.chargeGold.mixMoney(this)" class="form-control " maxlength="255" value="{$item->data.bds_project_total_area}" placeholder="Tổng diện tích dự án" />
    </div>
    <div class="col-sm-2">
        <input type="text" name="bds_project_construction_area" onkeypress="return numberOnly(this, event);" onkeyup="core.chargeGold.mixMoney(this)" class="form-control " maxlength="255" value="{$item->data.bds_project_construction_area}" placeholder="Tổng diện tích xây dựng" />
    </div>
    <div class="col-sm-2">
        <input type="text" name="bds_project_scale" onkeypress="return numberOnly(this, event);" onkeyup="core.chargeGold.mixMoney(this)" class="form-control " maxlength="255" value="{$item->data.bds_project_scale}" placeholder="Quy mô dự án" />
    </div>
    <div class="col-sm-2">
        <select class="form-control" name="bds_projectunit_area_scale_unit">
            <option value="m2">m2</option>
            <option value="hec">héc-ta</option>
        </select>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> Vốn đầu tư/Diện tích cây xanh và mặt nước</label>
    <div class="col-sm-4">
        <input type="text" name="bds_project_investment" class="form-control required" maxlength="255" value="{$item->data.bds_project_investment}" placeholder="Mức vốn đầu tư" />
    </div>
    <div class="col-sm-4">
        <input type="text" name="bds_project_parkland_wetland" class="form-control required" maxlength="255" value="{$item->data.bds_project_parkland_wetland}" placeholder="Diện tích cây xanh và mặt nước" />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> Mật độ xây dựng/Ngân hàng bảo trợ vốn</label>
    <div class="col-sm-4">
        <input type="text" name="bds_project_density" class="form-control required" maxlength="255" value="{$item->data.bds_project_density}" placeholder="Mật độ xây dựng" />
    </div>
    <div class="col-sm-4">
        <input type="text" name="bds_project_associated_bank" class="form-control required" maxlength="255" value="{$item->data.bds_project_associated_bank}" placeholder="Ngân hàng bảo trợ vốn" />
    </div>
</div>
<div class="space-4"></div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-status"> Tình trạng dự án</label>
    <div class="col-sm-4">
        <label>
            <input type="checkbox" class="ace ace-switch ace-switch-4" name="bds_project_handedover"{if $item->data.bds_project_handedover == 1} checked="checked"{/if} value="1">
            <span class="lbl">&nbsp;Đã bàn giao</span>
        </label>
    </div>
</div>
{literal}
<script type="text/javascript">
    // suggest company
    var timeoutHandle;
    function suggest_company(inputString, suggestions, suggestionsList, dataId, typeString) {
        if (timeoutHandle) {
            clearTimeout(timeoutHandle);
            timeoutHandle = null;
        }
        timeoutHandle = setTimeout(function () {
            if (inputString.length == 0) {
                $('#' + suggestions).fadeOut();
            } else {
                $.post("admin_ajax_tasks.php?task=getCompany", {queryString: "" + inputString + "", typeString: "" + typeString + ""}, function (data) {
                    if (data.length > 0) {
                        $('#' + suggestions).fadeIn();
                        $('#' + suggestionsList).html(data);
                        $('#' + dataId).removeClass('load');
                    }
                });
            }
        }, 1000); // 1 second
    }
    function fill_company(thisName, thisId, dataName, dataId, suggestions) {
        if (thisName == '') {
            $('#' + dataId).val('');
            $('#' + dataName).val('');
            return;
        } else {
            $('#' + dataName).val(thisName);
            $('#' + dataId).val(thisId);
        }
        if (thisId != '') {
            $('#' + dataId).removeAttr('disabled');
            $('#' + dataId).attr('readonly', 'readonly');
        }
        $('#' + suggestions).fadeOut('slow');
    }
    $(function() {
        $(".datepicker_only_year").datepicker( {
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years"
        });
    });
</script>
{/literal}