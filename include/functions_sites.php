<?php
/**
 * Get list all type site access
 */
function all_type_access_sites(){
	return array(
		SITE_PRODUCT 	=> 'Sản phẩm bán hàng',
		SITE_NEWS 		=> 'Tin tức trực tuyến',
		SITE_JOB 		=> 'Tuyển dụng - Việc làm',
		SITE_SERVICE 	=> 'Dịch vụ',
		SITE_BDS		=> 'Bất động sản - Thiết kế',
		SITE_EDUCATE	=> 'Đào tạo - Du học',
		SITE_RAO_VAT	=> 'Rao vặt online',
		SITE_DISCOUNT	=> 'Hệ thống giảm giá'
	);
}

function get_type_category_access( $type ){
	$aryData = all_type_access_sites();
	return $aryData[$type];
}

/**
 * Get site access type
 */
function get_site_access( $site_access ){
	global $site_product, $site_news, $site_jobs, $site_services, $site_bds, $site_educate, $site_discounts;
	if ( !isset($site_access) || !$site_access || !is_array($site_access) )
		return false;

	foreach ($site_access as $key_ac => $access) {
		if ( $access == SITE_PRODUCT ){
			$site_product = true;
		}
		if ( $access == SITE_NEWS ){
			$site_news = true;
		}
		if ( $access == SITE_JOB ){
			$site_jobs = true;
		}
		if ( $access == SITE_SERVICE ){
			$site_services = true;
		}
		if ( $access == SITE_BDS ){
			$site_bds = true;
		}
		if ( $access == SITE_EDUCATE ){
			$site_educate = true;
		}
		if ( $access == SITE_DISCOUNT ){
			$site_discounts = true;
		}
	}
}

/**
 * Modules global site type
 * @return array
 */
function modules_global_site_type(){
	$arrGlobalModule = array(
		SITE_GLOBAL_EXTEND => array(
			'keyword_seo.php',
			'keyword_in_site.php',
			'other_quote.php',
			'other_subject.php',
			'other_rate.php',
			'top_search_keyword.php',
			'site_groups.php',
			'static.php',
			'tag.php',
			'tag_special.php',
			'sharesite.php',
			'video.php',
			'widget.php',
			'user_special.php'
		),
		SITE_PRODUCT 	=> array(
			'product_categories.php',
			'product_categories_show_home.php',
			'product_category_position.php',
			'product_groups.php',
			'product_root_categories.php',
			'product_viewed.php'
		),
		SITE_NEWS 		=> array(
			'categories_list.php',
			'categories_root_level_sub.php',
			'categories_show_home.php',
			'categories_style.php',
			'categories_sub_level.php',
			'categories_item_style_level.php',
			'categories_item_sublevel.php',
			'categories_position.php',
			'content_add_link.php',
			'content_box_style_tab_categories.php',
			'content_categories.php',
			'content_category_position.php',
			'content_category_show_home.php',
			'content_category_sub_level.php',
			'content_category_item_level.php',
			'content_create_box.php',
			'content_create_box_hot.php',
			'content_hits.php',
			'content_hot.php',
			'content_inday_hits.php',
			'content_more_old_new.php',
			'content_new.php',
			'content_picture.php',
			'content_random.php',
            'content_others_rand.php',
			'content_special.php',
			'content_video.php'
		),
		SITE_JOB 		=> array(),
		SITE_SERVICE 	=> array(),
		SITE_BDS 		=> array(
			'bds_list_categories_groups.php',
			'bds_list_groups.php',
			'bds_list_project_groups.php',
			'bds_tktc.php',
			'bds_tktc_groups.php'
		),
		SITE_DISCOUNT	=> array(
			'partner_groups.php',
			'partner_categories.php'
		)
	);
	return $arrGlobalModule;
}

/**
 * Modules system site
 */
function module_system_site(){
	$arrSystemModule = array(
		'menu.php',
		'banner.php',
		'custom.php'
	);
	return $arrSystemModule;
}

/**
 * Get module global follow site_access
 * @return array
 */
function get_module_global_site_access($site_access = array()){
	if ( !isset($site_access) || !$site_access || !is_array($site_access) || empty($site_access) )
		return false;

	array_push($site_access, SITE_GLOBAL_EXTEND);

	$arrGlobalModule = modules_global_site_type();

	$arrModules = array();
	foreach( $site_access as $access ){
		if ( array_key_exists($access, $arrGlobalModule) ){
			$dataValue = $arrGlobalModule[$access];
			array_push_key($arrModules, $access, $dataValue);
		}
	}
	return $arrModules;
}

function get_site_display($domain = false){
	global $database, $setting, $check_on_localhost;

    $siteDefault = array(
        'site_id' => 34,
        'site_access' => 2,
        'site_group' => 0,
        'site_domain' => 'tuyensinhso.vn',
        'site_emails' => 'tuyensinhso.com@gmail.com',
        'site_phone' => '0889964368',
        'site_template_mobile' => 0,
        'site_template_mobile_name' => '',
        'site_template_tablet' => 0,
        'site_template_tablet_name' => '',
        'test_data_site_id' => 0,
        'template_code' => 'tuyen-sinh-so'
    );

	if ( !$domain ){
		if ( $check_on_localhost )
			$domain = basename(dirname($_SERVER['PHP_SELF']));
		else
			$domain = $_SERVER['SERVER_NAME'];
	}

    $sql = 'SELECT s.site_id, s.site_access, s.site_group, s.site_domain, s.site_emails, s.site_phone, s.site_template_mobile, s.site_template_mobile_name, s.site_template_tablet, s.site_template_tablet_name, s.test_data_site_id, t.template_code'
        . ' FROM '.TBL_SITE.' AS s'
        . ' LEFT JOIN '.TBL_TEMPLATE.' AS t ON s.site_template_id = t.template_id'
        . ' WHERE s.site_domain="'.$domain.'" AND s.site_status=1 AND t.template_display=1'
        . ' LIMIT 1'
    ;
    $result = $database->db_query($sql);
    $site = $database->db_fetch_assoc($result);
    if ( isset($site) && $site ){
        if ( isset($_COOKIE["curent_domain"]) && $_COOKIE["curent_domain"] != $site['site_domain'] ) {
            unset($_COOKIE["curent_domain"]);
            setcookie("curent_domain", $site['site_domain']);
        }
        $setting['setting_email'] = (isset($site['site_emails']) && $site['site_emails']) ? $site['site_emails'] : '';
        $setting['setting_support_phone'] = (isset($site['site_phone']) && $site['site_phone']) ? $site['site_phone'] : '';

        return $site;
    }else{
        $sql = 'SELECT site_id, site_access, site_domain, site_emails, site_phone, site_template_mobile, site_template_tablet, test_data_site_id'
            . ' FROM '.TBL_SITE
            .' WHERE site_domain ="'.$domain.'" AND site_status=1 AND site_template_id=0';
        $result = $database->db_query($sql);
        $site = $database->db_fetch_assoc($result);
        if ( isset($site) && $site ) {
            $site['template_code'] = 'default';
            if (isset($_COOKIE["curent_domain"]) && $_COOKIE["curent_domain"] != $site['site_domain']) {
                unset($_COOKIE["curent_domain"]);
                setcookie("curent_domain", $site['site_domain']);
            }
            $setting['setting_email'] = (isset($site['site_emails']) && $site['site_emails']) ? $site['site_emails'] : '';
            $setting['setting_support_phone'] = (isset($site['site_phone']) && $site['site_phone']) ? $site['site_phone'] : '';

            return $site;
        }
    }
	return $siteDefault;
}

function get_setting_site( $site_id = FALSE, $original_site_id = FALSE ){
	global $database, $datetime, $setting, $settingClass, $page, $isMobile, $isTablet;
	
	if ( !$site_id ){
		if ( isset($_COOKIE['fdomain']) && $_COOKIE['fdomain']!= '' ){
			$sql = 'SELECT site_id FROM '.TBL_SITE.' WHERE site_status=1 AND site_domain="'.$_COOKIE['fdomain'].'" LIMIT 1';
			if ($fsite = $database->db_fetch_assoc($database->db_query($sql))){
				$site_id = $fsite['site_id'];
			}
		}else
			return false;
	}
	
	$query = 'SELECT ST.*, S.site_group, S.site_template_color, S.site_domain, S.site_emails, S.site_phone, S.site_access, S.site_global_modules, S.site_file_include, S.site_group, S.site_group_student_show, S.site_register_date FROM '.TBL_SETTING.' AS ST LEFT JOIN '.TBL_SITE.' AS S ON ST.site_id = S.site_id WHERE ST.site_id='.$site_id.' LIMIT 1';
	$results = $database->db_query($query);
	if ( $row = $database->db_fetch_assoc($results) ){
		$row['logo'] = showImageSubject($row['url_logo'], 'logos', $image_large = 'banner');
		$row['favicon'] = showImageSubject($row['url_favicon'], 'favicons', $image_large = array('width' => 32, 'height' => 32));
		$row['thumbnail'] = showImageSubject(($row['url_thumbnail'] ? $row['url_thumbnail'] : $row['url_logo']), 'logos', $image_large = 'banner');
		$item = $row;
	}
	if ( !isset($item) ) return false;

	/**
	 * Check site origina have use template_color <> $item['site_template_color']
	 */
	$original_template_color = false;
	if ( ($original_site_id) && $site_id != $original_site_id ){
		$sql = "SELECT site_template_color FROM ".TBL_SITE." WHERE site_id = " . $original_site_id;
		$result = $database->db_query($sql);
		if ( $row = $database->db_fetch_assoc($result) ){
			$original_template_color = $row['site_template_color'];
		}
	}

	$setting['setting_id']					= ( $item['setting_id'] ) ? $item['setting_id'] : false;
	$setting['setting_email']				= ( $item['setting_email'] ) ? $item['setting_email'] : $setting['setting_support_email'];
	$setting['setting_master_email']		= ( $item['site_emails'] ) ? $item['site_emails'] : '';
	$setting['site_phone']					= ( $item['site_phone'] ) ? $item['site_phone'] : '';

	$setting['setting_ios_app_id']			= '';
	$setting['setting_google_play_app_id']	= '';
	$setting['setting_url_app_ios']			= '';
	$setting['setting_url_app_android']		= '';

	$setting['logo']						= $item['logo'] ? $item['logo'] : '';
	if ( $setting['logo'] ){
		list($width_logo, $height_logo) 	= getimagesize($setting['logo']);
		$setting['logo_w'] 					= $width_logo;
		$setting['logo_h'] 					= $height_logo;
	}
	$setting['setting_slogan']				= $item['slogan'] ? $item['slogan'] : '';
	if ( $item['favicon'] ){
		$setting['favicon'] 				= $item['favicon'];
	}else{
		if ( file_exists('images/favicons/'.$item['site_domain'].'/favicon.ico') ){
			$setting['favicon']					= PG_URL_HOMEPAGE . 'images/favicons/'.$item['site_domain'].'/favicon.ico';
		}else{
			$setting['favicon']					= PG_URL_HOMEPAGE . 'images/favicon.png';
		}
	}
	if ( $item['thumbnail'] ){
		$setting['thumbnail'] 				= $item['thumbnail'];
		list($width_thumb, $height_thumb) 	= getimagesize($setting['thumbnail']);
		$setting['thumbnail_w'] 			= $width_thumb;
		$setting['thumbnail_h'] 			= $height_thumb;
	}
	$setting['site_register_date']			= ( $item['site_register_date']  ? $item['site_register_date'] : ($datetime->timestampToDateTime()));

	$setting['setting_support_name']		= ( $item['setting_support_name'] ) ? $item['setting_support_name'] : $setting['setting_author'];
	$setting['setting_support_skype']		= ( $item['setting_support_skype'] ) ? $item['setting_support_skype'] : $setting['setting_support_skype'];
	$setting['setting_support_yahoo']		= ( $item['setting_support_yahoo'] ) ? $item['setting_support_yahoo'] : $setting['setting_support_yahoo'];
	$setting['setting_support_phone']		= ( $item['setting_support_phone'] ) ? $item['setting_support_phone'] : $setting['setting_support_phone'];
	$setting['setting_support_email']		= ( $item['setting_support_email'] ) ? $item['setting_support_email'] : $setting['setting_support_email'];

	$setting['setting_support_name2']		= ( $item['setting_support_name2'] ) ? $item['setting_support_name2'] : null;
	$setting['setting_support_skype2']		= ( $item['setting_support_skype2'] ) ? $item['setting_support_skype2'] : null;
	$setting['setting_support_yahoo2']		= ( $item['setting_support_yahoo2'] ) ? $item['setting_support_yahoo2'] : null;
	$setting['setting_support_phone2']		= ( $item['setting_support_phone2'] ) ? $item['setting_support_phone2'] : null;
	$setting['setting_support_email2']		= ( $item['setting_support_email2'] ) ? $item['setting_support_email2'] : null;

	$setting['setting_support_name3']		= ( $item['setting_support_name3'] ) ? $item['setting_support_name3'] : null;
	$setting['setting_support_skype3']		= ( $item['setting_support_skype3'] ) ? $item['setting_support_skype3'] : null;
	$setting['setting_support_yahoo3']		= ( $item['setting_support_yahoo3'] ) ? $item['setting_support_yahoo3'] : null;
	$setting['setting_support_phone3']		= ( $item['setting_support_phone3'] ) ? $item['setting_support_phone3'] : null;
	$setting['setting_support_email3']		= ( $item['setting_support_email3'] ) ? $item['setting_support_email3'] : null;

	$setting['setting_support_name4']		= ( $item['setting_support_name4'] ) ? $item['setting_support_name4'] : null;
	$setting['setting_support_skype4']		= ( $item['setting_support_skype4'] ) ? $item['setting_support_skype4'] : null;
	$setting['setting_support_yahoo4']		= ( $item['setting_support_yahoo4'] ) ? $item['setting_support_yahoo4'] : null;
	$setting['setting_support_phone4']		= ( $item['setting_support_phone4'] ) ? $item['setting_support_phone4'] : null;
	$setting['setting_support_email4']		= ( $item['setting_support_email4'] ) ? $item['setting_support_email4'] : null;

	$setting['setting_support_name5']		= ( $item['setting_support_name5'] ) ? $item['setting_support_name5'] : null;
	$setting['setting_support_skype5']		= ( $item['setting_support_skype5'] ) ? $item['setting_support_skype5'] : null;
	$setting['setting_support_yahoo5']		= ( $item['setting_support_yahoo5'] ) ? $item['setting_support_yahoo5'] : null;
	$setting['setting_support_phone5']		= ( $item['setting_support_phone5'] ) ? $item['setting_support_phone5'] : null;
	$setting['setting_support_email5']		= ( $item['setting_support_email5'] ) ? $item['setting_support_email5'] : null;

    $setting['setting_show_logo_to_image']	= ( $item['setting_show_logo_to_image'] ) ? $item['setting_show_logo_to_image'] : 0;

	$setting['setting_hotline']				= ( $item['setting_hotline'] ) ? $item['setting_hotline'] : $setting['setting_hotline'];
	$setting['setting_domain']				= ( $item['setting_domain'] ) ? $item['setting_domain'] : $setting['setting_domain'];
	if ( !$setting['setting_domain'] ){
		$current_url = ( (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" : "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
		$parse = parse_url($current_url);
		$setting['setting_domain'] = $parse['host'];
	}
	$setting['setting_author']				= ( $item['setting_author'] ) ? $item['setting_author'] : $setting['setting_author'];

	$setting['setting_tag_limit']			= ( $item['setting_tag_limit'] ) ? $item['setting_tag_limit'] : $setting['setting_list_limit'];
	$setting['setting_box_limit']			= ( $item['setting_box_limit'] ) ? $item['setting_box_limit'] : $setting['setting_list_limit'];
	$setting['setting_list_limit']			= ( $item['setting_list_limit'] ) ? $item['setting_list_limit'] : $setting['setting_list_limit'];

	$setting['setting_ga_id']				= ( $item['setting_ga_id'] ) ? $item['setting_ga_id'] : $setting['setting_ga_id'];
	$setting['setting_ga_profile_id']		= ( $item['setting_ga_profile_id'] ) ? $item['setting_ga_profile_id'] : $setting['setting_ga_profile_id'];
	$setting['setting_google_site_verification'] = ( $item['setting_google_site_verification'] ) ? $item['setting_google_site_verification'] : '';
    $setting['setting_dmca_site_verification'] = ( $item['setting_dmca_site_verification'] ) ? $item['setting_dmca_site_verification'] : '';
	$setting['setting_google_tag_manager']	= ( $item['setting_google_tag_manager'] ) ? $item['setting_google_tag_manager'] : '';
	$setting['setting_google_search_cse']	= ( $item['setting_google_search_cse'] ) ? $item['setting_google_search_cse'] : '';
	$setting['setting_google_key_api']		= ( $item['setting_google_key_api'] ) ? $item['setting_google_key_api'] : $setting['setting_google_key_api'];
	$setting['setting_map_api']				= ( $item['setting_map_api'] ) ? $item['setting_map_api'] : '';
	$setting['setting_map_lat']				= ( $item['setting_map_lat'] ) ? $item['setting_map_lat'] : '';
	$setting['setting_map_long']			= ( $item['setting_map_long'] ) ? $item['setting_map_long'] : '';
	$setting['setting_yandex_metrica_id']	= ( $item['setting_yandex_metrica_id'] ) ? $item['setting_yandex_metrica_id'] : '';
	$setting['setting_showroom_partner_basic']	= ( $item['setting_showroom_partner_basic'] ) ? $item['setting_showroom_partner_basic'] : 0;
	$setting['setting_multi_country']		= ( $item['setting_multi_country'] ) ? $item['setting_multi_country'] : 0;
	$setting['setting_show_facebook']		= ( $item['setting_show_facebook'] ) ? $item['setting_show_facebook'] : $setting['setting_show_facebook'];
	$setting['setting_facebook']			= ( $item['setting_facebook'] ) ? $item['setting_facebook'] : $setting['setting_facebook'];
	if ( $setting['setting_facebook'] ){
		$aryFace = explode("/",$setting['setting_facebook']);
		$aryFace = array_filter($aryFace);
		if ( is_array($aryFace) && count($aryFace) && !empty($aryFace) ){
			$setting['setting_facebook_name'] = end($aryFace);
		}
	}
	$setting['setting_twitter']				= ( $item['setting_twitter'] ) ? $item['setting_twitter'] : $setting['setting_twitter'];
	$setting['setting_youtube']				= ( $item['setting_youtube'] ) ? $item['setting_youtube'] : $setting['setting_youtube'];
	$setting['setting_google_plus']			= ( $item['setting_google_plus'] ) ? $item['setting_google_plus'] : $setting['setting_google_plus'];
	$setting['setting_url_social']			= ( $item['setting_url_social'] ) ? explode(",", $item['setting_url_social']) : false;
	if ( is_array($setting['setting_url_social']) && (count($setting['setting_url_social']) == 1) ){
		$setting['setting_url_social']		= end($setting['setting_url_social']);
	}
	$setting['setting_face_app_id']			= ( $item['setting_face_app_id'] ) ? $item['setting_face_app_id'] : $setting['setting_face_app_id'];
	$setting['facebook_likebox_width']		= ( $item['facebook_likebox_width'] ) ? $item['facebook_likebox_width'] : null;
	$setting['facebook_likebox_height']		= ( $item['facebook_likebox_height'] ) ? $item['facebook_likebox_height'] : null;
	$setting['facebook_comment_width']		= ( $item['facebook_comment_width'] ) ? $item['facebook_comment_width'] : null;
	$setting['facebook_comment_numberrow']	= ( $item['facebook_comment_numberrow'] ) ? $item['facebook_comment_numberrow'] : null;

	$setting['facebook_chat_page_id']		= ( $item['facebook_chat_page_id'] ) ? $item['facebook_chat_page_id'] : null;
	$setting['facebook_chat_color']			= ( $item['facebook_chat_color'] ) ? $item['facebook_chat_color'] : null;
	$setting['facebook_chat_message']		= ( $item['facebook_chat_message'] ) ? $item['facebook_chat_message'] : null;

    $setting['setting_show_zalo']		    = ( $item['setting_show_zalo'] ) ? $item['setting_show_zalo'] : 0;
    $setting['setting_zalo_id']		        = ( $item['setting_zalo_id'] ) ? $item['setting_zalo_id'] : '';

	$setting['setting_title_web']			= ( $item['setting_title_web'] ) ? $item['setting_title_web'] : $setting['setting_title_web'];
	$setting['setting_only_title_web']		= $setting['setting_title_web'];
	$setting['setting_show_domain_replace_title'] = ( $item['setting_show_domain_replace_title'] ) ? $item['setting_show_domain_replace_title'] : 0;
	$setting['setting_title_first']			= ( $item['setting_title_first'] ) ? $item['setting_title_first'] : $setting['setting_title_first'];
	$setting['setting_metatitle_web']		= ( $item['setting_metatitle_web'] ) ? $item['setting_metatitle_web'] : '';
	$setting['setting_keyword_web']			= ( $item['setting_keyword_web'] ) ? $item['setting_keyword_web'] : $setting['setting_keyword_web'];
	$setting['setting_description_web']		= ( $item['setting_description_web'] ) ? $item['setting_description_web'] : $setting['setting_description_web'];

	$setting['setting_domain_exclude']		= ( $item['setting_domain_exclude'] ) ? array_map('trim', explode(",", $item['setting_domain_exclude'])) : array();
	if ( is_array($setting['setting_domain_exclude']) ){
		if ( $setting['setting_domain'] && !in_array($setting['setting_domain'], $setting['setting_domain_exclude']) ){
			array_push($setting['setting_domain_exclude'], $setting['setting_domain']);
		}
		if ( $item['site_domain'] && !in_array($item['site_domain'], $setting['setting_domain_exclude']) ) {
			array_push($setting['setting_domain_exclude'], $item['site_domain']);
		}
	}
	$setting['setting_domain_exclude_json'] = json_encode($setting['setting_domain_exclude']);

	$setting['setting_robot_index']			= ( $item['setting_robot_index'] ) ? $item['setting_robot_index'] : false;
	$setting['setting_sitemap_update']		= ( $item['setting_sitemap_update'] ) ? $item['setting_sitemap_update'] : false;
	$setting['setting_save_log']			= ( $item['setting_save_log'] ) ? $item['setting_save_log'] : false;
	$setting['setting_page_user']			= ( $item['setting_page_user'] ) ? $item['setting_page_user'] : 0;
	$setting['setting_auto_submit_dmca']	= ( $item['setting_auto_submit_dmca'] ) ? $item['setting_auto_submit_dmca'] : false;
	$setting['setting_url_compact_seo']		= ( $item['setting_url_compact_seo'] ) ? $item['setting_url_compact_seo'] : false;
	$setting['setting_auto_submit_seo']		= ( $item['setting_auto_submit_seo'] ) ? $item['setting_auto_submit_seo'] : false;
	$setting['setting_auto_keyword_born']	= ( $item['setting_auto_keyword_born'] ) ? $item['setting_auto_keyword_born'] : false;
	$setting['setting_mobile_amp']			= ( $item['setting_mobile_amp'] ) ? $item['setting_mobile_amp'] : false;
	$setting['setting_facebook_instant_article'] = ( $item['setting_facebook_instant_article'] ) ? $item['setting_facebook_instant_article'] : false;
	$setting['setting_facebook_pages'] 		= ( $item['setting_facebook_pages'] ) ? $item['setting_facebook_pages'] : '';
	$setting['setting_facebook_placement'] 	= ( $item['setting_facebook_placement'] ) ? $item['setting_facebook_placement'] : '';
	$setting['setting_sitemap_saveDB']		= ( $item['setting_sitemap_saveDB'] ) ? $item['setting_sitemap_saveDB'] : false;
	$setting['setting_sitemap_share']		= ( $item['setting_sitemap_share'] ) ? $item['setting_sitemap_share'] : false;
	$setting['setting_company']				= ( $item['setting_company'] ) ? $item['setting_company'] : $setting['setting_company'];
	$setting['setting_company_address']		= ( $item['setting_company_address'] ) ? $item['setting_company_address'] : '';
	$setting['setting_company_address_locality'] 	= ( $item['setting_company_address_locality'] ) ? $item['setting_company_address_locality'] : '';
	$setting['setting_company_address_country'] 	= ( $item['setting_company_address_country'] ) ? $item['setting_company_address_country'] : '';
	$setting['setting_company_address_region'] 		= ( $item['setting_company_address_region'] ) ? $item['setting_company_address_region'] : '';
	$setting['setting_company_address_postalCode'] 	= ( $item['setting_company_address_postalCode'] ) ? $item['setting_company_address_postalCode'] : '';
	$setting['setting_company_description'] = ( $item['setting_company_description'] ) ? $item['setting_company_description'] : '';
	$setting['setting_company_googlemap'] 	= ( $item['setting_company_googlemap'] ) ? $item['setting_company_googlemap'] : '';
	$setting['setting_mobile_crm'] 			= ( $item['setting_mobile_crm'] ) ? $item['setting_mobile_crm'] : '';
	$setting['setting_company_latitude'] 	= ( $item['setting_company_latitude'] ) ? $item['setting_company_latitude'] : '';
	$setting['setting_company_longitude'] 	= ( $item['setting_company_longitude'] ) ? $item['setting_company_longitude'] : '';
	$setting['setting_company_urlTempalte'] = ( $item['setting_company_urlTempalte'] ) ? $item['setting_company_urlTempalte'] : '';

	$setting['setting_url_redirect']		= ( $item['setting_url_redirect'] ) ? $item['setting_url_redirect'] : false;
	$setting['setting_url_replace']			= ( $item['setting_url_replace'] ) ? $item['setting_url_replace'] : false;
	if ( $original_site_id  ){
		$_re_query = "SELECT setting_url_replace FROM ".TBL_SETTING." WHERE site_id = " . $original_site_id . " LIMIT 1";
		$_re_result = $database->db_query($_re_query);
		if ( $_re_row = $database->db_fetch_assoc($_re_result) ){
			$setting['setting_url_replace'] = ( $_re_row['setting_url_replace'] ? $_re_row['setting_url_replace'] : false );
		}
	}

	$setting['setting_seo_name'] 			= ( $item['setting_seo_name'] ) ? $item['setting_seo_name'] : '';
	$setting['setting_seo_job_title'] 		= ( $item['setting_seo_job_title'] ) ? $item['setting_seo_job_title'] : '';
	$setting['setting_seo_avatar'] 			= ( $item['setting_seo_avatar'] ) ? $item['setting_seo_avatar'] : '';
	$setting['setting_seo_url_sameas'] 		= ( $item['setting_seo_url_sameas'] ) ? explode(",", $item['setting_seo_url_sameas']) : '';
	$setting['setting_seo_alumni_of'] 		= ( $item['setting_seo_alumni_of'] ) ? explode(",", $item['setting_seo_alumni_of']) : '';
	$setting['setting_seo_address_locality']= ( $item['setting_seo_address_locality'] ) ? $item['setting_seo_address_locality'] : '';
	$setting['setting_seo_address_region'] 	= ( $item['setting_seo_address_region'] ) ? $item['setting_seo_address_region'] : '';

	// Ads
	$setting['setting_ads_facebook_code']	= ( $item['setting_ads_facebook_code'] ) ? $item['setting_ads_facebook_code'] : '';
	if ( $setting['setting_ads_facebook_code'] ){
		$setting['setting_ads_facebook_code'] = html_entity_decode($setting['setting_ads_facebook_code']);
		$setting['setting_ads_facebook_code'] = str_replace("&#039;", "'", $setting['setting_ads_facebook_code']);

	}
	$setting['setting_ads_google_code']		= ( $item['setting_ads_google_code'] ) ? $item['setting_ads_google_code'] : '';
	if ( $setting['setting_ads_google_code'] ){
		$setting['setting_ads_google_code'] = html_entity_decode($setting['setting_ads_google_code']);
		$setting['setting_ads_google_code'] = str_replace("&#039;", "'", $setting['setting_ads_google_code']);
	}

	$setting['setting_product_color']		= ( $item['setting_product_color'] ) ? $item['setting_product_color'] : 0;
	$setting['setting_product_size']		= ( $item['setting_product_size'] ) ? $item['setting_product_size'] : 0;
	$setting['setting_product_size_number']	= ( $item['setting_product_size_number'] ) ? $item['setting_product_size_number'] : 0;

	$setting['setting_image_in_content']	= ( $item['setting_image_in_content'] ) ? $item['setting_image_in_content'] : '';
	$setting['setting_show_introtext']		= ( $item['setting_show_introtext'] ) ? $item['setting_show_introtext'] : 0;
	$setting['setting_show_image_detail']	= ( $item['setting_show_image_detail'] ) ? $item['setting_show_image_detail'] : 0;
	$setting['setting_process_fulltext']	= ( $item['setting_process_fulltext'] ) ? $item['setting_process_fulltext'] : 0;
	$setting['setting_set_font_default']	= ( $item['setting_set_font_default'] ) ? $item['setting_set_font_default'] : 0;
	$setting['setting_comment']				= ( $item['setting_comment'] ) ? $item['setting_comment'] : 0;
	$setting['setting_tag_position']		= ( $item['setting_tag_position'] ) ? $item['setting_tag_position'] : '';

	// Wordpress
	$setting['setting_include_wordpress']	= ( $item['setting_include_wordpress'] ) ? $item['setting_include_wordpress'] : 0;
	$setting['setting_include_wordpress_team'] = ( $item['setting_include_wordpress_team'] ) ? $item['setting_include_wordpress_team'] : 0;

	// Resize image
	$setting['use_resize_image']			= ( $item['use_resize_image'] ) ? $item['use_resize_image'] : 0;
	$setting['use_resize_image_product']	= ( $item['use_resize_image_product'] ) ? $item['use_resize_image_product'] : 0;

	$setting['resize_image_tiny']			= ( $item['resize_image_tiny'] ) ? $item['resize_image_tiny'] : $setting['resize_image_tiny'];
	$setting['resize_image_tiny_height']	= ( $item['resize_image_tiny_height']) ? $item['resize_image_tiny_height'] : 0;
	$setting['resize_image_min']			= ( $item['resize_image_min'] ) ? $item['resize_image_min'] : $setting['resize_image_min'];
	$setting['resize_image_min_height']		= ( $item['resize_image_min_height'] ) ? $item['resize_image_min_height'] : 0;
	$setting['resize_image_normal']			= ( $item['resize_image_normal'] ) ? $item['resize_image_normal'] : $setting['resize_image_normal'];
	$setting['resize_image_normal_height']	= ( $item['resize_image_normal_height'] ) ? $item['resize_image_normal_height'] : 0;
	$setting['resize_image_max']			= ( $item['resize_image_max'] ) ? $item['resize_image_max'] : $setting['resize_image_max'];
	$setting['resize_image_max_height']		= ( $item['resize_image_max_height'] ) ? $item['resize_image_max_height'] : 0;

	$setting['resize_news_image_tiny']		= ( $item['resize_news_image_tiny'] ) ? $item['resize_news_image_tiny'] : $setting['resize_news_image_tiny'];
	$setting['resize_news_image_tiny_height']= ( $item['resize_news_image_tiny_height'] ) ? $item['resize_news_image_tiny_height'] : 0;
	$setting['resize_news_image_thumbnail']= ( $item['resize_news_image_thumbnail'] ) ? $item['resize_news_image_thumbnail'] : $setting['resize_news_image_thumbnail'];
	$setting['resize_news_image_thumbnail_height']= ( $item['resize_news_image_thumbnail_height'] ) ? $item['resize_news_image_thumbnail_height'] : 0;
	$setting['resize_news_image_normal']		= ( $item['resize_news_image_normal'] ) ? $item['resize_news_image_normal'] : $setting['resize_news_image_normal'];
	$setting['resize_news_image_normal_height']	= ( $item['resize_news_image_normal_height'] ) ? $item['resize_news_image_normal_height'] : 0;
	$setting['resize_news_image_large']		= ( $item['resize_news_image_large'] ) ? $item['resize_news_image_large'] : $setting['resize_news_image_large'];
	$setting['resize_news_image_large_height']	= ( $item['resize_news_image_large_height'] ) ? $item['resize_news_image_large_height'] : 0;

	// Get resize image for mobile
    $setting['resize_mobile_image_width']		= ( $item['resize_mobile_image_width'] ) ? $item['resize_mobile_image_width'] : 0;
    $setting['resize_mobile_image_height']	    = ( $item['resize_mobile_image_height'] ) ? $item['resize_mobile_image_height'] : 0;
    $setting['resize_mobile_news_image_width']	= ( $item['resize_mobile_news_image_width'] ) ? $item['resize_mobile_news_image_width'] : 0;
    $setting['resize_mobile_news_image_height']	= ( $item['resize_mobile_news_image_height'] ) ? $item['resize_mobile_news_image_height'] : 0;

	if ( $isMobile ){
	    if ( $setting['resize_mobile_image_width'] ){
            $setting['resize_image_tiny']
            = $setting['resize_image_min']
            = $setting['resize_image_normal']
            = $setting['resize_image_max']
            = $setting['resize_mobile_image_width'];
        }
        if ( $setting['resize_mobile_image_height'] ){
            $setting['resize_image_tiny_height']
            = $setting['resize_image_min_height']
            = $setting['resize_image_normal_height']
            = $setting['resize_image_max_height']
            = $setting['resize_mobile_image_height'];
        }

        if ( $setting['resize_mobile_news_image_width'] ){
            $setting['resize_news_image_tiny']
            = $setting['resize_news_image_thumbnail']
            = $setting['resize_news_image_normal']
            = $setting['resize_news_image_large']
            = $setting['resize_mobile_news_image_width'];
        }
        if ( $setting['resize_mobile_news_image_height'] ){
            $setting['resize_news_image_tiny_height']
            = $setting['resize_news_image_thumbnail_height']
            = $setting['resize_news_image_normal_height']
            = $setting['resize_news_image_large_height']
            = $setting['resize_mobile_news_image_height'];
        }
	}

	// Signature
	$setting['setting_signature_on']		= ( $item['setting_signature_on'] ) ? $item['setting_signature_on'] : 0;
	$setting['setting_signature_text']    	= ( $item['setting_signature_text'] ) ? $item['setting_signature_text'] : '';

	$setting['mail_type']					= ( $item['mail_type'] ) ? $item['mail_type'] : $setting['mail_type'];
	$setting['mail_smtpport']				= ( $item['mail_smtpport'] ) ? $item['mail_smtpport'] : $setting['mail_smtpport'];
	$setting['mail_smtphost']				= ( $item['mail_smtphost'] ) ? $item['mail_smtphost'] : $setting['mail_smtphost'];
	$setting['mail_smtpuser']				= ( $item['mail_smtpuser'] ) ? $item['mail_smtpuser'] : $setting['mail_smtpuser'];
	$setting['mail_smtppass']				= ( $item['mail_smtppass'] ) ? $item['mail_smtppass'] : $setting['mail_smtppass'];
	$setting['gmail_smtpuser']				= ( $item['gmail_smtpuser'] ) ? $item['gmail_smtpuser'] : $setting['gmail_smtpuser'];
	$setting['gmail_smtppass']				= ( $item['gmail_smtppass'] ) ? $item['gmail_smtppass'] : $setting['gmail_smtppass'];

	$setting['site_group']					= $item['site_group'] ? $item['site_group'] : 0;
	$setting['site_template_color']			= $item['site_template_color'] ? $item['site_template_color'] : false;
	if ( $original_template_color ){
		$setting['site_template_color']		= $original_template_color;
	}

	$setting['setting_update_newdate']		= $item['setting_update_newdate'] ? $item['setting_update_newdate'] : false;
	$setting['setting_data_schema']			= $item['setting_data_schema'] ? $item['setting_data_schema'] : 1;
	$setting['setting_schema_customize']	= $item['setting_schema_customize'] ? $item['setting_schema_customize'] : '';
	$setting['setting_admin_edit_fast']		= $item['setting_admin_edit_fast'] ? $item['setting_admin_edit_fast'] : false;
	$setting['setting_use_location']		= $item['setting_use_location'] ? $item['setting_use_location'] : false;
	$setting['setting_tab_data']			= $item['setting_tab_data'] ? $item['setting_tab_data'] : false;
	$setting['setting_show_admin_created']	= $item['setting_show_admin_created'] ? $item['setting_show_admin_created'] : false;

	$setting['setting_cache_on']			= ( CACHE_ON ? ( $item['cache_on'] ? $item['cache_on'] : 0 ) : 0 );
	$setting['setting_cache_time']			= ( CACHE_ON ? ( $item['cache_time'] ? $item['cache_time'] : 300 ) : 0 ); // 5 minutes

	// Site access
	$setting['site_access']					= explode("|", $item['site_access']);
	if ( in_array(SITE_PRODUCT, $setting['site_access']) ){
		// Query site ship
		$_ship_query = "SELECT ship_site_city, ship_site_cost_urban, ship_site_cost_extramural, ship_site_free, ship_site_free_info FROM ".TBL_SITE_SHIP." WHERE ship_site_id = " . $site_id;
		$_ship_result = $database->db_query($_ship_query);
		if ( $_shipRow = $database->db_fetch_assoc($_ship_result) ){
			$_shipRow['ship_site_city'] = json_decode($_shipRow['ship_site_city']);
			if ( is_array($_shipRow['ship_site_city']) && count($_shipRow['ship_site_city']) && !empty($_shipRow['ship_site_city']) ){
				$_shipRow['ship_urban_city'] = getCity($_shipRow['ship_site_city'], $ma_tinh = true);
				$_shipRow['ship_urban_city'] = array_values($_shipRow['ship_urban_city']);
			}
			$setting['cost_ship'] = $_shipRow;
		}
	}

	// Get global modules in side
	$setting['setting_global_modules']		= $item['site_global_modules'] ? (array)json_decode($item['site_global_modules']) : false;
	$arrListAllModuleGlobal = array();
	if ( isset($setting['setting_global_modules']) && is_array($setting['setting_global_modules']) && count($setting['setting_global_modules']) && !empty($setting['setting_global_modules']) ){
		foreach ( $setting['setting_global_modules'] as $g_modules ){
			foreach ( $g_modules as $_imodule ){
				if ( !in_array($_imodule, $arrListAllModuleGlobal) ){
					array_push($arrListAllModuleGlobal, $_imodule);
				}
			}
		}
	}

	if ( $site_id ){
		$setting_cache_time = intval($setting['setting_cache_time']) ? intval($setting['setting_cache_time']) : 86400; // 1day: 86400

		// Get module_code for site
		$setting['setting_module_access']		= false;
		if ( $setting['setting_cache_on'] ){
			$cache_key_module_access = 'setting_module_access_follow::site_id_'.$site_id;
			$setting['setting_module_access'] = CacheLib::get($cache_key_module_access, $setting_cache_time);
		}
		if ( !$setting['setting_module_access'] ){
			$sql = "SELECT m.module_code, m.module_title, m.module_description FROM ".TBL_MODULE." m LEFT JOIN ".TBL_SITE_MODULE." AS sm ON m.module_id = sm.module_id WHERE sm.site_id=".$site_id;
			$results = $database->db_query($sql);
			while ( $row = $database->db_fetch_assoc($results) ){
				$setting['setting_module_access'][$row['module_code']] = $row;
			}
			if ( $setting['setting_cache_on'] && is_array($setting['setting_module_access']) && count($setting['setting_module_access']) && !empty($setting['setting_module_access']) ) {
				CacheLib::set($cache_key_module_access, $setting['setting_module_access'], $setting_cache_time);
			}
		}

		// Get include file module for page
		$setting['setting_design_page']			= false;
		if ( $setting['setting_cache_on'] ){
			$cache_key_design_page = 'setting_design_page::site_id_'.$site_id;
			$setting['setting_design_page'] = CacheLib::get($cache_key_design_page, $setting_cache_time);
		}
		if ( !$setting['setting_design_page'] ){
			$query = "SELECT page_name, module_name, extension, directory FROM ".TBL_SITE_DESIGN." WHERE site_id=".$site_id;
			$results = $database->db_query($query);
			while ( $row = $database->db_fetch_assoc($results) ){
				if ( !empty($arrListAllModuleGlobal) ){
					$file_name =  $row['module_name'] . '.' .  $row['extension'];
					if ( !in_array($file_name, $arrListAllModuleGlobal) ){
						$setting['setting_design_page'][$row['page_name']][] = $row;
					}
				}else{
					$setting['setting_design_page'][$row['page_name']][] = $row;
				}
			}

			if ( $setting['setting_cache_on'] && is_array($setting['setting_design_page']) && count($setting['setting_design_page']) && !empty($setting['setting_design_page']) ) {
				CacheLib::set($cache_key_design_page, $setting['setting_design_page'], $setting_cache_time);
			}
		}
	}

	// Site groups
	$setting['site_group']	= $item['site_group'];
	$setting['site_group_student_show'] = $item['site_group_student_show'];
	if ( $setting['site_group'] == SITE_GROUP_SCHOOL && $setting['site_group_student_show'] ){
		$setting['site_group_nganh_hoc'] = $settingClass->list_nganh_hoc_cao_dang_y_duoc();
		$setting['list_candidates'] = $settingClass->list_new_ungvien();
		$setting['list_success_candidates'] = $settingClass->list_ungvien_success();
	}

	// Commons
	if ( $item['setting_commons'] ){
		$setting['setting_commons'] = explode(",", $item['setting_commons']);
		$setting['setting_commons'] = array_map('trim', $setting['setting_commons']);
	}

	// Get setting file include of page categories
	$setting['setting_include_file'] = $item['site_file_include'] ? array_filter((array)json_decode($item['site_file_include'])) : false;
	$setting['setting_site_json'] = json_encode($setting);

	return $setting;
}

function schema_webPage(){
	global $setting, $datetime;

	$arySchemaWebPage = array(
		"@context" 		=> "http://schema.org",
		"@type" 		=> "WebPage",
		"@id" 			=> PG_URL_HOMEPAGE . '#webpage',
		"url" 			=> PG_URL_HOMEPAGE,
		"inLanguage" 	=> 'vi',
		"name" 			=> ($setting['setting_metatitle_web'] ? $setting['setting_metatitle_web'] : $setting['setting_title_web']),
		"datePublished" => $setting['site_register_date'] . '+00:00',
		"dateModified" 	=> $setting['setting_sitemap_update'] . '+00:00',
		"description"	=> $setting['setting_description_web'],
		"isPartOf" 		=> array(
			"@type" 	=> "WebSite",
			"@id" 		=> PG_URL_HOMEPAGE . '#website',
			"url" 		=> PG_URL_HOMEPAGE,
			"name" 		=> $setting['setting_company'],
			"publisher" => array(
				"@type" 	=> 'Organization',
				"@id" 		=> PG_URL_HOMEPAGE . '#organization',
				"name" 		=> $setting['setting_company'],
				"url" 		=> PG_URL_HOMEPAGE,
				"sameAs" 	=> $setting['setting_facebook'],
				"sameAs" 	=> $setting['setting_youtube'],
				"sameAs" 	=> $setting['setting_google_plus'],
				"sameAs" 	=> $setting['setting_twitter'],
				"sameAs" 	=> $setting['setting_url_social'],
				"logo"		=> array(
					"@type"		=> 'ImageObject',
					"@id"		=> PG_URL_HOMEPAGE . '#logo',
					"url"		=> $setting['logo'],
					"width"		=> $setting['logo_w'],
					"height"	=> $setting['logo_h'],
					"caption"	=> ($setting['setting_title_web'] ? $setting['setting_title_web'] : $setting['setting_company'])
				),
				"image"		=> array(
					"@type"		=> 'ImageObject',
					"@id"		=> PG_URL_HOMEPAGE . '#cover',
					"url"		=> $setting['thumbnail'],
					"width"		=> $setting['thumbnail_w'],
					"height"	=> $setting['thumbnail_h'],
					"caption"	=> ($setting['setting_title_web'] ? $setting['setting_title_web'] : $setting['setting_company'])
				)
			),
			"potentialAction" => array(
				"@type"		=> 'SearchAction',
				"target"	=> array(
					"@type"			=> 'EntryPoint',
					"urlTemplate"	=> PG_URL_HOMEPAGE . 'search/{search_term_string}'
				),
				"query-input" => array(
					"@type"			=> 'PropertyValueSpecification',
					"valueRequired"	=> 'http://schema.org/True',
					"valueName"		=> 'search_term_string'
				)
			)
		)
	);
	return json_encode($arySchemaWebPage);
}

function schema_organization(){
	global $setting;

	$arySchema_organization = array(
		"@context" 		=> "http://schema.org",
		"@type"				=> 'Organization',
		"name"				=> ($setting['setting_title_web'] ? $setting['setting_title_web'] : $setting['setting_company']),
		"alternateName"		=> $setting['setting_author'],
		"url"				=> PG_URL_HOMEPAGE,
		"sameAs" 			=> $setting['setting_facebook'],
		"sameAs" 			=> $setting['setting_youtube'],
		"sameAs" 			=> $setting['setting_google_plus'],
		"sameAs" 			=> $setting['setting_twitter'],
		"sameAs" 			=> $setting['setting_url_social'],
		"logo"				=> array(
			"@type"				=> 'ImageObject',
			"url"				=> $setting['logo'],
			"width"				=> $setting['logo_w'],
			"height"			=> $setting['logo_h']
		)
	);
	return json_encode($arySchema_organization);
}

function schema_faq_page(){
	global $database, $site_id;

	$_sql = "SELECT answer_question, answer_reply FROM ".TBL_ANSWER." WHERE answer_status=1 AND answer_site_id = ".$site_id . " ORDER BY answer_ordering ASC, answer_id DESC";
	$_results = $database->db_query($_sql);
	while ( $_row = $database->db_fetch_assoc($_results) ){
		$_list_answers[] = $_row;
	}
	if ( isset($_list_answers) && $_list_answers && is_array($_list_answers) && !empty($_list_answers) ){
		$mainEntity = array();
		foreach ( $_list_answers as $ans){
			$mainEntity[] = array(
				"@type"				=> 'Question',
				"name"				=> $ans['answer_question'],
				"answerCount"		=> 1,
				"acceptedAnswer"	=> array(
					"@type"				=> 'Answer',
					"text"				=> $ans['answer_reply']
				)
			);
		}

		$arySchema_faq_page = array(
			"@context" 			=> "http://schema.org",
			"@type"				=> 'FAQPage',
			"name"				=> 'Các câu hỏi thường gặp',
			"mainEntity"		=> $mainEntity
		);
		return json_encode($arySchema_faq_page);
	}
	return false;
}

function schema_application_json(){
	global $setting;

	$arySchema = array(
		"@context" 		=> "http://schema.org",
        "@type" 		=> "Professionalservice",
        "@id" 			=> ( (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" : "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"),
        "url" 			=> ( (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" : "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"),
        "logo" 			=> $setting['logo'],
        "image" 		=> $setting['logo'],
        "priceRange" 	=> "25$-35$",
        "hasMap" 		=> $setting['setting_company_googlemap'],
        "email" 		=> "mailto:".$setting['setting_email'],
        "founder" 		=> $setting['setting_author'],
        "address" 		=> array(
            "@type" => "PostalAddress",
            "addressLocality" => $setting['setting_company_address_locality'],
            "addressCountry" => $setting['setting_company_address_country'],
            "addressRegion" => $setting['setting_company_address_region'],
            "postalCode" => $setting['setting_company_address_postalCode'],
            "streetAddress" => $setting['setting_company_address']
        ),
        "description" 	=> $setting['setting_company_description'],
        "name" 			=> $setting['setting_company'],
        "telephone" 	=> $setting['setting_hotline'],
		"openingHoursSpecification" => array(
			array(
			  "@type" => "OpeningHoursSpecification",
			  "dayOfWeek" => array(
					"Monday",
					"Tuesday",
					"Wednesday",
					"Thursday",
					"Friday"
				),
			  "opens" => "06:30",
			  "closes" => "18:00"
			),
			array(
				"@type" => "OpeningHoursSpecification",
				"dayOfWeek" => array(
					"Saturday"
				),
				"opens" 	=> "8:30",
				"closes" 	=> "17:30"
			)
		),
		"geo" => array(
				"@type" => "GeoCoordinates",
				"latitude" => $setting['setting_company_latitude'],
				"longitude" => $setting['setting_company_longitude']
		 ),
		"potentialAction" => array(
			"@type" => "ReserveAction",
				"target" => array(
						"@type" => "EntryPoint",
						"urlTemplate" => $setting['setting_company_urlTempalte'],
						"inLanguage" => "vn",
						"actionPlatform" => array(
							"http://schema.org/DesktopWebPlatform",
							"http://schema.org/IOSPlatform",
							"http://schema.org/AndroidPlatform"
						)
			),
			"result" => array(
				"@type" => "Reservation",
				"name" => "Đăng ký"
			)
		),
		"sameAs" => ((is_array($setting['setting_url_social']) && count($setting['setting_url_social']) && !empty($setting['setting_url_social'])) ? array_values($setting['setting_url_social']) : '')
	);
	return json_encode($arySchema);
}

function schema_application_json_user_seo(){
	global $setting;

	$arySchema = array(
		"@context" => "http://schema.org",
		"@type" => "Person",
		"name" => $setting['setting_seo_name'],
		"jobTitle" => $setting['setting_seo_job_title'],
		"image" => $setting['setting_seo_avatar'],
		"worksFor" => $setting['setting_company'],
		"url" => PG_URL_HOMEPAGE,
		"sameAs" => $setting['setting_seo_url_sameas'],
		"AlumniOf" => $setting['setting_seo_alumni_of'],
		"address" => array(
			"@type" => "PostalAddress",
			"addressLocality" 	=> $setting['setting_seo_address_locality'],
			"addressRegion" 	=> $setting['setting_seo_address_region']
		)
	);
	return json_encode($arySchema);
}

/**
 * @param bool|false $set_domain
 * @param bool|false $not_domain, if exist then array domain data
 * @return array|bool
 */
function get_list_sites($set_domain = false, $not_domain = false, $queryGroup = false, $valueGroup = false){
	global $database, $admin, $page, $check_on_localhost;

	$condition = '';
	if ( isset($admin) && is_object($admin) && $admin->admin_exists ){
		if ( $admin->admin_site_default['site_id'] && !$check_on_localhost ){
			if ( $admin->admin_super ){
				if ( $page != 'admin_setting' && $page != 'admin_user' && $page != 'admin_report_user' ){
					$condition = " AND site_id=" . $admin->admin_site_default['site_id'];
				}
			}else{
				$condition = " AND site_id=" . $admin->admin_site_default['site_id'];
			}
		}
	}

	if ( $queryGroup  ){
		$condition .= " AND site_group = " . $valueGroup;
	}

	$sql = "SELECT site_id, site_name FROM ".TBL_SITE." WHERE site_status=1" . $condition;
	$where = '';

	// Lay cac siteID theo quyen quan ly neu ko phai admin supper
	if ( isset($admin) && is_object($admin) && $admin->admin_exists ) {
		if ($admin->admin_info['admin_group'] != 1 && $admin->admin_info['admin_group'] != 4 && !$admin->admin_site_default['site_id']) {
			$query = "SELECT site_id FROM " . TBL_ADMIN_SITE . " WHERE admin_id=" . (int)$admin->admin_info['admin_id'];
			$results = $database->db_query($query);
			if (!$database->db_num_rows($results)) return FALSE;

			while (@$row = $database->db_fetch_assoc($results)) {
				$siteID[] = $row['site_id'];
			}
			$where = " AND site_id IN (" . implode(",", $siteID) . ")";

			if ($set_domain && isset($_COOKIE['fdomain']) && $_COOKIE['fdomain'] != '') {
				$where .= " AND site_domain='" . $_COOKIE['fdomain'] . "'";
			}
		}
	}

	// Not domain
	if ( $not_domain && is_array($not_domain) && count($not_domain)){
		foreach ( $not_domain as $d ){
			$where .= " AND site_domain != '{$d}'";
		}
	}

	// Lay array cac site
	$query = $sql.$where." ORDER BY site_name ASC";
	$results = $database->db_query($query);
	if (!$database->db_num_rows($results)) return FALSE;
	$sites = array();
	while (@$row = $database->db_fetch_assoc($results)){
		$sites[$row['site_id']] = $row['site_name'];
	}
	return $sites;
}

/*
 * GET DOMAIN ALLOW SITE_ID
 */
function get_domain_name($site_id){
	global $database;

	if ( !$site_id ) return false;

	$query = "SELECT site_domain FROM ".TBL_SITE." WHERE site_id = ".$site_id;
	$result = $database->db_query($query);
	if ( $row = $database->db_fetch_assoc($result) ){
		$site_domain = $row['site_domain'];
	}
	if ( isset($site_domain) && $site_domain ){
		return $site_domain;
	}
}

/*
 * ADMIN LIST SITE
 */
function admin_get_list_site_access($get_siteId = false){
	global $database, $admin;

	if ( isset($admin) && is_object($admin) && $admin->admin_exists ) {
		if ( $admin->admin_super || ($admin->admin_info['admin_group'] == 1) || ($admin->admin_info['admin_group'] == 4) ){
			$where = " WHERE 1";
		}else{
			$where = " WHERE A.admin_id=" . (int)$admin->admin_info['admin_id'];
		}
		$query = "SELECT DISTINCT S.site_id, S.site_domain FROM " . TBL_ADMIN_SITE . " A LEFT JOIN ".TBL_SITE. " S ON S.site_id = A.site_id" . $where;
		$results = $database->db_query($query);
		while ( $row = $database->db_fetch_assoc($results) ){
			$list[] = $get_siteId ? $row['site_id'] : $row['site_domain'];
		}
		if ( isset($list) && $list && count($list) && !empty($list) )
			return $list;
		else
			return false;
	}
	return false;
}

/*
 * CREATE FILE ROBOTS
 */
function create_robots(){
	global $setting, $site_id;

	if ( !$setting['setting_domain'] ){
		$setting['setting_domain'] = get_domain_name($site_id);
	}

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $setting['setting_domain'] . '/';

	$txtRobot = 'User-agent: *' . PHP_EOL;
	$txtRobot .= 'Allow: /' . PHP_EOL;
	$txtRobot .= 'Disallow: /qtidea/' . PHP_EOL;
	$txtRobot .= 'Disallow: /search/' . PHP_EOL;
	$txtRobot .= 'Sitemap: '.$base_url.'sitemap_'.$setting['setting_domain'].'.xml';

	return $txtRobot;
}

/*
 * CREATE SITEMAP XML FOR SITE
 */
function create_site_map(){
	global $database, $setting, $site_id, $rewriteClass;

	if ( !$site_id ) return false;

	if ( !$setting['setting_domain'] ){
		$setting['setting_domain'] = get_domain_name($site_id);
	}

	$timezone_offset = '+00:00';
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());

	$rewrite = $rewriteClass->getRewrite();

	$aryLink = array();

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $setting['setting_domain'] . '/';

	if ( !in_array($base_url, $aryLink) ){
		array_push_key($aryLink, $base_url, array('date' => $date, 'time' => $time, 'timezone_offset' => $timezone_offset));
		if ( $setting['setting_sitemap_saveDB'] ){
			save_site_map($site_id, $setting['setting_domain'], $base_url, $date, $time, $timezone_offset);
		}
	}

	// Get all menu of site
	$_mn_query = "SELECT link, link_rewrite, link_rewrite_compact FROM ".TBL_MENU." WHERE status=1 AND menu_site_id = ".$site_id." ORDER BY menutype, ordering ASC, menu_id DESC";
	$_mn_results = $database->db_query($_mn_query);
	while ( $_mnRow = $database->db_fetch_assoc($_mn_results) ){
		$link = ( $rewrite['rewrite_url_seo'] ? ($base_url . ($_mnRow['link_rewrite_compact'] ? $_mnRow['link_rewrite_compact'] : $_mnRow['link_rewrite'])) : $base_url . $_mnRow['link']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $date, 'time' => $time, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $date, $time, $timezone_offset);
			}
		}
	}

	// Get all categories of site
	$_cat_query = "SELECT category_id, category_alias, category_level, category_created FROM ".TBL_CATEGORY." WHERE category_status=1 AND category_site_id=".$site_id . " ORDER BY category_ordering ASC, category_id DESC";
	$_cat_results = $database->db_query($_cat_query);
	while ( $_catRow = $database->db_fetch_assoc($_cat_results) ){
		if ( isset($_catRow['category_created']) && $_catRow['category_created'] && $_catRow['category_created'] != '0000-00-00 00:00:00' ){
			$setDateCate = strtotime($_catRow['category_created']);
			$dateCat = date("Y-m-d", $setDateCate);
			$timeCat = date("H:i:s", $setDateCate);
		}
		$link = $rewriteClass->rewriteUrlCategory($_catRow['category_id'], $_catRow['category_alias'], $_catRow['category_level']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateCat, 'time' => $timeCat, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateCat, $timeCat, $timezone_offset);
			}
		}
	}

	// Get all page (tag) of site
	$_t_query = "SELECT tag_id, tag_alias, tag_directory, tag_created, tag_modified FROM ".TBL_TAG." WHERE tag_status=1 AND tag_site_id=".$site_id." ORDER BY tag_ordering ASC, tag_id DESC";
	$_t_results = $database->db_query($_t_query);
	while ( $_tRow = $database->db_fetch_assoc($_t_results) ){
		if ( isset($_tRow['tag_created']) && $_tRow['tag_created'] && $_tRow['tag_created'] == '0000-00-00 00:00:00' ){
			$_tRow['tag_created'] = false;
		}
		if ( isset($_tRow['tag_modified']) && $_tRow['tag_modified'] && $_tRow['tag_modified'] == '0000-00-00 00:00:00' ){
			$_tRow['tag_modified'] = false;
		}
		if ( $_tRow['tag_created'] || $_tRow['tag_modified'] ){
			$setDateTag = strtotime(($_tRow['tag_modified'] ? $_tRow['tag_modified'] : $_tRow['tag_created']));
			$dateTag = date("Y-m-d", $setDateTag);
			$timeTag = date("H:i:s", $setDateTag);
		}
		$link = $rewriteClass->rewriteUrlTag($_tRow['tag_id'], $_tRow['tag_alias'], $_tRow['category_level']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateTag, 'time' => $timeTag, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateTag, $timeTag, $timezone_offset);
			}
		}
	}

	// Get all static of site
	$_s_query = "SELECT static_id, static_alias, static_created, static_modified FROM ".TBL_STATIC." WHERE static_status=1 AND static_site_id=".$site_id." ORDER BY static_ordering ASC, static_id DESC";
	$_s_results = $database->db_query($_s_query);
	while ( $_sRow = $database->db_fetch_assoc($_s_results) ){
		if ( isset($_sRow['static_created']) && $_sRow['static_created'] && $_sRow['static_created'] == '0000-00-00 00:00:00' ){
			$_sRow['static_created'] = false;
		}
		if ( isset($_sRow['static_modified']) && $_sRow['static_modified'] && $_sRow['static_modified'] == '0000-00-00 00:00:00' ){
			$_sRow['static_modified'] = false;
		}
		if ( $_sRow['static_created'] || $_sRow['static_modified'] ){
			$setDateStatic = strtotime(($_sRow['static_modified'] ? $_sRow['static_modified'] : $_sRow['static_created']));
			$dateStatic = date("Y-m-d", $setDateStatic);
			$timeStatic = date("H:i:s", $setDateStatic);
		}
		$link = $rewriteClass->rewriteUrlPage($pageName = 'static', $_sRow['static_id'], $_sRow['static_alias']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateStatic, 'time' => $timeStatic, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateStatic, $timeStatic, $timezone_offset);
			}
		}
	}

	// Get all content of site
	$_c_query = "SELECT c.content_id, c.content_alias, c.content_created, c.content_modified, cat.category_alias FROM ".TBL_CONTENT." c LEFT JOIN ".TBL_CATEGORY." cat ON c.content_catid = cat.category_id WHERE c.content_status=1 AND c.content_site_id=".$site_id." AND cat.category_status=1 ORDER BY c.content_ordering ASC, c.content_id DESC";
	$_c_results = $database->db_query($_c_query);
	while ( $_cRow = $database->db_fetch_assoc($_c_results) ){
		if ( isset($_cRow['content_created']) && $_cRow['content_created'] && $_cRow['content_created'] == '0000-00-00 00:00:00' ){
			$_cRow['content_created'] = false;
		}
		if ( isset($_cRow['content_modified']) && $_cRow['content_modified'] && $_cRow['content_modified'] == '0000-00-00 00:00:00' ){
			$_cRow['content_modified'] = false;
		}
		if ( $_cRow['content_created'] || $_cRow['content_modified'] ){
			$setDateContent = strtotime(($_cRow['content_modified'] ? $_cRow['content_modified'] : $_cRow['content_created']));
			$dateContent = date("Y-m-d", $setDateContent);
			$timeContent = date("H:i:s", $setDateContent);
		}
		$link = $rewriteClass->rewriteUrlPage($pageName = 'content', $_cRow['content_id'], $_cRow['content_alias'], $_cRow['category_alias']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateContent, 'time' => $timeContent, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateContent, $timeContent, $timezone_offset);
			}
		}
	}

	// Get keywords
	$_k_query = "SELECT keyword, keyword_code, link_in_site, link_out_site, keyword_created, keyword_modified FROM ".TBL_KEYWORD." WHERE keyword_status=1 AND site_id=".$site_id." AND keyword_type < 3 ORDER BY keyword_count_search DESC, keyword ASC";
	$_k_results = $database->db_query($_k_query);
	while ( $_kRow = $database->db_fetch_assoc($_k_results) ){
		if ( isset($_kRow['keyword_created']) && $_kRow['keyword_created'] && $_kRow['keyword_created'] == '0000-00-00 00:00:00' ){
			$_kRow['keyword_created'] = false;
		}
		if ( isset($_kRow['keyword_modified']) && $_kRow['keyword_modified'] && $_kRow['keyword_modified'] == '0000-00-00 00:00:00' ){
			$_kRow['keyword_modified'] = false;
		}
		if ( $_kRow['keyword_created'] || $_kRow['keyword_modified'] ){
			$setDateKeyword = strtotime(($_kRow['keyword_modified'] ? $_kRow['keyword_modified'] : $_kRow['keyword_created']));
			$dateKeyword = date("Y-m-d", $setDateKeyword);
			$timeKeyword = date("H:i:s", $setDateKeyword);
			$timeKeyword = date("H:i:s", $setDateKeyword);
		}
		$link = '';
		if ( $_kRow['link_in_site'] ){
			$link = $_kRow['link_in_site'];
		}else if ( $_kRow['link_out_site'] ){
			$link = $_kRow['link_out_site'];
		}else{
			$link = PG_URL_HOMEPAGE . 'keyword/' . $_kRow['keyword_code'] . '.html';
		}
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateKeyword, 'time' => $timeKeyword, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateKeyword, $timeKeyword, $timezone_offset);
			}
		}
	}

	if ( isset($setting['site_access']) && is_array($setting['site_access']) && count($setting['site_access']) && !empty($setting['site_access']) ){
		if ( in_array(SITE_EDUCATE, $setting['site_access']) ){
			// Get all school of site
			$_nt_query = "SELECT ma_truong, bi_danh, ten_truong, created, last_activity FROM nha_truong WHERE trang_thai = 1 AND site_id = " . $site_id . " ORDER BY ten_truong";
			$_nt_results = $database->db_query($_nt_query);
			while ( $_nt_row = $database->db_fetch_assoc($_nt_results) ){
				if ( isset($_nt_row['created']) && $_nt_row['created'] && $_nt_row['created'] == '0000-00-00 00:00:00' ){
					$_nt_row['created'] = false;
				}
				if ( isset($_nt_row['last_activity']) && $_nt_row['last_activity'] && $_nt_row['last_activity'] == '0000-00-00 00:00:00' ){
					$_nt_row['last_activity'] = false;
				}
				if ( $_nt_row['created'] || $_nt_row['last_activity'] ){
					$setDateSchool = strtotime(($_nt_row['last_activity'] ? $_nt_row['last_activity'] : $_nt_row['created']));
					$dateSchool = date("Y-m-d", $setDateSchool);
					$timeSchool = date("H:i:s", $setDateSchool);
				}

				$link = $rewriteClass->rewriteUrlSchool($_nt_row['bi_danh']);
				if ( !in_array($link, $aryLink) ){
					array_push_key($aryLink, $link, array('date' => $dateSchool, 'time' => $timeSchool, 'timezone_offset' => $timezone_offset));
					if ( $setting['setting_sitemap_saveDB'] ) {
						save_site_map($site_id, $setting['setting_domain'], $link, $dateSchool, $timeSchool, $timezone_offset);
					}
				}
			}
		}
		if ( in_array(SITE_PRODUCT, $setting['site_access']) ){
			// Get all product of site
			$_p_query = "SELECT p.product_id, p.product_alias, p.product_created, p.product_modified, cat.category_alias FROM ".TBL_PRODUCT." p LEFT JOIN ".TBL_CATEGORY." cat ON p.product_catid = cat.category_id WHERE p.product_status=1 AND p.product_site_id=".$site_id." AND cat.category_status=1 ORDER BY p.product_ordering ASC, p.product_id DESC";
			$_p_results = $database->db_query($_p_query);
			while ( $_pRow = $database->db_fetch_assoc($_p_results) ){
				if ( isset($_pRow['product_created']) && $_pRow['product_created'] && $_pRow['product_created'] == '0000-00-00 00:00:00' ){
					$_pRow['product_created'] = false;
				}
				if ( isset($_pRow['product_modified']) && $_pRow['product_modified'] && $_pRow['product_modified'] == '0000-00-00 00:00:00' ){
					$_pRow['product_modified'] = false;
				}
				if ( $_pRow['product_created'] || $_pRow['product_modified'] ){
					$setDateProduct = strtotime(($_pRow['product_modified'] ? $_pRow['product_modified'] : $_pRow['product_created']));
					$dateProduct = date("Y-m-d", $setDateProduct);
					$timeProduct = date("H:i:s", $setDateProduct);
				}
				$link = $rewriteClass->rewriteUrlPage($pageName = 'product', $_pRow['product_id'], $_pRow['product_alias'], $_pRow['category_alias']);
				if ( !in_array($link, $aryLink) ){
					array_push_key($aryLink, $link, array('date' => $dateProduct, 'time' => $timeProduct, 'timezone_offset' => $timezone_offset));
					if ( $setting['setting_sitemap_saveDB'] ) {
						save_site_map($site_id, $setting['setting_domain'], $link, $dateProduct, $timeProduct, $timezone_offset);
					}
				}
			}
		}
		if ( in_array(SITE_BDS, $setting['site_access']) ){
			// Get tktc of site
			$_design_filed = array(
				'd.construction_design_id',
				'd.construction_design_name',
				'd.construction_design_alias',
				'd.construction_design_created',
				'd.construction_design_lastupdate'
			);
			if ( is_array($_design_filed) && !empty($_design_filed) )
				$_design_filed = implode(",", $_design_filed);
			else
				$_design_filed = " * ";

			$sql_tktcs = 'SELECT
						'.$_design_filed.',
						cat.category_id,
						cat.category_level,
						cat.category_name,
						cat.category_alias,
						cat.category_root_id
					FROM tbl_construction_designs d
					    LEFT JOIN '.TBL_CATEGORY.' cat ON d.construction_design_category_id = cat.category_id
					WHERE cat.category_status=1 AND cat.category_type='.SITE_BDS.' AND d.construction_design_status=1
						'.($site_id ? " AND d.construction_design_site_id=".$site_id : "").'
					GROUP BY d.construction_design_id
					ORDER BY d.construction_design_ordering ASC, d.construction_design_created DESC
				';
			$result_tktcs = $database->db_query($sql_tktcs);
			while ( $row_tktc = $database->db_fetch_assoc($result_tktcs) ){
				if ( isset($row_tktc['construction_design_created']) && $row_tktc['construction_design_created'] && ($row_tktc['construction_design_created'] == '0000-00-00 00:00:00' || $row_tktc['construction_design_created'] == '(NULL)') ){
					$row_tktc['construction_design_created'] = false;
				}
				if ( isset($row_tktc['construction_design_lastupdate']) && $row_tktc['construction_design_lastupdate'] && ($row_tktc['construction_design_lastupdate'] == '0000-00-00 00:00:00' || $row_tktc['construction_design_lastupdate'] == '(NULL)') ){
					$row_tktc['construction_design_lastupdate'] = false;
				}
				if ( $row_tktc['construction_design_created'] || $row_tktc['construction_design_lastupdate'] ){
					$setDateTktc = strtotime(($row_tktc['construction_design_lastupdate'] ? $row_tktc['construction_design_lastupdate'] : $row_tktc['construction_design_created']));
					$dateTktc = date("Y-m-d", $setDateTktc);
					$timeTktc = date("H:i:s", $setDateTktc);
				}
				$link = $rewriteClass->rewriteUrlPage($pageName = 'construction_design', $row_tktc['construction_design_id'], $row_tktc['construction_design_alias'], $row_tktc["category_alias"]);
				if ( !in_array($link, $aryLink) ){
					array_push_key($aryLink, $link, array('date' => $dateTktc, 'time' => $timeTktc, 'timezone_offset' => $timezone_offset));
					if ( $setting['setting_sitemap_saveDB'] ) {
						save_site_map($site_id, $setting['setting_domain'], $link, $dateTktc, $timeTktc, $timezone_offset);
					}
				}
			}
			// Get all section bds of site
			$_bds_sections = array(
				1 => 'Mua bán',
				2 => 'Cho thuê'
			);
			$arrData = array();
			$_query = "SELECT bds_section_id, bds_section_name, bds_section_alias, bds_section_created, bds_section_modified
                        FROM tbl_bds_sections
                         WHERE bds_section_status=1 AND bds_section_site_id=".$site_id."
                         ORDER BY bds_section_ordering ASC, bds_section_modified, bds_section_created DESC";
			$_results = $database->db_query($_query);
			while ( $_row = $database->db_fetch_assoc($_results) ){
				if ( isset($_row['bds_section_created']) && $_row['bds_section_created'] && ($_row['bds_section_created'] == '0000-00-00 00:00:00' || $_row['bds_section_created'] == '(NULL)') ){
					$_row['bds_section_created'] = false;
				}
				if ( isset($_row['bds_section_modified']) && $_row['bds_section_modified'] && ($_row['bds_section_modified'] == '0000-00-00 00:00:00' || $_row['bds_section_modified'] == '(NULL)') ){
					$_row['bds_section_modified'] = false;
				}
				if ( $_row['bds_section_created'] || $_row['bds_section_modified'] ){
					$setDateSection = strtotime(($_row['bds_section_modified'] ? $_row['bds_section_modified'] : $_row['bds_section_created']));
					$dateSection = date("Y-m-d", $setDateSection);
					$timeSection = date("H:i:s", $setDateSection);
				}
				$link = $rewriteClass->rewriteUrlBdsSection($_row["bds_section_alias"]);
				if ( !in_array($link, $aryLink) ){
					array_push_key($aryLink, $link, array('date' => $dateSection, 'time' => $timeSection, 'timezone_offset' => $timezone_offset));
					if ( $setting['setting_sitemap_saveDB'] ) {
						save_site_map($site_id, $setting['setting_domain'], $link, $dateSection, $timeSection, $timezone_offset);
					}
				}
				array_push_key($arrData, $_row['bds_section_id'], $_row['bds_section_name']);
			}

			if ( is_array($arrData) && count($arrData) && !empty($arrData) ){
				array_unique($arrData);
				$_bds_sections = $arrData;
			}

			// Get all project bds of site
			$_project_query = "SELECT bds_project_id, bds_project_name, bds_project_alias, bds_project_created, bds_project_lastupdate
								FROM tbl_bds_projects
								WHERE bds_project_status=1 AND bds_project_site_id=".$site_id."
								ORDER BY bds_project_ordering ASC, bds_project_id DESC
								";
			$_project_results = $database->db_query($_project_query);
			while ($_project_row = $database->db_fetch_assoc($_project_results)){
				if ( isset($_project_row['bds_project_created']) && $_project_row['bds_project_created'] && ($_project_row['bds_project_created'] == '0000-00-00 00:00:00' || $_project_row['bds_project_created'] == '(NULL)') ){
					$_project_row['bds_project_created'] = false;
				}
				if ( isset($_project_row['bds_project_lastupdate']) && $_project_row['bds_project_lastupdate'] && ($_project_row['bds_project_lastupdate'] == '0000-00-00 00:00:00' || $_project_row['bds_project_lastupdate'] == '(NULL)') ){
					$_project_row['bds_project_lastupdate'] = false;
				}
				if ( $_project_row['bds_project_created'] || $_project_row['bds_project_lastupdate'] ){
					$setDateProjectBds = strtotime(($_project_row['bds_project_lastupdate'] ? $_project_row['bds_project_lastupdate'] : $_project_row['bds_project_created']));
					$dateProjectBds = date("Y-m-d", $setDateProjectBds);
					$timeProjectBds = date("H:i:s", $setDateProjectBds);
				}
				$link = $rewriteClass->rewriteUrlBdsProject($_project_row["bds_project_alias"]);
				if ( !in_array($link, $aryLink) ){
					array_push_key($aryLink, $link, array('date' => $dateProjectBds, 'time' => $timeProjectBds, 'timezone_offset' => $timezone_offset));
					if ( $setting['setting_sitemap_saveDB'] ) {
						save_site_map($site_id, $setting['setting_domain'], $link, $dateProjectBds, $timeProjectBds, $timezone_offset);
					}
				}
			}

			// Get all bds of site
			$_bds_query = 'SELECT
						bds.bds_id,
						bds.bds_alias,
						bds.bds_section,
						bds.bds_created,
						bds.bds_lastupdate
					FROM tbl_bds AS bds
					WHERE bds.bds_status=1 AND bds.bds_site_id = '.$site_id.'
					GROUP BY bds.bds_id
					ORDER BY bds.bds_ordering ASC, bds.bds_lastupdate DESC';
			$_bds_results = $database->db_query($_bds_query);
			while ( $_bdsRow = $database->db_fetch_assoc($_bds_results) ){
				// Section alias
				$section_alias				        = convertKhongdau($_bds_sections[$_bdsRow['bds_section']]);
				$_bdsRow['bds_section_alias']      	= generateSlug($section_alias, strlen($section_alias));

				if ( isset($_bdsRow['bds_created']) && $_bdsRow['bds_created'] && $_bdsRow['bds_created'] == '0000-00-00 00:00:00' ){
					$_bdsRow['bds_created'] = false;
				}
				if ( isset($_bdsRow['bds_lastupdate']) && $_bdsRow['bds_lastupdate'] && $_bdsRow['bds_lastupdate'] == '0000-00-00 00:00:00' ){
					$_bdsRow['bds_lastupdate'] = false;
				}
				if ( $_bdsRow['bds_created'] || $_bdsRow['bds_lastupdate'] ){
					$setDateBds = strtotime(($_bdsRow['bds_lastupdate'] ? $_bdsRow['bds_lastupdate'] : $_bdsRow['bds_created']));
					$dateBds = date("Y-m-d", $setDateBds);
					$timeBds = date("H:i:s", $setDateBds);
				}
				$link = $rewriteClass->rewriteUrlPage($pageName = 'bds', $_bdsRow['bds_id'], $_bdsRow['bds_alias'], $_bdsRow['bds_section_alias']);
				if ( !in_array($link, $aryLink) ){
					array_push_key($aryLink, $link, array('date' => $dateBds, 'time' => $timeBds, 'timezone_offset' => $timezone_offset));
					if ( $setting['setting_sitemap_saveDB'] ) {
						save_site_map($site_id, $setting['setting_domain'], $link, $dateBds, $timeBds, $timezone_offset);
					}
				}
			}
		}

		// Get all keyword of site (trend)
		$_tr_query = "SELECT keyword_code, keyword_created, keyword_modified FROM ".TBL_KEYWORD." WHERE keyword_status=1 AND site_id=".$site_id." ORDER BY keyword_code";
		$_tr_result = $database->db_query($_tr_query);
		while ( $_trrow = $database->db_fetch_assoc($_tr_result) ){
			if ( isset($_trrow['keyword_created']) && $_trrow['keyword_created'] && $_trrow['keyword_created'] == '0000-00-00 00:00:00' ){
				$_trrow['keyword_created'] = false;
			}
			if ( isset($_trrow['keyword_modified']) && $_trrow['keyword_modified'] && $_trrow['keyword_modified'] == '0000-00-00 00:00:00' ){
				$_trrow['keyword_modified'] = false;
			}
			if ( $_trrow['keyword_created'] || $_trrow['keyword_modified'] ){
				$setDateTrend = strtotime(($_trrow['keyword_modified'] ? $_trrow['keyword_modified'] : $_trrow['keyword_created']));
				$dateTrend = date("Y-m-d", $setDateTrend);
				$timeTrend = date("H:i:s", $setDateTrend);
			}
			$link = PG_URL_HOMEPAGE . 'search/'.$_trrow['keyword_code'].'.html';
			if ( !in_array($link, $aryLink) ){
				array_push_key($aryLink, $link, array('date' => $dateTrend, 'time' => $timeTrend, 'timezone_offset' => $timezone_offset));
				if ( $setting['setting_sitemap_saveDB'] ) {
					save_site_map($site_id, $setting['setting_domain'], $link, $dateTrend, $timeTrend, $timezone_offset);
				}
			}
		}
	}
	return $aryLink;
}
function save_site_map($site_id, $site_domain, $url, $date, $time, $timezone){
	global $database, $setting;

	if ( !$setting['setting_sitemap_saveDB'] ){
		return false;
	}

	if ( !$site_id || !$site_domain || !$url || !$date || !$time || !$timezone )
		return false;

	$query = "INSERT INTO ".TBL_SITEMAP."(site_id, site_domain, url, date, time, timezone_offset, created)
			VALUES(
				".$site_id.",
				'".$site_domain."',
				'".$url."',
				'".$date."',
				'".$time."',
				'".$timezone."',
				'".date("Y-m-d H:i:s", time())."'
			)
			ON DUPLICATE KEY UPDATE
				date = '".$date."',
				time = '".$time."'
			";
	$database->db_query($query);
}
function update_sitemap(){
	global $database, $site_id, $setting, $datetime;

	if ( !$site_id || !$setting['setting_id'] ) return false;

	// Create site map
	define ("OUTPUT_FILE", "sitemap_".$setting['setting_domain'].".xml");
	define ("VERSION", "2.4");
	define ("FREQUENCY", "weekly");

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $setting['setting_domain'] . '/';

	$pf = fopen (DIR_ROOT . OUTPUT_FILE, "w");
	if (!$pf)
	{
		echo "ERROR: Cannot create " . OUTPUT_FILE . "!" . NL;
		return;
	}

	fwrite ($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
		"<?xml-stylesheet type=\"text/xsl\" href='".PG_URL_HOMEPAGE."templates/sitemap/sitemap.xsl'?>\n" .
		"<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n" .
		"        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
		"        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n" .
		"        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n");


	$aryLink = create_site_map();

	$text_mml = '';
	foreach( $aryLink as $link => $data )
	{
		$text_mml.= '<url>' . PHP_EOL;
		$text_mml.= '<loc>'. $link .'</loc>' . PHP_EOL;
		$text_mml.= '<lastmod>'.$data['date'].'T'.$data['time'].$data['timezone_offset'].'</lastmod>';
		$text_mml.= '<priority>0.80</priority>';
		$text_mml.= '<changefreq>weekly</changefreq>' . PHP_EOL;
		$text_mml.= '</url>' . PHP_EOL;
	}
	fwrite ($pf, $text_mml);

	fwrite ($pf, "</urlset>\n");
	fclose ($pf);

	//Update DB
	$query = "UPDATE ".TBL_SETTING." SET setting_sitemap_update = '".$datetime->timestampToDateTime()."' WHERE setting_id=" . $setting['setting_id'];
	$database->db_query($query);
}

function create_site_map_cat(){
	global $database, $setting, $site_id, $rewriteClass;

	if ( !$site_id ) return false;

	if ( !$setting['setting_domain'] ){
		return false;
		//$setting['setting_domain'] = get_domain_name();
	}

	$timezone_offset = '+00:00';
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());

	$rewrite = $rewriteClass->getRewrite();

	$aryLink = array();

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $setting['setting_domain'] . '/';

	if ( !in_array($base_url, $aryLink) ){
		array_push_key($aryLink, $base_url, array('date' => $date, 'time' => $time, 'timezone_offset' => $timezone_offset));
		if ( $setting['setting_sitemap_saveDB'] ){
			save_site_map($site_id, $setting['setting_domain'], $base_url, $date, $time, $timezone_offset);
		}
	}


	// Get all categories of site
	$_cat_query = "SELECT category_id, category_alias, category_level, category_created FROM ".TBL_CATEGORY." WHERE category_status=1 AND category_site_id=".$site_id . " ORDER BY category_ordering ASC, category_id DESC";
	$_cat_results = $database->db_query($_cat_query);
	while ( $_catRow = $database->db_fetch_assoc($_cat_results) ){
		if ( isset($_catRow['category_created']) && $_catRow['category_created'] && $_catRow['category_created'] != '0000-00-00 00:00:00' ){
			$setDateCate = strtotime($_catRow['category_created']);
			$dateCat = date("Y-m-d", $setDateCate);
			$timeCat = date("H:i:s", $setDateCate);
		}
		$link = $rewriteClass->rewriteUrlCategory($_catRow['category_id'], $_catRow['category_alias'], $_catRow['category_level']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateCat, 'time' => $timeCat, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateCat, $timeCat, $timezone_offset);
			}
		}
	}

	return $aryLink;
}

function create_site_map_school(){
	global $database, $setting, $site_id, $rewriteClass;

	if ( !$site_id ) return false;

	if ( !$setting['setting_domain'] ){
		return false;
		//$setting['setting_domain'] = get_domain_name();
	}

	$timezone_offset = '+00:00';
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());

	$rewrite = $rewriteClass->getRewrite();

	$aryLink = array();

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $setting['setting_domain'] . '/';

	if ( !in_array($base_url, $aryLink) ){
		array_push_key($aryLink, $base_url, array('date' => $date, 'time' => $time, 'timezone_offset' => $timezone_offset));
		if ( $setting['setting_sitemap_saveDB'] ) {
			save_site_map($site_id, $setting['setting_domain'], $base_url, $date, $time, $timezone_offset);
		}
	}

	// Get all school of site
	$_s_query = "SELECT id, bi_danh, ten_truong, created, last_activity FROM ".TS_NHA_TRUONG." WHERE trang_thai=1 AND site_id=".$site_id . " ORDER BY id DESC";
	$_s_results = $database->db_query($_s_query);
	while ( $_sRow = $database->db_fetch_assoc($_s_results) ){
		if ( isset($_sRow['created']) && $_sRow['created'] && $_sRow['created'] == '0000-00-00 00:00:00' ){
			$_sRow['created'] = false;
		}
		if ( isset($_sRow['last_activity']) && $_sRow['last_activity'] && $_sRow['last_activity'] == '0000-00-00 00:00:00' ){
			$_sRow['last_activity'] = false;
		}
		if ( $_sRow['created'] || $_sRow['last_activity'] ){
			$setDateSchool = strtotime(($_sRow['last_activity'] ? $_sRow['last_activity'] : $_sRow['created']));
			$dateSchool = date("Y-m-d", $setDateSchool);
			$timeSchool = date("H:i:s", $setDateSchool);
		}
		$link = $rewriteClass->rewriteUrlSchool($_sRow['bi_danh']);
		if ( !in_array($link, $aryLink) ){
			array_push_key($aryLink, $link, array('date' => $dateSchool, 'time' => $timeSchool, 'timezone_offset' => $timezone_offset));
			if ( $setting['setting_sitemap_saveDB'] ) {
				save_site_map($site_id, $setting['setting_domain'], $link, $dateSchool, $timeSchool, $timezone_offset);
			}
		}
	}
	return $aryLink;
}

function create_site_map_content(){
	global $database, $setting, $datetime, $site_id, $rewriteClass;

	if ( !$site_id ) return false;

	if ( !$setting['setting_domain'] ){
		return false;
		//$setting['setting_domain'] = get_domain_name();
	}

	$timezone_offset = '+00:00';
	$date = date("Y-m-d", time());
	$time = date("H:i:s", time());

	$rewrite = $rewriteClass->getRewrite();

	$aryLink = array();
	$first_day = date('Y-m-01');
	$last_day = date('Y-m-d',strtotime('+1 MONTHS', strtotime($first_day)));

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $setting['setting_domain'] . '/';

	if ( !in_array($base_url, $aryLink) ){
		array_push_key($aryLink, $base_url, array('date' => $date, 'time' => $time, 'timezone_offset' => $timezone_offset));
		if ( $setting['setting_sitemap_saveDB'] ) {
			save_site_map($site_id, $setting['setting_domain'], $base_url, $date, $time, $timezone_offset);
		}
	}

	$aryDataLink = array();

	$max_min_query = "SELECT MAX(content_created) AS MaxDate, MIN(content_created) AS MinDate FROM ".TBL_CONTENT." WHERE content_status = 1 AND content_site_id = " . $site_id;
	$_result_minmax = $database->db_query($max_min_query);
	if ( $rowMinMax = $database->db_fetch_assoc($_result_minmax) ){
		$aryMonth = $datetime->get_months($rowMinMax['MinDate'], $rowMinMax['MaxDate']);
		if ( is_array($aryMonth) && !empty($aryMonth) && count($aryMonth) ){
			foreach ( $aryMonth as $m_key => $m_value ){
				// Get all content in site of month
				$aryDateLink = array();
				$start_date = date('Y-m-01', strtotime($m_value));
				$this_month = date("Y-m", strtotime($m_value));

				$date_c_query = "SELECT c.content_id, c.content_alias, c.content_created, c.content_modified, cat.category_alias FROM ".TBL_CONTENT." c LEFT JOIN ".TBL_CATEGORY." cat ON c.content_catid = cat.category_id WHERE c.content_status=1 AND c.content_site_id=".$site_id." AND cat.category_status=1
    								AND content_created >='".$start_date."' AND content_created < '".$m_value."' ORDER BY c.content_ordering ASC, c.content_id DESC";
				$date_c_results = $database->db_query($date_c_query);
				while ( $_cRow = $database->db_fetch_assoc($date_c_results) ){
					if ( isset($_cRow['content_created']) && $_cRow['content_created'] && $_cRow['content_created'] == '0000-00-00 00:00:00' ){
						$_cRow['content_created'] = false;
					}
					if ( isset($_cRow['content_modified']) && $_cRow['content_modified'] && $_cRow['content_modified'] == '0000-00-00 00:00:00' ){
						$_cRow['content_modified'] = false;
					}
					if ( $_cRow['content_created'] || $_cRow['content_modified'] ){
						$setDateContent = strtotime(($_cRow['content_modified'] ? $_cRow['content_modified'] : $_cRow['content_created']));
						$dateContent = date("Y-m-d", $setDateContent);
						$timeContent = date("H:i:s", $setDateContent);
					}
					$link = $rewriteClass->rewriteUrlPage($pageName = 'content', $_cRow['content_id'], $_cRow['content_alias'], $_cRow['category_alias']);
					if ( !in_array($link, $aryDateLink) ){
						array_push_key($aryDateLink, $link, array('date' => $dateContent, 'time' => $timeContent, 'timezone_offset' => $timezone_offset));
						if ( $setting['setting_sitemap_saveDB'] ) {
							save_site_map($site_id, $setting['setting_domain'], $link, $dateContent, $timeContent, $timezone_offset);
						}
					}
				}
				array_push_key($aryDataLink, $this_month, $aryDateLink);
			}
		}
	}
	return $aryDataLink;
}
function create_sitemap_contents_temp( array $aryDateLink, $domain, $this_month){
	$OUTPUT_FILE = "sitemap_".$domain."_contents_".str_replace("-", "_", $this_month).".xml";
	$VERSION = "2.4";
	$FREQUENCY = "weekly";

	$ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
	$base_url = $ssl . '://' . $domain . '/';

	$pf = fopen (DIR_ROOT . $OUTPUT_FILE, "w");
	if (!$pf)
	{
		echo "ERROR: Cannot create " . $OUTPUT_FILE . "!" . NL;
		return;
	}

	fwrite ($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
		"<?xml-stylesheet type=\"text/xsl\" href='".PG_URL_HOMEPAGE."templates/sitemap/sitemap.xsl'?>\n" .
		"<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n" .
		"        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
		"        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n" .
		"        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n");

	$text_mml = '';
	foreach( $aryDateLink as $link => $data )
	{
		$text_mml.= '<url>' . PHP_EOL;
		$text_mml.= '<loc>'. $link .'</loc>' . PHP_EOL;
		$text_mml.= '<lastmod>'.$data['date'].'T'.$data['time'].$data['timezone_offset'].'</lastmod>';
		$text_mml.= '<priority>0.80</priority>';
		$text_mml.= '<changefreq>'.$FREQUENCY.'</changefreq>' . PHP_EOL;
		$text_mml.= '</url>' . PHP_EOL;
	}
	fwrite ($pf, $text_mml);

	fwrite ($pf, "</urlset>\n");
	fclose ($pf);
}
/*
 * END: CREATE SITEMAP XML FOR SITE
 */


function copy_files_to_site($source, $dest){
    if(is_dir($source)) {
        $dir_handle=opendir($source);
        while($file=readdir($dir_handle)){
            if($file!="." && $file!=".."){
                if(is_dir($source."/".$file)){
                    if(!is_dir($dest."/".$file)){
                        mkdir($dest."/".$file);
                    }
                    cpy($source."/".$file, $dest."/".$file);
                } else {
                    copy($source."/".$file, $dest."/".$file);
                }
            }
        }
        closedir($dir_handle);
    } else {
        copy($source, $dest);
    }
}

/**
 * Get list modules install
 */
function get_modules_install(){
	global $database, $sites, $admin;

	$whereModuleInstall[] = "m.module_status = 1";
	if ( !$admin->admin_site_default ){
		$where[] = "sm.site_id IN (".implode(",", array_flip($sites)).")";
	}else{
		$whereModuleInstall[] = "sm.site_id = " . $admin->admin_site_default['site_id'];
	}
	$whereModuleInstall = (count($whereModuleInstall) ? ' WHERE '.implode(' AND ', $whereModuleInstall) : '');

	$query = "SELECT m.module_id, m.module_code, m.module_title, m.module_description, sm.site_id"
		. " FROM " . TBL_MODULE . " AS m LEFT JOIN " . TBL_SITE_MODULE . " AS sm ON m.module_id = sm.module_id"
		. $whereModuleInstall
		. " ORDER BY m.module_ordering ASC, m.module_id DESC";
	$results = $database->db_query($query);
	while ( $row = $database->db_fetch_assoc($results) ){
		$row['exist'] = false;
		$list_modules[$row['module_code']] = $row;
	}
	//print_r($list_modules); die;

	if ( isset($list_modules) && $list_modules )
		return $list_modules;
	else
		return false;
}

/*
 * Get instant articel facebook
 */
function get_instant_article_rss(){
	global $database, $rewriteClass, $setting, $site_id;

	if ( !$setting['setting_facebook_instant_article'] || !$site_id )
		return false;

	$where = ' WHERE c.content_status=1 AND c.content_allow_show=1 AND c.content_fulltext_instant_article <> ""' . ($site_id ? " AND c.content_site_id=".$site_id : "");
	$groupBy = ' GROUP BY c.content_id';
	$orderBy = " ORDER BY c.content_ordering ASC, c.content_created DESC";
	if ( $setting['setting_update_newdate'] ){
		$orderBy = " ORDER BY c.content_ordering ASC, c.content_modified DESC, c.content_created DESC";
	}
	$wLimit = " LIMIT 0, 10";

	$sql = 'SELECT c.content_id,
					c.content_catid,
					c.content_title,
					c.content_alias,
					c.content_add_link,
					c.content_introtext,
					c.content_fulltext_instant_article,
					c.content_image_thumbnail,
					c.content_image_large,
					c.content_image_social,
					c.content_created,
					c.content_created_by,
					c.content_modified,
					cat.category_id,
					cat.category_level,
					cat.category_name,
					cat.category_alias,
					ad.admin_name';
	$sql .= ' FROM '.TBL_CONTENT.' c';
	$sql .= ' LEFT JOIN '.TBL_CATEGORY.' cat';
	$sql .= ' ON c.content_catid = cat.category_id';
	$sql .= ' LEFT JOIN '.TBL_ADMIN.' ad';
	$sql .= ' ON c.content_created_by = ad.admin_id';
	$sql .= $where . $groupBy . $orderBy . $wLimit;
	$result = $database->db_query($sql);
	while ( $row = $database->db_fetch_assoc($result) ){
		/*-- Image tiny, thumbnail, large --*/
		$row["tiny_thumbnail"]  = showImageSubject(($row["content_image_thumbnail"] ? $row["content_image_thumbnail"] : $row["content_image_large"]), TBL_CONTENT, $image_params = 'tiny');
		$row["image_thumbnail"] = showImageSubject(($row["content_image_thumbnail"] ? $row["content_image_thumbnail"] : $row["content_image_large"]), TBL_CONTENT, $image_params = 'thumbnail');
		$row["image_large"]     = showImageSubject(($row["content_image_large"] ? $row["content_image_large"] : $row["content_image_thumbnail"]), TBL_CONTENT, $image_params = 'large');
		$row["image_normal"]    = showImageSubject(($row["content_image_large"] ? $row["content_image_large"] : $row["content_image_thumbnail"]), TBL_CONTENT, $image_params = 'normal');
		$row["image_original"]  = showImageSubject(($row["content_image_large"] ? $row["content_image_large"] : $row["content_image_thumbnail"]), TBL_CONTENT, $image_params = 'banner');
		$row["image_social"]  = showImageSubject(($row["content_image_social"] ? $row["content_image_social"] : ($row["content_image_large"] ? $row["content_image_large"] : $row["content_image_thumbnail"])), TBL_CONTENT, $image_params = 'banner');

		$row['pubDate'] = date(DATE_RSS, strtotime($row['content_created']));
		$row['modDate'] = date(DATE_RSS, strtotime($row['content_modified']));

		$row['content_fulltext_instant_article'] = htmlspecialchars(htmlentities($row['content_fulltext_instant_article']));
		if ( isset($row['content_add_link']) && $row['content_add_link'] ){
			$row['link'] = $row['content_add_link'];
		}else{
			$row['link'] = $rewriteClass->rewriteUrlPage($pageName = 'content', $row['content_id'], $row['content_alias'], $row["category_alias"]);
		}
		if (isset($row['category_id']) && isset($row['category_name']) && isset($row['category_level'])) {
			$row['linkcat'] = $rewriteClass->rewriteUrlCategory($row['category_id'], $row['category_alias'], $row["category_level"]);
		}
		$list_rss[] = $row;
	}
	if ( isset($list_rss) && $list_rss ){
		return $list_rss;
	}
	return false;
}
?>