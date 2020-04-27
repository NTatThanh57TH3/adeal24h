{include file='admin_header.tpl'}
{if $task == "add" || $task == "edit"}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="tabbable">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>Thông tin cơ bản</h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-body-inner">
                                            <div class="widget-main">
                                                {if !$admin->admin_site_default}
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-site-id"> Site sử dụng </label>
                                                        <div class="col-sm-9">
                                                            <select name="quote_site_id" class="form-control required">
                                                                <option value="0"{if $thisQuote->data.quote_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
                                                                {foreach from=$sites key=s item=site}
                                                                    <option value="{$s}"{if $s == $thisQuote->data.quote_site_id} selected="selected"{/if}>{$site}</option>
                                                                {/foreach}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="space-4"></div>
                                                {else}
                                                    <input type="hidden" name="quote_site_id" value="{$admin->admin_site_default.site_id}" />
                                                {/if}
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Tên khách hàng</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="quote_name" class="form-control required" value="{$thisQuote->data.quote_name}" />
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-image">&nbsp;</label>
                                                    <div class="col-sm-9">
                                                        <p>(Kích thước ảnh: <b>{$setting.resize_news_image_thumbnail} x {$setting.resize_news_image_thumbnail_height}</b>)</p>
                                                        <div id="image-holder">
                                                            {if $thisQuote->data.image_thumbnail}
                                                                <img src="{$thisQuote->data.image_thumbnail}" border="0" />
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-changeimage">&nbsp;</label>
                                                    <div class="col-sm-9">
                                                        <div class="checkbox" style="padding: 0;">
                                                            <label>
                                                                <input type="checkbox" class="ace ace-checkbox-2" name="changeimage" value="1" />
                                                                <span class="lbl"> Thay ảnh đại diện</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-image-url">&nbsp;</label>
                                                        <div class="col-sm-7">
                                                            <div id="show_pic" style="display: none; padding: 0;" class="col-sm-10 ace-file-input">
                                                                <input size="15" type="file" id="fileUpload" name="image" class="input-file-image" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-ordering"> Thứ tự sắp xếp </label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="quote_ordering" onkeypress="return numberOnly(this, event);" class="form-control" value="{$thisQuote->data.quote_ordering}" placeholder="Thứ tự sắp xếp" />
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-status"> Trạng thái </label>
                                                    <div class="col-sm-9">
                                                        <label>
                                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="quote_status"{if $thisQuote->data.quote_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>Thông tin cơ bản</h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-body-inner">
                                            <div class="widget-main">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-vote"> Đánh giá </label>
                                                    <div class="col-sm-4">
                                                        <select name="quote_vote" class="form-control required">
                                                            <option value="0"{if $thisQuote->data.quote_vote == 0} selected="selected"{/if}>-- Lựa chọn đánh giá --</option>
                                                            <option value="1"{if $thisQuote->data.quote_vote == 1} selected="selected"{/if}>1 sao</option>
                                                            <option value="1.5"{if $thisQuote->data.quote_vote == 1.5} selected="selected"{/if}>1.5 sao</option>
                                                            <option value="2"{if $thisQuote->data.quote_vote == 2} selected="selected"{/if}>2 sao</option>
                                                            <option value="2.5"{if $thisQuote->data.quote_vote == 2.5} selected="selected"{/if}>2.5 sao</option>
                                                            <option value="3"{if $thisQuote->data.quote_vote == 3} selected="selected"{/if}>3 sao</option>
                                                            <option value="3.5"{if $thisQuote->data.quote_vote == 3.5} selected="selected"{/if}>3.5 sao</option>
                                                            <option value="4"{if $thisQuote->data.quote_vote == 4} selected="selected"{/if}>4 sao</option>
                                                            <option value="4.5"{if $thisQuote->data.quote_vote == 4.5} selected="selected"{/if}>4.5 sao</option>
                                                            <option value="5"{if $thisQuote->data.quote_vote == 5} selected="selected"{/if}>5 sao</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-content-short-description"> Nội dung trích dẫn</label>
                                                    <div class="col-sm-9">
                                                        <textarea cols="75" rows="5" name="quote_text" class="wysiwyg required">{$thisQuote->data.quote_text}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="quote_id_value" value="{$quote_id}" />
                <input type="hidden" name="task" value="save" />
            </form>
        </div>
    </div>
{else}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" name="adminForm" method="post" action="{$page}.php">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
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
                                                <input type="text" class="form-control" size="40" value="{$search}" id="search" name="search" placeholder="Nhập tiêu đề nội dung tĩnh" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-purple btn-sm" onclick="this.form.submit();"><i class="icon-search icon-on-right bigger-110"></i> Tìm kiếm</button>
                                                <button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_site_id').value=0;document.getElementById('filter_group').value=0;document.getElementById('filter_status').value=3;document.getElementById('limit').value='50';document.adminForm.p.value=1;"><i class="icon-undo bigger-110"></i> Làm lại</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Tìm kiếm theo site</h4>
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
                                                <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_site_id" name="filter_site_id">
                                                    <option {if $filter_site_id==0}selected="selected"{/if} value="0">- Lựa chọn theo site -</option>
                                                    {foreach from=$sites key=s item=site}
                                                        <option {if $filter_site_id==$s}selected="selected"{/if} value="{$s}">{$site}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4>Tìm kiếm theo lựa chọn</h4>
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
                                                <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_group" name="filter_group">
                                                    <option value="0"{if $filter_group == 0} selected="selected"{/if}>-- Lựa chọn đánh giá --</option>
                                                    <option value="1"{if $filter_group == 1} selected="selected"{/if}>1 sao</option>
                                                    <option value="1.5"{if $filter_group == 1.5} selected="selected"{/if}>1.5 sao</option>
                                                    <option value="2"{if $filter_group == 2} selected="selected"{/if}>2 sao</option>
                                                    <option value="2.5"{if $filter_group == 2.5} selected="selected"{/if}>2.5 sao</option>
                                                    <option value="3"{if $filter_group == 3} selected="selected"{/if}>3 sao</option>
                                                    <option value="3.5"{if $filter_group == 3.5} selected="selected"{/if}>3.5 sao</option>
                                                    <option value="4"{if $filter_group == 4} selected="selected"{/if}>4 sao</option>
                                                    <option value="4.5"{if $filter_group == 4.5} selected="selected"{/if}>4.5 sao</option>
                                                    <option value="5"{if $filter_group == 5} selected="selected"{/if}>5 sao</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
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
                <div class="row">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="5">#</th>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" onclick="checkAll(50);" value="" name="toggle" class="ace">
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th class="title" nowrap="nowrap">
                                    <strong>Tên khách hàng</strong>
                                </th>
                                <th class="title" nowrap="nowrap">
                                    <strong>Trích dẫn</strong>
                                </th>
                                <th class="title" nowrap="nowrap">
                                    <strong>Tên Site</strong>
                                </th>
                                <th class="title" nowrap="nowrap" width="110">
                                    <strong>Đánh giá</strong>
                                </th>
                                <th class="title" nowrap="nowrap">
                                    <strong>Ngày tạo</strong>
                                </th>
                                <th class="title" nowrap="nowrap" width="80">
                                    <strong>Thứ tự</strong>
                                </th>
                                <th width="100" nowrap="nowrap">
                                    <strong>Trạng thái</strong>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {section name=loops loop=$lsQuote}
                                <tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
                                    <td>{$smarty.section.loops.index+1}</td>
                                    <td align="center">
                                        <label>
                                            <input type="checkbox" onclick="isChecked(this.checked);" value="{$lsQuote[loops].quote_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{$page}.php?task=edit&quote_id={$lsQuote[loops].quote_id}">{$lsQuote[loops].quote_name}</a>
                                    </td>
                                    <td>{$lsQuote[loops].quote_text}</td>
                                    <td>{$lsQuote[loops].site}</td>
                                    <td>
                                        {if $lsQuote[loops].quote_vote == 1}
                                            <span class="fa fa-star" style="color:#FFD700;"></span>
                                        {elseif $lsQuote[loops].quote_vote == 2}
                                            <span class="fa fa-star" style="color:#FFD700;"></span><span style="color:#FFD700;" class="fa fa-star"></span>
                                        {elseif $lsQuote[loops].quote_vote == 3}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span>
                                        {elseif $lsQuote[loops].quote_vote == 4}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span>
                                        {elseif $lsQuote[loops].quote_vote == 5}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span>
                                        {elseif $lsQuote[loops].quote_vote == 1.5}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star-half-o"></span>
                                        {elseif $lsQuote[loops].quote_vote == 2.5}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star-half-o"></span>
                                        {elseif $lsQuote[loops].quote_vote == 3.5}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star-half-o"></span>
                                        {elseif $lsQuote[loops].quote_vote == 4.5}
                                            <span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star"></span><span style="color:#FFD700;" class="fa fa-star-half-o"></span>
                                        {/if}
                                    </td>
                                    <td>
                                        {$lsQuote[loops].quote_created|date_format:"%d/%m/%Y %H:%M:%S"}
                                    </td>
                                    <td align="center">{$lsQuote[loops].quote_ordering}</td>
                                    <td align="center">
                                        {if $lsQuote[loops].quote_status == 1}
                                            <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','unpublish')" title="Ẩn bài viết">
                                                <i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
                                            </a>
                                        {else}
                                            <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','publish')" title="Cho hiển thị bài viết">
                                                <i class="icon-lock" style="color: #999; font-size: 15px;"></i>
                                            </a>
                                        {/if}
                                    </td>
                                </tr>
                                {sectionelse}
                                <tr>
                                    <td colspan="9" align="center"><font color="red">Không tồn tại trích dẫn nào thỏa mãn điều kiện tìm kiếm!</font></td>
                                </tr>
                            {/section}
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="9">
                                    {$datapage}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <input type="hidden" value="{$task}" name="task">
                <input type="hidden" value="" name="boxchecked">
                <input type="hidden" value="{$total_record}" name="total_record" id="total_record" />
            </form>
        </div>
    </div>
{/if}
{include file='admin_footer.tpl'}