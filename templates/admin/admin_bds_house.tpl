<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-product_price_contact"> Loại căn
                hộ </label>
            <div class="col-sm-9">
                <input type="text" name="house_type" class="col-xs-12" value="{$bdsById[0].type}"
                       placeholder="Loại căn hộ"/>
            </div>
        </div>
        <div class="space-4 price"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-fullname"> Tên căn hộ </label>
            <div class="col-sm-9">
                <input type="text" id="alias" name="house_name" class="col-xs-12" value="{$bdsById[0].housename}"
                       placeholder="Tên căn hộ"/>
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-mobile"> Mã căn hộ </label>
            <div class="col-sm-9">
                <input type="text" id="alias" name="house_code" class="col-xs-12" value="{$bdsById[0].code}"
                       placeholder=" Mã căn hộ"/>
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-mobile"> Giá căn hộ </label>
            <div class="col-sm-9">
                <input type="text" name="house_price" class="col-xs-4" onkeyup="core.chargeGold.mixMoney(this)"
                       onkeypress="return numberOnly(this, event);"
                       value="{$bdsById[0].houseprice|number_format:0:".":","}" placeholder="0"/> <label
                        style="margin-left: 10px; color: #999;">(VNĐ)</label>
            </div>
        </div>
        <div class="space-4"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-mobile"> Diện tích căn
                hộ </label>
            <div class="col-sm-9">
                <input type="text" name="house_area" class="col-xs-4" onkeypress="return numberOnly(this, event);"
                       value="{$bdsById[0].area|number_format:0:".":","}" placeholder="0"/><label
                        style="margin-left: 10px; color: #999;">(m2)</label>
            </div>
        </div>
        <div class="space-4"></div>
    </div>
</div>
