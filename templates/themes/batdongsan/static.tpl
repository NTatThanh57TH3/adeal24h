{if $itemStatic->data.static_custom_html_mobile && $isMobile}
    {include file = "$include_header_footer_static/mobile/header.tpl"}
        {$itemStatic->data.static_fulltext_mobile}
    {include file = "$include_header_footer_static/mobile/footer.tpl"}
{elseif $itemStatic->data.static_custom_html}
    {include file = "$include_header_footer_static/header.tpl"}
        {$itemStatic->data.static_fulltext}
    {include file = "$include_header_footer_static/footer.tpl"}
{else}
    {include file = 'header.tpl'}
    <div class="content-detail">
        {include file = 'components/banners/banner.tpl' position = "slide"}
        <div class="detail-left">
            <h1 class="detail_title">{$itemStatic->data.static_title}</h1>
            <div class="timer">
                <span class="fa fa-calendar"></span>Ngày đăng: &nbsp;<span class="date date-created">{$itemStatic->data.static_created|date_format:"%d/%m/%Y %H:%M:%S"}</span>&nbsp;{if $itemStatic->data.static_modified && $itemStatic->data.static_modified != '0000-00-00 00:00:00'}|&nbsp;<span class="fa fa-clock-o"></span>Cập nhật:&nbsp;<span class="date date-update">{$itemStatic->data.static_modified|date_format:"%d/%m/%Y %H:%M:%S"}</span>{/if}
            </div>
            <div class="detail-content">
                <div class="detail-contentText">
                    {$itemStatic->data.static_fulltext}
                    {if $setting.setting_signature_on}
                        <div style="width: 100%; float: left; height: 5px; border-bottom: 1px dotted #e4dcd3; margin: 10px 0;"></div>
                        {$setting.setting_signature_text}
                    {/if}
                    {include file = 'modules/facebook_comments.tpl'}
                    <div class="clearfix"></div>
                </div>
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