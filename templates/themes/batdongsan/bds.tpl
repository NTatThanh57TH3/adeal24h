{include file = 'header.tpl'}
<div class="content-detail">
    {include file = 'components/banners/banner.tpl' position = "slide"}
    <div class="detail-left">
        <h1 class="detail_title">{$itemBds->data.bds_title}</h1>
        <div class="timer">
            <span class="fa fa-calendar"></span>Ngày đăng: &nbsp;<span class="date date-created">{$itemBds->data.bds_created|date_format:"%d/%m/%Y %H:%M:%S"}</span>&nbsp;{if $itemBds->data.bds_lastupdate && $itemBds->data.bds_lastupdate != '0000-00-00 00:00:00'}|&nbsp;<span class="fa fa-clock-o"></span>Cập nhật:&nbsp;<span class="date date-update">{$itemBds->data.bds_lastupdate|date_format:"%d/%m/%Y %H:%M:%S"}</span>{/if}
        </div>
        <div class="detail-content">
            <div class="detail-desc desc-bds clearfix">
                {if $bds.show_address}
                    <div class="field-desc">
                        <span class="fa fa-map-marker"></span><b>Địa chỉ</b>: {if $bds.bds_address_show}{$itemBds->data.bds_address}, {/if}{if $bds.bds_district_show}{$itemBds->data.ten_huyen}, {/if}{if $bds.bds_city_show}{$itemBds->data.ten_tinh}{/if}
                    </div>
                {/if}
                <div class="field-desc">
                    <div class="item_field dien_tich"><b>Diện tích</b>: {$itemBds->data.bds_area}{$itemBds->data.area_unit}</div>
                    <div class="item_field phong_ngu"><b>Số phòng ngủ</b>: {$itemBds->data.bds_number_bedroom}</div>
                    <div class="item_field phong_tam"><b>Số phòng tắm</b>: {$itemBds->data.bds_number_bathroom}</div>
                    <div class="item_field huong_nha"><b>Hướng nhà</b>: {$itemBds->data.bds_view}</div>
                </div>
                <div class="field-desc">
                    <div class="item_field thanh_toan"><b>Giá</b>: {$itemBds->data.price} <em>VNĐ</em></div>
                    <div class="item_field thanh_toan"><b>Giá/m2</b>: {$itemBds->data.price_area_medium} <em>{$itemBds->data.price_area_medium_unit}</em></div>
                </div>
            </div>
            <div class="detail-contentText">
                {if $itemBds->data.list_images}
                    <div class="gallery">
                        <div class="mygallery" id="mygallery" data-skin="gallery" data-width="600" data-height="405" data-resizemode="fill" data-responsive="true">
                            {foreach from=$itemBds->data.list_images key=k item=pic}
                                <a href="{$pic}" style="display: none;">
                                    <img alt="{$itemBds->data.bds_title}" src="{$pic}">
                                </a>
                            {/foreach}
                            <div class="html5gallery-container-0" style="width: 600px; height: 497px;">
                                <div class="html5gallery-box-0" style="width: 584px; height: 389px;">
                                    <div class="html5gallery-elem-0" style="width: 576px; height: 389px;">
                                        <div class="html5gallery-loading-center-0"></div>
                                        <a style="text-decoration:none;" target="_blank" href="http://html5box.com/html5gallery/watermark.php">
                                            <div style="display:block;visibility:visible;position:absolute;top:10px;left:10px;width:170px;height:18px;line-height:18px;text-align:center;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;background-color:#fff;color:#333;font-size:12px;font-family:Arial,Helvetica,sans-serif;">
                                                HTML5 Gallery Free Version
                                            </div>
                                        </a>
                                    </div>
                                    <div class="html5gallery-title-0" style="width: 576px; display: none;">
                                        <div class="html5gallery-title-text-0">
                                            {$itemBds->data.bds_title}
                                        </div>
                                    </div>
                                    <div class="html5gallery-timer-0" style="width: 0px; top: 387px;"></div>
                                    <div class="html5gallery-viral-0" style="top: 0px;"></div>
                                    <div class="html5gallery-toolbox-0" style="display: none;">
                                        <div class="html5gallery-toolbox-bg-0"></div>
                                        <div class="html5gallery-toolbox-buttons-0">
                                            <div class="html5gallery-play-0" style="top: 334px; left: 488px; display: block;"></div>
                                            <div class="html5gallery-pause-0" style="top: 334px; left: 488px; display: none;"></div>
                                            <div class="html5gallery-left-0" style="top: 171px; display: block; background-position: left top;"></div>
                                            <div class="html5gallery-right-0" style="top: 171px; left: 536px; display: block;"></div>
                                            <div class="html5gallery-lightbox-0" style="top: 334px; left: 536px; display: block;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="html5gallery-car-0" style="width: 576px; top: 411px; height: 74px;">
                                    <div class="html5gallery-car-list-0" style="width: 568px; height: 74px;">
                                        <div class="html5gallery-car-mask-0" style="left: 35px; width: 498px; height: 74px;">
                                            <div class="html5gallery-thumbs-0" style="margin-left: 41.5px; width: 415px;">
                                                <div id="html5gallery-tn-0-0" class="html5gallery-tn-selected-0" data-index="0" style="width: 75px; height: 50px;"></div>
                                                {foreach from=$itemBds->data.list_images key=k item=pic}
                                                    <div id="html5gallery-tn-0-{$k+1}" class="html5gallery-tn-0" data-index="{$k+1}" style="width: 75px; height: 50px;">
                                                        <div class="html5gallery-tn-img-0" style="position:relative;">
                                                            <div style="display:block; overflow:hidden; position:absolute; width:71px;height:46px; top:2px; left:2px;">
                                                                <img class="html5gallery-tn-image-0" style="border:none; padding:0px; margin:0px; max-width:100%; max-height:none; width:71px; height:48px;" src="{$pic}">
                                                            </div>
                                                        </div>
                                                        <div class="html5gallery-tn-title-0">
                                                            {$itemBds->data.bds_title}
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                        <div class="html5gallery-car-slider-bar-0">
                                            <div class="html5gallery-car-slider-bar-top-0"></div>
                                            <div class="html5gallery-car-slider-bar-middle-0"></div>
                                            <div class="html5gallery-car-slider-bar-bottom-0"></div>
                                        </div>
                                        <div class="html5gallery-car-left-0" style="background-position: -64px 0px; display: none; top: 21px;"></div>
                                        <div class="html5gallery-car-right-0" style="background-position: -64px 0px; display: none; top: 21px;"></div>
                                        <div class="html5gallery-car-slider-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {literal}
                    <script type="text/javascript">
                        $("#mygallery").html5gallery({
                            effects:'slide',
                            thumbwidth: 75,
                            thumbheight: 50,
                            thumbshowtitle: false,
                            thumbshadow:false
                        });
                    </script>
                    {/literal}
                {/if}
                {$itemBds->data.bds_info}
                {if $setting.setting_signature_on}
                    <div style="width: 100%; float: left; height: 5px; border-bottom: 1px dotted #e4dcd3; margin: 10px 0;"></div>
                    {$setting.setting_signature_text}
                {/if}
                {include file = 'modules/facebook_comments.tpl'}
                <div class="clearfix"></div>
                {include file = '../../commons/form_contact_info/form_contact_bds.tpl'}
            </div>
        </div>
        {if $_list_design_others}
            <div class="detail-news-relative">
                <h2 class="detail_title ">CÁC BẤT ĐỘNG SẢN KHÁC</h2>
                <div class="right_list_1">
                    {foreach from=$_list_design_others key=k item=bds}
                        <div class="item_bds bds_small">
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
                                                    <span class="button-price margin-right-5"><i class="fa fa-tags" aria-hidden="true"></i>Giá: {if $bds.price}<b>{$bds.price} {$bds.price_unit}</b>{else}Liên hệ trực tiếp{/if}</span>
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
        {/if}
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