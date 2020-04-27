{foreach from=$_bds_prices key=p item=prices}
    {if is_array($prices) && $prices|@count}
        {foreach from=$prices key=sp_key item=sp_value}
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> {$sp_value}</label>
                    <div class="col-sm-8">
                        <input type="text" name="bds_project_prices[{$sp_key}]" class="form-control" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" value="{$item->data.bds_fees.$sp_key}" placeholder="Nhập {$sp_value}" />
                    </div>
                </div>
            </div>
        {/foreach}
    {/if}
{/foreach}