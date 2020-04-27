{if $task == 'section'}
    {if $check_sub}
        {if $list_data_contents}
            {foreach from=$list_data_contents key=d item=category}
                {if $category.data}
                    <h3 class="heading">
                        {$category.cat.category_name}
                        <a class="btn_view_all" href="{$category.link}">Xem tất cả <i class="fa fa-plus"></i></a>
                    </h3>
                    <div class="wrap-content bxSlider_new clearfix">
                        {foreach from=$category.data key=c item=content name=foo}
                            <div class="item_bds item_content">
                                <div class="Product_List">
                                    <div class="wrap">
                                        <div class="avatar">
                                            <div class="p_avatar">
                                                <a href="{$content.link}" class="owl-lazy" title="{$content.content_title}" style="background-image: url({$content.image_normal}); opacity: 1;"></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h2 class="bds_title">
                                                <a href="{$content.link}">{$content.content_title}</a>
                                            </h2>
                                            <div class="datetime">
                                                <span class="fa fa-clock-o"></span>
                                                {if $content.content_modified && $content.content_modified != '0000-00-00 00:00:00'}
                                                    {$content.content_modified|date_format:"%d/%m/%Y %H:%M"}
                                                {else}
                                                    {$content.content_created|date_format:"%d/%m/%Y %H:%M"}
                                                {/if}
                                            </div>
                                            <div class="area">
                                                {$content.content_introtext|truncate:150:"..."}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                {/if}
            {/foreach}
        {/if}
    {else}
        <h3 class="heading">
            {$itemCategory->data.category_name}
        </h3>
        <div class="wrap-content nopad-lr clearfix">
            {foreach from=$list_contents key=k item=content name=foo}
                <div class="item_bds item_content">
                    <div class="Product_List">
                        <div class="wrap">
                            <div class="avatar">
                                <div class="p_avatar">
                                    <a href="{$content.link}" class="owl-lazy" title="{$content.content_title}" style="background-image: url({$content.image_normal}); opacity: 1;"></a>
                                </div>
                            </div>
                            <div class="content">
                                <h2 class="bds_title">
                                    <a href="{$content.link}">{$content.content_title}</a>
                                </h2>
                                <div class="datetime">
                                    <span class="fa fa-clock-o"></span>
                                    {if $content.content_modified && $content.content_modified != '0000-00-00 00:00:00'}
                                        {$content.content_modified|date_format:"%d/%m/%Y %H:%M"}
                                    {else}
                                        {$content.content_created|date_format:"%d/%m/%Y %H:%M"}
                                    {/if}
                                </div>
                                <div class="area">
                                    {$content.content_introtext|truncate:150:"..."}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
            <div class="pagination-page">
                <form id="adminForm" method="POST" name="adminForm" action="">
                    <input type="hidden" value="{$task}" name="task">
                    <input type="hidden" value="{$totalRecords}" name="total_record" id="total_record" />
                    {if $totalRecords}
                        {$datapage}
                    {/if}
                </form>
            </div>
            {literal}
                <script language="javascript" type="text/javascript">
                    function submitform(){
                        $('#adminForm').submit();
                    }
                </script>
            {/literal}
        </div>
    {/if}
{else}
    <h3 class="heading">
        {$itemCategory->data.category_name}
    </h3>
    <div class="wrap-content nopad-lr clearfix">
        {foreach from=$list_contents key=k item=content name=foo}
            <div class="item_bds item_content">
                <div class="Product_List">
                    <div class="wrap">
                        <div class="avatar">
                            <div class="p_avatar">
                                <a href="{$content.link}" class="owl-lazy" title="{$content.content_title}" style="background-image: url({$content.image_normal}); opacity: 1;"></a>
                            </div>
                        </div>
                        <div class="content">
                            <h2 class="bds_title">
                                <a href="{$content.link}">{$content.content_title}</a>
                            </h2>
                            <div class="datetime">
                                <span class="fa fa-clock-o"></span>
                                {if $content.content_modified && $content.content_modified != '0000-00-00 00:00:00'}
                                    {$content.content_modified|date_format:"%d/%m/%Y %H:%M"}
                                {else}
                                    {$content.content_created|date_format:"%d/%m/%Y %H:%M"}
                                {/if}
                            </div>
                            <div class="area">
                                {$content.content_introtext|truncate:150:"..."}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
        <div class="pagination-page">
            <form id="adminForm" method="POST" name="adminForm" action="">
                <input type="hidden" value="{$task}" name="task">
                <input type="hidden" value="{$totalRecords}" name="total_record" id="total_record" />
                {if $totalRecords}
                    {$datapage}
                {/if}
            </form>
        </div>
        {literal}
            <script language="javascript" type="text/javascript">
                function submitform(){
                    $('#adminForm').submit();
                }
            </script>
        {/literal}
    </div>
{/if}