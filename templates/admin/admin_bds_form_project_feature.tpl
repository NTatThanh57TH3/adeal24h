<div class="form-group">
    <div class="col-sm-12">
        {foreach from=$_bds_features key=fu item=feature name=f_oo}
            <div class="col-sm-6">
                <div class="checkbox checkbox_parent">
                    <label>
                        <input name="bds_project_features[{$fu}]" value="{$fu}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{if $ifu == $fu} checked="checked"{/if}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_parent">
                        <span class="lbl"> <b>{$feature}</b></span>
                    </label>
                    {foreach from=$_bds_features_value key=f_ku item=f_features}
                        {if $fu == $f_ku}
                            {foreach from=$f_features key=v item=f_item}
                                <div class="checkbox" style="padding-left: 25px;">
                                    <label>
                                        {if is_array($f_item) && $f_item|@count}
                                            {foreach from=$f_item key=s_key item=s_value}
                                                <input name="bds_project_features[{$fu}][{$v}]" value="{$v}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{foreach from=$ffu key=_iv item=i_fu}{if $ifu == $fu && $i_fu == $v} checked="checked"{/if}{/foreach}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_child">
                                                <span class="lbl"> {$s_value}</span>
                                            {/foreach}
                                        {else}
                                            <input name="bds_project_features[{$fu}][{$v}]" value="{$v}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{foreach from=$ffu key=_iv item=i_fu}{if $ifu == $fu && $i_fu == $v} checked="checked"{/if}{/foreach}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_child">
                                            <span class="lbl"> {$f_item}</span>
                                        {/if}
                                    </label>
                                </div>
                            {/foreach}
                        {/if}
                    {/foreach}
                </div>
            </div>
            {if ($smarty.foreach.f_oo.index+1)%2 == 0}
                <div class="clearfix"></div>
                <div class="space-4" style="border:1px solid silver; margin: 20px 0;"></div>
            {/if}
        {/foreach}
    </div>
</div>