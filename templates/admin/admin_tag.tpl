{include file='admin_header.tpl'}
{if $task == "add" || $task == "edit"}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
                            <li class="active">
                                <a href="#tab-information" data-toggle="tab">THÔNG TIN CƠ BẢN TAG</a>
                            </li>
                            {if $setting.setting_tab_data}
                                <li class="">
                                    <a href="#tab-tabs" data-toggle="tab">TABS DỮ LIỆU</a>
                                </li>
                            {/if}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-information">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4>Thông tin cơ bản</h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-body-inner">
                                                    <div class="widget-main">
                                                        {if $task == 'edit'}
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-site-id">&nbsp; </label>
                                                                <div class="col-sm-9">
                                                                    <a style="font-size: 16px; color: red;" target="_blank" href="{$thisTag->data.link}"><i class="icon-double-angle-right"></i> Xem nhanh bài viết</a>
                                                                </div>
                                                            </div>
                                                            <div class="space-4"></div>
                                                        {/if}
                                                        {if !$admin->admin_site_default}
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-site-id"> Site sử dụng </label>
                                                                <div class="col-sm-9">
                                                                    <select name="tag_site_id" class="form-control required">
                                                                        <option value="0"{if $thisTag->data.tag_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
                                                                        {foreach from=$sites key=s item=site}
                                                                            <option value="{$s}"{if $s == $thisTag->data.tag_site_id} selected="selected"{/if}>{$site}</option>
                                                                        {/foreach}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="space-4"></div>
                                                        {else}
                                                            <input type="hidden" name="tag_site_id" value="{$admin->admin_site_default.site_id}" />
                                                        {/if}
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Tên tag</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="tag_name" class="form-control required" value="{$thisTag->data.tag_name}" />
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Đường dẫn tag</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="tag_directory" class="form-control " value="{$thisTag->data.tag_directory}" />
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-link-redirect"> Link chuyển hướng</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="tag_link_redirect" class="form-control " value="{$thisTag->data.tag_link_redirect}" />
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-content-short-description"> Mô tả ngắn </label>
                                                            <div class="col-sm-9">
                                                                <textarea cols="75" rows="5" name="tag_short_desc" class="wysiwyg required">{$thisTag->data.tag_short_desc}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-ordering"> Thứ tự sắp xếp </label>
                                                            <div class="col-sm-4">
                                                                <input type="text" name="tag_ordering" class="form-control" onkeypress="return numberOnly(this, event);" value="{$thisTag->data.tag_ordering}" placeholder="Thứ tự sắp xếp" />
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-special"> Nhóm nổi bật </label>
                                                            <div class="col-sm-9">
                                                                <label>
                                                                    <input type="checkbox" class="ace ace-switch ace-switch-4" name="tag_special"{if $thisTag->data.tag_special == 1} checked="checked"{/if} value="1">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-status"> Trạng thái </label>
                                                            <div class="col-sm-9">
                                                                <label>
                                                                    <input type="checkbox" class="ace ace-switch ace-switch-4" name="tag_status"{if $thisTag->data.tag_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
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
                                                <h4>Ảnh mô tả - SEO - Thông tin thẻ Meta</h4>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-body-inner">
                                                    <div class="widget-main">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pic"> Ảnh đại diện</label>
                                                            <div class="col-sm-9">
                                                                <p>(Kích thước ảnh: <b>{$setting.resize_news_image_thumbnail} x {$setting.resize_news_image_thumbnail_height}</b>)</p>
                                                                <div id="image-holder" class="border_doted">
                                                                    {if $thisTag->data.image_thumbnail}
                                                                        <img src="{$thisTag->data.image_thumbnail}" border="0" />
                                                                    {/if}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pic">&nbsp;</label>
                                                            <div class="col-sm-6">
                                                                <div class="ace-file-input">
                                                                    <input size="15" type="file" id="fileUpload" name="image" class="input-file-image" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-title"> Meta Title</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="tag_metatitle" class="form-control" maxlength="500" value="{$thisTag->data.tag_metatitle}" />
                                                            </div>
                                                        </div>
                                                        <div class="space-4"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-keyword"> Meta Keyword</label>
                                                            <div class="col-sm-9">
                                                                <textarea cols="50" rows="5" class="form-control" maxlength="500" name="tag_metakey">{$thisTag->data.tag_metakey}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-meta-description"> Meta Description</label>
                                                            <div class="col-sm-9">
                                                                <textarea cols="50" rows="5" class="form-control" name="tag_metadesc">{$thisTag->data.tag_metadesc}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="tabbable">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="widget-box">
                                                    <div class="widget-header">
                                                        <h4>Thông tin chi tiết</h4>
                                                    </div>
                                                    <div class="widget-body">
                                                        <div class="widget-body-inner">
                                                            <div class="widget-main">
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-struct-html"> Xây dựng cấu trúc trang</label>
                                                                    <div class="col-sm-4">
                                                                        <label class="inline" style="margin-right:10px;padding-top:5px;">
                                                                            <input type="checkbox" class="ace" value="1" name="tag_struct_html_h"{if $thisTag->data.tag_struct_html_h} checked="checked"{/if}>
                                                                            <span class="lbl" style="font-weight:bold;"> H1, H2, H3, H4, H5, H6</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="space-4"></div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-use-custom-template"> Sử dụng template </label>
                                                                    <div class="col-sm-10">
                                                                        <label>
                                                                            <input type="checkbox" class="ace ace-switch ace-switch-4" name="tag_custom_html"{if $thisTag->data.tag_custom_html == 1} checked="checked"{/if} value="1">
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                {if $admin->admin_super || ($admin->admin_info.admin_group == 1)}
                                                                    <div class="space-4"></div>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-use-custom-template"> Sử dụng template mobile </label>
                                                                        <div class="col-sm-10">
                                                                            <label>
                                                                                <input type="checkbox" class="ace ace-switch ace-switch-4" name="tag_custom_html_mobile"{if $thisTag->data.tag_custom_html_mobile == 1} checked="checked"{/if} value="1">
                                                                                <span class="lbl"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                {/if}
                                                                <div class="space-4"></div>
                                                                <div class="form-group" id="check_direct">
                                                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-use-custom-template"> Đường dẫn template </label>
                                                                    <div class="col-sm-2">
                                                                        <input type="text" name="tag_template_director" class="form-control" value="{$thisTag->data.tag_template_director}" placeholder="Đường dẫn template" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-content-long-description"> Mô tả chi tiết </label>
                                                                    <div class="col-sm-10">
                                                                        <textarea cols="75" rows="30" name="tag_fulltext" id="fulltext">{$thisTag->data.tag_fulltext}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" id="box-custom-mobile" style="display: none;">
                                                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-content-long-description"> Mô tả chi tiết cho bản mobile </label>
                                                                    <div class="col-sm-10">
                                                                        <textarea cols="75" rows="30" name="tag_fulltext_mobile" id="tinyfulltext">{$thisTag->data.tag_fulltext_mobile}</textarea>
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
                            </div>
                            {if $setting.setting_tab_data}
                                <div class="tab-pane" id="tab-tabs">
                                    {include file = 'admin_tab_form.tpl'}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tag_id_value" value="{$tag_id}" />
                <input type="hidden" name="task" value="save" />
            </form>
        </div>
    </div>
    {literal}
    <script type="text/javascript">
        $(document).ready(function(){
            //Change click
            if ($('input[name=tag_custom_html]').is(':checked')){
                $('#check_direct').show();
            }else{
                $('#check_direct').hide();
            }
            $('input[name=tag_custom_html]').click(function(){
                if ($(this).is(':checked')){
                    $('#check_direct').show();
                }else{
                    $('#check_direct').hide();
                }
            });

            if ($('input[name=tag_custom_html_mobile]').is(':checked')){
                $('#box-custom-mobile').show();
            }else{
                $('#box-custom-mobile').hide();
            }
            $('input[name=tag_custom_html_mobile]').click(function(){
                if ($(this).is(':checked')){
                    $('#box-custom-mobile').show();
                }else{
                    $('#box-custom-mobile').hide();
                }
            });
        });
    </script>
    {/literal}
{elseif $task == "change"}
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm">
                <div class="row">
                    <div class="tabbable">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>Import danh sách giáo viên</h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-body-inner" style="display: block;">
                                            <div class="widget-main">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label no-padding-right" for="text-find"> Từ cần tìm </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="text_find" class="form-control" value="" placeholder="Từ cần tìm" />
                                                    </div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label no-padding-right" for="text-replace"> Từ thay thế </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="text_replace" class="form-control" value="" placeholder="Từ thay thế" />
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
                <input type="hidden" name="changetext" value="1" />
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
                                            <div class="col-sm-4">
                                                <label>
                                                    <input type="checkbox" value = "1" id="filter_fulltext" name="filter_fulltext"{if $filter_fulltext == 1} checked="checked"{/if} class="ace">
                                                    <span class="lbl">&nbsp;Tìm nội dung</span>
                                                </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <button class="btn btn-purple btn-sm" onclick="this.form.submit();"><i class="icon-search icon-on-right bigger-110"></i> Tìm kiếm</button>
                                                <button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_fulltext').value='';document.getElementById('filter_site_id').value=0;document.getElementById('filter_status').value=3;document.getElementById('limit').value='50';document.adminForm.p.value=1;"><i class="icon-undo bigger-110"></i> Làm lại</button>
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
                                                <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_site_id" name="filter_site_id">
                                                    <option {if $filter_site_id==0}selected="selected"{/if} value="0">- Lựa chọn theo site -</option>
                                                    {foreach from=$sites key=s item=site}
                                                        <option {if $filter_site_id==$s}selected="selected"{/if} value="{$s}">{$site}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_status" name="filter_status">
                                                    <option {if $filter_status==3}selected="selected"{/if} value="3">- Trạng thái -</option>
                                                    <option {if $filter_status==1}selected="selected"{/if} value="1">Đang hoạt động</option>
                                                    <option {if $filter_status==2}selected="selected"{/if} value="2">Chờ xét duyệt</option>
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
                                <th class="center" width="80">
                                    <label>
                                        <input type="checkbox" onclick="checkAll(50);" value="" name="toggle" class="ace">
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th class="title" nowrap="nowrap">
                                    <strong>Tên tags</strong>
                                </th>
                                {if $filter_fulltext}
                                    <th class="title" nowrap="nowrap">
                                        <strong>Mô tả ngắn/Meta</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap">
                                        <strong>Mô tả chi tiết</strong>
                                    </th>
                                {else}
                                    <th class="title" nowrap="nowrap">
                                        <strong>Đường dẫn</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap">
                                        <strong>Tên Site</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap">
                                        <strong>Danh sách bài viết</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap" width="150">
                                        <strong>Ngày tạo</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap">
                                        <strong>Người tạo</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap">
                                        <strong>Người cập nhật</strong>
                                    </th>
                                    <th class="title" nowrap="nowrap" width="80">
                                        <strong>Thứ tự</strong>
                                    </th>
                                    <th width="100" nowrap="nowrap">
                                        <strong>Xem nhanh</strong>
                                    </th>
                                {/if}
                                <th width="100" nowrap="nowrap">
                                    <strong>Trạng thái</strong>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {section name=loops loop=$lstag}
                                <tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
                                    <td>{$smarty.section.loops.index+1}</td>
                                    <td align="center">
                                        <label>
                                            <input type="checkbox" onclick="isChecked(this.checked);" value="{$lstag[loops].tag_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{$page}.php?task=edit&tag_id={$lstag[loops].tag_id}">{$lstag[loops].tag_name}</a>
                                        {if $lstag[loops].tag_special == 1}
                                            <i class="icon-cog" style="color: #54b234; font-size: 15px;"></i>
                                        {/if}
                                    </td>
                                    {if $filter_fulltext}
                                        <td align="left" valign="top">
                                            <p><b>Mô tả ngắn:</b> {$lstag[loops].keyword_introtext}</p>
                                            <p><b>Metatitle:</b>{$lstag[loops].keyword_metatitle}</p>
                                            <p><b>Metakey:</b>{$lstag[loops].keyword_metakey}</p>
                                            <p><b>Metadesct:</b>{$lstag[loops].keyword_metadesc}</p>
                                        </td>
                                        <td align="left" valign="top">
                                            <div style="height:300px;overflow:scroll;">
                                                {$lstag[loops].keyword_fulltext}
                                            </div>
                                        </td>
                                    {else}
                                        <td>{$lstag[loops].tag_directory}</td>
                                        <td>{$lstag[loops].site}</td>
                                        <td>
                                            <div class="user_access">
                                                {foreach from=$lstag[loops].data_content key=c item=content}
                                                    <a target="_blank" href="admin_content.php?task=edit&content_id={$content.content_id}">{$content.content_title}</a><br/>
                                                {/foreach}
                                                {if $lstag[loops].data_content|@count >= 3}
                                                    <div class="readmore">
                                                        <a id="userID{$lstag[loops].tag_id}" data-sum="{$lstag[loops].data_content|@count}" data-uiid="{$lstag[loops].tag_id}" class="extend" href="#">
                                                            Chi tiết (<b>{$lstag[loops].data_content|@count}</b>) <b class="arrow icon-angle-down"></b>
                                                        </a>
                                                    </div>
                                                {/if}
                                            </div>
                                        </td>
                                        <td>
                                            {$lstag[loops].tag_created|date_format:"%d/%m/%Y %H:%M:%S"}
                                        </td>
                                        <td align="left">{$lstag[loops].name_created}</td>
                                        <td align="left">{$lstag[loops].name_modified}</td>
                                        <td align="center">{$lstag[loops].tag_ordering}</td>
                                        <td align="center">
                                            <a target="_blank" href="{$lstag[loops].link}"><i class="icon-double-angle-right"></i> Xem nhanh</a>
                                        </td>
                                    {/if}
                                    <td align="center">
                                        {if $lstag[loops].tag_status == 1}
                                            <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','unpublish')" title="Ẩn bài tag">
                                                <i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
                                            </a>
                                        {elseif $lstag[loops].tag_status == 2}
                                            <a style="cursor:pointer; text-decoration: none;" onclick="listItemTask('cb{$smarty.section.loops.index}','publish')" title="Hiển thị bài tag">
                                                <i class="icon-key" style="color: #FDB053; font-size: 15px;"></i>
                                            </a>
                                        {else}
                                            <a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','publish')" title="Hiển thị bài tag">
                                                <i class="icon-off" style="color: red; font-size: 15px;"></i>
                                            </a>
                                        {/if}
                                    </td>
                                </tr>
                                {sectionelse}
                                <tr>
                                    <td colspan="{if $filter_fulltext}4{else}12{/if}" align="center"><font color="red">Không tồn tại hashtag nào thỏa mãn điều kiện tìm kiếm!</font></td>
                                </tr>
                            {/section}
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="{if $filter_fulltext}6{else}12{/if}">
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
    {literal}
    <script type="text/javascript">
        $('.readmore').click(function(){
            var data = $(this).find('a').attr("class");
            var uId = $(this).find('a').attr("data-uiid");
            var sum = $(this).find('a').attr("data-sum");

            if ( data == 'extend' ){
                $(this).find('a').attr("class", "record");
                $(this).find('a').html('<b class="arrow icon-angle-up"></b> Thu lại (<b>'+sum+'</b>)');
                $(this).parent().css('height', 'auto');
            }else{
                $(this).find('a').attr("class", "extend");
                $(this).find('a').html('<b class="arrow icon-angle-down"></b> Chi tiết (<b>'+sum+'</b>)');
                $(this).parent().css('height', '50px');
            }
            $('html, body').animate({
                scrollTop: (($("#userID" + uId).offset().top) - 500)
            }, 2000);
        });
    </script>
    {/literal}
{/if}
{include file='admin_footer.tpl'}