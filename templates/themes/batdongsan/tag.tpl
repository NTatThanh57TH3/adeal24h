{if $itemTag.tag_custom_html_mobile && $isMobile}
    {include file = "$include_header_footer_tag/mobile/header.tpl"}
        {$itemTag.tag_fulltext_mobile}
    {include file = "$include_header_footer_tag/mobile/footer.tpl"}
{elseif $itemTag.tag_custom_html}
    {include file = "$include_header_footer_tag/header.tpl"}
        {$itemTag.tag_fulltext}
    {include file = "$include_header_footer_tag/footer.tpl"}
{else}
    {include file = '_header.tpl'}
    <section class="container-fluid full">
        <div class="row">
            {include file = 'components/banners/banner.tpl' position = "slide"}
        </div>
    </section>
    {include file = 'modules/others/navigation.tpl'}
    <div class="clearfix"></div>
    <div class="content-strip feature-screen e-padding-bottom-50">
        <div class="page-main">
            <div class="e-container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <p class="section-heading" align="center">{$itemTag.tag_name}</p>
                        <p class="section-description">{if $itemTag.tag_fulltext}{$itemTag.tag_fulltext}{elseif $itemTag.tag_short_desc}{$itemTag.tag_short_desc}{/if}</p>
                    </div>
                    <div class="col-lg-12">
                        <div class="thumb-tacked-strip clearfix">
                            {foreach from=$list_tags key=c item=content name=foo}
                                {if $smarty.foreach.foo.index <= 2}
                                    <div class="thumb-tacked">
                                        <div class="thumb-tacked-image">
                                            <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">
                                                <img alt="{$content.content_title}" src="{$content.image_normal}">
                                            </a>
                                        </div>
                                        <h3><a rel="nofollow" href="{$content.link}" title="{$content.content_title}">{$content.content_title}</a></h3>
                                        <p>{$content.content_introtext|truncate:160:"..."}</p>
                                        <div class="read_more">
                                            <a rel="nofollow" href="{$content.link}">Xem thêm <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-strip feature-section e-margin-top-100">
        <div class="page-main">
            <div class="e-container">
                <div class="row">
                    <div class="col-xs-6">
                        {foreach from=$list_tags key=c item=content name=foo}
                            {if $smarty.foreach.foo.index > 2 && $smarty.foreach.foo.index <= 5}
                                <div class="corner-item pull-left">
                                    <div class="media">
                                        <div class="media-left">
                                            <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">
                                                <img class="media-object" alt="{$content.content_title}" src="{$content.tiny_thumbnail}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">{$content.content_title}</a>
                                            </h4>
                                            <p>{$content.content_introtext|truncate:100:"..."}</p>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                    <div class="col-xs-6">
                        {foreach from=$list_tags key=c item=content name=foo}
                            {if $smarty.foreach.foo.index > 5 && $smarty.foreach.foo.index <= 8}
                                <div class="corner-item pull-right">
                                    <div class="media">
                                        <div class="media-left">
                                            <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">
                                                <img class="media-object" alt="{$content.content_title}" src="{$content.tiny_thumbnail}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">{$content.content_title}</a>
                                            </h4>
                                            <p>{$content.content_introtext|truncate:100:"..."}</p>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {include file = 'components/banners/banner.tpl' position = "toolbar"}

    <div class="content-strip feature-muted e-padding-top-50">
        <div class="page-main">
            <div class="e-container">
                <div class="row">
                    <div class="col-xs-5 tab-image">
                        {foreach from=$list_tags key=c item=content name=foo}
                            {if $smarty.foreach.foo.index > 8 && $smarty.foreach.foo.index <= 11}
                                <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">
                                    <img class="image tab{$smarty.foreach.foo.index}{if $smarty.foreach.foo.index == 9} active{/if}" src="{$content.image_normal}" />
                                </a>
                            {/if}
                        {/foreach}
                    </div>
                    <div class="col-xs-7 mobile-view-callouts">
                        {foreach from=$list_tags key=c item=content name=foo}
                            {if $smarty.foreach.foo.index > 8 && $smarty.foreach.foo.index <= 11}
                                <div class="callout{if $smarty.foreach.foo.index == 9} active{/if}" title="{$smarty.foreach.foo.index}">
                                    <div class="callout-row">
                                        <div class="callout-container">
                                            <div class="callout-image">
                                                <img alt="{$content.content_title}" src="{$content.tiny_thumbnail}">
                                            </div>
                                            <h3>{$content.content_title}</h3>
                                            <p class="text-muted">{$content.content_introtext|truncate:180:"..."}</p>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
            {literal}
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.callout').click(function(){
                            $('.callout').each(function(){
                                $(this).removeClass('active');
                            });
                            $('.tab-image img').each(function(){
                                $(this).removeClass('active');
                            });

                            var show_name = $(this).attr('title');
                            $(this).addClass('active');
                            $('.tab-image').find('img').hide();
                            $('.tab-image').find('img.tab' + show_name).fadeIn();
                        });
                    });
                </script>
            {/literal}
        </div>
    </div>

    <div class="content-strip feature-screen">
        <div class="page-main">
            <div class="e-container">
                <div class="row">
                    {foreach from=$list_tags key=c item=content name=foo}
                        {if $smarty.foreach.foo.index > 11}
                            <div class="col-xs-4 text-left">
                                <div class="well well-clean">
                                    <div class="well-image">
                                        <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">
                                            <img alt="{$content.content_title}" src="{$content.image_thumbnail}">
                                        </a>
                                    </div>
                                    <h4 class="well-heading">
                                        <a rel="nofollow" href="{$content.link}" title="{$content.content_title}">{$content.content_title}</a>
                                    </h4>
                                    <p>{$content.content_introtext|truncate:125:"..."}</p>
                                </div>
                            </div>
                        {/if}
                    {/foreach}
                </div>
            </div>
        </div>
        </div>
    </div>

    {include file = '_footer.tpl'}
{/if}