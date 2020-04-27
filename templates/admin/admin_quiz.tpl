{include file='admin_header.tpl'}
{if $task == 'view'}
    {if $type_acount == 2}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal statistics_out" name="adminForm" method="post" action="admin_quiz.php?type_acount=2">
                {include file = 'admin_filter_home.tpl'}
                <div class="col-sm-6">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5">#</th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Tên trường</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Mã trường</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Số điện thoại</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Tên giáo viên</strong>
                                        </th>
                                        <th width="15" nowrap="nowrap">
                                            <strong>Trạng thái</strong>
                                        </th>
                                        <th width="15" nowrap="nowrap" align="center">
                                            <strong>Setup</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {section name=loops loop=$list}
                                        <tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
                                            <td>{$smarty.section.loops.index+1}</td>
                                            <td class="quiz_name_school">{$list[loops].ten_truong}</td>
                                            <td class="quiz_name_school">{$list[loops].ma_truong}</td>
                                            <td class="quiz_name_school">{$list[loops].phone}</td>
                                            <td class="quiz_name_school_href"><a href="{$page}.php?task=edit&id={$list[loops].id}">{$list[loops].ten_hien_thi}</a></td>
                                            <td align="center">
                                                {if $list[loops].status == 1}
                                                    <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}', 'unpublish')" title="Ẩn đi">
                                                        <i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
                                                    </a>
                                                {else}
                                                    <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}', 'publish')" title="Hiển thị">
                                                        <i class="icon-ban-circle" style="color: red; font-size: 15px;"></i>
                                                    </a>
                                                {/if}
                                            </td>
                                            <td align="center">{$list[loops].check_str}</td>
                                        </tr>
                                    {sectionelse}
                                        <tr>
                                            <td colspan="7" align="center"><font color="red">Không tồn tại giáo viên nào thỏa mãn điều kiện tìm kiếm!</font></td>
                                        </tr>
                                    {/section}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            {$datapage}
                                        </td>
                                    </tr>
                                    {if $filter_status_setup==3}
                                        <tr>
                                            <td colspan="7" align="left"><span class="total_static">Tổng số tài khoản: <b class="statistics_num">{$data_total}</b></span></td>
                                        </tr>
                                        {if $filter_status==3 &&  $filter_status_setup==3}
                                            <tr>
                                                <td colspan="7" align="left"><span class="total_static">Hoạt động: <b class="statistics_num">{$total_hd}</b></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" align="left"><span class="total_static">Không hoạt động: <b class="statistics_num">{$total_khd}</b></span></td>
                                            </tr>
                                        {/if}
                                 {/if}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" value="{$task}" name="task">
                    <input type="hidden" value="2" name="type_acount">
                    <input type="hidden" value="" name="boxchecked">
                    <input type="hidden" value="{$totalRecords}" name="total_record" id="total_record" />
                </div>
                <div class="col-sm-6">
                    {include file = 'admin_chart_home.tpl'}
                </div>
            </form>
        </div>
    </div>
{elseif $type_acount == 5}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal statistics_out" name="adminForm" method="post" action="admin_quiz.php?type_acount=5">
                {include file = 'admin_filter_home.tpl'}
                <div class="col-sm-6">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5">#</th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Tên trường</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Mã trường</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Mã học sinh</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Tên học sinh</strong>
                                        </th>
                                        <th width="15" nowrap="nowrap">
                                            <strong>Trạng thái</strong>
                                        </th>
                                        <th width="15" nowrap="nowrap">
                                            <strong>Setup</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {section name=loops loop=$list}
                                        <tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
                                            <td>{$smarty.section.loops.index+1}</td>
                                            <td class="quiz_name_school">{$list[loops].ten_truong}</td>
                                            <td class="quiz_name_school">{$list[loops].ma_truong}</td>
                                            <td class="quiz_name_school">{$list[loops].ma_hoc_sinh}</td>
                                            <td class="quiz_name_school_href"><a href="{$page}.php?task=edit&id={$list[loops].id}">{$list[loops].ten_hien_thi}</a></td>
                                            <td align="center">
                                                {if $list[loops].status == 1}
                                                    <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$list[loops].id}', 'unpublish')" title="Ẩn đi">
                                                        <i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
                                                    </a>
                                                {else}
                                                    <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$list[loops].id}', 'publish')" title="Hiển thị">
                                                        <i class="icon-ban-circle" style="color: red; font-size: 15px;"></i>
                                                    </a>
                                                {/if}
                                            </td>
                                            <td align="center">{$list[loops].check_str}</td>
                                        </tr>
                                    {sectionelse}
                                        <tr>
                                            <td colspan="7" align="center"><font color="red">Không tồn tại học sinh nào thỏa mãn điều kiện tìm kiếm!</font></td>
                                        </tr>
                                    {/section}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            {$datapage}
                                        </td>
                                    </tr>
                                    {if $filter_status_setup==3}
                                    <tr>
                                        <td colspan="7" align="left"><span class="total_static">Tổng số tài khoản: <b class="statistics_num">{$data_total}</b></span></td>
                                    </tr>
                                    {if $filter_status==3 &&  $filter_status_setup==3}
                                        <tr>
                                            <td colspan="7" align="left"><span class="total_static">Hoạt động: <b class="statistics_num">{$total_hd}</b></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" align="left"><span class="total_static">Không hoạt động: <b class="statistics_num">{$total_khd}</b></span></td>
                                        </tr>
                                    {/if}
                                    {/if}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    {include file = 'admin_chart_home.tpl'}
                </div>
                <input type="hidden" value="{$task}" name="task">
                <input type="hidden" value="5" name="type_acount">
                <input type="hidden" value="" name="boxchecked">
                <input type="hidden" value="{$totalRecords}" name="total_record" id="total_record" />
            </form>
        </div>
    </div>
{elseif $type_acount == 3}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal statistics_out" name="adminForm" method="post" action="admin_quiz.php?type_acount=3">
                {include file = 'admin_filter_home.tpl'}
                <div class="col-sm-6">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5">#</th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Tên phụ huynh</strong>
                                        </th>
                                        <th class="title" nowrap="nowrap">
                                            <strong>Số điện thoại</strong>
                                        </th>
                                        <th width="15" nowrap="nowrap">
                                            <strong>Trạng thái</strong>
                                        </th>
                                        <th width="15" nowrap="nowrap">
                                            <strong>Setup</strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {section name=loops loop=$list}
                                        <tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
                                            <td>{$smarty.section.loops.index+1}</td>
                                            <td class="quiz_name_school_href"><a href="{$page}.php?task=edit&id={$list[loops].id}">{$list[loops].ten_phu_huynh}</a></td>
                                            <td class="quiz_name_school">{$list[loops].ma_phu_huynh}</td>
                                            <td align="center">
                                                {if $list[loops].status == 1}
                                                    <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$list[loops].id}', 'unpublish')" title="Ẩn đi">
                                                        <i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
                                                    </a>
                                                {else}
                                                    <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$list[loops].id}', 'publish')" title="Hiển thị">
                                                        <i class="icon-ban-circle" style="color: red; font-size: 15px;"></i>
                                                    </a>
                                                {/if}
                                            </td>
                                            <td align="center">{$list[loops].check_str}</td>
                                        </tr>
                                    {sectionelse}
                                        <tr>
                                            <td colspan="7" align="center"><font color="red">Không tồn tại phụ huynh nào thỏa mãn điều kiện tìm kiếm!</font></td>
                                        </tr>
                                    {/section}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            {$datapage}
                                        </td>
                                    </tr>
                                    {if $filter_status_setup==3}
                                    <tr>
                                        <td colspan="7" align="left"><span class="total_static">Tổng số tài khoản: <b class="statistics_num">{$data_total}</b></span></td>
                                    </tr>
                                    {if $filter_status==3 &&  $filter_status_setup==3}
                                        <tr>
                                            <td colspan="7" align="left"><span class="total_static">Hoạt động: <b class="statistics_num">{$total_hd}</b></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" align="left"><span class="total_static">Không hoạt động: <b class="statistics_num">{$total_khd}</b></span></td>
                                        </tr>
                                    {/if}
                                    {/if}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    {include file = 'admin_chart_home.tpl'}
                </div>
                <input type="hidden" value="{$task}" name="task">
                <input type="hidden" value="3" name="type_acount">
                <input type="hidden" value="" name="boxchecked">
                <input type="hidden" value="{$totalRecords}" name="total_record" id="total_record" />
            </form>
        </div>
    </div>
{/if}
{/if}
{include file='admin_footer.tpl'}