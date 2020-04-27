	<div class="footer">
		<div class="content-main">
			<div class="box-info-footer big">
				<div class="box-info-company">
					<div class="title">{$setting.setting_company}</div>
					<div class="content">
						{include file = 'components/customs/custom.tpl' position = "bottom-left"}
					</div>
				</div>
			</div>
			<div class="box-info-footer small">
				<div class="box-info-social align-center">
					<div class="title align-center">Liên kết mạng xã hội</div>
					<div class="clearfix"></div>
					<ul class="align-center">
						<li><a target="_blank" href="{$setting.setting_facebook}"><p class="fa fa-facebook"></p></a></li>
						<li><a target="_blank" href="{$setting.setting_google_plus}"><p class="fa fa-google-plus"></p></a></li>
						<li><a target="_blank" href="{$setting.setting_youtube}"><p class="fa fa-youtube-play"></p></a></li>
						<li><a target="_blank" href="{$setting.setting_twitter}"><p class="fa fa-twitter"></p></a></li>
						<li><a target="_blank" href="{$setting.setting_url_social}"><p class="fa fa-instagram"></p></a></li>
					</ul>
					<div style="display: block; text-align: center;">
						{include file = 'integrated/dmca.tpl'}
					</div>
				</div>
			</div>
			<div class="box-info-footer big">
				<div class="box-info-cate">
					<div class="title">Liên kết nhanh</div>
					<div class="clearfix"></div>
					{include file = 'components/menus/menu.tpl' type = "bottom"}
				</div>
			</div>
			<div class="box-info-footer small">
				<div class="box-info-cate">
					<div class="title">Bản đồ vị trí</div>
					<div class="clearfix"></div>
					<div class="contact-map">
						<iframe src="{$setting.setting_company_googlemap}" width="280" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="content-main align-center">
		{include file = 'components/customs/custom.tpl' position = "copyright"}
		</div>
	</div>
	{if $smarty.const.PG_DEBUG && $setting.setting_debug_page==1}
		<div class="clearfix"></div>
		{include file="footer_debug.tpl"}
	{/if}
</div>
{*{include file = 'integrated/chat_face.tpl'}*}
{include file = 'integrated/vchat.tpl'}
<script src="{$url_template_display}js/jquery.bxslider.min.js" type="text/javascript"></script>
<script src="{$url_template_display}js/script.js?v=4.4" type="text/javascript"></script>
</body>
</html>