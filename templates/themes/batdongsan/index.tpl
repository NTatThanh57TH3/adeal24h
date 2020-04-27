{include file = 'header.tpl'}
<div class="banner">
    {include file = 'components/banners/banner.tpl' position = "slide"}
    {if $bds_active}
        {include file = 'modules/bds/search.tpl'}
    {/if}
</div>
{if $bds_active}
    {include file = 'modules/bds/bds_project_group.tpl' group = "hot"}
    {include file = 'modules/bds/bds_group.tpl' group = "new"}
    {include file = 'modules/bds/bds_group.tpl' group = "project"}
{else}
    {include file = 'components/customs/custom.tpl' position = "position1"}
{/if}
{include file = 'components/banners/banner.tpl' position = "toolbar"}
{include file = 'components/contents/content_new.tpl'}
{include file = 'modules/bds/list.tpl'}
{*<div class="content-main bds-main book_bg_2">*}
    {*<div class="container-bds">*}
        {*<h3 class="heading">*}
            {*Căn hộ chung cư*}
            {*<a class="btn_view_all" href="">Xem tất cả <i class="fa fa-plus"></i></a>*}
        {*</h3>*}
        {*<div class="banner-category clearfix">*}
            {*{include file = 'components/banners/banner.tpl' position = "position1"}*}
            {*{include file = 'components/banners/banner.tpl' position = "position1"}*}
        {*</div>*}
        {*<div class="wrap-content clearfix">*}
            {*{foreach from=$list_bds_groups.new key=k item=bds}*}
                {*<div class="item_bds bds_normal">*}
                    {*<div class="Product_List">*}
                        {*<div class="wrap">*}
                            {*<div class="avatar">*}
                                {*<div class="p_avatar">*}
                                    {*<a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_title}" style="background-image: url({$bds.image_normal}); opacity: 1;"></a>*}
                                {*</div>*}
                            {*</div>*}
                            {*<div class="content">*}
                                {*<h2 class="bds_title">*}
                                    {*<a href="{$bds.link}">{$bds.bds_title}</a>*}
                                {*</h2>*}
                                {*<div class="area">*}
                                    {*<div class="Al_Price_Area">*}
                                        {*<span class="button-price margin-right-5">{if $bds.price}{$bds.price} {$bds.price_unit}{else}Liên hệ trực tiếp{/if}</span>*}
                                        {*<span class="margin-right-5">*}
                                            {*<span class="product-area">{if $bds.area}{$bds.area}{else}Chưa xác định{/if}</span>*}
                                        {*</span>*}
                                        {*<span class="province">*}
                                            {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-phuong-19-binh-thanh-ho-chi-minh.html"><span>{$bds.bds_address}</span></a>,*}
                                            {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-binh-thanh-ho-chi-minh.html"><span>{$bds.ten_huyen}</span></a>,*}
                                            {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-ho-chi-minh.html"><span>{$bds.ten_tinh}</span></a>*}
                                        {*</span>*}
                                    {*</div>*}
                                {*</div>*}
                            {*</div>*}
                        {*</div>*}
                    {*</div>*}
                {*</div>*}
            {*{/foreach}*}
        {*</div>*}
    {*</div>*}
{*</div>*}
{*<div class="content-main bds-main book_bg_2">*}
    {*<div class="container-bds two">*}
        {*<h3 class="heading">*}
            {*Căn hộ chung cư*}
            {*<a class="btn_view_all" href="">Xem tất cả <i class="fa fa-plus"></i></a>*}
        {*</h3>*}
        {*<div class="banner-category clearfix">*}
            {*{include file = 'components/banners/banner.tpl' position = "position1"}*}
        {*</div>*}
        {*<div class="wrap-content clearfix">*}
            {*{foreach from=$list_bds_groups.new key=k item=bds name=foo}*}
                {*{if $smarty.foreach.foo.index < 3}*}
                    {*<div class="item_bds bds_small">*}
                        {*<div class="Product_List">*}
                            {*<div class="wrap">*}
                                {*<div class="avatar">*}
                                    {*<div class="p_avatar">*}
                                        {*<a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_title}" style="background-image: url({$bds.image_normal}); opacity: 1;"></a>*}
                                    {*</div>*}
                                {*</div>*}
                                {*<div class="content">*}
                                    {*<h2 class="bds_title">*}
                                        {*<a href="{$bds.link}">{$bds.bds_title}</a>*}
                                    {*</h2>*}
                                    {*<div class="area">*}
                                        {*<div class="Al_Price_Area">*}
                                            {*<span class="button-price margin-right-5">{if $bds.price}{$bds.price} {$bds.price_unit}{else}Liên hệ trực tiếp{/if}</span>*}
                                            {*<span class="margin-right-5">*}
                                                {*<span class="product-area">{if $bds.area}{$bds.area}{else}Chưa xác định{/if}</span>*}
                                            {*</span>*}
                                            {*<span class="province">*}
                                                {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-phuong-19-binh-thanh-ho-chi-minh.html"><span>{$bds.bds_address}</span></a>,*}
                                                {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-binh-thanh-ho-chi-minh.html"><span>{$bds.ten_huyen}</span></a>,*}
                                                {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-ho-chi-minh.html"><span>{$bds.ten_tinh}</span></a>*}
                                            {*</span>*}
                                        {*</div>*}
                                    {*</div>*}
                                {*</div>*}
                            {*</div>*}
                        {*</div>*}
                    {*</div>*}
                {*{/if}*}
            {*{/foreach}*}
        {*</div>*}
    {*</div>*}
    {*<div class="container-bds two">*}
        {*<h3 class="heading">*}
            {*Căn hộ chung cư*}
            {*<a class="btn_view_all" href="">Xem tất cả <i class="fa fa-plus"></i></a>*}
        {*</h3>*}
        {*<div class="banner-category clearfix">*}
            {*{include file = 'components/banners/banner.tpl' position = "position1"}*}
        {*</div>*}
        {*<div class="wrap-content clearfix">*}
            {*{foreach from=$list_bds_groups.new key=k item=bds name=foo}*}
                {*{if $smarty.foreach.foo.index < 3}*}
                    {*<div class="item_bds bds_small">*}
                        {*<div class="Product_List">*}
                            {*<div class="wrap">*}
                                {*<div class="avatar">*}
                                    {*<div class="p_avatar">*}
                                        {*<a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_title}" style="background-image: url({$bds.image_normal}); opacity: 1;"></a>*}
                                    {*</div>*}
                                {*</div>*}
                                {*<div class="content">*}
                                    {*<h2 class="bds_title">*}
                                        {*<a href="{$bds.link}">{$bds.bds_title}</a>*}
                                    {*</h2>*}
                                    {*<div class="area">*}
                                        {*<div class="Al_Price_Area">*}
                                            {*<span class="button-price margin-right-5">{if $bds.price}{$bds.price} {$bds.price_unit}{else}Liên hệ trực tiếp{/if}</span>*}
                                            {*<span class="margin-right-5">*}
                                                {*<span class="product-area">{if $bds.area}{$bds.area}{else}Chưa xác định{/if}</span>*}
                                            {*</span>*}
                                            {*<span class="province">*}
                                                {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-phuong-19-binh-thanh-ho-chi-minh.html"><span>{$bds.bds_address}</span></a>,*}
                                                {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-binh-thanh-ho-chi-minh.html"><span>{$bds.ten_huyen}</span></a>,*}
                                                {*<a href="/giao-dich/cho-thue-can-ho-mini-tai-ho-chi-minh.html"><span>{$bds.ten_tinh}</span></a>*}
                                            {*</span>*}
                                        {*</div>*}
                                    {*</div>*}
                                {*</div>*}
                            {*</div>*}
                        {*</div>*}
                    {*</div>*}
                {*{/if}*}
            {*{/foreach}*}
        {*</div>*}
    {*</div>*}
{*</div>*}
<div class="content-main">
    {include file = 'components/contents/content_special.tpl'}
</div>
{include file = 'footer.tpl'}