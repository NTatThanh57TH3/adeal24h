{include file='admin_header.tpl'}
<div class="row">
    <div class="col-xs-12">
        {if $task == 'view'}
            <form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="span6">
                        <p>
                            {if $admin->admin_info.admin_id == 28} <!-- Sỹ -->
                                <button data-id="construction" class="btn btn-primary{if $action == 'construction'} btn-pink{/if} action_type">Thiết kế - Thi công</button>
                            {else}
                                <button data-id="section" class="btn btn-primary{if $action == 'section'} btn-pink{/if} action_type">Quản lý nhu cầu </button>
                                <button data-id="bds" class="btn btn-primary{if $action == 'bds'} btn-pink{/if} action_type">Quản lý bất động sản </button>
                                <button data-id="project" class="btn btn-primary{if $action == 'project'} btn-pink{/if} action_type">Quản lý dự án</button>
                                <button data-id="construction" class="btn btn-primary{if $action == 'construction'} btn-pink{/if} action_type">Thiết kế - Thi công</button>
                                <button data-id="company" class="btn btn-primary{if $action == 'company'} btn-pink{/if} action_type">Đơn vị hợp tác</button>
                            {/if}
                        </p>
                    </div>
                </div>
                <div class="space"></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Tìm kiếm theo từ khóa</h4>
                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                    <a data-action="close" href="#">
                                        <i class="icon-remove"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-body-inner" style="display: block;">
                                    <div class="widget-main">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" size="40" value="{$search}" id="search" name="search" placeholder="{if $action == 'bds'}Nhập mã hoặc tên BDS{elseif $action == 'project'}Nhập tên dự án{/if}" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-purple btn-sm" onclick="this.form.submit();"><i class="icon-search icon-on-right bigger-110"></i> Tìm kiếm</button>
                                                <button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_site_id').value=0;document.getElementById('filter_status').value=3;document.getElementById('limit').value='50';document.adminForm.p.value=1;{if $action == 'bds'}document.getElementById('filter_catid').value=0;{elseif $action == 'don_dang_ky_ung_tuyen'}document.getElementById('filter_quoc_gia_id').value=0;document.getElementById('filter_vung_lam_viec_id').value=0;document.getElementById('filter_trinh_do').value=0;document.getElementById('filter_thoi_han_hop_dong').value=0;document.getElementById('filter_nganh_nghe_id').value=0;document.getElementById('filter_gioi_tinh').value=3;{elseif $action == 'don_tuyen_dung_lao_dong'}document.getElementById('filter_quoc_gia_id').value=0;document.getElementById('filter_vung_lam_viec_id').value=0;document.getElementById('filter_nganh_nghe_id').value=0;document.getElementById('filter_gioi_tinh').value=3;{/if}"><i class="icon-undo bigger-110"></i> Làm lại</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Tìm kiếm theo lựa chọn khác</h4>
                                <div class="widget-toolbar">
                                    <a data-action="collapse" href="#">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                    <a data-action="close" href="#">
                                        <i class="icon-remove"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <div class="widget-body-inner" style="display: block;">
                                    <div class="widget-main">
                                        {if $action != 'section'}
                                            <div class="form-group">
                                                {if $action == 'bds'}
                                                    <div class="col-sm-6">
                                                        <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_section" name="filter_section">
                                                            <option {if $filter_section==0}selected="selected"{/if} value="0">- Chọn theo nhu cầu -</option>
                                                            {foreach from=$list_sections key=s item=section}
                                                                <option {if $filter_section==$s}selected="selected"{/if} value="{$s}">{$section}</option>
                                                            {/foreach}
                                                        </select>
                                                    </div>
                                                {/if}
                                                <div class="{if $action == 'bds'}col-sm-6{else}col-sm-12{/if}">
                                                    <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_catid" name="filter_catid">
                                                        <option {if $filter_catid==0}selected="selected"{/if} value="0">- Chọn theo danh mục -</option>
                                                        {$option}
                                                    </select>
                                                </div>
                                            </div>
                                        {/if}
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_site_id" name="filter_site_id">
                                                    <option {if $filter_site_id==0}selected="selected"{/if} value="0">- Lựa chọn theo site -</option>
                                                    {foreach from=$sites key=s item=site}
                                                        <option {if $filter_site_id==$s}selected="selected"{/if} value="{$s}">{$site}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_status" name="filter_status">
                                                    <option {if $filter_status==3}selected="selected"{/if} value="3">- Trạng thái -</option>
                                                    <option {if $filter_status==1}selected="selected"{/if} value="1">Đang hoạt động</option>
                                                    <option {if $filter_status==0}selected="selected"{/if} value="0">Không hoạt động</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                {if $action == 'section'}
                    {include file = 'admin_bds_section.tpl'}
                {elseif $action == 'bds'}
                    {include file = 'admin_bds_list.tpl'}
                {elseif $action == 'project'}
                    {include file = 'admin_bds_project_list.tpl'}
                {elseif $action == 'construction'}
                    {include file = 'admin_constructions.tpl'}
                {elseif $action == 'company'}
                    {include file = 'admin_bds_company_list.tpl'}
                {/if}
                <input type="hidden" name="action" value="{$action}" />
                <input type="hidden" value="{$task}" name="task">
                <input type="hidden" value="" name="boxchecked">
                <input type="hidden" value="{$total_record}" name="total_record" id="total_record" />
            </form>
            {literal}
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.action_type').click(function(){
                        var valueAction = $(this).attr('data-id');
                        $('input[name=action]').val(valueAction);

                        $('#adminForm').submit();
                    });
                });
            </script>
            {/literal}
        {elseif $task == 'add' || $task == 'edit'}
            <form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
                {if $action == 'section'}
                    {include file = 'admin_bds_form_section.tpl'}
                {elseif $action == 'bds'}
                    {include file = 'admin_bds_form.tpl'}
                {elseif $action == 'project'}
                    {include file = 'admin_bds_form_project.tpl'}
                {elseif $action == 'construction'}
                    {include file = 'admin_bds_form_construction.tpl'}
                {elseif $action == 'company'}
                    {include file = 'admin_bds_form_company.tpl'}
                {/if}
                <input type="hidden" name="action" value="{$action}" />
                <input type="hidden" name="{if $action == 'section'}bds_section_id{elseif $action == 'bds'}bds_id{elseif $action == 'project'}bds_project_id{elseif $action == 'construction'}construction_design_id{elseif $action == 'company'}company_id{/if}" value="{$id}" />
                <input type="hidden" name="task" value="save" />
            </form>
        {/if}
    </div>
</div>
{literal}
    <script type="text/javascript">
        var arrPriceRange = new Array;
        var arrDistrict = new Array;
        {/literal}
        {foreach from=$_bds_price_ranges key=p item=price_ranges name=foo}
            {foreach from=$price_ranges key=r item=price name=roo}
                arrPriceRange[{if $smarty.foreach.foo.index == 0}{math equation="x * y" x=1 y=$smarty.foreach.roo.index+1}{else}{math equation="x + y" x=$price_ranges|@count y=$smarty.foreach.roo.index+1}{/if}] = new Array( '{$p}','{$r}','{$price}' );
            {/foreach}
        {/foreach}

        {section name=loops loop=$listDistrict}
            arrDistrict[{$smarty.section.loops.index}] = new Array( '{$listDistrict[loops].ma_tinh}','{$listDistrict[loops].ma_huyen}','{$listDistrict[loops].ten_huyen}' );
        {/section}
        {literal}
    </script>
{/literal}
{include file='admin_footer.tpl'}