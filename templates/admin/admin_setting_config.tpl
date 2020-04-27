<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTabSettingSiteConfig">
		<li class="active">
			<a data-toggle="tab" href="#area-design" aria-expanded="true">Giao diện</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#area-logo" aria-expanded="true">Logo & Favicon</a>
		</li>
		{if in_array(1, $item->data.site_access)}
			<li class="">
				<a data-toggle="tab" href="#resize-image-product" aria-expanded="false">Ảnh sản phẩm</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#resize-color-size-product" aria-expanded="false">Màu sắc - Kích thước</a>
			</li>
		{/if}
		{if in_array(2, $item->data.site_access) || in_array(3, $item->data.site_access) || in_array(4, $item->data.site_access) || in_array(5, $item->data.site_access)}
			<li class="">
				<a data-toggle="tab" href="#resize-image-news" aria-expanded="false">Ảnh bài viết</a>
			</li>
		{/if}
		{if $admin->admin_super}
			<li class="">
				<a data-toggle="tab" href="#configuration-email" aria-expanded="false">Cấu hình Mail</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#configuration-cache" aria-expanded="false">Cache dữ liệu</a>
			</li>
		{/if}
	</ul>
	<div class="tab-content">
		<div id="area-design" class="tab-pane active">
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-limit-tag"> Bản ghi nhóm (tag) </label>
				<div class="col-sm-8">
					<input type="text" name="setting_tag_limit" class="col-xs-6" maxlength="2" onkeypress="return numberOnly(this, event);" value="{if $item->data.setting_tag_limit}{$item->data.setting_tag_limit}{/if}" placeholder="Số lượng bản ghi tag" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-limit-box"> Bản ghi từng vùng (box) </label>
				<div class="col-sm-8">
					<input type="text" name="setting_box_limit" class="col-xs-6" maxlength="2" onkeypress="return numberOnly(this, event);" value="{if $item->data.setting_box_limit}{$item->data.setting_box_limit}{/if}" placeholder="Số lượng bản ghi từng vùng" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-list-limit"> Bản ghi trang (page) </label>
				<div class="col-sm-8">
					<input type="text" name="setting_list_limit" class="col-xs-6" maxlength="2" onkeypress="return numberOnly(this, event);" value="{if $item->data.setting_list_limit}{$item->data.setting_list_limit}{/if}" placeholder="Số lượng bản ghi từng trang" />
				</div>
			</div>
			<div style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting_image_in_content"> Chiều rộng ảnh bài viết </label>
				<div class="col-sm-8">
					<input type="text" name="setting_image_in_content" class="col-xs-6" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.setting_image_in_content}{$item->data.setting_image_in_content}{/if}" placeholder="Chiều rộng ảnh bài viết chi tiết" />
				</div>
			</div>
			{if $admin->admin_super}
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-use-location"> Sử dụng dữ liệu vị trí </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_use_location"{if $item->data.setting_use_location == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-use-location"> Sử dụng dữ liệu tabs </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_tab_data"{if $item->data.setting_tab_data == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-show-admin-created"> Hiển thị tên người viết bài </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_show_admin_created"{if $item->data.setting_show_admin_created == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-show-introtext"> Hiển thị mô tả ngắn </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_show_introtext"{if $item->data.setting_show_introtext == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-show-pic-detail"> Hiển thị ảnh chi tiết </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_show_image_detail"{if $item->data.setting_show_image_detail == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-process-fulltext"> Xử lý xóa style bài viết </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_process_fulltext"{if $item->data.setting_process_fulltext == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-set-font-default"> Sử dụng font mặc định </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_set_font_default"{if $item->data.setting_set_font_default == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-comment"> Sử dụng chức năng comment </label>
					<div class="col-sm-8">
						<label>
							<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_comment"{if $item->data.setting_comment == 1} checked="checked"{/if} value="1">
							<span class="lbl"></span>
						</label>
					</div>
				</div>
				<div style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-tag-content-position"> Vị trí tag hiển thị </label>
					<div class="col-sm-4">
						<label style="margin-right:10px;">
							<input type="radio" class="ace ace-switch ace-switch-4" name="setting_tag_position"{if $item->data.setting_tag_position == 'bottom'} checked="checked"{/if} value="bottom">
							<span class="lbl">&nbsp;Dưới bài viết</span>
						</label>
						<label>
							<input type="radio" class="ace ace-switch ace-switch-4" name="setting_tag_position"{if $item->data.setting_tag_position == 'right'} checked="checked"{/if} value="right">
							<span class="lbl">&nbsp;Bên phải bài viết</span>
						</label>
					</div>
				</div>
				<div style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-tag-content-position"> Import site wordpress </label>
					<div class="col-sm-4">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_include_wordpress == 1} checked="checked"{/if} name="setting_include_wordpress" />
							<span class="lbl"> Hệ thống wordpress</span>
						</label>
					</div>
					<div class="col-sm-4">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_include_wordpress_team == 1} checked="checked"{/if} name="setting_include_wordpress_team" />
							<span class="lbl"> Bật file .team</span>
						</label>
					</div>
				</div>
				<div style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
				<div class="space-4"></div>
				<div class="form-group">
					<h4 align="center" style="margin: 0 0 10px 0;"> Liên kết với các site trong hệ thống </h4>
					<div class="col-sm-12">
						<select name="cbo_site[]" id="cbo_site" multiple class="form-control">
							{foreach from=$sites key=siteid item=sitename}
								<option value="{$siteid}"{foreach from=$arySiteId key=id2 item=siteId2}
										{if $siteId2 == $siteid}selected='selected'{/if}{/foreach}>{$sitename}</option>
							{/foreach}
						</select>
						{literal}
							<script type="text/javascript">
								//$('#cbo_site').multiSelect();
								$('#cbo_site').multiSelect({
									selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='Nhập tìm tên site'>",
									selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='Nhập tìm tên site được chọn'>",
									afterInit: function(ms){
										var that = this,
												$selectableSearch = that.$selectableUl.prev(),
												$selectionSearch = that.$selectionUl.prev(),
												selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
												selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

										that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
												.on('keydown', function(e){
													if (e.which === 40){
														that.$selectableUl.focus();
														return false;
													}
												});

										that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
												.on('keydown', function(e){
													if (e.which == 40){
														that.$selectionUl.focus();
														return false;
													}
												});
									},
									afterSelect: function(){
										this.qs1.cache();
										this.qs2.cache();
									},
									afterDeselect: function(){
										this.qs1.cache();
										this.qs2.cache();
									}
								});
							</script>
						{/literal}
					</div>
				</div>
			{/if}
		</div>
		<div id="area-logo" class="tab-pane">
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo"> Logo website</label>
				<div class="col-sm-8">
					<div id="image-holder" class="border_doted">
                        {if $item->data.logo}
							<img src="{$item->data.logo}" border="0" />
                        {/if}
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo-check"></label>
				<div class="col-sm-6">
					<div class="checkbox">
						<label>
							<input type="checkbox" class="ace ace-checkbox-2" name="changeimage" value="1" />
							<span class="lbl"> Cập nhật logo</span>
						</label>
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo-choose"></label>
				<div class="col-sm-6">
					<div id="show_pic" style="display: none;" class="col-sm-12 ace-file-input">
						<input size="20" type="file" id="fileUpload" name="image" class="input-file-image" />
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo"> Favicon website</label>
				<div class="col-sm-8">
					<div id="image-holder-1" class="border_doted" style="width: 150px;">
                        {if $item->data.favicon}
							<img src="{$item->data.favicon}" border="0" />
                        {/if}
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo-check"></label>
				<div class="col-sm-6">
					<div class="checkbox">
						<label>
							<input type="checkbox" class="ace ace-checkbox-2" name="changeimageicon" value="1" />
							<span class="lbl"> Cập nhật favicon</span>
						</label>
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo-choose"></label>
				<div class="col-sm-6">
					<div id="show_pic_icon" style="display: none;" class="col-sm-12 ace-file-input">
						<input size="20" type="file" id="fileUpload1" name="imageicon" class="input-file-image" />
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-image-thumbnail"> Ảnh đại diện chia sẻ</label>
				<div class="col-sm-8">
					<div id="image-holder-2" class="border_doted" style="width: 250px;">
						{if $item->data.thumbnail}
							<img src="{$item->data.thumbnail}" border="0" />
						{/if}
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo-check"></label>
				<div class="col-sm-6">
					<div class="checkbox">
						<label>
							<input type="checkbox" class="ace ace-checkbox-2" name="changeimagethumbnail" value="1" />
							<span class="lbl"> Cập nhật ảnh đại diện</span>
						</label>
					</div>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-logo-choose"></label>
				<div class="col-sm-6">
					<div id="show_pic_thumbnail" style="display: none;" class="col-sm-12 ace-file-input">
						<input size="20" type="file" id="fileUpload2" name="imagethumbanil" class="input-file-image" />
					</div>
				</div>
			</div>
		</div>
		{if in_array(1, $item->data.site_access)}
			<div id="resize-image-product" class="tab-pane">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-resize-image-tiny"> Sử dụng ảnh resize sản phẩm</label>
					<div class="col-sm-4">
						<label class="inline" style="margin-right:10px;padding-top:5px;">
							<input type="checkbox" class="ace" value="1" name="use_resize_image_product"{if $item->data.use_resize_image_product} checked="checked"{/if}>
							<span class="lbl"> Có sử dụng resize ảnh sản phẩm</span>
						</label>
					</div>
				</div>
				<div class="form-group show-image-product">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-resize-image-tiny"> Ảnh mini (tiny)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_image_tiny" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_tiny}{$item->data.resize_image_tiny}{/if}" placeholder="Chiều rộng ảnh mini (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_image_tiny_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_tiny_height}{$item->data.resize_image_tiny_height}{/if}" placeholder="Chiều cao ảnh mini (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-product"></div>
				<div class="form-group show-image-product">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-resize-image-min"> Ảnh nhỏ (thumbnail)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_image_min" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_min}{$item->data.resize_image_min}{/if}" placeholder="Chiều rộng ảnh nhỏ (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_image_min_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_min_height}{$item->data.resize_image_min_height}{/if}" placeholder="Chiều cao ảnh nhỏ (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-product"></div>
				<div class="form-group show-image-product">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-image-normal"> Ảnh trung bình (normal)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_image_normal" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_normal}{$item->data.resize_image_normal}{/if}" placeholder="Chiều rộng ảnh trung bình (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_image_normal_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_normal_height}{$item->data.resize_image_normal_height}{/if}" placeholder="Chiều cao ảnh trung bình (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-product"></div>
				<div class="form-group show-image-product">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-image-large"> Ảnh lớn (large)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_image_max" class="col-xs-12" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_max}{$item->data.resize_image_max}{/if}" placeholder="Chiều rộng ảnh lớn (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_image_max_height" class="col-xs-12" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_image_max_height}{$item->data.resize_image_max_height}{/if}" placeholder="Chiều cao ảnh lớn (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-product"></div>
				<div class="show-image-product" style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
				<div class="form-group show-image-product">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-image-large"> Phiên bản mobile</label>
					<div class="col-sm-4">
						<input type="text" name="resize_mobile_image_width" class="col-xs-12" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_mobile_image_width}{$item->data.resize_mobile_image_width}{/if}" placeholder="Chiều rộng ảnh mobile (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_mobile_image_height" class="col-xs-12" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_mobile_image_height}{$item->data.resize_mobile_image_height}{/if}" placeholder="Chiều cao ảnh mobile (pixel)" />
					</div>
				</div>
			</div>
			<div id="resize-color-size-product" class="tab-pane">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-cache-site"> Màu sản phẩm </label>
					<div class="col-sm-4">
						<select name="setting_product_color" class="form-control">
							<option value="0"{if $item->data.setting_product_color == 0} selected="selected"{/if}>Không sử dụng</option>
							<option value="1"{if $item->data.setting_product_color == 1} selected="selected"{/if}>Có sử dụng</option>
						</select>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-cache-site"> Size sản phẩm </label>
					<div class="col-sm-4">
						<select name="setting_product_size" class="form-control">
							<option value="0"{if $item->data.setting_product_size == 0} selected="selected"{/if}>Không sử dụng</option>
							<option value="1"{if $item->data.setting_product_size == 1} selected="selected"{/if}>Có sử dụng</option>
						</select>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-cache-site"> Loại size </label>
					<div class="col-sm-4">
						<div class="controls">
							<label> <input name="setting_product_size_number"{if $item->data.setting_product_size_number == 1} checked="checked"{/if} type="radio" class="ace" value="1"> <span class="lbl"> Size số</span> </label>
							<label> <input name="setting_product_size_number"{if $item->data.setting_product_size_number == 0} checked="checked"{/if} type="radio" class="ace" value="0"> <span class="lbl"> Size chữ</span> </label>
						</div>
					</div>
				</div>
			</div>
			{literal}
			<script type="text/javascript">
				if ($('input[name=use_resize_image_product]').is(':checked')){
					$('.show-image-product').show();
				}else{
					$('.show-image-product').hide();
				}
				$('input[name=use_resize_image_product]').change(function(){
					if ($(this).is(':checked')){
						$('.show-image-product').show();
					}else{
						$('.show-image-product').hide();
					}
				});
			</script>
			{/literal}
		{/if}
		{if in_array(2, $item->data.site_access) || in_array(3, $item->data.site_access) || in_array(4, $item->data.site_access) || in_array(5, $item->data.site_access)}
			<div id="resize-image-news" class="tab-pane">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-resize-image-tiny"> Sử dụng ảnh resize bài viết</label>
					<div class="col-sm-4">
						<label class="inline" style="margin-right:10px;padding-top:5px;">
							<input type="checkbox" class="ace" value="1" name="use_resize_image"{if $item->data.use_resize_image} checked="checked"{/if}>
							<span class="lbl"> Có sử dụng resize ảnh bài viết</span>
						</label>
					</div>
				</div>
				<div class="form-group show-image-news">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-resize-news-image-tiny"> Ảnh mini (tiny)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_tiny" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_tiny}{$item->data.resize_news_image_tiny}{/if}" placeholder="Chiều rộng ảnh mini (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_tiny_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_tiny_height}{$item->data.resize_news_image_tiny_height}{/if}" placeholder="Chiều cao ảnh mini (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-news"></div>
				<div class="form-group show-image-news">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-news-image-thumbnail"> Ảnh nhỏ (thumbnail)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_thumbnail" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_thumbnail}{$item->data.resize_news_image_thumbnail}{/if}" placeholder="Chiều rộng ảnh nhỏ (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_thumbnail_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_thumbnail_height}{$item->data.resize_news_image_thumbnail_height}{/if}" placeholder="Chiều cao ảnh nhỏ (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-news"></div>
				<div class="form-group show-image-news">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-news-image-normal"> Ảnh trung bình (normal)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_normal" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_normal}{$item->data.resize_news_image_normal}{/if}" placeholder="Chiều rộng ảnh trung bình (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_normal_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_normal_height}{$item->data.resize_news_image_normal_height}{/if}" placeholder="Chiều cao ảnh trung bình (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-news"></div>
				<div class="form-group show-image-news">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-news-image-large"> Ảnh lớn (large)</label>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_large" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_large}{$item->data.resize_news_image_large}{/if}" placeholder="Chiều rộng ảnh lớn (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_news_image_large_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_news_image_large_height}{$item->data.resize_news_image_large_height}{/if}" placeholder="Chiều cao ảnh lớn (pixel)" />
					</div>
				</div>
				<div class="space-4 show-image-news"></div>
				<div class="show-image-news" style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
				<div class="form-group show-image-news">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-resize-image-large"> Phiên bản mobile</label>
					<div class="col-sm-4">
						<input type="text" name="resize_mobile_news_image_width" class="col-xs-12" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_mobile_news_image_width}{$item->data.resize_mobile_news_image_width}{/if}" placeholder="Chiều rộng ảnh mobile (pixel)" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="resize_mobile_news_image_height" class="col-xs-12" maxlength="4" onkeypress="return numberOnly(this, event);" value="{if $item->data.resize_mobile_news_image_height}{$item->data.resize_mobile_news_image_height}{/if}" placeholder="Chiều cao ảnh mobile (pixel)" />
					</div>
				</div>
			</div>
			{literal}
			<script type="text/javascript">
				if ($('input[name=use_resize_image]').is(':checked')){
					$('.show-image-news').show();
				}else{
					$('.show-image-news').hide();
				}
				$('input[name=use_resize_image]').change(function(){
					if ($(this).is(':checked')){
						$('.show-image-news').show();
					}else{
						$('.show-image-news').hide();
					}
				});
			</script>
			{/literal}
		{/if}
		<div id="configuration-email" class="tab-pane">
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-type"> Cấu hình kiểu email </label>
				<div class="col-sm-8">
					<input type="text" name="mail_type" class="col-xs-6" maxlength="100" value="{$item->data.mail_type}" placeholder="smtp" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-smtpport"> Cấu hình email smtp port </label>
				<div class="col-sm-8">
					<input type="text" name="mail_smtpport" class="col-xs-6" maxlength="3" onkeypress="return numberOnly(this, event);" value="{$item->data.mail_smtpport}" placeholder="25" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-smtphost"> Cấu hình email smtp host </label>
				<div class="col-sm-8">
					<input type="text" name="mail_smtphost" class="col-xs-6" maxlength="100" value="{$item->data.mail_smtphost}" placeholder="Tên smtp host" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-smtpuser"> Cấu hình email smtp user </label>
				<div class="col-sm-8">
					<input type="text" name="mail_smtpuser" class="col-xs-6" maxlength="255" value="{$item->data.mail_smtpuser}" placeholder="Tên user gửi mail" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-smtppass"> Cấu hình email smtp password </label>
				<div class="col-sm-8">
					<input type="text" name="mail_smtppass" class="col-xs-6" maxlength="255" value="{$item->data.mail_smtppass}" placeholder="Mật khẩu gửi mail" />
				</div>
			</div>
			<div style="width: 100%; height: 1px; display: block; margin-bottom:15px; border-bottom: 1px dotted #333;"></div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-smtpuser"> Tên gmail gửi thư </label>
				<div class="col-sm-8">
					<input type="text" name="gmail_smtpuser" class="col-xs-6" maxlength="255" value="{$item->data.gmail_smtpuser}" placeholder="Tên user gửi gmail" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-mail-smtppass"> Password gmail gửi thư </label>
				<div class="col-sm-8">
					<input type="text" name="gmail_smtppass" class="col-xs-6" maxlength="255" value="{$item->data.gmail_smtppass}" placeholder="Mật khẩu gửi gmail" />
				</div>
			</div>
		</div>
		{if $admin->admin_super}
			<div id="configuration-cache" class="tab-pane">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-cache-site"> Cache site </label>
					<div class="col-sm-4">
						<select name="cache_on" class="form-control">
							<option value="0"{if $item->data.cache_on == 0} selected="selected"{/if}>Không sử dụng</option>
							<option value="1"{if $item->data.cache_on == 1} selected="selected"{/if}>Có sử dụng</option>
						</select>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-cache-time"> Thời gian cache </label>
					<div class="col-sm-4">
						<select name="cache_time" class="form-control">
							<option value="60"{if $item->data.cache_time == 60} selected="selected"{/if}>1 phút</option>
							<option value="300"{if $item->data.cache_time == 300} selected="selected"{/if}>5 phút</option>
							<option value="600"{if $item->data.cache_time == 600} selected="selected"{/if}>10 phút</option>
							<option value="900"{if $item->data.cache_time == 900} selected="selected"{/if}>15 phút</option>
							<option value="1800"{if $item->data.cache_time == 1800} selected="selected"{/if}>30 phút</option>
							<option value="3600"{if $item->data.cache_time == 3600} selected="selected"{/if}>1 tiếng</option>
							<option value="43200"{if $item->data.cache_time == 43200} selected="selected"{/if}>nửa ngày</option>
							<option value="86400"{if $item->data.cache_time == 86400} selected="selected"{/if}>1 ngày</option>
						</select>
					</div>
				</div>
			</div>
		{/if}
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

		//Change Image thumbnail
		$('input[name=changeimagethumbnail]').change(function(){
			if ($(this).is(':checked')){
				$('#show_pic_thumbnail').show();
			}else{
				$('#show_pic_thumbnail').hide();
			}
		});
		$("#fileUpload2").on('change', function () {
			//Get count of selected files
			var countFiles = $(this)[0].files.length;

			var imgPath = $(this)[0].value;
			var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
			var image_holder = $("#image-holder-2");
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