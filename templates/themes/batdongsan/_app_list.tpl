{include file = 'header.tpl'}
<div class="banner">
    {include file = 'components/banners/banner.tpl' position = "slide"}
    {if $bds_active}
        {include file = 'modules/bds/search.tpl'}
    {/if}
</div>
{if isset($list_bds) && $list_bds && $list_bds|@count}
    <div class="content-main bds-main book_bg2">
        <ul class="container-bds">
            <h3 class="heading">
                {$page_title}
            </h3>
            <div class="wrap-content clearfix">
                <div class="main-list-item">
                    {foreach from=$list_bds key=k item=bds}
                        <div class="item_row">
                            <a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_title}">
                                <img class="image" src="{$bds.image_normal}" />
                            </a>
                            <h2 class="bds_title">
                                <a href="{$bds.link}">{$bds.bds_title}</a>
                            </h2>
                            <div class="content">
                                <div class="area">
                                    <div class="Al_Price_Area">
                                        <span class="margin-right-5">
                                            <span class="product-area"><i class="fa fa-id-card-o" aria-hidden="true"></i>Mã: <b>{$bds.bds_code}</b></span>
                                        </span>
                                            <span class="button-price margin-right-5"><i class="fa fa-tags" aria-hidden="true"></i>Giá: {if $bds.price}<b>{$bds.price|number_format:0:",":"."} <sup>{$bds.price_unit}</sup></b>{else}Liên hệ trực tiếp{/if}</span>
                                        <span class="margin-right-5">
                                            <span class="product-area"><i class="fa fa-area-chart" aria-hidden="true"></i>Diện tích: <b>{if $bds.area}{$bds.area} <sup>m2</sup>{else}Chưa xác định{/if}</b></span>
                                        </span>
                                        <span class="margin-right-5">
                                            <span class="product-area"><i class="fa fa-pencil" aria-hidden="true"></i>Thiết kế: <b>{$bds.bds_number_bedroom} p.ngủ, {$bds.bds_number_bathroom} p.tắm</b></span>
                                        </span>
                                        <span class="margin-right-5">
                                            <span class="product-area"><i class="fa fa-eye" aria-hidden="true"></i>Hướng nhà: <b>{$bds.bds_view}</b></span>
                                        </span>
                                        {if $bds.show_address}
                                            <span class="province">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {if $bds.bds_address_show}
                                                    <a href="{$bds.link_sec}?roads={$bds.bds_address}"><span>{$bds.bds_address}</span></a>,
                                                {/if}
                                                {if $bds.bds_district_show}
                                                    <a href="{$bds.link_sec}?location={$bds.ma_huyen}"><span>{$bds.ten_huyen}</span></a>,
                                                {/if}
                                                {if $bds.bds_city_show}
                                                    <a href="{$bds.link_sec}?area={$bds.ma_tinh}"><span>{$bds.ten_tinh}</span></a>
                                                {/if}
                                            </span>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
{/if}
{include file = 'footer.tpl'}
