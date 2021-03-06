{if $task == "add" || $task == "edit"}
    <div class="row">
        <div class="col-xs-6">
            <div class="widget-box">
                <div class="widget-header">
                    <h4>Mô tả ngắn sản phẩm</h4>
                    <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                            <i class="icon-chevron-up"></i>
                        </a>
                        <a data-action="close" href="#">
                            <i class="icon-remove"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-body-inner" style="display: block;">
                        <div class="widget-main">
                            {if $task == 'add'}
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" name="bds_introtext[]" class="col-xs-12 col-sm-12" value=""
                                               placeholder="Mô tả sản phẩm 1"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" name="bds_introtext[]" class="col-xs-12 col-sm-12" value=""
                                               placeholder="Mô tả sản phẩm 2"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" name="bds_introtext[]" class="col-xs-12 col-sm-12" value=""
                                               placeholder="Mô tả sản phẩm 3"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" name="bds_introtext[]" class="col-xs-12 col-sm-12" value=""
                                               placeholder="Mô tả sản phẩm 4"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="text" name="bds_introtext[]" class="col-xs-12 col-sm-12" value=""
                                               placeholder="Mô tả sản phẩm 5"/>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                            {else}
                                {foreach from=$bdsById key='k' item='foo'}
                                    {foreach from=$foo.introtext key='key' item='item'}
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" name="bds_introtext[]" class="col-xs-12 col-sm-12"
                                                       value="{$item}" placeholder="Mô tả sản phẩm {$k+1}"/>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                    {/foreach}
                                {/foreach}
                                {*{foreach from=$bdsById key='k' item='foo'}*}
                                    {*{foreach from=$foo.introtext key='key' item='item'}*}
                                    {*{if $bdsById['introtext']|@count<5}*}
                                        {*{foreach name=foo start=$bdsById['introtext']|@count loop=5}*}
                                            {*<div class="form-group">*}
                                                {*<div class="col-sm-12">*}
                                                    {*<input type="text" name="bds_introtext[]"*}
                                                           {*class="col-xs-12 col-sm-12" value=""*}
                                                           {*placeholder="Mô tả sản phẩm {$smarty.foreach.foo.index+1}"/>*}
                                                {*</div>*}
                                            {*</div>*}
                                            {*<div class="space-4"></div>*}
                                        {*{/foreach}*}
                                    {*{/if}*}
                                    {*{/foreach}*}
                                {*{/foreach}*}
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 pull-right">
            <div class="widget-box">
                <div class="widget-header">
                    <h4>Từ khóa tìm kiếm - SEO</h4>
                    <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                            <i class="icon-chevron-up"></i>
                        </a>
                        <a data-action="close" href="#">
                            <i class="icon-remove"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-body-inner" style="display: block;">
                        <div class="widget-main">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-description"> Mô
                                    tả tìm kiếm</label>
                                <div class="col-sm-9">
                                    <textarea cols="50" rows="4" class="form-control"
                                              name="product_metadesc">{$thisProduct->data.product_metadesc}</textarea>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-keyword"> Từ
                                    khóa </label>
                                <div class="col-sm-9">
                                    <textarea cols="50" rows="4" class="form-control" name="product_metakey"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-4"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4>Mô tả chi tiết</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-body-inner" style="display: block;">
                        <div class="widget-main">
                            <div class="form-group">
                                {foreach from=$bdsById key='k' item='foo'}
                                    <div class="col-sm-12">
                                        <textarea cols="65" rows="15" name="bds_fulltext" id="fulltext"
                                                  class="wysiwyg-editor">{$foo.fulltext}</textarea>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}