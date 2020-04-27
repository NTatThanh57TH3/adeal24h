{if $itemContent->data.content_custom_html_mobile && $isMobile}
    {include file = "$include_header_footer_content/mobile/header.tpl"}
        {$itemContent->data.content_fulltext_mobile}
    {include file = "$include_header_footer_content/mobile/footer.tpl"}
{elseif $itemContent->data.content_custom_html}
    {include file = "$include_header_footer_content/header.tpl"}
        {$itemContent->data.content_fulltext}
    {include file = "$include_header_footer_content/footer.tpl"}
{else}
    {include file = 'header.tpl'}
    <div class="content-detail">
        {include file = 'components/banners/banner.tpl' position = "slide"}
        <div class="detail-left">
            <h1 class="detail_title">{$itemContent->data.content_title}</h1>
            <i class="timer">{$itemContent->data.content_created}</i>
            <div class="detail-content">
                <h2 class="detail-desc">{$itemContent->data.content_introtext}</h2>
                <div class="detail-contentText">
                    {$itemContent->data.content_fulltext}
                </div>

            </div>
            <div class="detail-news-relative">
                <h2 class="detail_title ">CÁC TIN KHÁC</h2>
                <ul class="right_list_1">
                    {foreach from=$list_others key=c item=other}
                    <li><a href="{$other.link}">{$other.content_title}</a> </li>
                    {/foreach}
                </ul>
            </div>
        </div><!--End Left-->
        <!--Right-->
        <div class="detail-right">
            <div class="right_box nav">
                {include file = 'modules/bds/search.tpl'}
            </div>
            {include file = 'components/contents/content_hot.tpl'}
            {include file = 'components/categories/categories_style.tpl'}
            {include file = 'components/banners/banner.tpl' position = "right"}
        </div>
    </div>
    {include file = 'footer.tpl'}
{/if}