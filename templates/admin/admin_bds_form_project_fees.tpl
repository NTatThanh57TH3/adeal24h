{foreach from=$_bds_fees key=f item=fees}
    {if is_array($fees) && $fees|@count}
        {foreach from=$fees key=sf_key item=sf_value}
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="col-sm-4 control-label no-padding-right" for="form-field-title"> {$sf_value}</label>
                    <div class="col-sm-8">
                        <input type="text" name="bds_project_fees[{$sf_key}]" class="form-control" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" value="{$item->data.bds_fees.$sf_key}" placeholder="Nhập {$sf_value}" />
                    </div>
                </div>
            </div>
        {/foreach}
    {/if}
{/foreach}