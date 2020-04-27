<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	{include file = '../../header_seo_global.tpl'}
	<link type="text/css" rel="stylesheet" href="{$PG_URL_HOMEPAGE}templates/font-awesome-4.7.0/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="{$url_template_display}css/font-roboto.css" />
	<link type="text/css" href="{$url_template_display}css/jquery.bxslider.css" rel="stylesheet">
	<link type="text/css" href="{$url_template_display}css/style.css?v=8.5" rel="stylesheet" />
	{if $bds_active}
		<link type="text/css" href="{$url_template_display}css/bds.css?v=11.4" rel="stylesheet" />
	{/if}
	{$pgThemeCss}
	{include file = '../../header_seojs_global.tpl'}
	<script src="{$PG_URL_HOMEPAGE}include/js/jquery/js/jquery-1.11.1.min.js"></script>
	<script src="{$PG_URL_HOMEPAGE}templates/js/crawler.js?v=1.1"></script>
	{$pgThemeJs}
</head>
<body>
{if $setting.setting_show_facebook}
	{literal}
		<div id="fb-root"></div>
		<script>
			var appFaceId = {/literal}{$setting.setting_face_app_id}{literal};
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId='+appFaceId+'&autoLogAppEvents=1';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	{/literal}
	<!-- Your customer chat code -->
	<div class="fb-customerchat"
		 attribution=setup_tool
		 page_id="{$setting.setting_face_app_id}"
		 theme_color="#0084ff"
		 logged_in_greeting="Bạn cần {$setting.setting_author} hỗ trợ?"
		 logged_out_greeting="Bạn cần {$setting.setting_author} hỗ trợ?">
	</div>
{/if}
{if $setting.setting_google_tag_manager}
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$setting.setting_google_tag_manager}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
{/if}
{if $setting.setting_ads_google_code}
	{$setting.setting_ads_google_code}
{/if}