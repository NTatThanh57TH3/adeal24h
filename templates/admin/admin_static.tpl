{include file='admin_header.tpl'}
{if $task == "add" || $task == "edit"}
<script src="../templates/admin/js/jscolor/jscolor.min.js"></script>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
			<div class="row">
				<div class="tabbable">
					<ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
						<li class="active">
							<a href="#tab-information" data-toggle="tab">THÔNG TIN CƠ BẢN NỘI DUNG TĨNH</a>
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
																<a style="font-size: 16px; color: red;" target="_blank" href="{$thisStatic->data.link}"><i class="icon-double-angle-right"></i> Xem nhanh bài viết</a>
															</div>
														</div>
														<div class="space-4"></div>
													{/if}
													{if !$admin->admin_site_default}
														<div class="form-group">
															<label class="col-sm-3 control-label no-padding-right" for="form-field-site-id"> Site sử dụng </label>
															<div class="col-sm-9">
																<select name="static_site_id" class="form-control required">
																	<option value="0"{if $thisStatic->data.static_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
																	{foreach from=$sites key=s item=site}
																		<option value="{$s}"{if $s == $thisStatic->data.static_site_id} selected="selected"{/if}>{$site}</option>
																	{/foreach}
																</select>
															</div>
														</div>
														<div class="space-4"></div>
													{else}
														<input type="hidden" name="static_site_id" value="{$admin->admin_site_default.site_id}" />
													{/if}
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-category"> Chọn nhóm hiển thị</label>
														<div class="col-sm-9">
															<select name="static_group" class="form-control required">
																<option value="">Chọn nhóm hiển thị</option>
																{foreach from=$grStatic key=k item=static}
																	<option value="{$k}"{if $thisStatic->data.static_group==$k} selected="seleceted"{/if}>{$static}</option>
																{/foreach}
															</select>
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Tiêu đề</label>
														<div class="col-sm-9">
															<input type="text" name="static_title" class="form-control required" value="{$thisStatic->data.static_title}" />
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-static-alias"> Bí danh tiêu đề</label>
														<div class="col-sm-9">
															<input type="text" name="static_alias" class="col-xs-12 form-control" value="{$thisStatic->data.static_alias}" placeholder="Nhập bí danh alias" />
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-style"> Icon Tiêu đề</label>
														<div class="col-sm-3">
															<input type="text" name="static_style" class="form-control" placeholder="start-o" value="{$thisStatic->data.static_style}" />
														</div>
														<div class="col-sm-3">
															<input type="text" name="static_style_color" class="form-control jscolor" placeholder="FFA611" value="{$thisStatic->data.static_style_color}" />
														</div>
														<div class="col-sm-3">
															<a href="http://fontawesome.io/icons/" target="_blank">Xem mẫu các icon</a>
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-image">&nbsp;</label>
														<div class="col-sm-9">
															<p>(Kích thước ảnh: <b>{$setting.resize_news_image_thumbnail} x {$setting.resize_news_image_thumbnail_height}</b>)</p>
															<div id="image-holder">
																{if $thisStatic->data.image_thumbnail}
																	<img src="{$thisStatic->data.image_thumbnail}" border="0" />
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
														<label class="col-sm-3 control-label no-padding-right" for="form-field-content-short-description"> Mô tả ngắn </label>
														<div class="col-sm-9">
															<textarea cols="75" rows="5" name="static_short_desc" class="wysiwyg required">{$thisStatic->data.static_short_desc}</textarea>
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-status"> Trạng thái </label>
														<div class="col-sm-9">
															<label>
																<input type="checkbox" class="ace ace-switch ace-switch-4" name="static_status"{if $thisStatic->data.static_status == 1 || $task == 'add'} checked="checked"{/if} value="1">
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
											<h4>SEO - Thông tin thẻ Meta</h4>
										</div>
										<div class="widget-body">
											<div class="widget-body-inner">
												<div class="widget-main">
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-meta-title"> Meta Title</label>
														<div class="col-sm-9">
															<input type="text" name="static_metatitle" class="form-control" maxlength="500" value="{$thisStatic->data.static_metatitle}" />
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-meta-keyword"> Meta Keyword</label>
														<div class="col-sm-9">
															<textarea cols="50" rows="5" class="form-control" maxlength="500" name="static_metakey">{$thisStatic->data.static_metakey}</textarea>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label no-padding-right" for="form-field-meta-description"> Meta Description</label>
														<div class="col-sm-9">
															<textarea cols="50" rows="5" class="form-control" name="static_metadesc">{$thisStatic->data.static_metadesc}</textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<div class="widget-box">
										<div class="widget-header">
											<h4>Mô tả chi tiết</h4>
										</div>
										<div class="widget-body">
											<div class="widget-body-inner">
												<div class="widget-main">
													<div class="form-group">
														<label class="col-sm-2 control-label no-padding-right" for="form-field-struct-html"> Xây dựng cấu trúc trang</label>
														<div class="col-sm-4">
															<label class="inline" style="margin-right:10px;padding-top:5px;">
																<input type="checkbox" class="ace" value="1" name="static_struct_html_h"{if $thisStatic->data.static_struct_html_h} checked="checked"{/if}>
																<span class="lbl" style="font-weight:bold;"> H1, H2, H3, H4, H5, H6</span>
															</label>
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<label class="col-sm-2 control-label no-padding-right" for="form-field-use-custom-template"> Sử dụng template </label>
														<div class="col-sm-10">
															<label>
																<input type="checkbox" class="ace ace-switch ace-switch-4" name="static_custom_html"{if $thisStatic->data.static_custom_html == 1} checked="checked"{/if} value="1">
																<span class="lbl"></span>
															</label>
														</div>
													</div>
													{if $admin->admin_super}
														<div class="space-4"></div>
														<div class="form-group">
															<label class="col-sm-2 control-label no-padding-right" for="form-field-use-custom-template"> Sử dụng template mobile</label>
															<div class="col-sm-10">
																<label>
																	<input type="checkbox" class="ace ace-switch ace-switch-4" name="static_custom_html_mobile"{if $thisStatic->data.static_custom_html_mobile == 1} checked="checked"{/if} value="1">
																	<span class="lbl"></span>
																</label>
															</div>
														</div>
													{/if}
													<div class="space-4"></div>
													<div class="form-group" id="check_direct">
														<label class="col-sm-2 control-label no-padding-right" for="form-field-use-custom-template"> Đường dẫn template </label>
														<div class="col-sm-2">
															<input type="text" name="static_template_director" class="form-control" value="{$thisStatic->data.static_template_director}" placeholder="Đường dẫn template" />
														</div>
													</div>
													<div class="space-4"></div>
													<div class="form-group">
														<textarea cols="65" rows="5" class="required" name="static_fulltext" id="fulltext">{$thisStatic->data.static_fulltext}</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="widget-body" id="box-custom-mobile" style="display: none;">
											<div class="widget-body-inner">
												<div class="widget-main">
													<div class="form-group">
														<h3>Nội dung thể hiện riêng cho mobile</h3>
														<textarea cols="65" rows="5" id="tinyfulltext" name="static_fulltext_mobile">{$thisStatic->data.static_fulltext_mobile}</textarea>
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
			{literal}
				<script type="text/javascript">
					$(document).ready(function(){
						//Change click
						if ($('input[name=static_custom_html]').is(':checked')){
							$('#check_direct').show();
						}else{
							$('#check_direct').hide();
						}
						$('input[name=static_custom_html]').click(function(){
							if ($(this).is(':checked')){
								$('#check_direct').show();
							}else{
								$('#check_direct').hide();
							}
						});

						if ($('input[name=static_custom_html_mobile]').is(':checked')){
							$('#box-custom-mobile').show();
						}else{
							$('#box-custom-mobile').hide();
						}
						$('input[name=static_custom_html_mobile]').click(function(){
							if ($(this).is(':checked')){
								$('#box-custom-mobile').show();
							}else{
								$('#box-custom-mobile').hide();
							}
						});
					});
				</script>
			{/literal}
		   	<input type="hidden" name="static_id_value" value="{$static_id}" />
			<input type="hidden" name="task" value="save" />
		</form>
	</div>
</div>
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
											<button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_fulltext').value='';document.getElementById('filter_site_id').value=0;document.getElementById('filter_group').value=0;document.getElementById('filter_status').value=3;document.getElementById('limit').value='50';document.adminForm.p.value=1;"><i class="icon-undo bigger-110"></i> Làm lại</button>
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
												<option value="0">Chọn nhóm hiển thị</option>
												{foreach from=$grStatic key=k item=static}
									   			<option value="{$k}"{if $filter_group==$k} selected="seleceted"{/if}>{$static}</option>
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
								<th class="center">
									<label>
										<input type="checkbox" onclick="checkAll(50);" value="" name="toggle" class="ace">
										<span class="lbl"></span>
									</label>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Tên nội dung</strong>
								</th>
								{if $filter_fulltext}
									<th class="title" nowrap="nowrap">
										<strong>Mô tả ngắn/Meta</strong>
									</th>
									<th class="title" nowrap="nowrap">
										<strong>Mô tả chi tiết</strong>
									</th>
								{else}
									<th class="title" nowrap="nowrap" width="50">
										<strong>Icon</strong>
									</th>
									<th class="title" nowrap="nowrap">
										<strong>Tên Site</strong>
									</th>
									<th class="title" nowrap="nowrap">
										<strong>Thuộc nhóm</strong>
									</th>
									<th class="title" nowrap="nowrap">
										<strong>Ngày tạo</strong>
									</th>
								{/if}
								<th width="100" nowrap="nowrap">
									<strong>Trạng thái</strong>
								</th>
							</tr>
						</thead>
						<tbody>
							{section name=loops loop=$lsStatic}
							<tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
								<td>{$smarty.section.loops.index+1}</td>
								<td align="center">
									<label>
										<input type="checkbox" onclick="isChecked(this.checked);" value="{$lsStatic[loops].static_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
										<span class="lbl"></span>
									</label>
								</td>
								<td>
									<a href="{$page}.php?task=edit&static_id={$lsStatic[loops].static_id}">{$lsStatic[loops].static_title}</a>
								</td>
								{if $filter_fulltext}
									<td align="left" valign="top">
										<p><b>Mô tả ngắn:</b> {$lsStatic[loops].keyword_introtext}</p>
										<p><b>Metatitle:</b>{$lsStatic[loops].keyword_metatitle}</p>
										<p><b>Metakey:</b>{$lsStatic[loops].keyword_metakey}</p>
										<p><b>Metadesct:</b>{$lsStatic[loops].keyword_metadesc}</p>
									</td>
									<td align="left" valign="top">
										<div style="height:300px;overflow:scroll;">
											{$lsStatic[loops].keyword_fulltext}
										</div>
									</td>
								{else}
									<td align="center"><span style="color: #{if $lsStatic[loops].static_style_color}{$lsStatic[loops].static_style_color}{else}FFA611{/if}" class="fa fa-{if $lsStatic[loops].static_style}{$lsStatic[loops].static_style}{else}star-o{/if}"></span></td>
									<td>{$lsStatic[loops].site}</td>
									<td>{$lsStatic[loops].name_group_type}</td>
									<td>
										{$lsStatic[loops].static_created|date_format:"%d/%m/%Y %H:%M:%S"}
									</td>
								{/if}
								<td align="center">
									{if $lsStatic[loops].static_status == 1}
										<a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','unpublish')" title="Ẩn bài viết">
											<i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
										</a>
									{elseif $lsStatic[loops].static_status == 2}
										<a style="cursor:pointer; text-decoration: none;" onclick="listItemTask('cb{$smarty.section.loops.index}','publish')" title="Hiển thị bài viết">
											<i class="icon-key" style="color: #FDB053; font-size: 15px;"></i>
										</a>
									{else}
										<a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','publish')" title="Hiển thị bài viết">
											<i class="icon-off" style="color: red; font-size: 15px;"></i>
										</a>
									{/if}
								</td>
							</tr>
							{sectionelse}
							<tr>
								<td colspan="{if $filter_fulltext}6{else}8{/if}" align="center"><font color="red">Không tồn tại nội dung thỏa mãn điều kiện tìm kiếm!</font></td>
							</tr>
							{/section}
						</tbody>
						<tfoot>
							<tr>
								<td colspan="{if $filter_fulltext}6{else}8{/if}">
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