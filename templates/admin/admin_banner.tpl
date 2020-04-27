{include file='admin_header.tpl'}
{if $task == "add" || $task == "edit"}
<script src="../templates/admin/js/jscolor/jscolor.min.js"></script>
{literal}
<script type="text/javascript">
	var arrCategory = new Array;
	{/literal}
		
	{foreach from=$groups key=k item=v}
	arrCategory[{$v-1}] = new Array( '{$v}','0','Lựa chọn theo nhóm' );
	{/foreach}
	
	{section name=loops loop=$lsCategory}
		arrCategory[{math equation="x + y" x=$smarty.section.loops.index y=$groups|@count}] = new Array( '{$lsCategory[loops].category_type}','{$lsCategory[loops].category_id}','{$lsCategory[loops].category_name}{if $lsCategory[loops].category_follow_type} | {$lsCategory[loops].name_groups_follow}{/if}' );	
	{/section}
	{literal}
</script>
{/literal}
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
														<select name="banner_site_id" class="form-control required">
															<option value=""{if $thisBanner->data.banner_site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
															{foreach from=$sites key=s item=site}
															<option value="{$s}"{if $s == $thisBanner->data.banner_site_id} selected="selected"{/if}>{$site}</option>
															{/foreach}
														</select>
													</div>
												</div>
												<div class="space-4"></div>
											{else}
												<input type="hidden" name="banner_site_id" value="{$admin->admin_site_default.site_id}" />
											{/if}
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-category"> Chọn nhóm </label>
												<div class="col-sm-9">
													<select name="banner_category_id" class=form-control>
											   			<option value="0">Lựa chọn theo nhóm</option>
											   			<option value="homepage"{if $thisBanner->data.banner_fix == "homepage"} selected="seleceted"{/if}>Trang chủ</option>
											   			{$list_option_category}
														<option value="partner"{if $thisBanner->data.banner_fix == "partner"} selected="seleceted"{/if}>Đối tác - Khách hàng</option>
											   			{foreach from=$grStatic key=k item=static}
											   				<option value="static-{$k}"{if $thisBanner->dataStatic.banner_static_id == $k} selected="seleceted"{/if}>{$static}</option>
											   			{/foreach}
											   			<option value="contact"{if $thisBanner->data.banner_fix == "contact"} selected="seleceted"{/if}>Liên hệ</option>
											   		</select>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Tên quảng cáo</label>
												<div class="col-sm-9">
													<input type="text" name="banner_title" class="col-xs-12 form-control required" value="{$thisBanner->data.banner_title}" placeholder="Tên quảng cáo" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-image">&nbsp;</label>
												<div class="col-sm-9">
													<div id="image-holder" class="box-item-image width_height_auto">
														{if $thisBanner->data.banner_images}
															<img src="{$thisBanner->data.banner_images}" width="400" border="0" />
														{/if}
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-changeimage">&nbsp;</label>
												<div class="col-sm-5">
													<div class="checkbox" style="padding: 0;">
														<label>
															<input type="checkbox" class="ace ace-checkbox-2" name="changeimage" value="1" />
															<span class="lbl"> Thay ảnh banner (web)</span>
														</label>
													</div>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<div class="col-sm-12">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-image-url">&nbsp;</label>
													<div class="col-sm-5">
														<div id="show_pic" style="display: none; padding: 0;" class="col-sm-12 ace-file-input">
															<input size="20" type="file" id="fileUpload" name="image" class="input-file-image" />
														</div>
													</div>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-image">&nbsp;</label>
                                                <div class="col-sm-4">
													<div id="image-holder-1" class="box-item-image width_height_auto">
														{if $thisBanner->data.banner_icon}
															<img src="{$thisBanner->data.banner_icon}" width="200" border="0" />
														{/if}
													</div>
                                                </div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-changeimage">&nbsp;</label>
                                                <div class="col-sm-4">
													<div class="checkbox" style="padding: 0;">
														<label>
															<input type="checkbox" class="ace ace-checkbox-2" name="changeimageicon" value="1" />
															<span class="lbl"> Thay ảnh banner (mobile)</span>
														</label>
													</div>
                                                </div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<div class="col-sm-12">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-image-url">&nbsp;</label>
                                                    <div class="col-sm-4">
														<div id="show_pic_icon" style="display: none; padding: 0;" class="col-sm-12 ace-file-input">
															<input size="20" type="file" id="fileUpload1" name="imageicon" class="input-file-image" />
														</div>
                                                    </div>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-background"> Màu nền</label>
												<div class="col-sm-9">
													<input type="text" name="banner_background" class="col-xs-4 form-control jscolor" value="{$thisBanner->data.banner_background}" placeholder="Nhập mã màu nền" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-link"> Link Url</label>
												<div class="col-sm-9">
													<input type="text" name="banner_url" class="col-xs-12 form-control required" value="{$thisBanner->data.banner_url}" placeholder="Nhập địa chỉ url liên kết" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-ordering"> Thứ tự sắp xếp</label>
												<div class="col-sm-9">
													<input type="text" name="banner_ordering" class="col-xs-4 form-control" onkeypress="return numberOnly(this, event);" value="{$thisBanner->data.banner_ordering}" placeholder="Thứ tự sắp xếp" />
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
									<h4>Thông tin khác</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner">
										<div class="widget-main">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-position"> Vị trí </label>
												<div class="col-sm-9">
											   		<select name="banner_position" class="form-control required">
											   			<option value="">Chọn vị trí</option>
											   			{foreach from=$lsPosition key=k item=position}
											   			<option value="{$position}"{if $position==$thisBanner->data.banner_position || $position == $filter_position} selected="selected"{/if}>{$position}</option>
											   			{/foreach}
											   		</select>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-desc"> Mô tả </label>
												<div class="col-sm-9">
													<textarea cols="65" rows="15" name="banner_description" class="wysiwyg">{$thisBanner->data.banner_description}</textarea>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-created"> Ngày cập nhật </label>
												<div class="col-sm-9">
											   		<input type="text" data-date-format="dd/mm/yyyy" name="banner_created" class="form-control datetime" value="{if $thisBanner->data.banner_id>0}{$thisBanner->data.banner_created|date_format:"%d/%m/%Y"}{else}{$smarty.now|date_format:"%d/%m/%Y"}{/if}" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-start-date"> Ngày bắt đầu </label>
												<div class="col-sm-9">
													<input type="text" data-date-format="dd/mm/yyyy" name="banner_start_date" class="form-control datetime" value="{if $thisBanner->data.banner_id>0}{$thisBanner->data.banner_start_date|date_format:"%d/%m/%Y"}{else}{$smarty.now|date_format:"%d/%m/%Y"}{/if}" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-end-date"> Ngày kết thúc </label>
												<div class="col-sm-9">
													<input type="text" data-date-format="dd/mm/yyyy" name="banner_end_date" class="form-control datetime" value="{if $thisBanner->data.banner_id>0}{$thisBanner->data.banner_end_date|date_format:"%d/%m/%Y"}{else}{$smarty.now|date_format:"%d/%m/%Y"}{/if}" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-is-logo"> Logo đối tác </label>
												<div class="col-sm-9">
													<label>
														<input type="checkbox" class="ace ace-switch ace-switch-4" name="is_logo"{if $thisBanner->data.is_logo == 1} checked="checked"{/if} value="1">
														<span class="lbl"></span>
													</label>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-status"> Trạng thái </label>
												<div class="col-sm-9">
													<label>
														<input type="checkbox" class="ace ace-switch ace-switch-4" name="banner_status"{if $thisBanner->data.banner_status == 1} checked="checked"{/if} value="1">
														<span class="lbl"></span>
													</label>
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
		   	<input type="hidden" name="banner_id_value" value="{$banner_id}" />
		   	<input type="hidden" name="task" value="save" />
		</form>
	</div>
</div>
{literal}
<script>
	//Change Image icon
	$('input[name=changeimageicon]').change(function(){
		if ($(this).is(':checked')){
			$('#show_pic_icon').show();
		}else{
			$('#show_pic_icon').hide();
		}
	});
	$("#fileUpload1").on('change', function () {
		//Get count of selected files
		var countFiles = $(this)[0].files.length;

		var imgPath = $(this)[0].value;
		var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		var image_holder = $("#image-holder-1");
		image_holder.empty();

		if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
			if (typeof (FileReader) != "undefined") {

				//loop for each file selected for uploaded.
				for (var i = 0; i < countFiles; i++) {

					var reader = new FileReader();
					reader.onload = function (e) {
						$("<img />", {
							"src": e.target.result,
							"class": "thumb-image"
						}).appendTo(image_holder);
					}

					image_holder.show();
					reader.readAsDataURL($(this)[0].files[i]);
				}

			} else {
				alert("This browser does not support FileReader.");
			}
		} else {
			alert("Please select only images");
		}
	});
</script>
{/literal}
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
											<input type="text" class="form-control" size="40" value="{$search}" id="search" name="search" placeholder="Nhập tiêu đề quảng cáo" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<button class="btn btn-purple btn-sm" onclick="this.form.submit();"><i class="icon-search icon-on-right bigger-110"></i> Tìm kiếm</button>
											<button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_site_id').value=0;document.getElementById('filter_category').value=0;document.getElementById('filter_position').value='';document.getElementById('filter_status').value=3;document.getElementById('limit').value='50';document.adminForm.p.value=1;"><i class="icon-undo bigger-110"></i> Làm lại</button>
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
							<h4>Tìm kiếm theo site - dữ liệu</h4>
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
											<select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_category" name="filter_category">
												<option {if $filter_category==0}selected="selected"{/if} value="0">- Chọn vùng dữ liệu -</option>
												<option value="homepage"{if $filter_fix == "homepage"} selected="seleceted"{/if}>Trang chủ</option>
												{$option}
												<option value="partner"{if $filter_fix == "partner"} selected="seleceted"{/if}>Đối tác - Khách hàng</option>
												{foreach from=$grStatic key=k item=static}
									   				<option value="static-{$k}"{if $filter_static == $k} selected="seleceted"{/if}>{$static}</option>
									   			{/foreach}
									   			<option value="contact"{if $filter_fix == "contact"} selected="seleceted"{/if}>Liên hệ</option>
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
											<select onchange="document.adminForm.submit();" size="1" class="form-control" id="filter_position" name="filter_position">
												<option {if $filter_position==""}selected="selected"{/if} value="">- Chọn vị trí -</option>
												{foreach from=$lsPosition key=k item=position}
												<option {if $filter_position==$position}selected="selected"{/if} value="{$position}">{$position}</option>
												{/foreach}
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
									<strong>Tên Banner</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Tên Site</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Chuyên mục</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>URL</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Vị trí</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Màu nền</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Ngày tạo</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Bắt đầu</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Kết thúc</strong>
								</th>
								<th width="100" nowrap="nowrap">
									<strong>Số click</strong>
								</th>
								<th width="80" nowrap="nowrap">
									<strong>Sắp xếp</strong>
								</th>
								<th width="25" nowrap="nowrap">
									<strong>Logo</strong>
								</th>
								<th width="100" nowrap="nowrap">
									<strong>Trạng thái</strong>
								</th>
							</tr>
						</thead>
						<tbody>
							{section name=loops loop=$lsBanner}
							<tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
								<td>{$smarty.section.loops.index+1}</td>
								<td align="center">
									<label>
										<input type="checkbox" onclick="isChecked(this.checked);" value="{$lsBanner[loops].banner_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
										<span class="lbl"></span>
									</label>
								</td>
								<td>
									<a href="{$page}.php?task=edit&banner_id={$lsBanner[loops].banner_id}">{$lsBanner[loops].banner_title}</a>
								</td>
								<td>{$lsBanner[loops].site}</td>
								<td>
									<font color="#D15B47">
										{$lsBanner[loops].dataCat.category_name}
										{if $lsBanner[loops].dataStatic.static_title}{$lsBanner[loops].dataStatic.static_title}{/if}
										{if $lsBanner[loops].banner_fix == "homepage"}Trang chủ{elseif $lsBanner[loops].banner_fix == "contact"}Liên hệ{elseif $lsBanner[loops].banner_fix == "partner"}Đối tác - Khách hàng{/if}
									</font>
								</td>
								<td>
									{$lsBanner[loops].banner_url}
								</td>
								<td><font color="#FF8000">{$lsBanner[loops].banner_position}</font></td>
								<td align="center"><div style="width:20px;height:20px;border:1px solid #eee;{if $lsBanner[loops].banner_background}background-color:#{$lsBanner[loops].banner_background}{/if}"></div> </td>
								<td>
									{$lsBanner[loops].banner_created|date_format:"%d/%m/%Y"}
								</td>
								<td>
									{$lsBanner[loops].banner_start_date|date_format:"%d/%m/%Y"}
								</td>
								<td>
									{$lsBanner[loops].banner_end_date|date_format:"%d/%m/%Y"}
								</td>
								<td align="center">
									{$lsBanner[loops].banner_click}
								</td>
								<td align="center">
									{$lsBanner[loops].banner_ordering}
								</td>
								<td align="center">
									{if $lsBanner[loops].is_logo == 1}
										<i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
									{/if}
								</td>
								<td align="center">
									{if $lsBanner[loops].banner_status == 1}
										<a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','unpublish')" title="Đóng quảng cáo">
											<i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
										</a>
									{else}
										<a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','publish')" title="Mở quảng cáo">
											<i class="icon-lock" style="color: #999; font-size: 15px;"></i>
										</a>
									{/if}
								</td>
							</tr>
							{sectionelse}
							<tr>
								<td colspan="15" align="center"><font color="red">Không tồn tại quảng cáo nào thỏa mãn điều kiện tìm kiếm!</font></td>
							</tr>
							{/section}
						</tbody>
						<tfoot>
							<tr>
								<td colspan="15">
									{$datapage}
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<input type="hidden" value="{$task}" name="task">
			<input type="hidden" value="" name="boxchecked">
			<input type="hidden" value="{$totalRecords}" name="total_record" id="total_record" />
		</form>
	</div>
</div>
{/if}
{include file='admin_footer.tpl'}