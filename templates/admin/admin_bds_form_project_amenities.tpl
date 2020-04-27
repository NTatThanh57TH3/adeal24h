<div class="form-group">
    <div class="col-sm-12">
        {foreach from=$_bds_utilities key=ku item=utilitie name=k_oo}
            <div class="col-sm-6">
                <div class="checkbox checkbox_parent">
                    <label>
                        <input name="bds_project_utilities[{$ku}]" value="{$ku}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{if $ifu == $fu} checked="checked"{/if}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_parent">
                        <span class="lbl"> <b>{$utilitie}</b></span>
                    </label>
                    {foreach from=$_bds_utilities_value key=v_ku item=v_utilitie}
                        {if $ku == $v_ku}
                            {foreach from=$v_utilitie key=v item=f_item}
                                <div class="checkbox" style="padding-left: 25px;">
                                    <label>
                                        <input name="bds_project_utilities[{$ku}][{$v}]" value="{$v}"{if $item->data.bds_furniture}{foreach from=$item->data.bds_furniture key=ifu item=ffu}{foreach from=$ffu key=_iv item=i_fu}{if $ifu == $fu && $i_fu == $v} checked="checked"{/if}{/foreach}{/foreach}{/if} name="form-field-checkbox" type="checkbox" class="ace bds_option bds_child">
                                        <span class="lbl"> {$f_item}</span>
                                    </label>
                                </div>
                            {/foreach}
                        {/if}
                    {/foreach}
                </div>
            </div>
            {if ($smarty.foreach.k_oo.index+1)%2 == 0}
                <div class="clearfix"></div>
                <div class="space-4" style="border:1px solid silver; margin: 20px 0;"></div>
            {/if}
        {/foreach}
    </div>
</div>