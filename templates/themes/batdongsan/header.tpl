{include file = 'header_global.tpl'}
<div class="container {if $page!='index'} bg_gioithieu{/if}" >
	<div class="container-header{if $page!='index'} header-detail{/if}">
		<div class="form_header">
			<div class="header">
				{include file = 'components/banners/logo.tpl' position = "logo"}
			</div>
			<div class="adver">
				{include file = 'components/banners/banner.tpl' position = "top"}
			</div>
		</div>
		<div class="menu">
			<div class="button_menu">
				<div id="menu1"></div>
				<div id="menu2"></div>
				<div id="menu3"></div>
			</div>
			<ul class="list_menu">
				<a href="{$PG_URL_HOMEPAGE}" class="menu_home">
					<img src="{$url_template_display}images/home_menu.png"/>
				</a>
				{include file = 'components/menus/menu.tpl' type = "main"}
			</ul>
		</div>
	</div>
