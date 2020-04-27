{include file='admin_header.tpl'}
{if $errorTxt}
	<fieldset class="adminform">
		<legend>
		{if $errFlag} Xảy ra lỗi sau {else} Thông báo{/if}</legend>
		<table class="admintable" width="100%">
			<tr>
				<td><font color="Red">{$errorTxt}</font></td>
			</tr>
		</table>
	</fieldset>
{/if}
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
			<div class="row">
				<div class="tabbable">
					<div class="row">
						<div class="col-xs-5">
							<div class="widget-box">
								<div class="widget-header">
									<h4>Sửa thông tin cá nhân</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner">
										<div class="widget-main">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-fullname"> Họ và tên </label>
												<div class="col-sm-9">
													<input type="text" name="admin_name" id="admin_name" value="{$users.admin_name|escape:'html'}" placeholder="Họ và tên" class="form-control required">
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-nickname"> Bút danh </label>
												<div class="col-sm-9">
													<input type="text" name="admin_nickname" id="admin_nickname" value="{$users.admin_nickname|escape:'html'}" placeholder="Bút danh" class="col-xs-12">
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-fullname"> Avatar </label>
												<div class="col-sm-9 avatar_home_user">
													{*<div class="image_preview_camera"><i class="icon-camera"></i></div>*}
													<div id="image-holder" class="box-item-image border_doted">
														<img class="my_avatar" src="{$users.avatar}" width="150" height="150" style="cursor: pointer;"/>
													</div>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-tick-avatar">&nbsp;</label>
												<div class="col-sm-4">
													<input size="15" type="file" id="fileUpload" name="image" class="input-file-image" />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-email"> Địa chỉ Email</label>
												<div class="col-sm-9">
													<input type="text" name="admin_email" id="admin_email" value="{$users.admin_email|escape:'html'}" class="form-control required" placeholder="Địa chỉ email">
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-username"> Tên đăng nhập</label>
												<div class="col-sm-9">
													{$users.admin_username|escape:'html'}
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-username"> Nhóm</label>
												<div class="col-sm-9">
													{$users.admin_group|escape:'html'}
												</div>
											</div>
											{if $users.admin_group > 1}
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-username"> Quyền hạn</label>
												<div class="col-sm-9">
													{$users.admin_access}
												</div>
											</div>
											{/if}
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-username"> Ngày đăng ký</label>
												<div class="col-sm-9">
													{$users.admin_registerDate}
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-username"> Lần truy cập cuối</label>
												<div class="col-sm-9">
													{$users.admin_lastvisitDate}
												</div>
											</div>
											<input type="hidden" name="admin_group" value="{$users.admin_group}">
											<input type="hidden" name="admin_username" value="{$users.admin_username}">
											<input type="hidden" name="admin_registerDate" value="{$users.admin_registerDate}">
											<input type="hidden" name="admin_lastvisitDate" value="{$users.admin_lastvisitDate}">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<div class="widget-box">
								<div class="widget-header">
									<h4>Thay đổi mật khẩu</h4>
								</div>
								<div class="widget-body">
									<div class="widget-body-inner" style="display: block;">
										<div class="widget-main">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-password"> Nhập mật khẩu cũ</label>
												<div class="col-sm-9">
													<input type="password" name="admin_password_old" id="admin_password_old" value="{$users.admin_password_old}" class="form-control required">
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-password"> Nhập mật khẩu mới</label>
												<div class="col-sm-9">
													<input type="password" name="admin_password_new" id="admin_password_new" value="{$users.admin_password_new}" class="form-control required">
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="form-field-password"> Nhập lại mật khẩu mới</label>
												<div class="col-sm-9">
													<input type="password" name="admin_password_conf" id="admin_password_conf" value="{$users.admin_password_conf}" class="form-control required">
												</div>
											</div>
											<div class="space-4"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		   	<input type="hidden" value="{$task}" name="task">
			<input type="hidden" value="{$adminId}" name="adminId" id="adminId">
		</form>
	</div>
</div>



{include file='admin_footer.tpl'}