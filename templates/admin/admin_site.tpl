{include file='admin_header.tpl'}
{if $task == "add" || $task == "edit"}
<div class="row" style="display:none;" id="blockErr">
	<div class="col-xs-12">
		<h3 class="header smaller lighter green"><i class="ace-icon fa fa-bullhorn"></i>Xảy ra lỗi sau</h3>
		<div class="alert alert-danger">
			<span id="strErr">{$errorTxt}</span>
		</div>
	</div>
</div>
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
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-code"> Mã site</label>
												<div class="col-sm-9">
													<input type="text" name="site_code" class="col-xs-12 required" value="{$thisSite->data.site_code}" placeholder="Mã site" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Tên site</label>
												<div class="col-sm-9">
													<input type="text" name="site_name" class="col-xs-12 required" value="{$thisSite->data.site_name}" placeholder="Tên site" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-secure-secret"> Secure Secret</label>
												<div class="col-sm-9">
													<label style="padding-top: 5px; color: #666;">{$thisSite->data.site_secure_secret}</label>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-domain"> Domain</label>
												<div class="col-sm-9">
													<input type="text" name="site_domain" class="col-xs-12 required" value="{$thisSite->data.site_domain}" placeholder="Tên domain" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-phone"> Điện thoại</label>
												<div class="col-sm-9">
													<input type="text" name="site_phone" class="col-xs-12 required" onkeypress="return numberOnly(this, event);" value="{$thisSite->data.site_phone}" placeholder="Điện thoại" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-email"> Email</label>
												<div class="col-sm-9">
													<input type="text" name="site_emails" class="col-xs-12 required" value="{$thisSite->data.site_emails}" placeholder="Địa chỉ email" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="widget-box">
								<div class="widget-header">
									<h4>Phân loại site</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner">
										<div class="widget-main">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-group-type"> Nhóm site / Kiểu site</label>
												{if $admin->admin_super}
													<div class="col-sm-4">
														<select size="1" class="form-control" name="site_group">
															{foreach from=$site_groups key = g item=gr}
																<option {if $thisSite->data.site_group==$g}selected="selected"{/if} value="{$g}">{$gr}</option>
															{/foreach}
														</select>
													</div>
												{/if}
												<div class="{if $admin->admin_super}col-sm-5{else}col-sm-9{/if}">
													<select size="1" class="form-control" name="site_type">
														{foreach from=$site_types key = t item=type}
															<option {if $thisSite->data.site_type==$t}selected="selected"{/if} value="{$t}">{$type}</option>
														{/foreach}
													</select>
												</div>
											</div>
											{if $task == 'edit' && $thisSite->data.site_group == 1}
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-site-group-student-show" style="color:#00ba00;"> Hiển thị ứng viên đăng ký</label>
													<div class="col-sm-9">
														<div class="checkbox" style="width: 32%; float: left; margin-right: 1%;">
															<label>
																<input type="checkbox"{if $thisSite->data.site_group_student_show} checked="checked"{/if} value="1" name="site_group_student_show" class="ace">
																<span class="lbl"> Bật hiển thị chức năng</span>
															</label>
														</div>
													</div>
												</div>
											{/if}
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-site-data-test"> Dữ liệu test site</label>
												<div class="col-sm-9">
													<select size="1" class="form-control" name="test_data_site_id">
														<option {if $thisSite->data.test_data_site_id == 0}selected="selected"{/if} value="0">-- Không sử dụng --</option>
														{foreach from=$list_site_others key=s item=osite}
															<option {if $thisSite->data.test_data_site_id == $osite.site_id}selected="selected"{/if} value="{$osite.site_id}">Dùng dữ liệu site: {$osite.site_domain}</option>
														{/foreach}
													</select>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-access"> Các nhóm site truy cập</label>
												<div class="col-sm-9">
													{foreach from=$group_sites key=ac item=access}
														{assign var=filename_include value=""}
														{if $ac == 1}
															{assign var=filename_include value="products.php"}
														{elseif $ac == 2}
															{assign var=filename_include value="news.php"}
														{elseif $ac == 3}
															{assign var=filename_include value="jobs.php"}
														{elseif $ac == 4}
															{assign var=filename_include value="services.php"}
														{elseif $ac == 5}
														{elseif $ac == 6}
														{/if}
														<div class="checkbox" style="width: 32%; float: left; margin-right: 1%;">
															<label>
																<input type="checkbox"{if in_array($ac, $thisSite->data.site_access)} checked="checked"{/if} value="{$ac}" name="site_access[]" class="ace ck_access">
																<span class="lbl"> {$access}</span>
																{if $filename_include}
																	<p class="help">
																		<input class="file_include" type="text" disabled name="filename_include[{$ac}]" size="10" value="{if is_array($thisSite->data.site_file_include) && !empty($thisSite->data.site_file_include)}{foreach from=$thisSite->data.site_file_include key=vf item=file}{if $vf == $ac && $file}{$file}{/if}{/foreach}{else}{$filename_include}{/if}" />
																	</p>
																{/if}
															</label>
														</div>
													{/foreach}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="widget-box">
								<div class="widget-header">
									<h4>Modules sử dụng chung</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner">
										<div class="widget-main">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-site-module"> Modules sử dụng</label>
												<div class="col-sm-9" id="list_global_module" style="display:none"></div>
											</div>
											{literal}
											<script type="text/javascript">
												// Function show hide ships
												function show_hide_ships(spValue, sData){
													//console.log(sData);
													if($.inArray(spValue, sData) > -1){
														// does exist
														$('#ship_for_product').show();
													}else{
														// does not exist
														$('#ship_for_product').hide();
													}
												}

												// Function get module global
												function get_list_global_modules(count, sData, arrDataModuleChecked){
													if ( count ){
														$('#list_global_module').show();
													}else{
														$('#list_global_module').hide();
													}
													var data = {data : sData}
													$.ajax({
														type: "POST",
														url: "admin_ajax_tasks.php?task=get_global_module",
														data: data,
														dataType: "json",
														success: function(xmlhttp) {
															var objData = xmlhttp;
															if (parseInt(objData.isOk) == 0) {
																return false;
															}else{
																var arrDataModule = objData.data;
																var html = '';
																$.each(arrDataModule, function(index, values) {
																	$.each(values, function(index_s, value) {
																		var checked = '';
																		if($.isArray(arrDataModuleChecked) && $.inArray(value, arrDataModuleChecked) > -1){
																			// does exist
																			var checked = ' checked = "checked"';
																		}
																		html += '<div class="checkbox">';
																		html += '<label>';
																		html += '<input type="checkbox"'+checked+' value="' + value + '" name="site_global_modules['+index+'][]" class="ace">';
																		html += '<span class="lbl"> ' + value + '</span>';
																		html += '</label>';
																		html += '</div>';
																	});
																});
																$('#list_global_module').html(html);
															}
														}
													});
												}

												// Jquery
												$(document).ready(function(){
													var spValue = "1";
													var sData = [];
													var countChecked = 0;
													var arrDataModuleChecked = {/literal}{if $thisSite->data.site_global_modules_json}{$thisSite->data.site_global_modules_json}{else}''{/if}{literal};
													$(".ck_access").each(function(){
														if ( $(this).is( ":checked" ) ){
															sData.push($(this).val());
															countChecked++;
															// Set file include
															$(this).parent().find('.file_include').removeAttr("disabled");
														}
														show_hide_ships(spValue, sData);
													});
													get_list_global_modules(countChecked, sData, arrDataModuleChecked);
													$(".ck_access").click(function(){
														if ( $(this).is( ":checked" ) ){
															sData.push($(this).val());
															countChecked++;
															// Set file include
															$(this).parent().find('.file_include').removeAttr("disabled");
														}else{
															var index = sData.indexOf($(this).val());
															if (index > -1) {
																sData.splice(index, 1);
															}
															if ( countChecked ){
																countChecked--;
															}
														}
														show_hide_ships(spValue, sData);
														get_list_global_modules(countChecked, sData, arrDataModuleChecked);
													});
												});
											</script>
											{/literal}
										</div>
									</div>
								</div>
							</div>
							<div class="widget-box">
								<div class="widget-header">
									<h4>Giao diện hiển thị</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner">
										<div class="widget-main">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-template"> Giao diện</label>
												<div class="col-sm-9">
													<select size="1" class="form-control" name="site_template_id">
														<option {if $thisSite->data.site_template_id==0}selected="selected"{/if} value="0">-- Mặc định --</option>
														{if $templates}
															{foreach from=$templates key=t item=temp}
																<option {if $thisSite->data.site_template_id==$temp.template_id}selected="selected"{/if} value="{$temp.template_id}">{$temp.template_name}({$temp.template_code})</option>
															{/foreach}
														{/if}
													</select>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-template-color"> Màu giao diện</label>
												<div class="col-sm-9">
													<div class="scrollbox">
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "blue"} checked="checked"{/if} type="radio" value="blue" name="site_template_color" class="ace">
																<span class="lbl"> Màu xanh (blue)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "red"} checked="checked"{/if} type="radio" value="red" name="site_template_color" class="ace">
																<span class="lbl"> Màu đỏ (red)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "orange"} checked="checked"{/if} type="radio" value="orange" name="site_template_color" class="ace">
																<span class="lbl"> Màu cam (orange)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "yellow"} checked="checked"{/if} type="radio" value="yellow" name="site_template_color" class="ace">
																<span class="lbl"> Màu vàng (yellow)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "purple"} checked="checked"{/if} type="radio" value="purple" name="site_template_color" class="ace">
																<span class="lbl"> Màu tím (purple)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "pink"} checked="checked"{/if} type="radio" value="pink" name="site_template_color" class="ace">
																<span class="lbl"> Màu hồng (pink)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "brown"} checked="checked"{/if} type="radio" value="brown" name="site_template_color" class="ace">
																<span class="lbl"> Màu nâu (brown)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == "black"} checked="checked"{/if} type="radio" value="black" name="site_template_color" class="ace">
																<span class="lbl"> Màu đen (black)</span>
															</label>
														</div>
														<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
															<label>
																<input{if $thisSite->data.site_template_color == ""} checked="checked"{/if} type="radio" value="" name="site_template_color" class="ace">
																<span class="lbl"> <b>Mặc định</b> </span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-mobile-template"> Giao diện mobile </label>
												<div class="col-sm-3">
													<label>
														<input type="checkbox" class="ace ace-switch ace-switch-4" name="site_template_mobile"{if $thisSite->data.site_template_mobile == 1} checked="checked"{/if} value="1">
														<span class="lbl"></span>
													</label>
												</div>
												<div id="name_theme_mobile" class="col-sm-6">
													<input type="text" class="col-xs-10 form-control" name="site_template_mobile_name" value="{$thisSite->data.site_template_mobile_name}" placeholder="Tên template mobile" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-tablet-template"> Giao diện tablet </label>
												<div class="col-sm-3">
													<label>
														<input type="checkbox" class="ace ace-switch ace-switch-4" name="site_template_tablet"{if $thisSite->data.site_template_tablet == 1} checked="checked"{/if} value="1">
														<span class="lbl"></span>
													</label>
												</div>
												<div id="name_theme_tablet" class="col-sm-6">
													<input type="text" class="col-xs-10 form-control" name="site_template_tablet_name" value="{$thisSite->data.site_template_tablet_name}" placeholder="Tên template tablet" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-status"> Trạng thái </label>
												<div class="col-sm-9">
													<label>
														<input type="checkbox" class="ace ace-switch ace-switch-4" name="site_status"{if $thisSite->data.site_status == 1} checked="checked"{/if} value="1">
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
							{if $admin->admin_super}
								<div class="widget-box">
									<div class="widget-header">
										<h4>Thông tin đăng ký chủ site</h4>
									</div>
									<div class="widget-body">
										<div class="widget-body-inner">
											<div class="widget-main">
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-register-date"> Ngày đăng ký</label>
													<div class="col-sm-6">
														<input type="text" name="site_register_date" class="col-xs-12 form-control datetime" value="{$thisSite->data.site_register_date|date_format:"%m/%d/%Y"}" placeholder="Ngày đăng ký site" />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-site-number-month-reset"> Số tháng gia hạn</label>
													<div class="col-sm-6">
														<input type="text" name="site_number_month_reset" maxlength="2" class="col-xs-12 form-control" onkeypress="return numberOnly(this, event);" value="{if $thisSite->data.site_number_month_reset}{$thisSite->data.site_number_month_reset}{else}12{/if}" placeholder="Số tháng gia hạn" />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-register-cost"> Phí phải trả</label>
													<div class="col-sm-6">
														<input type="text" name="site_register_cost" class="col-xs-12 form-control" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" value="{$thisSite->data.site_register_cost|number_format:0:".":","}" placeholder="Ngày đăng ký site" />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="form-field-register-info"> Ghi chú</label>
													<div class="col-sm-9">
														<textarea cols="75" rows="5" name="site_register_info" class="wysiwyg form-control">{$thisSite->data.site_register_info}</textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							{/if}
							{if $list_all_modules}
								<div class="widget-box">
									<div class="widget-header">
										<h4>Site sử dụng các modules mở rộng</h4>
									</div>
									<div class="widget-body">
										<div class="widget-body-inner">
											<div class="widget-main">
												<div class="form-group">
													<div class="col-sm-12">
														<div class="scrollbox">
															{foreach from=$list_all_modules key=k item=module}
																<div class="checkbox" style="width: 48%; float: left; margin-right: 2%;">
																	<label onmouseover="showtip('{$module.module_description}', '300', '#4FC11E');" onmouseout="hidetip();" style="cursor:pointer;">
																		<input{if in_array($module.module_id, $thisSite->data.site_module_access)} checked="checked"{/if} type="checkbox" value="{$module.module_id}" name="module_id[]" class="ace">
																		<span class="lbl"> {$module.module_title}</span>
																	</label>
																</div>
															{/foreach}
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							{/if}
							<div id="ship_for_product" class="widget-box">
								<div class="widget-header">
									<h4>Chọn các tỉnh nội thành - Phương thức tính phí vận chuyển</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner">
										<div class="widget-main">
											<div class="form-group">
												<div class="col-sm-12">
													<div class="scrollbox">
														{foreach from=$list_citys key=c item=city}
															<div class="checkbox" style="width: 28%; float: left; margin-right: 2%;">
																<label>
																	<input{if in_array($city.ma_tinh, $thisSite->data.cost_ship.ship_site_city)} checked="checked"{/if} type="checkbox" value="{$city.ma_tinh}" name="ship_site_city[]" class="ace">
																	<span class="lbl"> {$city.ten_tinh}</span>
																</label>
															</div>
														{/foreach}
													</div>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-ship-urban"> Phí nội thành</label>
												<div class="col-sm-9">
													<input type="text" name="ship_site_cost_urban" class="col-xs-12 required" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" value="{$thisSite->data.cost_ship.ship_site_cost_urban|number_format:0:".":","}" placeholder="Phí nội thành" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-ship-extramural"> Phí ngoại thành</label>
												<div class="col-sm-9">
													<input type="text" name="ship_site_cost_extramural" onkeyup="core.chargeGold.mixMoney(this)" onkeypress="return numberOnly(this, event);" class="col-xs-12 required" value="{$thisSite->data.cost_ship.ship_site_cost_extramural|number_format:0:".":","}" placeholder="TPhí ngoại thành" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-free-ship"> Miễn phí ship </label>
												<div class="col-sm-9">
													<label>
														<input type="checkbox" class="ace ace-switch ace-switch-4" name="ship_site_free"{if $thisSite->data.cost_ship.ship_site_free == 1} checked="checked"{/if} value="1">
														<span class="lbl"></span>
													</label>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group" id="box_ship_site_free_info" style="{if $thisSite->data.cost_ship.ship_site_free == 1} display: block;{else}display: none;{/if}">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-domain"> Điều kiện miễn phí</label>
												<div class="col-sm-9">
													<textarea class="form-control" rows="5" cols="30" name="ship_site_free_info">{$thisSite->data.cost_ship.ship_site_free_info}</textarea>
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
		   	<input type="hidden" name="site_id_value" value="{$site_id}" />
		   	<input type="hidden" value="{$task}" name="task">
		   	<input type="hidden" value="{$task}" name="action">
		</form>
	</div>
</div>
{literal}
<script language="javascript">
// Show name template mobile, tablet
if ($('input[name=site_template_mobile]').is(':checked')){
    $('#name_theme_mobile').show();
}else{
    $('#name_theme_mobile').hide();
}
$('input[name=site_template_mobile]').click(function(){
    if ($(this).is(':checked')){
        $('#name_theme_mobile').show();
    }else{
        $('#name_theme_mobile').hide();
    }
});

if ($('input[name=site_template_tablet]').is(':checked')){
    $('#name_theme_tablet').show();
}else{
    $('#name_theme_tablet').hide();
}
$('input[name=site_template_tablet]').click(function(){
    if ($(this).is(':checked')){
        $('#name_theme_tablet').show();
    }else{
        $('#name_theme_tablet').hide();
    }
});

// Mô tả phí Ship
if ($('input[name=ship_site_free]').is(':checked')){
    $('#box_ship_site_free_info').show();
}else{
    $('#box_ship_site_free_info').hide();
}
$('input[name=ship_site_free]').click(function(){
	if ($(this).is(':checked')){				
		$('#box_ship_site_free_info').show();
	}else{
		$('#box_ship_site_free_info').hide();
	}	
});
function submitform(pressbutton){
	var action = document.adminForm.action.value;
	if (pressbutton == 'save') {
		if (action == 'add') {
			objSite.processAction("admin_site.php?task=add&ajax=1");
		}
		else if (action == 'edit') {
			objSite.processAction("admin_site.php?task=edit&ajax=1");
		}
	}
	else {
		if (pressbutton) {
			document.adminForm.task.value=pressbutton;
		}
		document.adminForm.submit();
	}
}

if (typeof objSite == 'undefined') {
	objSite = {
		processAction: function(sUrl) {
			$.ajax({
				type: "POST",
				url: sUrl,
				data: $("#adminForm").serialize(),
				dataType: "json",
				success: function(xmlhttp){
					var objData = xmlhttp;
					if (parseInt(objData.intOK) > 0) {
						document.location = "admin_site.php";
					} else {
						$("#strErr").html(objData.strError);
						$("#blockErr").css("display", "block");
					}
				}
			});
			return false;
		}
	}
}
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
											<input type="text" class="form-control" size="40" value="{$search}" id="search" name="search" placeholder="Nhập tiêu đề site" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<button class="btn btn-purple btn-sm" onclick="this.form.submit();"><i class="icon-search icon-on-right bigger-110"></i> Tìm kiếm</button>
											{if $admin->admin_super}
												<button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_status').value=3;document.getElementById('filter_type').value=3;document.getElementById('filter_group').value=3;document.getElementById('filter_site_access').value=0;document.getElementById('limit').value='50';document.adminForm.p.value=1;"><i class="icon-undo bigger-110"></i> Làm lại</button>
											{else}
												<button class="btn btn-sm" onclick="document.getElementById('search').value='';document.getElementById('filter_status').value=3;document.getElementById('filter_type').value=3;document.getElementById('filter_site_access').value=0;document.getElementById('limit').value='50';document.adminForm.p.value=1;"><i class="icon-undo bigger-110"></i> Làm lại</button>
											{/if}
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
							<h4>Tìm kiếm theo phân loại</h4>
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
											<select size="1" class="form-control" id="filter_type" name="filter_type">
												<option {if $filter_type==3}selected="selected"{/if} value="3">- Chọn kiểu site -</option>
												{foreach from=$site_types key=t item=type}
													<option {if $filter_type==$t}selected="selected"{/if} value="{$t}">{$type}</option>
												{/foreach}
											</select>
										</div>
									</div>
									{if $admin->admin_super}
										<div class="form-group">
											<div class="col-sm-12">
												<select size="1" class="form-control" id="filter_group" name="filter_group">
													<option {if $filter_group==3}selected="selected"{/if} value="3">- Chọn nhóm site -</option>
													{foreach from=$site_groups key=g item=gr}
														<option {if $filter_group==$g}selected="selected"{/if} value="{$g}">{$gr}</option>
													{/foreach}
												</select>
											</div>
										</div>
									{else}
										<input type="hidden" name="filter_group" id="filter_group" value="{$admin->admin_info.admin_type}">
									{/if}
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
											<select size="1" class="form-control" id="filter_site_access" name="filter_site_access">
												<option {if $filter_site_access==0}selected="selected"{/if} value="0">- Dữ liệu site truy cập -</option>
												{foreach from=$group_sites key=gra item=group_access}
													<option {if $filter_site_access==$gra}selected="selected"{/if} value="{$gra}">{$group_access}</option>
												{/foreach}
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<select size="1" class="form-control" id="filter_status" name="filter_status">
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
										<input type="checkbox" onclick="checkAll({$limit});" value="" name="toggle" class="ace">
										<span class="lbl"></span>
									</label>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Mã site</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Tên site</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Site Admin | Group</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Template</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Mobile</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Tablet</strong>
								</th>
								<th class="title" nowrap="nowrap" width="150">
									<strong>Site Access</strong>
								</th>
								<th class="title" nowrap="nowrap" width="150">
									<strong>Module global</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Điện thoại</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Ngày tạo</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Ngày đăng ký</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Ngày hết hạn</strong>
								</th>
								<th class="title" nowrap="nowrap">
									<strong>Email xác nhận</strong>
								</th>
								<th width="90" nowrap="nowrap">
									<strong>Trạng thái</strong>
								</th>
							</tr>
						</thead>
						<tbody>
							{section name=loops loop=$lsSite}
							<tr class="row{if $smarty.section.loops.index%2==0}0{else}1{/if}">
								<td>{$smarty.section.loops.index+1}</td>
								<td align="center">
									<label>
										<input type="checkbox" onclick="isChecked(this.checked);" value="{$lsSite[loops].site_id}" name="cid[]" id="cb{$smarty.section.loops.index}" class="ace">
										<span class="lbl"></span>
									</label>
								</td>
								<td>
									{$lsSite[loops].site_code}
								</td>
								<td>
									{if $lsSite[loops].site_domain != $lsSite[loops].site_name}
										<a href="{$page}.php?task=edit&site_id={$lsSite[loops].site_id}">{$lsSite[loops].site_name}</a>
										<br />
										{$lsSite[loops].site_domain}
									{else}
										<a href="{$page}.php?task=edit&site_id={$lsSite[loops].site_id}">{$lsSite[loops].site_name}</a>
									{/if}
									{if $lsSite[loops].test_data_site_id}
									<br />
									<span>Sử dụng data site test ID: <b>{$lsSite[loops].test_data_site_id}</b></span>
									{/if}
								</td>
								<td>
									{if $lsSite[loops].site_type == 0}
										<b><span style="color: #2C492A;">Site quản trị</span></b>
									{else}
										<span style="color: #87B75A;">Hệ thống user</span>
									{/if}
									<br/>
									{if $lsSite[loops].site_group == 1}
										<i><span style="color: #009900;">Dữ liệu trường</span></i>
									{elseif $lsSite[loops].site_group == 2}
										<i><span style="color: #197fd0;">Nhà trường</span></i>
									{else}
										<i><span style="color: rgba(123, 123, 123, 0.77);">Hệ thống chung</span></i>
									{/if}
								</td>
								<td>
									{if $lsSite[loops].template}<span style="color: #1591CC;">{$lsSite[loops].template}</span>{else}<span style="color: #666;">Mặc định</span>{/if}
									{if $lsSite[loops].site_template_color}<br/><b>Color: </b><span style="color: {$lsSite[loops].site_template_color};">{$lsSite[loops].site_template_color}</span>{/if}
								</td>
								<td width="25" align="center">
									{if $lsSite[loops].site_template_mobile == 1}
										<i class="icon-ok-sign" style="color: #54b234; font-size: 15px;"></i>
									{else}
										<i class="icon-off" style="color: red; font-size: 15px;"></i>
									{/if}
								</td>
								<td width="25" align="center">
									{if $lsSite[loops].site_template_tablet == 1}
										<i class="icon-ok-sign" style="color: #54b234; font-size: 15px;"></i>
									{else}
										<i class="icon-off" style="color: red; font-size: 15px;"></i>
									{/if}
								</td>
								<td>{$lsSite[loops].group_access_site}</td>
								<td>
									{foreach from=$lsSite[loops].site_global_modules key=m item=modules}
										{foreach from=$modules key=s item=moditem}
											{$moditem},
										{/foreach}
									{/foreach}
								</td>
								<td>
									{$lsSite[loops].site_phone}
								</td>
								<td>
									{$lsSite[loops].site_created|date_format:"%d/%m/%Y"}
								</td>
								<td align="center">
									{if $lsSite[loops].site_register_date && $lsSite[loops].site_register_date != '0000-00-00 00:00:00'}
										{if $admin->admin_super}
											<a href="javascript:void(0);" style="cursor:pointer; text-decoration: none;" onmouseover="showtip('<ul><li>Giá: {$lsSite[loops].site_register_cost|number_format:0:".":","} VNĐ</li><li>{$lsSite[loops].site_register_info}</li></ul>', '200', '#666');" onmouseout="hidetip();">
												{$lsSite[loops].site_register_date|date_format:"%d/%m/%Y"}
											</a>
										{else}
											{$lsSite[loops].site_register_date|date_format:"%d/%m/%Y"}
										{/if}
									{else}
										<i title="Không xác định" class="icon-remove" style="color: #ff0000; font-size: 15px;"></i>
									{/if}
								</td>
								<td align="center">
									{$lsSite[loops].site_expirated_date|date_format:"%d/%m/%Y"}
									{if $lsSite[loops].expiration}<br/> (<span style="font-weight:bold;color:#dd542a;">{$lsSite[loops].days} ngày</span>){/if}
								</td>
								<td width="25" align="center">
									{if $lsSite[loops].site_sendemail == 1}
										<i class="icon-ok-sign" style="color: #54b234; font-size: 15px;"></i>
									{else}
										<i class="icon-off" style="color: red; font-size: 15px;"></i>
									{/if}
								</td>
								<td align="center">
									{if $lsSite[loops].site_status == 1}
										<a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','unpublish')" title="Đóng site">
											<i class="icon-ok" style="color: #54b234; font-size: 15px;"></i>
										</a>
									{else}
										<a style="cursor:pointer; text-decoration: none;" onclick="return listItemTask('cb{$smarty.section.loops.index}','publish')" title="Mở site">
											<i class="icon-remove" style="color: #ff0000; font-size: 15px;"></i>
										</a>
									{/if}
								</td>
							</tr>
							{sectionelse}
							<tr>
								<td colspan="16" align="center"><font color="red">Không tồn tại site nào thỏa mãn điều kiện tìm kiếm!</font></td>
							</tr>
							{/section}
						</tbody>
						<tfoot>
							<tr>
								<td colspan="16">
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