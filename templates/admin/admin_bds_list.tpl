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
                <th class="title" nowrap="nowrap" width="150">
                    <strong>Mã code</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Tên bất động sản</strong>
                </th>
                <th class="title" nowrap="nowrap">
                    <strong>Tên Site</strong>
                </th>
                <th class="title" nowrap="nowrap" width="100">
                    <strong>Chủng loại</strong>
                </th>
                <th class="title" nowrap="nowrap" width="100">
                    <strong>Danh mục</strong>
                </th>
                <th class="title" nowrap="nowrap" width="120">
                    <strong>Phòng ngủ/tắm</strong>
                </th>
                <th class="title" nowrap="nowrap" width="80">
                    <strong>Giá</strong>
                </th>
                <th class="title" nowrap="nowrap" width="80">
                    <strong>Diện tích</strong>
                </th>
                <th class="title" nowrap="nowrap" width="120">
                    <strong>Địa điểm</strong>
                </th>
                <th nowrap="nowrap" width="60">
                    <strong>Thứ tự</strong>
                </th>
                <th nowrap="nowrap" width="80">
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
                            <input type="checkbox" onclick="isChecked(this.checked);" value="{$list[loops].bds_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td align="left">
                        {$list[loops].bds_code}
                        {if $list[loops].bds_user_date_created == $list[loops].bds_user_date_expired}
                        {else}
                            <div class="field" style="color: #09d261; font-weight: bold;">{$list[loops].bds_user_date_created|date_format:"%d/%m/%Y %H:%M:%S"}</div>
                            <div class="field" style="color: #969da3; font-style: italic;">{$list[loops].bds_user_date_expired|date_format:"%d/%m/%Y %H:%M:%S"}</div>
                        {/if}
                    </td>
                    <td align="left">
                        <div style="float:left; margin-right:5px;">
                            <a href="{$page}.php?action={$action}&task=edit&id={$list[loops].bds_id}">
                                <img src="{$list[loops].tiny_thumbnail}" width="50" height="50" border="0" />
                            </a>
                        </div>
                        <a onmouseover="showtip('{$list[loops].bds_metakey}', '300', '#009a2a');" href="{$page}.php?action={$action}&task=edit&id={$list[loops].bds_id}">
                            {$list[loops].bds_title}
                        </a>
                        <div class="field">Dự án: <i>{$list[loops].bds_project_name}</i></div>
                    </td>
                    <td align="left">{$list[loops].site}</td>
                    <td align="left">{$list[loops].section}</td>
                    <td align="left">{$list[loops].category_name}</td>
                    <td align="left">
                        <b>{$list[loops].room}</b> và <b>{$list[loops].bathroom}</b>
                    </td>
                    <td align="left">{$list[loops].price}</td>
                    <td align="left">{$list[loops].area}</td>
                    <td align="left">
                        <i>{$list[loops].ten_huyen}</i><br/>
                        <b>{$list[loops].ten_tinh}</b>
                    </td>
                    <td align="center">
                        {$list[loops].bds_ordering}
                    </td>
                    <td align="center">
                        {if $list[loops].bds_status == 1}
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
{literal}
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
{/literal}