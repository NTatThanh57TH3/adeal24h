{if !$admin->admin_site_default}
    <div class="form-group">
        <label class="col-sm-4 control-label no-padding-right" for="form-field-site-id-project-id"> Thuộc site/Danh mục </label>
        <div class="col-sm-8">
            <select name="bds_project_site_id" class="form-control required">
                <option value="0"{if $item->data.bds_project_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
                {foreach from=$sites key=s item=site}
                    <option value="{$s}"{if $s == $item->data.bds_project_site_id} selected="selected"{/if}>{$site}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="space-4"></div>
{else}
    <input type="hidden" name="bds_project_site_id" value="{$admin->admin_site_default.site_id}" />
{/if}
<div class="form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12" style="padding: 0;">
                <h4 style="padding-left: 10px;">Chủng loại dự án</h4>
                {foreach from=$_bds_types key=k_type item=cate}
                    <div class="col-sm-6" style="padding: 0;">
                        <div class="checkbox">
                            <label>
                                <input name="bds_project_types[]" data-type="{$sf_key}" value="{$k_type}"{if in_array($item->data.bds_furniture, $item->data.bds_project_types)} checked="checked"{/if} name="form-field-checkbox" type="checkbox" class="ace bds_project_types">
                                <span class="lbl"> {$cate}</span>
                            </label>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="form-group" id="info_bds_type">
    <div class="row">
        <div class="col-xs-12">
            <h4 style="padding-left: 10px;">Khối nhà/Số lượng sản phẩm</h4>
            {foreach from=$_bds_project_blocks key=b_key item=block}
                <div class="form-group">
                    <label class="col-sm-4 control-label"> {$block}</label>
                    <div class="col-sm-6">
                        <input type="text" size="3" class="form-control" maxlength="5" onkeypress="return numberOnly(this, event);" name="bds_project_number_blocks[{$block}]" placeholder="Số lượng chủng loại {$block}" />
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>