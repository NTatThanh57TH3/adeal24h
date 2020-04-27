<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTabSettingSiteContent">
		<li class="active">
			<a data-toggle="tab" href="#website" aria-expanded="true">Cài đặt Site</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#support" aria-expanded="false">Hỗ trợ trực tuyến</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#social" aria-expanded="false">Mạng xã hội</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#systemSite" aria-expanded="false">Hệ thống Site</a>
		</li>
		{if $admin->admin_super}
			<li class="">
				<a data-toggle="tab" href="#user-seo" aria-expanded="false">User SEO</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#ads" aria-expanded="false">Mã tiếp thị QC</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#install_module" aria-expanded="false">Cài đặt modules</a>
			</li>
		{/if}
	</ul>
	<div class="tab-content">
		<div id="website" class="tab-pane active">
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-site-id"> Chọn Site cấu hình </label>
				<div class="col-sm-8">
					<select name="site_id" class="form-control">
						<option value="0"{if $item->data.site_id == 0} selected="selected"{/if}>-- Lựa chọn site --</option>
						{foreach from=$sites key=s item=site}
							<option value="{$s}"{if $s == $item->data.site_id} selected="selected"{/if}>{$site}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-title-website"> Đặt tiêu đề cho website </label>
				<div class="col-sm-8">
					<input type="text" name="setting_title_web" class="col-xs-12" maxlength="100" value="{$item->data.setting_title_web}" placeholder="Đặt tiêu đề cho website" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-title-website"> Cấu hình hiển thị tiêu đề </label>
				<div class="col-sm-8">
					<label class="inline" style="margin-right:10px;">
						<input type="checkbox" class="ace" value="1"{if $item->data.setting_show_domain_replace_title == 1} checked="checked"{/if} name="setting_show_domain_replace_title" />
						<span class="lbl"> Domain hiển thị thay thế tiêu đề</span>
					</label>
					<label class="inline">
						<input type="checkbox" class="ace" value="1"{if $item->data.setting_title_first == 1} checked="checked"{/if} name="setting_title_first" />
						<span class="lbl"> Tiêu đề bài viết hiển thị trước</span>
					</label>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-slogan"> Câu slogan của bạn </label>
				<div class="col-sm-8">
					<input type="text" name="slogan" class="col-xs-12" maxlength="100" value="{$item->data.slogan}" placeholder="Câu slogan của bạn" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-metatitle-web"> Metatitle trang chủ </label>
				<div class="col-sm-8">
					<input type="text" name="setting_metatitle_web" class="col-xs-12" maxlength="100" value="{$item->data.setting_metatitle_web}" placeholder="Đặt meta title cho trang chủ" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-keyword-website"> Đặt từ khóa tìm kiếm </label>
				<div class="col-sm-8">
					<textarea name="setting_keyword_web" rows="5" cols="20" maxlength="500" class="form-control">{$item->data.setting_keyword_web}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-description-website"> Mô tả tìm kiếm </label>
				<div class="col-sm-8">
					<textarea name="setting_description_web" rows="5" cols="20" maxlength="500" class="form-control">{$item->data.setting_description_web}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-domain-exclude"> Tên miền được phép dofollow </label>
				<div class="col-sm-8">
					<textarea name="setting_domain_exclude" rows="5" cols="20" maxlength="500" class="form-control" placeholder="Liệt kê tên domain ngăn cách nhau bởi dấu ,">{$item->data.setting_domain_exclude}</textarea>
				</div>
			</div>
			{if $admin->admin_super}
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-commons"> Các commons sử dụng </label>
					<div class="col-sm-8">
						<textarea name="setting_commons" rows="5" cols="20" maxlength="500" class="form-control" placeholder="Liệt kê tên common ngăn cách nhau bởi dấu ,">{$item->data.setting_commons}</textarea>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-redirect"> Trang chuyển hướng </label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="setting_url_redirect" placeholder="Địa chỉ trang chuyển hướng thay thế" value="{$item->data.setting_url_redirect}" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-url-replace"> Url trang đích </label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="setting_url_replace" placeholder="Địa chỉ url trang đích thay thế" value="{$item->data.setting_url_replace}" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-robot-index"> Robots Index </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="radio" class="ace" value="1"{if $item->data.setting_robot_index == 1} checked="checked"{/if} name="setting_robot_index" />
							<span class="lbl"> Mở Index</span>
						</label>
						<label class="inline" style="margin-right:10px;">
							<input type="radio" class="ace" value="0"{if $item->data.setting_robot_index == 0} checked="checked"{/if} name="setting_robot_index" />
							<span class="lbl"> Khóa Index</span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-save-log"> Bật chế độ lưu log </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_save_log == 1} checked="checked"{/if} name="setting_save_log" />
							<span class="lbl"> Cho phép ghi thay đổi</span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-page-user"> Trang thành viên(user) </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_page_user == 1} checked="checked"{/if} name="setting_page_user" />
							<span class="lbl"> Bật chế độ sử dụng <b>(Popup đăng ký / Đăng nhập)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-page-logo"> Đặt logo cho hình ảnh </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_show_logo_to_image == 1} checked="checked"{/if} name="setting_show_logo_to_image" />
							<span class="lbl"> Cho phép <b style="color: green">logo hiển thị</b> trong ảnh bài viết</span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-dmca-autosubmit"> Sử dụng DMCA - Auto submit </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_auto_submit_dmca == 1} checked="checked"{/if} name="setting_auto_submit_dmca" />
							<span class="lbl"> DMCA - Auto Submit <b style="color:#ff6a16;">(130,000 VNĐ/Tháng)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-seo-url-compact"> <b><i>SEO Url Compact</i></b> </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_url_compact_seo == 1} checked="checked"{/if} name="setting_url_compact_seo" />
							<span class="lbl"> SEO - Rút gọn Url <b style="color:#ff6a16;">(150,000 VNĐ/Tháng)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-seo-autosubmit"> Auto submit SEO </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_auto_submit_seo == 1} checked="checked"{/if} name="setting_auto_submit_seo" />
							<span class="lbl"> SEO - Auto Submit <b style="color:#ff6a16;">(220,000 VNĐ/Tháng)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-seo-keyword"> Tự động sinh từ khóa meta(nếu rỗng) </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_auto_keyword_born == 1} checked="checked"{/if} name="setting_auto_keyword_born" />
							<span class="lbl"> SEO - Tự động sinh từ khóa <b style="color:#ff6a16;">(500,000 VNĐ/Tháng)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-mobile-amp"> Sử dụng AMP cho mobile </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_mobile_amp == 1} checked="checked"{/if} name="setting_mobile_amp" />
							<span class="lbl"> Integrated Mobile AMP <b style="color:#ff6a16;">(1,500,000 VNĐ/Năm)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-facebook-instant-article"> Facebook Instant Article </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_facebook_instant_article == 1} checked="checked"{/if} name="setting_facebook_instant_article" />
							<span class="lbl"> Instant Article <b style="color:#ff6a16;">(3,500,000 VNĐ/Năm)</b></span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-sitemap-saveDB"> <b><i>Lưu sitemap vào DB</i></b> </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_sitemap_saveDB == 1} checked="checked"{/if} name="setting_sitemap_saveDB" />
							<span class="lbl"> Bật sử dụng chức năng lưu</span>
						</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-sitemap-big"> <b><i>Hệ thống sitemap phân chia</i></b> </label>
					<div class="col-sm-8">
						<label class="inline" style="margin-right:10px;">
							<input type="checkbox" class="ace" value="1"{if $item->data.setting_sitemap_share == 1} checked="checked"{/if} name="setting_sitemap_share" />
							<span class="lbl"> Bật sử dụng <b style="color:#ff6a16;">(2,800,000 VNĐ/Năm)</b></span>
						</label>
					</div>
				</div>
			{/if}
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-sitemap-update"> Thời gian cập nhật sitemap </label>
				<div class="col-sm-8">
					<span class="date" style="display:block;color:#00ce00;font-size:13px;padding-top:4px;">{if $item->data.setting_sitemap_update && $item->data.setting_sitemap_update != '0000-00-00 00:00:00'}{$item->data.setting_sitemap_update|date_format:"%d/%m/%Y %H:%M:%S"}{else}Chưa cập nhật{/if}</span>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-setting-on"> Sử dụng mẫu chữ ký </label>
				<div class="col-sm-8">
					<label>
						<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_signature_on"{if $item->data.setting_signature_on == 1} checked="checked"{/if} value="1">
						<span class="lbl"></span>
					</label>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<div class="col-sm-12">
					<textarea name="setting_signature_text" rows="5" cols="20" id="fulltext" class="form-control">{$item->data.setting_signature_text}</textarea>
				</div>
			</div>
		</div>
		<div id="support" class="tab-pane">
			<fieldset>
				<legend><h5>Thông tin Cán bộ hỗ trợ</h5></legend>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-name"> Cán bộ hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_name" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_name}" placeholder="Tên người hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-skype"> Nick skype hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_skype" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_skype}" placeholder="Nhập skype hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-yahoo"> Nick yahoo hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_yahoo" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_yahoo}" placeholder="Nhập yahoo hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Điện thoại hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_phone" class="col-xs-12" maxlength="15" onkeypress="return numberOnly(this, event);" value="{$item->data.setting_support_phone}" placeholder="Số điện thoại hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Email hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_email" class="col-xs-12" maxlength="50" value="{$item->data.setting_support_email}" placeholder="Địa chỉ email hỗ trợ" />
					</div>
				</div>
			</fieldset>
			<div class="space-4"></div>
			<fieldset>
				<legend><h5>Thông tin Cán bộ hỗ trợ</h5></legend>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-name"> Cán bộ hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_name2" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_name2}" placeholder="Cán bộ hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-skype"> Nick skype hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_skype2" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_skype2}" placeholder="Nhập skype hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-yahoo"> Nick yahoo hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_yahoo2" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_yahoo2}" placeholder="Nhập yahoo hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Điện thoại hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_phone2" class="col-xs-12" maxlength="15" onkeypress="return numberOnly(this, event);" value="{$item->data.setting_support_phone2}" placeholder="Số điện thoại hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Email hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_email2" class="col-xs-12" maxlength="50" value="{$item->data.setting_support_email2}" placeholder="Địa chỉ email hỗ trợ" />
					</div>
				</div>
			</fieldset>
			<div class="space-4"></div>
			<fieldset>
				<legend><h5>Thông tin Cán bộ hỗ trợ</h5></legend>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-name"> Cán bộ hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_name3" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_name3}" placeholder="Cán bộ hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-skype"> Nick skype hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_skype3" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_skype3}" placeholder="Nhập skype hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-yahoo"> Nick yahoo hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_yahoo3" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_yahoo3}" placeholder="Nhập yahoo hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Điện thoại hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_phone3" class="col-xs-12" maxlength="15" onkeypress="return numberOnly(this, event);" value="{$item->data.setting_support_phone3}" placeholder="Số điện thoại hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Email hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_email3" class="col-xs-12" maxlength="50" value="{$item->data.setting_support_email3}" placeholder="Địa chỉ email hỗ trợ" />
					</div>
				</div>
			</fieldset>
			<div class="space-4"></div>
			<fieldset>
				<legend><h5>Thông tin Cán bộ hỗ trợ</h5></legend>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-name"> Cán bộ hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_name4" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_name4}" placeholder="Cán bộ hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-skype"> Nick skype hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_skype4" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_skype4}" placeholder="Nhập skype hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-yahoo"> Nick yahoo hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_yahoo4" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_yahoo4}" placeholder="Nhập yahoo hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Điện thoại hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_phone4" class="col-xs-12" maxlength="15" onkeypress="return numberOnly(this, event);" value="{$item->data.setting_support_phone4}" placeholder="Số điện thoại hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Email hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_email4" class="col-xs-12" maxlength="50" value="{$item->data.setting_support_email4}" placeholder="Địa chỉ email hỗ trợ" />
					</div>
				</div>
			</fieldset>
			<div class="space-4"></div>
			<fieldset>
				<legend><h5>Thông tin Cán bộ hỗ trợ</h5></legend>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-name"> Cán bộ hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_name5" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_name5}" placeholder="Cán bộ hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-skype"> Nick skype hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_skype5" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_skype5}" placeholder="Nhập skype hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-yahoo"> Nick yahoo hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_yahoo5" class="col-xs-12" maxlength="100" value="{$item->data.setting_support_yahoo5}" placeholder="Nhập yahoo hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Điện thoại hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_phone5" class="col-xs-12" maxlength="15" onkeypress="return numberOnly(this, event);" value="{$item->data.setting_support_phone5}" placeholder="Số điện thoại hỗ trợ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-support-phone"> Email hỗ trợ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_support_email5" class="col-xs-12" maxlength="50" value="{$item->data.setting_support_email5}" placeholder="Địa chỉ email hỗ trợ" />
					</div>
				</div>
			</fieldset>
		</div>
		<div id="social" class="tab-pane">
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-analytics"> Google Analytics ID </label>
				<div class="col-sm-8">
					<input type="text" name="setting_ga_id" class="col-xs-12" maxlength="100" value="{$item->data.setting_ga_id}" placeholder="ID Google Analytics" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-analytics-profile-id"> Google Analytics Profile ID </label>
				<div class="col-sm-8">
					<input type="text" name="setting_ga_profile_id" class="col-xs-12" maxlength="100" value="{$item->data.setting_ga_profile_id}" placeholder="Profile ID Google Analytics" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-site-verification"> Google Site Verification </label>
				<div class="col-sm-8">
					<input type="text" name="setting_google_site_verification" class="col-xs-12" maxlength="255" value="{$item->data.setting_google_site_verification}" placeholder="google-site-verification" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-dmca-site-verification"> DMCA Site Verification </label>
				<div class="col-sm-8">
					<input type="text" name="setting_dmca_site_verification" class="col-xs-12" maxlength="255" value="{$item->data.setting_dmca_site_verification}" placeholder="dmca-site-verification" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-analytics"> Google Tag Manager </label>
				<div class="col-sm-8">
					<input type="text" name="setting_google_tag_manager" class="col-xs-12" maxlength="100" value="{$item->data.setting_google_tag_manager}" placeholder="ID Google Tag Manager" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-search-cse"> Google Search CSE </label>
				<div class="col-sm-8">
					<input type="text" name="setting_google_search_cse" class="col-xs-12" maxlength="100" value="{$item->data.setting_google_search_cse}" placeholder="ID Google Search Cse" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-application-key-api"> Google Application API KEY </label>
				<div class="col-sm-8">
					<input type="text" name="setting_google_key_api" class="col-xs-12" maxlength="255" value="{$item->data.setting_google_key_api}" placeholder="Google Application API KEY" />
					<br/><a target="_blank" href="https://developers.google.com/custom-search/v1/introduction#identify_your_application_to_google_with_api_key">GET KEY API</a>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-map-api"> Google Map API </label>
				<div class="col-sm-8">
					<input type="text" name="setting_map_api" class="col-xs-12" maxlength="255" value="{$item->data.setting_map_api}" placeholder="Google Map API" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google-map-api"> Google Map Location </label>
				<div class="col-sm-4">
					<input type="text" name="setting_map_lat" class="col-xs-12" maxlength="255" value="{$item->data.setting_map_lat}" placeholder="Google Map Location Lat" />
				</div>
				<div class="col-sm-4">
					<input type="text" name="setting_map_long" class="col-xs-12" maxlength="255" value="{$item->data.setting_map_long}" placeholder="Google Map Location Long" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-Yandex-Metrica-ID"> Yandex Metrica ID </label>
				<div class="col-sm-8">
					<input type="text" name="setting_yandex_metrica_id" class="col-xs-12" maxlength="100" value="{$item->data.setting_yandex_metrica_id}" placeholder="ID Yandex Metrica" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting_show_facebook"> Hệ thống showrom cơ bản / Đa quốc gia </label>
				<div class="col-sm-4">
					<label>
						<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_showroom_partner_basic"{if $item->data.setting_showroom_partner_basic == 1} checked="checked"{/if} value="1">
						<span class="lbl">&nbsp;Showroom cơ bản</span>
					</label>
				</div>
				<div class="col-sm-4">
					<label>
						<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_multi_country"{if $item->data.setting_multi_country == 1} checked="checked"{/if} value="1">
						<span class="lbl">&nbsp;Đa quốc gia</span>
					</label>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting_show_facebook_zalo"> Bật/Tắt ứng dụng facebook/zalo </label>
				<div class="col-sm-4">
					<select name="setting_show_facebook" class="form-control">
						<option value="0"{if $item->data.setting_show_facebook == 0} selected="selected"{/if}>Tắt ứng dụng facebook</option>
						<option value="1"{if $item->data.setting_show_facebook == 1} selected="selected"{/if}>Bật ứng dụng facebook</option>
					</select>
				</div>
				<div class="col-sm-4">
					<select name="setting_show_zalo" class="form-control">
						<option value="0"{if $item->data.setting_show_zalo == 0} selected="selected"{/if}>Tắt ứng dụng zalo</option>
						<option value="1"{if $item->data.setting_show_zalo == 1} selected="selected"{/if}>Bật ứng dụng zalo</option>
					</select>
				</div>
			</div>
			{if $item->data.setting_facebook_instant_article == 1}
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-face-instant-article-page"> Facebook Instant Article PIN </label>
					<div class="col-sm-4">
						<input type="text" name="setting_facebook_pages" class="col-xs-12" maxlength="100" value="{$item->data.setting_facebook_pages}" placeholder="Facebook Page Instant" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="setting_facebook_placement" class="col-xs-12" maxlength="100" value="{$item->data.setting_facebook_placement}" placeholder="Facebook Placement Instant" />
					</div>
				</div>
			{/if}
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-face-zalo-app-id"> AppID facebook/ZaloID </label>
				<div class="col-sm-4">
					<input type="text" name="setting_face_app_id" class="col-xs-12" maxlength="100" value="{$item->data.setting_face_app_id}" placeholder="Số AppID của facebook" />
				</div>
				<div class="col-sm-4">
					<input type="text" name="setting_zalo_id" class="col-xs-12" maxlength="100" value="{$item->data.setting_zalo_id}" placeholder="Số AppID của Zalo" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-facebook"> Mạng xã hội facebook </label>
				<div class="col-sm-8">
					<input type="text" name="setting_facebook" class="col-xs-12" maxlength="255" value="{$item->data.setting_facebook}" placeholder="Đường dẫn mạng xã hội facebook" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-face-likebox-width"> Like Box</label>
				<div class="col-sm-4">
					<input type="text" name="facebook_likebox_width" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.facebook_likebox_width}{$item->data.facebook_likebox_width}{/if}" placeholder="Chiều rộng likebox" />
				</div>
				<div class="col-sm-4">
					<input type="text" name="facebook_likebox_height" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.facebook_likebox_height}{$item->data.facebook_likebox_height}{/if}" placeholder="Chiều cao likebox" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-face-face-comment-width"> Comments Box</label>
				<div class="col-sm-4">
					<input type="text" name="facebook_comment_width" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.facebook_comment_width}{$item->data.facebook_comment_width}{/if}" placeholder="Chiều rộng comments" />
				</div>
				<div class="col-sm-4">
					<input type="text" name="facebook_comment_numberrow" class="col-xs-12" maxlength="3" onkeypress="return numberOnly(this, event);" value="{if $item->data.facebook_comment_numberrow}{$item->data.facebook_comment_numberrow}{/if}" placeholder="Số dòng comments" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-face-plugin-chat"> Facebook Chat PageId</label>
				<div class="col-sm-4">
					<input type="text" name="facebook_chat_page_id" class="col-xs-12" maxlength="50" onkeypress="return numberOnly(this, event);" value="{$item->data.facebook_chat_page_id}" placeholder="Số ID page face" />
				</div>
				<div class="col-sm-4">
					<input type="text" name="facebook_chat_color" class="col-xs-12" maxlength="50" value="{$item->data.facebook_chat_color}" placeholder="Mã màu plugin chat" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-face-plugin-chat-message"> Facebook Chat Message</label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="5" name="facebook_chat_message" placeholder="Nội dung lời chào">{$item->data.facebook_chat_message}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-twitter"> Mạng xã hội twitter </label>
				<div class="col-sm-8">
					<input type="text" name="setting_twitter" class="col-xs-12" maxlength="255" value="{$item->data.setting_twitter}" placeholder="Đường dẫn mạng xã hội twitter" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-youtube"> Mạng xã hội youtube </label>
				<div class="col-sm-8">
					<input type="text" name="setting_youtube" class="col-xs-12 maxlength="255" value="{$item->data.setting_youtube}" placeholder="Đường dẫn mạng xã hội youtube" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-google+"> Mạng xã hội google+ </label>
				<div class="col-sm-8">
					<input type="text" name="setting_google_plus" class="col-xs-12" maxlength="255" value="{$item->data.setting_google_plus}" placeholder="Đường dẫn mạng xã hội google+" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-linkedin"> Mạng xã hội linkedin </label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="7" name="setting_url_social" placeholder="Các trang mạng xã hội khác ngăn cách nhau bởi dấu ','">{$item->data.setting_url_social}</textarea>
				</div>
			</div>
		</div>
		<div id="systemSite" class="tab-pane">
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-email"> Email hệ thống(nhận đơn hàng) </label>
				<div class="col-sm-8">
					<input type="text" name="setting_email" class="col-xs-12" maxlength="50"{if !$admin->admin_super && ($admin->admin_info.admin_group > 2)} disabled{/if} value="{$item->data.setting_email}" placeholder="Nhập email quản lý" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-domain"> Tên domain </label>
				<div class="col-sm-8">
					<input type="text" name="setting_domain" class="col-xs-12" maxlength="100"{if !$admin->admin_super && ($admin->admin_info.admin_group > 2)} disabled{/if} value="{$item->data.setting_domain}" placeholder="Nhập tên domain" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-author"> Tên người sáng tạo </label>
				<div class="col-sm-8">
					<input type="text" name="setting_author" class="col-xs-12" maxlength="255"{if !$admin->admin_super && ($admin->admin_info.admin_group > 2)} disabled{/if} value="{$item->data.setting_author}" placeholder="Nhập tên người sáng tạo" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-company"> Tên công ty </label>
				<div class="col-sm-8">
					<input type="text" name="setting_company" class="col-xs-12" maxlength="255" value="{$item->data.setting_company}" placeholder="Nhập tên công ty" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-hotline"> Số hotline </label>
				<div class="col-sm-8">
					<input type="text" name="setting_hotline" class="col-xs-12" maxlength="30"{if !$admin->admin_super && ($admin->admin_info.admin_group > 2)} disabled{/if} onkeypress="return numberOnly(this, event);" value="{$item->data.setting_hotline}" placeholder="Số điện thoại hotline" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-company-address"> Địa chỉ công ty </label>
				<div class="col-sm-8">
					<input type="text" name="setting_company_address" class="col-xs-12" maxlength="255" value="{$item->data.setting_company_address}" placeholder="Nhập địa chỉ công ty" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-location-lat-long"> Thông tin vùng/miền </label>
				<div class="col-sm-2">
					<input type="text" name="setting_company_address_locality" class="col-xs-12" maxlength="100" value="{$item->data.setting_company_address_locality}" placeholder="Tên quận/huyện" />
				</div>
				<div class="col-sm-2">
					<input type="text" name="setting_company_address_region" class="col-xs-12" maxlength="100" value="{$item->data.setting_company_address_region}" placeholder="Tên tỉnh/TP" />
				</div>
				<div class="col-sm-2">
					<input type="text" name="setting_company_address_country" class="col-xs-12" maxlength="100" value="{$item->data.setting_company_address_country}" placeholder="Tên quốc gia" />
				</div>
				<div class="col-sm-2">
					<input type="text" name="setting_company_address_postalCode" class="col-xs-12" maxlength="100" onkeypress="return numberOnly(this, event);" value="{$item->data.setting_company_address_postalCode}" placeholder="Mã postalCode" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-company-desc"> Tóm tắt công ty </label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="5" name="setting_company_description" placeholder="Tóm tắt sơ lược công ty">{$item->data.setting_company_description}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-googlemap"> Link google Map </label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="5" name="setting_company_googlemap" placeholder="Địa chỉ url google map">{$item->data.setting_company_googlemap}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-crm-mobile"> Mobile CRM </label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="5" name="setting_mobile_crm" placeholder="Mã Mobile CRM">{$item->data.setting_mobile_crm}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-location-lat-long"> Vị trí lat/long </label>
				<div class="col-sm-4">
					<input type="text" name="setting_company_latitude" class="col-xs-12" maxlength="100" value="{$item->data.setting_company_latitude}" placeholder="Vị trí location lat" />
				</div>
				<div class="col-sm-4">
					<input type="text" name="setting_company_longitude" class="col-xs-12" maxlength="100" value="{$item->data.setting_company_longitude}" placeholder="Vị trí location long" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-url-template"> Địa chỉ url template </label>
				<div class="col-sm-8">
					<input type="text" name="setting_company_urlTempalte" class="col-xs-12" maxlength="255" value="{$item->data.setting_company_urlTempalte}" placeholder="Địa chỉ website giới thiệu" />
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting_update_newdate"> Cập nhật mới <b>ngày chỉnh sửa</b> với <b>ngày xuất bản</b> </label>
				<div class="col-sm-8">
					<label>
						<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_update_newdate"{if $item->data.setting_update_newdate == 1} checked="checked"{/if} value="1">
						<span class="lbl"></span>
					</label>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting_schema"> <b>Dữ liệu cấu trúc</b> </label>
				<div class="col-sm-3">
					<label>
						<input type="radio" class="ace ace-switch ace-switch-4" name="setting_data_schema"{if $item->data.setting_data_schema == 1} checked="checked"{/if} value="1">
						<span class="lbl">&nbsp;Cấu trúc chuẩn</span>
					</label>
				</div>
				<div class="col-sm-2">
					<label>
						<input type="radio" class="ace ace-switch ace-switch-4" name="setting_data_schema"{if $item->data.setting_data_schema == 2} checked="checked"{/if} value="2">
						<span class="lbl">&nbsp;Cấu mở rộng</span>
					</label>
				</div>
				<div class="col-sm-3">
					<label>
						<input type="radio" class="ace ace-switch ace-switch-4" name="setting_data_schema"{if $item->data.setting_data_schema == 3} checked="checked"{/if} value="3">
						<span class="lbl">&nbsp;Cấu trúc tùy chỉnh</span>
					</label>
				</div>
			</div>
			<div class="space-4"></div>
			<div id="data_schema" class="form-group">
				<div class="col-sm-12">
					<textarea class="form-control" rows="10" name="setting_schema_customize"{if !$admin->admin_super} readonly{/if} placeholder="Mã Schema tùy chỉnh">{$item->data.setting_schema_customize}</textarea>
				</div>
			</div>
			<div class="space-4"></div>
			<div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="form-field-setting_admin_edit_fast"> Admin chỉnh sửa nhanh </label>
				<div class="col-sm-8">
					<label>
						<input type="checkbox" class="ace ace-switch ace-switch-4" name="setting_admin_edit_fast"{if $item->data.setting_admin_edit_fast == 1} checked="checked"{/if} value="1">
						<span class="lbl"></span>
					</label>
				</div>
			</div>
		</div>
		{if $admin->admin_super}
			<div id="ads" class="tab-pane">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-facebook-code"> Facebook Pixel Code </label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="10" name="setting_ads_facebook_code" placeholder="Mã code Facebook Pixel Code">{$item->data.setting_ads_facebook_code}</textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-google-code"> Google Code </label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="10" name="setting_ads_google_code" placeholder="Mã code Google Code">{$item->data.setting_ads_google_code}</textarea>
					</div>
				</div>
			</div>
			<div id="user-seo" class="tab-pane">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-setting-user-name-seo"> Người SEO </label>
					<div class="col-sm-8">
						<input type="text" name="setting_seo_name" class="col-xs-12" maxlength="50" value="{$item->data.setting_seo_name}" placeholder="Tên người seo" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-seo-job-title"> Chức vụ </label>
					<div class="col-sm-8">
						<input type="text" name="setting_seo_job_title" class="col-xs-12" maxlength="100" value="{$item->data.setting_seo_job_title}" placeholder="Chức vụ" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-seo-url-avatar"> Url avatar người seo </label>
					<div class="col-sm-8">
						<input type="text" name="setting_seo_avatar" class="col-xs-12" value="{$item->data.setting_seo_avatar}" placeholder="Url avatar người seo" />
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-seo-url-scoop"> Các link giới thiệu </label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="5" name="setting_seo_url_sameas" placeholder="Các url về user seo ngăn cách nhau bởi dấu ','">{$item->data.setting_seo_url_sameas}</textarea>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-seo-url-scoop"> Từng học các trường </label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="5" name="setting_seo_alumni_of" placeholder="Tên các trường từng học ngăn cách nhau bởi dấu ','">{$item->data.setting_seo_alumni_of}</textarea>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-location-user-seo-address"> Địa chỉ người SEO </label>
					<div class="col-sm-4">
						<input type="text" name="setting_seo_address_locality" class="col-xs-12" maxlength="255" value="{$item->data.setting_seo_address_locality}" placeholder="Địa chỉ địa phương" />
					</div>
					<div class="col-sm-4">
						<input type="text" name="setting_seo_address_region" class="col-xs-12" maxlength="100" value="{$item->data.setting_seo_address_region}" placeholder="Khu vực" />
					</div>
				</div>
			</div>
		{/if}
		<div id="install_module" class="tab-pane">
		{if $list_modules}
			<ol class="dd-list">
			{foreach from=$list_modules key=k item=module}
				{if $module.exist == 1}
					<li class="dd-item" data-id="{$module.module_id}">
						<div class="dd-handle">
							<span onmouseover="showtip('{$module.module_description}', '300', '#4FC11E');" onmouseout="hidetip();" style="cursor:pointer;">{$module.module_title}</span>
							<div class="pull-right action-buttons">
								{if $module.site_id == $site_id || $module.active == 1}
									<a class="green" href="#">
										<i title="Đã cài đặt" class="ace-icon icon icon-check bigger-130"></i>
									</a>
									<a class="red" href="#">
										<i title="Gỡ cài đặt" data-id="module-uninstall" class="ace-icon icon icon-trash bigger-130"></i>
									</a>
								{else}
									<a class="red" href="#">
										<i title="Chưa cài đặt" class="ace-icon icon icon-ban-circle bigger-130"></i>
									</a>
									<a class="blue" href="#">
										<i title="Cài đặt" data-id="module-install" class="ace-icon icon icon-cog bigger-130"></i>
									</a>
								{/if}
							</div>
						</div>
					</li>
				{/if}
			{/foreach}
			</ol>
			{literal}
			<script type="text/javascript">
				function check_radio_data_schema(){
					var value = 1;
					$('input[name="setting_data_schema"]').each(function(){
						if ($(this).is(":checked")) {
							value = $(this).val();
						}
					});
					if ( value == 3 ){
						$('#data_schema').show();
					}else{
						$('#data_schema').hide();
					}
				}
				$(document).ready(function(){
					check_radio_data_schema();
					$('input[name="setting_data_schema"]').change(function(){
						check_radio_data_schema();
					});
					$('#install_module .icon-trash, #install_module .icon-cog').click(function(){
						var task = $(this).attr('data-id');
						var site_id = $('select[name=site_id]').val();
						var module_id = $(this).closest('.dd-item').attr('data-id');
						var data = {task: task, site_id: site_id, module_id: module_id};

						if ( task == 'module-uninstall' ){
							$(this).closest('.dd-item').remove();
						}

						// Call ajax process
						$.ajax({
							type: "POST",
							url: "admin_ajax_tasks.php",
							data: data,
							dataType: "json",
							success: function(data) {
								$('#install_module').prepend(data.html);
								setTimeout(function() {
									$('#alert-message').fadeOut("slow", function() { $(this).remove(); } );
									window.location.reload(1);
								}, 2000); // 2 seconds
							}
						});
					});
				});
			</script>
			{/literal}
		{else}
			<p align="center"><b style="color:green;">Không tồn tại cấu hình module dịch vụ nào sử dụng cho website này!</b></p>
		{/if}
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function () {
    $('select[name=site_id]').change(function(){
        var siteId = $(this).val();
        var url = "";
        if ( siteId > 0 ){
        	window.location = "admin_setting.php?task=edit&site_id=" + siteId;
        }
    });
});
</script>
{/literal}