<div class="row">
    <div class="table-responsive">
        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th width="5">#</th>
                <th class="center" width="25">
                    <label>
                        <input type="checkbox" onclick="checkAll(50);" value="" name="toggle" class="ace">
                        <span class="lbl"></span>
                    </label>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Tên dự án</strong>
                </th>
                <th class="title" nowrap="nowrap" width="200">
                    <strong>Tên Site</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Danh mục</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Loại hình dự án</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Giá bán/m2</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Thời gian bàn giao</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Tình trạng</strong>
                </th>
                <th class="title" nowrap="nowrap" width="200">
                    <strong>Địa chỉ</strong>
                </th>
                <th nowrap="nowrap" width="150">
                    <strong>Ngày tạo</strong>
                </th>
                <th nowrap="nowrap" width="60">
                    <strong>Thứ tự</strong>
                </th>
                <th nowrap="nowrap" width="100">
                    <strong>Trạng thái</strong>
                </th>
            </tr>
            </thead>
            <tbody>
            {section name=loops loop=$list}
                <tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
                    <td>{$smarty.section.loops.index+1}</td>
                    <td class="center">
                        <label>
                            <input type="checkbox" onclick="isChecked(this.checked);" value="{$list[loops].bds_project_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td align="left">
                        <a href="{$page}.php?action={$action}&task=edit&id={$list[loops].bds_project_id}">{$list[loops].bds_project_name}</a>
                    </td>
                    <td align="left">{$list[loops].site}</td>
                    <td align="left">{$list[loops].category_name}</td>
                    <td align="left">{$list[loops].bds_project_type_of_development}</td>
                    <td align="left">{$list[loops].bds_project_price}</td>
                    <td align="left">
                        {if $list[loops].bds_project_date_hand_over && $list[loops].bds_project_date_hand_over != '0000-00-00 00:00:00'}
                            {$list[loops].bds_project_date_hand_over|date_format:"%d/%m/%Y"}
                        {/if}
                    </td>
                    <td align="center">
                        {if $list[loops].bds_project_handedover}
                            <a style="cursor:pointer; text-decoration: none;" onmouseover="showtip('Đã bàn giao', '100', '#87B87F');" onmouseout="hidetip();">
                                <i class="icon-ok-sign" style="color: #54b234; font-size: 15px;"></i>
                            </a>
                        {else}
                            <a style="cursor:pointer; text-decoration: none;" onmouseover="showtip('Chưa bàn giao', '120', '#D15B47');" onmouseout="hidetip();">
                                <i class="icon-ban-circle" style="color: gray; font-size: 15px;"></i>
                            </a>
                        {/if}
                    </td>
                    <td align="left">
                        {$list[loops].bds_project_address}
                        {if $list[loops].ten_huyen},{$list[loops].ten_huyen}{/if}
                        {if $list[loops].ten_tinh},{$list[loops].ten_tinh}{/if}
                    </td>
                    <td align="left">
                        {$list[loops].bds_project_created|date_format:"%d/%m/%Y %H:%M:%S"}
                    </td>
                    <td align="center">
                        {$list[loops].bds_project_ordering}
                    </td>
                    <td align="center">
                        {if $list[loops].bds_project_status == 1}
                            <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','unpublish')" onmouseover="showtip('Hoạt động', '100', '#87B87F');" onmouseout="hidetip();">
                                <i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
                            </a>
                        {else}
                            <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','publish')" onmouseover="showtip('Ẩn đi', '100', '#D15B47');" onmouseout="hidetip();">
                                <i class="icon-ban-circle" style="color: red; font-size: 15px;"></i>
                            </a>
                        {/if}
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="13" align="center"><font color="red">Không tồn tại bản ghi nào thỏa mãn điều kiện tìm kiếm!</font></td>
                </tr>
            {/section}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="13">
                    {$datapage}
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>