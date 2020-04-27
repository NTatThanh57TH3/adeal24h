{include file = 'header.tpl'}
{*{include file = 'modules/bds/filter_location.tpl'}*}
{if $list_bds}
    {foreach from=$list_bds key=a item=area}
        <div class="content-main bds-main book_bg_2">
            <div class="container-bds">
                <h3 class="heading">
                    {$itemArea->data.bds_section_name}
                    <a href="" class="btn_view_all" href="">Xem tất cả <i class="fa fa-plus"></i></a>
                </h3>
                <div class="banner-category clearfix">
                    {include file = 'components/banners/banner.tpl' position = "position1"}
                    {include file = 'components/banners/banner.tpl' position = "position1"}
                </div>
                <div class="wrap-content clearfix">
                    <div class="nav-left nav">
                        {include file = 'modules/bds/filter.tpl'}
                    </div>
                    {if $area.data}
                        <div class="main-list-item">
                            {foreach from=$area.data key=k item=bds}
                                <div class="item_row">
                                    <a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_title}">
                                        <img class="image" src="{$bds.image_thumbnail}" />
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
                    <div class="nav-right nav">
                        {include file = 'modules/bds/search.tpl'}
                        <div class="clearfix"></div>
                        {include file = 'components/contents/content_new.tpl'}
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
{/if}
{include file = 'footer.tpl'}