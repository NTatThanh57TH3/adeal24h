{include file='admin_header.tpl'}
<link rel="stylesheet" href="../templates/admin/css/multi-select.css" />
<script type="text/javascript" src="../include/js/jquery/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="../include/js/jquery/js/jquery.quicksearch.js"></script>
{if $task == "edit"}
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="{$page}.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
			<div class="row">
				<div class="tabbable">
					<div class="row">
						<div class="col-xs-6">
							{include file = 'admin_setting_content.tpl'}
						</div>
						<div class="col-xs-6">
							{include file = 'admin_setting_config.tpl'}
						</div>
					</div>
				</div>
			</div>
   			<input type="hidden" name="task" value="save" />
		</form>
	</div>
</div>
{/if}
{include file='admin_footer.tpl'}