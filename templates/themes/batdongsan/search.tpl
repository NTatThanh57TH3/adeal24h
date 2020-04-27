{include file = 'header.tpl'}
{if $task == 'searchBds'}
    <div class="content-main bds-main book_bg_2">
        <div class="container-bds">
            <h3 class="heading">
                Kết quả tìm kiếm bất động sản
                <a href="" class="btn_view_all" href="">Xem tất cả <i class="fa fa-plus"></i></a>
            </h3>
            <div class="wrap-content clearfix">
                <div class="nav-left nav">
                    {include file = 'modules/bds/filter.tpl'}
                </div>
                {if $list_search_bds}
                    <div class="main-list-item">
                        {foreach from=$list_search_bds key=k item=bds}
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
                {else}
                    <div class="main-list-item">
                        <p class="error">Không tìm thấy bất động sản nào thỏa mãn yêu cầu tìm kiếm!</p>
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
{elseif $task == 'searchBdsProject'}
    <div class="content-main bds-main book_bg">
        <div class="container-bds">
            <h3 class="heading">
                Kết quả tìm kiếm dự án bất động sản
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
{else}
    {include file = 'components/banners/banner.tpl' position = "slide"}
    <div class="main_content">
        <div id="BreadCrumb">
            <div class="box-breadcrumb">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="bread_url">
                                <a href="{$PG_URL_HOMEPAGE}" class="home">
                                    <i class="fa fa-home"></i>
                                    Trang chủ
                                </a>
                                <a href="#">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <a href="">Tìm kiếm</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="box_content">
                <div class="clearfix">
                    <div class="fl">
                        <div class="box_left">
                            {include file = 'components/menus/menu.tpl' type = "left"}
                            {include file = 'components/contents/content_hot.tpl'}
                            {include file = 'components/tags/tag.tpl'}
                            {include file = 'components/contents/content_special.tpl'}
                        </div>
                    </div>
                    <div class="fr">
                        <div class="box_right">
                            <div id="ContentPanel">
                                <h3 class="box_right_heading">TÌM KIẾM</h3>
                                <div class="box_right_news">
                                    <div class="box_right_item">
                                        {if $totalRecords}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Tìm thấy <b style="color: red;">{$totalRecords}</b> kết quả cho <b>"{$keywordsearch}"</b></p>
                                                </div>
                                            </div>
                                        {/if}
                                        {foreach from=$_list_searchs.tbl_contents key=c item=content name=foo}
                                            {if $smarty.foreach.foo.index == 0}
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <a href="{$content.link}" class="photo-wrap">
                                                            <img src="{$content.image_thumbnail}" alt="{$content.TITLE}" class="img-responsive">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="box_info">
                                                            <div class="box_info_date">
                                                                <i class="fa fa-calendar"></i>
                                                                <span>{$content.number_day}: {$content.created|date_format:"%d/%m/%Y"} lúc {$content.created|date_format:"%H:%M"}</span>
                                                            </div>
                                                            <h3 class="box_info_name">
                                                                <a href="{$content.link}">
                                                                    {$content.TITLE}
                                                                </a>
                                                            </h3>
                                                            <div class="box_info_para">{$content.MSG|truncate:200:"..."}</div>
                                                            <div class="box_info_btn">
                                                                <a class="btn_xem" href="{$content.link}">
                                                                    <i class="fa fa-angle-double-right"></i>
                                                                    Xem thêm
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {/if}
                                        {/foreach}
                                    </div>
                                </div>
                                <div class="box_right_list">
                                    <div class="clearfix">
                                        {foreach from=$_list_searchs.tbl_contents key=c item=content name=foo}
                                            {if $smarty.foreach.foo.index > 0}
                                                <div class="box_list_item">
                                                    <a href="{$content.link}" class="photo-wrap">
                                                        <img alt="{$content.TITLE}" class="img-responsive" src="{$content.image_thumbnail}">
                                                    </a>
                                                    <h3 class="box_info_name">
                                                        <a href="{$content.link}">{$content.TITLE}</a>
                                                    </h3>
                                                    <div class="box_info_para">{$content.MSG|truncate:200:"..."}</div>
                                                </div>
                                            {/if}
                                        {/foreach}
                                    </div>
                                </div>
                                <p class="page-numb">
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
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
{include file = 'footer.tpl'}