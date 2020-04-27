<meta name="google-site-verification" content="{$setting.setting_google_site_verification}" />
<meta name="dmca-site-verification" content="{$setting.setting_dmca_site_verification}" />
<meta name="keywords" content="{$keyword}"/>
<meta name="description" content="{$description}"/>
<title>{$page_title}</title>
<link rel="shortcut icon" href="{$setting.favicon}" type="image/x-icon"/>
<meta property="fb:app_id"          content="{$setting.setting_face_app_id}"/>
<meta name="robots" content="{if $setting.setting_robot_index}index, follow{else}noindex, nofollow{/if}"/>
<meta http-equiv="content-language" content="vi"/>
<meta property="og:title"         content="{$page_title}" />
<meta property="og:description"   content="{$description}" />
{if $page == 'index'}
    <meta property="og:url"           content="{$PG_URL_HOMEPAGE}" />
    <meta property="og:type"          content="index" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{if $setting.thumbnail}{$setting.thumbnail}{else}{$setting.logo}{/if}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{elseif $page == 'categories'}
    <meta property="og:url"           content="{$itemCategory->data.actual_link}" />
    <meta property="og:type"          content="article" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{if $itemCategory->data.image_social}{$itemCategory->data.image_social}{else}{$itemCategory->data.image}{/if}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{elseif $page == 'content'}
    <meta property="og:url"           content="{$itemContent->data.actual_link}" />
    <meta property="og:type"          content="article" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{$itemContent->data.image_social}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{elseif $page == 'static'}
    <meta property="og:url"           content="{$itemStatic->data.actual_link}" />
    <meta property="og:type"          content="article" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{$itemStatic->data.image_large}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{elseif $page == 'tag'}
    <meta property="og:url"           content="{$itemTag.actual_link}" />
    <meta property="og:type"          content="article" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{$itemTag.image_large}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{elseif $page == 'product'}
    <meta property="og:url"           content="{$product_data->data.actual_link}" />
    <meta property="og:type"          content="product" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{$product_data->data.image_large}" />
    <meta property="og:image:width"   content="{$setting.resize_image_max}" />
    <meta property="og:image:height"  content="{$setting.resize_image_max_height}" />
{elseif $page == 'bds'}
    {if $task == 'view'}
        <meta property="og:url"           content="{$itemBds->data.actual_link}" />
        <meta property="og:type"          content="bds" />
        <meta property="og:image"         itemprop="thumbnailUrl" content="{$itemBds->data.image_large}" />
        <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
        <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
    {elseif $task == 'viewdesign'}
        <meta property="og:url"           content="{$itemBds->data.actual_link}" />
        <meta property="og:type"          content="construction_design" />
        <meta property="og:image"         itemprop="thumbnailUrl" content="{$itemBds->data.image_large}" />
        <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
        <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
    {/if}
{elseif $page == 'keyword'}
    <meta property="og:url"           content="{$canonical}" />
    <meta property="og:type"          content="website" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{if $setting.thumbnail}{$setting.thumbnail}{else}{$setting.logo}{/if}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{else}
    <meta property="og:url"           content="{$canonical}" />
    <meta property="og:type"          content="website" />
    <meta property="og:image"         itemprop="thumbnailUrl" content="{if $setting.thumbnail}{$setting.thumbnail}{else}{$setting.logo}{/if}" />
    <meta property="og:image:width"   content="{$setting.resize_news_image_large}" />
    <meta property="og:image:height"  content="{$setting.resize_news_image_large_height}" />
{/if}
{if $setting.setting_twitter}
    <!-- Twitter Card -->
    <meta name="twitter:card" value="summary">
    <meta name="twitter:url" content="{$canonical}">
    <meta name="twitter:title" content="{$page_title}">
    <meta name="twitter:description" content="{$description}">
    <meta name="twitter:site" content="@{$setting.setting_domain}">
    <meta name="twitter:creator" content="@{$setting.setting_company}">
    {if $page == 'index'}
        <meta name="twitter:image" content="{if $setting.thumbnail}{$setting.thumbnail}{else}{$setting.logo}{/if}"/>
    {elseif $page == 'categories'}
        <meta name="twitter:image" content="{if $itemCategory->data.image_social}{$itemCategory->data.image_social}{else}{$itemCategory->data.image}{/if}"/>
    {elseif $page == 'content'}
        <meta name="twitter:image" content="{$itemContent->data.image_social}"/>
    {elseif $page == 'static'}
        <meta name="twitter:image" content="{$itemStatic->data.image_large}"/>
    {elseif $page == 'tag'}
        <meta name="twitter:image" content="{$itemTag.image_large}"/>
    {elseif $page == 'product'}
        <meta name="twitter:image" content="{$product_data->data.image_large}"/>
    {elseif $page == 'bds'}
        {if $task == 'view'}
            <meta name="twitter:image" content="{$itemBds->data.image_large}"/>
        {elseif $task == 'viewdesign'}
            <meta name="twitter:image" content="{$itemBds->data.image_large}"/>
        {/if}
    {/if}
    <!-- End Twitter Card -->
{/if}
<link rel="canonical" href="{$canonical}"/>
<link rel="alternate" href="{$canonical}" hreflang="vi-vn" />
<link rel="alternate" media="handheld" href="{$canonical}" />