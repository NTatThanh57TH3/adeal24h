{include file = 'header.tpl'}
{if $task == "view"}
    <div class="content-detail">
        {include file = 'components/banners/banner.tpl' position = "slide"}
        <div class="detail-left">
            <h1 class="detail_title">{$itemProject->data.bds_project_name}</h1>
            <div class="timer">
                <span class="fa fa-calendar"></span>Ngày đăng: &nbsp;<span class="date date-created">{$itemProject->data.bds_project_created|date_format:"%d/%m/%Y %H:%M:%S"}</span>&nbsp;{if $itemProject->data.bds_project_lastupdate && $itemProject->data.bds_project_lastupdate != '0000-00-00 00:00:00'}|&nbsp;<span class="fa fa-clock-o"></span>Cập nhật:&nbsp;<span class="date date-update">{$itemProject->data.bds_project_lastupdate|date_format:"%d/%m/%Y %H:%M:%S"}</span>{/if}
            </div>
            <div class="detail-content">
                <div class="detail-desc-button">
                    <ul>
                        <li><a data-id="tong-quan" href="{$actual_link}#tong-quan">Tổng quan</a></li>
                        <li><a data-id="hinh-anh" href="{$actual_link}#hinh-anh">Hình ảnh</a></li>
                        <li><a data-id="gioi-thieu" href="{$actual_link}#gioi-thieu">Giới thiệu</a></li>
                        <li><a data-id="vi-tri-dia-ly" href="{$actual_link}#vi-tri-dia-ly">Vị trí địa lý</a></li>
                        <li><a data-id="tien-ich" href="{$actual_link}#tien-ich">Tiện ích</a></li>
                        <li><a data-id="dac-diem" href="{$actual_link}#dac-diem">Đặc điểm</a></li>
                        <li><a data-id="gia-ban" href="{$actual_link}#gia-ban">Giá bán</a></li>
                        <li><a data-id="cac-chi-phi" href="{$actual_link}#cac-chi-phi">Các chi phí</a></li>
                    </ul>
                </div>
                <div id="tong-quan" class="detail-desc desc-bds clearfix">
                    <div class="field-desc">
                        <div class="item_field two_colum dien_tich"><b>Chủ đầu tư</b>: {$itemProject->data.bds_project_investor}</div>
                        <div class="item_field two_colum phong_ngu"><b>Đơn vị thiết kế kiến trúc</b>: {$itemProject->data.bds_number_bedroom}</div>
                    </div>
                    <div class="field-desc">
                        <div class="item_field two_colum dien_tich"><b>Đơn vị thiết kế cảnh quan</b>: {$itemProject->data.bds_area}{$itemProject->data.area_unit}</div>
                        <div class="item_field two_colum phong_ngu"><b>Đơn vị thiết kế nội thất</b>: {$itemProject->data.bds_number_bedroom}</div>
                    </div>
                    <div class="field-desc">
                        <div class="item_field two_colum dien_tich"><b>Nhà thầu thi công</b>: {$itemProject->data.bds_area}{$itemProject->data.area_unit}</div>
                        <div class="item_field two_colum phong_ngu"><b>Đơn vị quản lý</b>: {$itemProject->data.bds_number_bedroom}</div>
                    </div>
                    <div class="field-desc">
                        <div class="item_field two_colum dien_tich"><b>Vốn đầu tư</b>: {$itemProject->data.bds_project_investment}</div>
                        <div class="item_field two_colum phong_ngu"><b>Diện tích cây xanh và mặt nước</b>: {$itemProject->data.bds_project_parkland_wetland}</div>
                    </div>
                    <div class="field-desc">
                        <div class="item_field two_colum dien_tich"><b>Mật độ xây dựng</b>: {$itemProject->data.bds_area}{$itemProject->data.bds_project_density}</div>
                        <div class="item_field two_colum phong_ngu"><b>Ngân hàng bảo trợ vốn</b>: {$itemProject->data.bds_project_associated_bank}</div>
                    </div>
                    <div class="field-desc">
                        <div class="item_field one_colum dien_tich">
                            <b>Chủng loại</b>:
                            {if $itemProject->data.dataCat && is_array($itemProject->data.dataCat)}
                                {foreach from = $itemProject->data.dataCat key=c item=cat}
                                    <a target="_blank" href="{$cat.link}">{$cat.category_name}</a>
                                    {if $itemProject->data.dataCat|@count > ($c+1)}, {/if}
                                {/foreach}
                            {/if}
                        </div>
                    </div>
                    <div class="field-desc">
                        {if $itemProject->data.bds_project_number_blocks && is_array($itemProject->data.bds_project_number_blocks)}
                            {foreach from = $itemProject->data.bds_project_number_blocks key=block item=number}
                                <div class="item_field three_colum dien_tich">
                                    <b>{$block}: </b>{$number|number_format:0:",":"."}
                                </div>
                            {/foreach}
                        {/if}
                    </div>
                    <div class="field-desc">
                        <div class="item_field three_colum dien_tich"><b>Năm khởi công</b>: {$itemProject->data.bds_project_commencement_year}</div>
                        <div class="item_field three_colum phong_ngu"><b>Năm hoàn thành</b>: {$itemProject->data.bds_project_completion_year}</div>
                        <div class="item_field three_colum phong_tam"><b>Ngày bàn giao nhà</b>: {$itemProject->data.bds_project_date_hand_over|date_format:"%d/%m/%Y"}</div>
                    </div>
                    <div class="field-desc">
                        <div class="item_field three_colum dien_tich"><b>Tổng diện tích dự án</b>: {$itemProject->data.bds_project_total_area} <sup>{$itemProject->data.bds_projectunit_area_scale_unit}</sup></div>
                        <div class="item_field three_colum phong_ngu"><b>Diện tích xây dựng</b>: {$itemProject->data.bds_project_construction_area} <sup>{$itemProject->data.bds_projectunit_area_scale_unit}</sup></div>
                        <div class="item_field three_colum phong_tam"><b>Quy mô dự án</b>: {$itemProject->data.bds_project_scale} <sup>{$itemProject->data.bds_projectunit_area_scale_unit}</sup></div>
                    </div>
                </div>
                <div id="hinh-anh" class="detail-contentText">
                    {if $itemProject->data.list_images}
                        <div class="gallery">
                            <div class="mygallery" id="mygallery" data-skin="gallery" data-width="600" data-height="405" data-resizemode="fill" data-responsive="true">
                                {foreach from=$itemProject->data.list_images key=k item=pic}
                                    <a href="{$pic}" style="display: none;">
                                        <img alt="{$itemProject->data.bds_project_name}" src="{$pic}">
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
                                                {$itemProject->data.bds_project_name}
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
                                                    {foreach from=$itemProject->data.list_images key=k item=pic}
                                                        <div id="html5gallery-tn-0-{$k+1}" class="html5gallery-tn-0" data-index="{$k+1}" style="width: 75px; height: 50px;">
                                                            <div class="html5gallery-tn-img-0" style="position:relative;">
                                                                <div style="display:block; overflow:hidden; position:absolute; width:71px;height:46px; top:2px; left:2px;">
                                                                    <img class="html5gallery-tn-image-0" style="border:none; padding:0px; margin:0px; max-width:100%; max-height:none; width:71px; height:48px;" src="{$pic}">
                                                                </div>
                                                            </div>
                                                            <div class="html5gallery-tn-title-0">
                                                                {$itemProject->data.bds_project_name}
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
                </div>
                <div id="gioi-thieu" class="detail-contentText">
                    {$itemProject->data.bds_project_info}
                    {if $setting.setting_signature_on}
                        <div style="width: 100%; float: left; height: 5px; border-bottom: 1px dotted #e4dcd3; margin: 10px 0;"></div>
                        {$setting.setting_signature_text}
                    {/if}
                    <h2 class="headingBox">Các sản phẩm của dự án {$itemProject->data.bds_project_name}</h2>
                    <div class="wrap-content clearfix">
                        {foreach from=$list_bds_of_project key=k item=bds}
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
                                                    <span class="button-price margin-right-5"><i class="fa fa-tags" aria-hidden="true"></i>Giá: {if $bds.price}<b>{$bds.price|number_format:0:",":"."} <sup>{$bds.price_unit}</sup></b>{else}Liên hệ trực tiếp{/if}</span>
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
                                                            <i class="fa fa-map-marker" aria-hidden="true"></i><a href="{$bds.link_sec}?roads={$bds.bds_address}"><span>{$bds.bds_address}</span></a>,
                                                            <a href="{$bds.link_sec}?location={$bds.ma_huyen}"><span>{$bds.ten_huyen}</span></a>,
                                                            <a href="{$bds.link_sec}?area={$bds.ma_tinh}"><span>{$bds.ten_tinh}</span></a>
                                                        </span>
                                                    {/if}
                                                </div>
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
                    <div class="clearfix"></div>
                    {include file = 'modules/facebook_comments.tpl'}
                    <div class="clearfix"></div>
                    {include file = '../../commons/form_contact_info/form_contact_bds.tpl'}
                </div>
                <div id="vi-tri-dia-ly" class="detail-contentText">
                    <div class="detail-desc desc-bds clearfix">
                        <div class="field-desc">
                            <span class="fa fa-map-marker"></span><b>Địa chỉ</b>: {$itemProject->data.bds_project_address}, {$itemProject->data.ten_huyen}, {$itemProject->data.ten_tinh}
                        </div>
                        <div class="field-desc">
                            <div class="item_field lo_goc"><b>Lô góc</b>: {if $itemProject->data.bds_project_location_corner == 1}<span class="fa fa-check-square-o"></span>{else}<span class="fa fa-ban"></span>{/if}</div>
                            <div class="item_field gan_cong_vien"><b>Gần công viên</b>: {if $itemProject->data.bds_project_location_parkside == 1}<span class="fa fa-check-square-o"></span>{else}<span class="fa fa-ban"></span>{/if}</div>
                            <div class="item_field gan_ven_ho"><b>Ven hồ</b>: {if $itemProject->data.bds_project_location_lakeside == 1}<span class="fa fa-check-square-o"></span>{else}<span class="fa fa-ban"></span>{/if}</div>
                            <div class="item_field gan_ven_song"><b>Ven sông</b>: {if $itemProject->data.bds_project_location_riverside == 1}<span class="fa fa-check-square-o"></span>{else}<span class="fa fa-ban"></span>{/if}</div>
                        </div>
                    </div>
                </div>
                <div id="tien-ich" class="detail-contentText">
                    Các tiện ích
                </div>
                <div id="dac-diem" class="detail-contentText">
                    Các đặc điểm
                </div>
                <div id="gia-ban" class="detail-contentText">
                    Giá bán
                </div>
                <div id="cac-chi-phi class="detail-contentText">
                    Chi phí
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
                                                <a href="{$bds.link}" class="owl-lazy" title="{$bds.bds_project_name}" style="background-image: url({$bds.image_normal}); opacity: 1;"></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h2 class="bds_project_name">
                                                <a href="{$bds.link}">{$bds.bds_project_name}</a>
                                            </h2>
                                            <div class="area">
                                                <div class="Al_Price_Area">
                                                    <span class="margin-right-5">
                                                        <span class="product-area"><i class="fa fa-id-card-o" aria-hidden="true"></i>Mã: <b>{$bds.bds_code}</b></span>
                                                    </span>
                                                    <span class="button-price margin-right-5"><i class="fa fa-tags" aria-hidden="true"></i>Giá: {if $bds.price}<b>{$bds.price|number_format:0:",":"."} <sup>{$bds.price_unit}</sup></b>{else}Liên hệ trực tiếp{/if}</span>
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
                                                            <i class="fa fa-map-marker" aria-hidden="true"></i><a href="{$bds.link_sec}?roads={$bds.bds_address}"><span>{$bds.bds_address}</span></a>,
                                                            <a href="{$bds.link_sec}?location={$bds.ma_huyen}"><span>{$bds.ten_huyen}</span></a>,
                                                            <a href="{$bds.link_sec}?area={$bds.ma_tinh}"><span>{$bds.ten_tinh}</span></a>
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
{else}
    <div class="content-main bds-main book_bg">
        <div class="container-bds">
            <h3 class="heading">
                {if $task == 'all'}Danh sách dự án{elseif $task == 'da-ban-giao'}Các dự án bất động sản đã bàn giao{elseif $task == 'chua-ban-giao'}Các dự án bất động sản chưa bàn giao{/if}
            </h3>
            <div class="wrap-content nopad-lr clearfix">
                {include file = 'modules/bds/search_project.tpl'}
                {foreach from=$_list_projects key=p item=project name=foo}
                    <div class="project-items-list">
                        <div class="project-items-avatar">
                            <a href="{$project.link}" title="{$project.bds_project_name}" style="background-image:url('{$project.image_thumbnail}')">
                            </a>
                        </div>
                        <div class="project-items-content">
                            <h3 class="project-items-title">
                                <a href="{$project.link}" title="{$project.bds_project_name}">{$project.bds_project_name}</a>
                            </h3>
                            <div class="project-items-body">
                                <span class="fa fa-clock-o date margin-right-15 icon-baseline">
                                    {if $project.bds_project_lastupdate && $project.bds_project_lastupdate != '0000-00-00 00:00:00'}
                                        {$project.bds_project_lastupdate|date_format:"%d/%m/%Y %H:%M"}
                                    {else}
                                        {$project.bds_project_created|date_format:"%d/%m/%Y %H:%M"}
                                    {/if}
                                </span>
                                {if $project.bds_project_investor}
                                    <span class="fa fa-building-o view margin-right-15 icon-baseline">
                                        Nhà đầu tư: <b>{$project.bds_project_investor}</b>
                                    </span>
                                {/if}
                                {if $project.bds_project_total_area}
                                    <span class="fa fa-area-chart view margin-right-15 icon-baseline">
                                        Tổng diện tích: <b>{$project.bds_project_total_area} <sup>m2</sup></b>
                                    </span>
                                {/if}
                                <span class="fa fa-map-marker view margin-right-15 icon-baseline">
                                    {$project.bds_project_address}, {$project.ten_huyen}, {$project.ten_tinh}
                                </span>
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
        </div>
    </div>
{/if}
{include file = 'footer.tpl'}