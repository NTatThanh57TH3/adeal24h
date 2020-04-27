<div class="row">
    <div class="tabbable">
        <div class="row">
            <div class="col-xs-6">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4>Thông tin cơ bản nhu cầu</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-section-name"> Tên nhu cầu </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="alias" name="bds_section_name" class="form-control col-xs-12 required" value="{$item->data.bds_section_name}" placeholder="Tên nhu cầu" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-style"> Style nhu cầu</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="bds_section_style" class="form-control col-xs-12" value="{$item->data.bds_section_style}" placeholder="Style nhu cầu" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-ordering-status"> Thứ tự/Trạng thái</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="bds_section_ordering" onkeypress="return numberOnly(this, event);" class="form-control" value="{$item->data.bds_section_ordering}" placeholder="Thứ tự sắp xếp" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="bds_section_status"{if $item->data.bds_section_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
                                            <span class="lbl">&nbsp;Hiển thị</span>
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
                                        <input type="text" name="bds_section_metatitle" class="form-control" maxlength="500" value="{$item->data.bds_section_metatitle}" />
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-keyword"> Meta Keyword</label>
                                    <div class="col-sm-9">
                                        <textarea cols="50" rows="5" class="form-control" maxlength="500" name="bds_section_metakey">{$item->data.bds_section_metakey}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-description"> Meta Description</label>
                                    <div class="col-sm-9">
                                        <textarea cols="50" rows="5" class="form-control" name="bds_section_metadesc">{$item->data.bds_section_metadesc}</textarea>
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
                        <h4>Thông tin cơ bản nhu cầu</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-body-inner">
                            <div class="widget-main">
                                {section name=foo loop=10}
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-section-name"> Mức khoảng giá {$smarty.section.foo.index+1}</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="bds_section_price_text[]" class="form-control col-xs-12 required" value="{if $item->data.priceValueText}{foreach from=$item->data.priceValueText key=t item=textValue}{if $t == $smarty.section.foo.index}{$textValue.bds_section_price_text}{/if}{/foreach}{/if}" placeholder="Tên khoảng giá" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="bds_section_price_value_min[]" class="form-control col-xs-12" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" value="{if $item->data.priceValueText}{foreach from=$item->data.priceValueText key=t item=textValue}{if $t == $smarty.section.foo.index}{$textValue.bds_section_price_value_min|number_format:0:".":","}{/if}{/foreach}{/if}" placeholder="Giá trị mức giá từ" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="bds_section_price_value_max[]" class="form-control col-xs-12" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" value="{if $item->data.priceValueText}{foreach from=$item->data.priceValueText key=t item=textValue}{if $t == $smarty.section.foo.index}{$textValue.bds_section_price_value_max|number_format:0:".":","}{/if}{/foreach}{/if}" placeholder="Giá trị mức giá đến" />
                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                {/section}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>