{if $itemCategory->data.category_custom_html}
    {include file = "$include_header_footer_category/header.tpl"}
        {$itemCategory->data.category_description}
    {include file = "$include_header_footer_category/footer.tpl"}
{else}
    {include file = 'header.tpl'}
    <div class="content-main bds-main book_bg">
        <div class="container-bds">
            {if $is_news}
                {include file = 'news.tpl'}
            {/if}
            {if $site_bds}
                {include file = 'list_bds.tpl'}
            {/if}
        </div>
    </div>
    {include file = 'footer.tpl'}
{/if}