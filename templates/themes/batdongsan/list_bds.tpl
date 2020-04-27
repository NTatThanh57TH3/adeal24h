<div class="content-main bds-main book_bg">
    <div class="container-bds">
        <h3 class="heading">
            {$itemCategory->data.category_name}
            <a class="btn_view_all margin-right-15" href="{$itemCategory->data.link}">Xem tất cả <i class="fa fa-plus"></i></a>
        </h3>
        <div class="wrap-content clearfix">
            {foreach from=$list key=k item=bds}
                <div class="item_bds bds_normal">
                    <div class="Product_List">
                        <div class="wrap">
                            <div class="avatar">
                                <div class="p_avatar">
                                    <a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_title}" style="background-image: url({$bds.image_normal}); opacity: 1;"></a>
                                </div>
                            </div>
                            <div class="content">
                                <h2 class="bds_title">
                                    <a href="{$bds.link}">{$bds.bds_title}</a>
                                </h2>
                                <div class="area">
                                    <div class="Al_Price_Area">
                                        <span class="margin-right-5">
                                            <span class="product-area"><i class="fa fa-id-card-o" aria-hidden="true"></i>Mã: <b>{$bds.bds_code}</b></span>
                                        </span>
                                        <span class="button-price margin-right-5"><i class="fa fa-tags" aria-hidden="true"></i>
                                            Giá: {if $bds.price}<b>{$bds.price|number_format:0:",":"."} <sup>{$bds.price_unit}</sup></b>{else}Liên hệ trực tiếp{/if}
                                        </span>
                                        <span class="margin-right-5">
                                            <span class="product-area"><i class="fa fa-area-chart" aria-hidden="true"></i>Diện tích: <b>{if $bds.area}{$bds.area}{else}Chưa xác định{/if}</b></span>
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
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>