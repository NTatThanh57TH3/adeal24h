<?php
defined('PG_PAGE') or die();
require_once 'phpmailer/class.phpmailer.php';
require_once "include/phpmailer/class.smtp.php";

define('EMAIL_TYPE_ADMIN', 1);
define('EMAIL_TYPE_USER', 2);
define('EMAIL_TYPE_ORDER', 3);
define('EMAIL_TYPE_CUSTOMER', 4);

function send_gmail($email, $subject, $message, $email_cc = false, $send_error = false, $order_id = false ){
	global $database, $setting, $check_on_localhost;

	$setting_email = ( $setting['setting_email'] ? $setting['setting_email'] : $setting['setting_support_email']);

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = $setting['gmail_protocol'];
	$mail->SMTPAuth = true;
	$mail->Host = 'smtp.gmail.com'; // "ssl://smtp.gmail.com" didn't worked
	$mail->Port = ( $check_on_localhost ? $setting['gmail_smtpport'] : 587 );
	$mail->SMTPSecure = ( $check_on_localhost ? 'ssl' : 'tls' );
	$mail->CharSet = $setting['gmail_charset'];
	// or try these settings (worked on XAMPP and WAMP):
	// $mail->Port = 587;
	// $mail->SMTPSecure = 'tls';

	$mail->Username = $setting['gmail_smtpuser'];
	$mail->Password = $setting['gmail_smtppass'];

	$mail->IsHTML(true); // if you are going to send HTML formatted emails
	$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

	$mail->From = $setting['setting_email'];
	$mail->SingleTo = $email;
	$mail->FromName = $setting['setting_company'];

	$aryEmail = explode(",", $email);
	if ( is_array($aryEmail) && !empty($aryEmail) && (count($aryEmail) > 1) ){
		foreach($aryEmail as $a_email){
			$mail->addAddress($a_email,"");
		}
	}else{
		$mail->addAddress($email,"");
	}

	if ( !$send_error ){
		if ( $setting['setting_email'] ){
			$mail->addAddress($setting['setting_email'],"");
		}
		if ( isset($setting['setting_master_email']) && $setting['setting_master_email'] ){
			$mail->AddCC($setting['setting_master_email']);
		}
	}

	if ( $email_cc && is_array($email_cc) && count($email_cc) ){
		foreach( $email_cc as $item_email ){
			$mail->AddCC($item_email);
		}
	}

	$mail->Subject = $subject;
	$mail->Body = $message;

	if( !$mail->Send() ){
		return false;
	}
	if ( $order_id ){
		// Update order
		$database->db_query("UPDATE ".TBL_ORDER." SET order_sendmail=1 WHERE order_id=$order_id");
	}
	return true;
}
/*
 * Template email system for contact
 */
function create_template_mail_system($params = array(), $htmlTag = false){
	global $setting, $datetime;

	$html = '<div style="padding:0;margin:0;background:#fff;font:13px tahoma;color:#404040">
				<div style="max-width:700px;margin:0 auto">
					<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
					<td style="border-bottom:solid 3px #1769b2" align="center" valign="middle" height="93">'.( $setting['logo'] ? '<a target="_blank" href="'.PG_URL_HOMEPAGE.'"><img alt="'.$setting['setting_only_title_web'].'" src="'.$setting['logo'].'" border="0" width="210" /></a>' : $setting['setting_domain']). '</td>
					</tr>
					<tr>
					<td>
					<p style="font:700 15px tahoma;color:#000;margin-top:25px">Kính gửi:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">'.$params['name'].'</span>!</p>
					<p style="font:13px tahoma;color:#404040;margin:10px 0 5px 0"><span style="text-transform:uppercase">'.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_domain']).'</span> xin gửi lời cám ơn đến Quý khách đã tin tưởng sử dụng dịch vụ của chúng tôi.</p>
					<p style="color:#404040;font:13px tahoma;margin:5px 0 20px 0">Thông tin liên hệ&nbsp;của bạn:&nbsp;<strong style="color:#1769b2">'.$params['title'].'&nbsp;</strong> đã được gửi tới bộ phận tiếp nhận ý kiến.</p>
					</td>
					</tr>
					<tr>
					<td style="font:700 15px tahoma;text-transform:uppercase;text-align:center;background:#3eb8cd;color:#fff;padding:10px">THÔNG TIN LIÊN HỆ</td>
					</tr>
					<tr>
					<td><img style="float:left;margin-left:48%" src="'.PG_URL_HOMEPAGE.'images/email/ar_donhang.png"></td>
					</tr>
					<tr>
					<td>
					<p style="font:700 14px tahoma;color:#e26919;text-transform:uppercase;border-bottom:dotted 1px #989898;padding-bottom:5px;margin:20px 0 5px 0">Thông tin LIÊN HỆ:</p>
					<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Tên khách hàng</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#1769b2">: <span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">'.$params['name'].'</span></td>
					</tr>
					'.( $params['mobile'] ? '
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Số điện thoại</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">'.$params['mobile'].'</span></td>
					</tr>
					' : '' ).'
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Địa chỉ email</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">.<a href="mailto:'.$params['email'].'">'.$params['email'].'</a></span></td>
					</tr>
					'.( $params['address'] ? '
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Địa chỉ</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">'.$params['address'].'</span></td>
					</tr>
					' : '' ).'
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Thời gian gửi</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">'.$datetime->datetimeDisplay(time(), false, true).'</span></td>
					</tr>
					'.( $params['content'] ? '
					'.( $htmlTag ? '
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Nội dung</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;</td>
					</tr>
					<tr>
					<td colspan="2" style="padding:5px 0;font:13px tahoma;color:#404040">'.$params['content'].'</td>
					</tr>
					' : '
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">Nội dung</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px">'.$params['content'].'</span></td>
					</tr>
					' ).'
					' : '' ).'
					'.( $params['files'] ? '
					<tr>
					<td style="padding:5px 0;font:13px tahoma;color:#404040">File đính kèm</td>
					<td style="padding:5px 0;font:700 13px tahoma;color:#404040">:&nbsp;<span style="box-sizing:border-box;color:#31708f;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px"><a href="'.PG_URL_HOMEPAGE.'images/files/'.$setting['setting_domain'].'/contacts/'.$params['files'].'">Download file đính kèm</a></span></td>
					</tr>
					' : '' ).'
					</tbody>
					</table>
					<p style="box-sizing:border-box;margin:0px 0px 10px;font-variant-numeric:normal;font-variant-east-asian:normal;font-stretch:normal;font-size:13px;line-height:normal;font-family:tahoma">&nbsp;</p>
					<p style="box-sizing:border-box;margin:0px 0px 10px;font-variant-numeric:normal;font-variant-east-asian:normal;font-stretch:normal;font-size:13px;line-height:normal;font-family:tahoma">Nếu có bất kỳ thắc mắc nào khác, Quý khách vui lòng liên hệ với <span style="text-transform:uppercase">'.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_domain']).'</span> để được hỗ trợ kịp thời.<br><br>+ Hotline:&nbsp;<span style="box-sizing:border-box;font-weight:bold;color:#ff4800">'.$setting['setting_hotline'].'</span>&nbsp;(Bộ phận tiếp nhận ý kiến khách hàng 24/7)</p>
					<p style="box-sizing:border-box;margin:0px 0px 30px;font-variant-numeric:normal;font-variant-east-asian:normal;font-stretch:normal;font-size:13px;line-height:normal;font-family:tahoma">+ Email:&nbsp;<a style="box-sizing:border-box;background-color:transparent;color:#1769b2;text-decoration-line:none" href="mailto:'.$setting['setting_email'].'" target="_blank">'.$setting['setting_email'].'</a></p>
					</td>
					</tr>
					</tbody>
					</table>
					</div>
					<div style="background-color:#3eb8cd;color:#fff;border-bottom:solid 10px #1a92ab;float:left;width:100%">
						<div style="max-width:700px;margin:0 auto">
							<table style="background-color:#3eb8cd;font:13px tahoma;color:#fff" border="0" width="100%" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
							<td style="text-align:center"><img src="'.PG_URL_HOMEPAGE.'images/email/img_footer_donhang.jpg" width="100%"></td>
							</tr>
							<tr>
							<td style="font:700 14px tahoma;margin:0 0 0 10px;float:left;width:100%;text-transform:uppercase">'.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_domain']).'</td>
							</tr>
							<tr>
							<td>
							<p style="margin:15px 0 0 10px;font:13px tahoma"><strong>Địa chỉ:</strong> '.$setting['setting_company_address'].'.</p>
							<p style="margin:0 0 0 10px;font:13px tahoma">Điện thoại: '.$setting['setting_hotline'].'</p>
							<p style="margin:15px 0 0 10px;font:13px tahoma">Website:&nbsp;<a style="color:#fff" href="http://'.$setting['setting_domain'].'" target="_blank">http://'.$setting['setting_domain'].'</a></p>
							<p style="margin:0 0 0 10px;font:13px tahoma">Email:&nbsp;<a style="color:#fff" href="mailto:'.$setting['setting_email'].'" target="_blank">'.$setting['setting_email'].'</a></p>
							</td>
							</tr>
							</tbody>
							</table>
						</div>
					</div>
				</div>';
	return $html;
}

function create_note_promotion($input = array()){
	global $setting;

	$html = '<table width="950" align="center" style="background-color: #FFFFFF; border: 1px solid #128DC6; position: relative; padding: 0; font-family: Arial, Tahoma, Verdana; font-size: 14px; color: #333; line-height: 22px; display: inline-block; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;">
		<thead>
		<tr>
			<th width="250" align="center" style="font-size:16px; font-weight: bold; background: rgba(20,158,224,0.7); color: #FFF; line-height: 30px; text-transform:uppercase;">'.( $setting['logo'] ? '<a target="_blank" href="'.PG_URL_HOMEPAGE.'"><img alt="'.$setting['setting_only_title_web'].'" src="'.$setting['logo'].'" border="0" width="210" /></a>' : $setting['setting_domain']). '</th>
			<th width="700" align="center" style="font-size:16px; font-weight: bold; background: rgba(20,158,224,0.7); color: #FFF; line-height: 30px;">PHIẾU ĐĂNG KÝ ONLINE - NHẬN MÃ GIẢM GIÁ SỬ DỤNG DỊCH VỤ/MUA SẢN PHẨM</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td align="left" style="font-size:14px;font-weight: bold; padding-left: 5px; text-transform:uppercase; background: rgba(20,158,224,0.7); color: #FFF; line-height: 25px;">Mã phiếu giảm giá</td>
			<td align="left" style="padding-left: 5px;"><b style="color:#ec530f;text-transform:uppercase;">' .$input['order_code'].'</b></td>
		</tr>
		<tr>
			<td align="left" valign="top" style="font-size:14px;font-weight: bold; padding-left: 5px; text-transform:uppercase; background: rgba(20,158,224,0.7); color: #FFF; line-height: 25px;">Thông tin dịch vụ/sản phẩm</td>
			<td align="center">Quý khách hàng vui lòng sử dụng chính xác <b>mã phiếu giảm giá</b> này để nhận được ưu đãi của các dịch vụ/sản phẩm của '.$setting['setting_company'].' như cam kết <a target="_blank" href="'.PG_URL_HOMEPAGE.'khach-hang.html">tại đây</a></td>
		</tr>
		<tr>
			<td align="left" valign="top" style="font-size:14px;font-weight: bold; padding-left: 5px; text-transform:uppercase; background: rgba(20,158,224,0.7); color: #FFF; line-height: 25px;">Thông tin khách hàng</td>
			<td>
				<table>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Tên khách hàng</td>
						<td align="left" style="padding-left: 5px;">'.$input['name'].'</td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Điện thoại liên hệ</td>
						<td align="left" style="padding-left: 5px;">'.$input['mobile'].'</td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Email đăng ký</td>
						<td align="left" style="padding-left: 5px;"><a style="color:#128DC6; text-decoration: underline;" href="mailto:'.$input['email'].'">'.$input['email'].'</a></td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Ghi chú của khách hàng</td>
						<td align="left" style="padding-left: 5px;">'.$input['message'].'</td>
					</tr>
				</table>
			</td>
		</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" align="left" style="padding:5px 10px; background: #f1f1f1;">
					<div style="float: left">
						<span><b>'.$setting['setting_company'].'</b></span><br/>
						<span>Địa chỉ: '.$setting['setting_company_address'].'</span><br/>
					</div>
					<div style="float: right">
						<span>Hotline: '.$setting['setting_hotline'].'</span><br/>
						<span>Email: <a style="color:#128DC6; text-decoration: underline;" href="mailto:'.$setting['setting_email'].'">'.$setting['setting_email'].'</a></span><br/>
						<span>Website: <a style="color:#128DC6; text-decoration: underline;" target="_blank" href="http://'.$setting['setting_domain'].'">'.$setting['setting_domain'].'</a></span>
					</div>
				</td>
			</tr>
		</tfoot>
	</table>';
	return $html;
}
function create_order_template($input_user_order = array(), $aryInfoCustomer, $totalPrice, $list_product_name, $list_product_id, $list_price, $list_qty, $list_price_total, $list_color = false, $list_size = false, $note = false ){
	global $setting, $database;

	if ( !$input_user_order
        || !is_array($input_user_order)
        || empty($input_user_order)
        || !$aryInfoCustomer
        || !is_array($aryInfoCustomer)
        || empty($aryInfoCustomer)
        || !$totalPrice
        || !$list_product_name
        || !is_array($list_product_name)
        || !$list_product_id
        || !is_array($list_product_id)
        || !$list_price
        || !is_array($list_price)
        || !$list_qty
        || !is_array($list_qty)
        || !$list_price_total
        || !is_array($list_price_total) ){
		    return false;
	}

	if (count($list_product_name)){
		$build_text_description = '';
		for ($i = 0; $i<count($list_product_name); $i++){
			$input_product['order_id']		= $input_user_order['order_id'];
			$input_product['product_id'] 	= $list_product_id[$i];
			$input_product['price'] 		= $list_price[$i];
			$input_product['number'] 		= $list_qty[$i];
			$input_product['totals']		= $list_price[$i] * $list_qty[$i];
			$database->insert(TBL_ORDER_PRODUCT, $input_product);

			$build_text_description .= '<tr>';
				$build_text_description .= '<td align="left" style="padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">'.$list_product_name[$i].'</td>';
				$build_text_description .= ( (!empty($list_color[$i]) && $list_color[$i]) ? '<td align="left" style="padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;"><div style="width: 15px; height:15px; background: #'.$list_color[$i].'"></div></td>' : '');
				$build_text_description .= ( (!empty($list_size[$i]) && $list_size[$i]) ? '<td align="left" style="padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">'.$list_size[$i].'</td>' : '');
				$build_text_description .= '<td align="left" style="padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">'.$list_qty[$i].'</td>';
				$build_text_description .= '<td align="left" style="padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;"><span style="color:#ed470d">'.number_format($list_price[$i], 0, ",", ".").' VNĐ</span></td>';
				$build_text_description .= '<td align="left" style="padding-left: 5px; border-bottom: 1px solid #dedede;"><span style="color:#ed470d; font-weight: bold;">'.number_format($list_price_total[$i], 0, ",", ".").' VNĐ</span></td>';
			$build_text_description .= '</tr>';
		}
	}

	$html = '<table width="950" align="center" style="background-color: #FFFFFF; border: 1px solid #128DC6; position: relative; padding: 0; font-family: Arial, Tahoma, Verdana; font-size: 12px; color: #333; line-height: 22px; display: inline-block; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;">
		<thead>
		<tr>
			<th width="250" align="center" style="font-size:16px; font-weight: bold; background: rgba(20,158,224,0.7); color: #FFF; line-height: 30px; text-transform:uppercase;">'.$setting['setting_domain'].'</th>
			<th width="700" align="center" style="font-size:16px; font-weight: bold; background: rgba(20,158,224,0.7); color: #FFF; line-height: 30px;">THÔNG TIN ĐƠN ĐẶT HÀNG</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td align="left" style="font-size:13px;font-weight: bold; padding-left: 5px; text-transform:uppercase; background: rgba(20,158,224,0.7); color: #FFF; line-height: 25px;">Mã đơn hàng</td>
			<td align="left" style="padding-left: 5px;"><b>'.$input_user_order['order_code'].'</b></td>
		</tr>
		<tr>
			<td align="left" valign="top" style="font-size:13px;font-weight: bold; padding-left: 5px; text-transform:uppercase; background: rgba(20,158,224,0.7); color: #FFF; line-height: 25px;">Thông tin sản phẩm</td>
			<td>
				<table width="100%" style="border:1px solid #DEDEDE; margin:0; padding:0;">
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">Tên sản phẩm</td>
						'.( (!empty($list_color) && is_array($list_color)) ? '<td align="left" style="font-weight: bold; padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">Màu sắc</td>' : '').'
						'.( (!empty($list_size) && is_array($list_size)) ? '<td align="left" style="font-weight: bold; padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">Kích thước</td>' : '').'
						<td align="left" style="font-weight: bold; padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">Số lượng mua</td>
						<td align="left" style="font-weight: bold; padding-left: 5px; border-bottom: 1px solid #dedede; border-right: 1px solid #dedede;">Đơn giá</td>
						<td align="left" style="font-weight: bold; padding-left: 5px; border-bottom: 1px solid #dedede;">Thành tiền</td>
					</tr>
					'.$build_text_description.'
					<tr>
						<td colspan="6" align="right" style="text-transform: uppercase; font-weight: bold; font-size: 13px; line-height: 30px; padding-right: 10px;">Tổng giá trị đơn hàng : <span style="color:#ed2709">'.number_format($totalPrice, 0, ",", ".").' VNĐ</span> (Tổng tiền chưa bao gồm phí ship)</td>
					</tr>
					'.($note ? '<tr><td colspan="6" align="right" style="color:red;">'.$note.'</td></tr>' : '').'
				</table>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" style="font-size:13px;font-weight: bold; padding-left: 5px; text-transform:uppercase; background: rgba(20,158,224,0.7); color: #FFF; line-height: 25px;">Thông tin người mua</td>
			<td>
				<table>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Tên khách hàng</td>
						<td align="left" style="padding-left: 5px;">'.$aryInfoCustomer['user_fullname'].'</td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Điện thoại liên hệ</td>
						<td align="left" style="padding-left: 5px;">'.$aryInfoCustomer['user_mobile'].'</td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Email đặt hàng</td>
						<td align="left" style="padding-left: 5px;"><a style="color:#128DC6; text-decoration: underline;" href="mailto:'.$aryInfoCustomer['user_email'].'">'.$aryInfoCustomer['user_email'].'</a></td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Hình thức thanh toán</td>
						<td align="left" style="padding-left: 5px;">'.$aryInfoCustomer['service'].'</td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Ghi chú của khách hàng</td>
						<td align="left" style="padding-left: 5px;">'.$aryInfoCustomer['message'].'</td>
					</tr>
					<tr>
						<td align="left" style="font-weight: bold; padding-left: 5px;">Địa chỉ nhận hàng</td>
						<td align="left" style="padding-left: 5px;">'.$aryInfoCustomer['address'].'</td>
					</tr>
				</table>
			</td>
		</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" align="left" style="padding:5px 10px; background: #f1f1f1;">
					<div style="float: left">
						<span><b>'.$setting['setting_company'].'</b></span><br/>
						<span>Địa chỉ: '.$setting['setting_company_address'].'</span><br/>
					</div>
					<div style="float: right">
						<span>Hotline: '.$setting['setting_hotline'].'</span><br/>
						<span>Email: <a style="color:#128DC6; text-decoration: underline;" href="mailto:'.$setting['setting_email'].'">'.$setting['setting_email'].'</a></span><br/>
						<span>Website: <a style="color:#128DC6; text-decoration: underline;" target="_blank" href="http://'.$setting['setting_domain'].'">'.$setting['setting_domain'].'</a></span>
					</div>
				</td>
			</tr>
		</tfoot>
	</table>';
	return $html;
}

function tao_phieu_dang_ky_lam_thu_tuc_online( $aryInput ){
	global $setting, $datetime, $site_id;

	if ( !is_array($aryInput) || !count($aryInput) )
		return false;

	$number_code = get_random_code_number();
	$html = '
		<table width="800px" align="center" style="width: 800px;margin: 0 auto;font-family: Arial sans-serif;font-size: 15px;border: 1px solid #ddd">
			<tr>
				<td style="padding: 10px">
					<div class="sch_name" style="width: 390px;float: left;">
						<p style="width: 100%;float: left;margin:5px 0;"><b>Bộ Lao Động Thương Binh Và Xã Hội</b></p>
						<p style="width: 100%;float: left;margin:5px 0;"><a target="_blank" href="'.PG_URL_HOMEPAGE.'"><img alt="'.$setting['setting_only_title_web'].'" src="'.$setting['logo'].'" border="0" width="210" /></a></p>
						<span class="boder_bottom" style="border-bottom:1px solid #000;height: 1px;width: 237px;float: left;margin-top: 10px;margin-bottom: 10px;"></span>
						<p style="width: 100%;float: left;margin:5px 0;">Số : <b>S'.$site_id.'-Ts'.$number_code.'</b></p>
					</div>
					<div class="tieungu" style="float: left;width: 375px;text-align: center;">
						<p style="float: left;width: 100%;margin:5px 0;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
						<p style="float: left;width: 100%;margin:5px 0;">Độc lập - Tự do - Hạnh phúc</p>
						<span class="border_bottom2" style="border-bottom:1px solid #000;height: 1px;width: 237px;float: left;margin-top: 10px;margin-bottom: 10px;margin-left: 70px;"></span>
						<p style="float: left;width: 100%;margin:5px 0;"><i>Ngày '.date('d', time()).' tháng '.date('m', time()).' năm '.date('Y', time()).'</i></p>
					</div>
					<div class="tieude" style="float: left;width: 100%;text-align: center;margin-top: 20px;">
						<h1 style="margin:10px 0;">THÔNG TIN THÍ SINH ĐĂNG KÝ</h1>
						<p style="margin:5px 0;">(<i>Phòng tuyển sinh '.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_only_title_web']).' năm học '.get_current_year().' - '.(get_current_year()+1).'</i>)</p>
					</div>
					<div class="content" style="float: left;width: 100%;">
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Phòng tuyển sinh <b style="text-transform:uppercase;">'.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_only_title_web']).'</b> cảm ơn bạn đã gửi thông tin đăng ký thủ tục nhập học trực tuyến. Căn cứ thông tin đăng ký, chúng tôi gửi tới bạn các thông tin sau: </p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="name">Thí sinh <b style="text-transform:uppercase;">'.$aryInput['ho_va_ten'].'</b></span> - <span id="sbd">Mã số sinh viên: <b>'.$aryInput['ma_sinh_vien'].'</b> </span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="dob">Sinh ngày : <b>'.$datetime->datetimeDisplay($aryInput['ngay_sinh'] . ' 00:00:00', true, true).'</b></span> - <span id="mhs">Mã hồ sơ : <b>'.$number_code.'</b> </span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="gioitinh">Giới tính: <b>'.($aryInput['gioi_tinh'] ? "Nam": "Nữ").'</b></span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="hokhau">Địa chỉ: <b>'.$aryInput['dia_chi'].'</b></span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="email">Email: <b>'.$aryInput['email'].'</b></span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="dienthoai">Số điện thoại liên hệ: <b>'.$aryInput['so_dien_thoai'].'</b></span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">'.($aryInput['trinh_do_hoc_van'] ? "Trình độ học vấn : <b>".$aryInput['trinh_do_hoc_van']." - </b> ": "") .($aryInput['nganh_hoc_text'] ? '<span id="khuvuc">Ngành học đăng ký: <b>'.$aryInput['nganh_hoc_text'].'</b></span>' : '').( $aryInput['he_dao_tao'] ? ' - <span>Hệ đào tạo: <b>'.$aryInput['he_dao_tao'].'</b></span>' : '').( $aryInput['note'] ? $aryInput['note'] : '').'</p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Sau khi xác minh thông tin đăng ký bạn gửi tới phòng tuyển sinh của '.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_only_title_web']).', nhà trường sẽ thông báo cho bạn thời gian đến trường làm thủ tục nhập học.</p>
					</div>
					<div style="float: right;width: 100%;text-align: right;" class="condau">
						<p style="width: 100%;float: right;height: 150px;margin-top: 50px;margin-bottom: 50px;"><i>Phòng tuyển sinh '.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_only_title_web']).'!</i></p>
					</div>
					<div style="border-top: dashed 1px #000;float: left;width: 96%;padding: 10px;" class="note">
						<h3>THÍ SINH ĐĂNG KÝ CẦN LƯU Ý</h3>
						<ul style="padding-left: 15px;">
							<li style="padding: 5px;font-style:italic;">Thông báo này sử dụng cho thí sinh có nguyện vọng đăng ký học tại '.($setting['setting_company'] ? $setting['setting_company'] : $setting['setting_only_title_web']).'</li>
							<li style="padding: 5px;font-style:italic;">Mọi thông tin thắc mắc vui lòng gọi hotline: <a href="tel:'.$setting['setting_hotline'].'" style="color:red;font-weight:bold;text-decoration:none;">'.$setting['setting_hotline'].'</b></li>
						</ul>
					</div>
				</td>
			</tr>
		</table>';
	return $html;
}

function tao_giay_bao_nhap_hoc( $aryInput ){
	global $setting, $datetime;

	if ( !is_array($aryInput) || !count($aryInput) )
		return false;

	$html = '
		<table width="800px" align="center" style="width: 800px;margin: 0 auto;font-family: Arial sans-serif;font-size: 15px;border: 1px solid #ddd">
			<tr>
				<td style="padding: 10px">
					<div class="sch_name" style="width: 390px;float: left;">
						<p style="width: 100%;float: left;margin:5px 0;">'.$setting['setting_only_title_web'].'</p>
						<p style="width: 100%;float: left;margin:5px 0;"><b>'.$setting['setting_only_title_web'].'</b></p>
						<span class="boder_bottom" style="border-bottom:1px solid #000;height: 1px;width: 237px;float: left;margin-top: 10px;margin-bottom: 10px;"></span>
						<p style="width: 100%;float: left;margin:5px 0;">Số : <b>2973-Ts2018</b></p>
					</div>
					<div class="tieungu" style="float: left;width: 375px;text-align: center;">
						<p style="float: left;width: 100%;margin:5px 0;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
						<p style="float: left;width: 100%;margin:5px 0;">Độc lập - Tự do - Hạnh phúc</p>
						<span class="border_bottom2" style="border-bottom:1px solid #000;height: 1px;width: 237px;float: left;margin-top: 10px;margin-bottom: 10px;margin-left: 70px;"></span>
						<p style="float: left;width: 100%;margin:5px 0;"><i>Tp.Hồ Chí Minh, ngày 31 tháng 03 năm 2018</i></p>
					</div>
					<div class="tieude" style="float: left;width: 100%;text-align: center;margin-top: 40px;">
						<h1>GIẤY BÁO NHẬP HỌC</h1>
						<p>(<i>Đại học chính qui năm '.get_current_year().'</i>)</p>
					</div>
					<div class="content" style="float: left;width: 100%;">
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Chủ tịch hội đồng quản trị trường <b>Cao đẳng Y Dược Sài Gòn</b> trân trọng thông báo : </p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="name">Thí sinh <b style="text-transform:uppercase;">'.$aryInput['ho_va_ten'].'</b></span> - <span id="sbd">Số báo danh : <b>'.$aryInput['ma_sinh_vien'].'</b> </span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="dob">Sinh ngày : '.$datetime->datetimeDisplay($aryInput['ngay_sinh'], true, true).'</span> - <span id="mhs">Mã hồ sơ : <b>99-000003:99</b> </span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;" id="bants">Ban TS : 99 &nbsp;&nbsp;&nbsp;&nbsp; Đơn vị ĐKDT : (99)- Nộp hồ sơ tại trường</p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="hokhau">Hộ khẩu TT: (48.8) Huyện Long Thành</span> <span id="doituong">Đối tượng : --</span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Năm tốt nghiệp : 2012 tại : (48054) - THPT Bình Sơn <span id="khuvuc">Khu vực 2NT</span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Kết quả thi TS2018 khối A - Đại học : <span id="montoan">Môn 1 (Toán) : 5.75</span> <span id="monly">Môn 2(Lý):6.50</span></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;"><span id="monhoa">Môn 3 (Hóa) : 6.75</span> <span id="tongdiem">Tổng cộng : <b>19.5</b></span> điểm</p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Đã trúng tuyển vào ngành <b id="nganh">Cao đẳng hộ sinh</b>(NV1) Điểm chuẩn 20.0</p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">thuộc khoa Cao đẳng hộ sinh - Trường Cao đẳng Y dược Sài Gòn</p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;margin-top: 20px;" class="thaymat">Thay mặt nhà trường, chúng tôi xin gửi lời chúc mừng đến bạn và gia đình.</p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Bạn cần chuẩn bị đầy đủ các giấy tờ cần thiết theo hướng dẫn đính kèm theo giấy báo này và có mặt lúc <b>8g00 ngày 28/4/2018</b> để làm thủ tục nhập học tại <b>Cơ sở 2 Cao đẳng Y dược Sài Gòn, Công viên phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, TP.HCM</b>
						. Bạn sẽ có 1 tuần sinh hoạt đầu khóa - bắt đầu từ thứ 3 ngày 29/5/2018(lịch chi tiết xem tại nơi thu nhận) và sau đó từ tuần lễ 09/09/2018 sẽ vào học chính thức năm nhất tại <b>Cơ sở 2 Cao đẳng Y dược Sài Gòn, Công viên phần mềm Quang Trung, Phường Tân Chánh Hiệp, Quận 12, TP.HCM</b></p>
						<p style="line-height: 1.7em;text-align: justify;margin:5px 0;">Mã số sinh viên của bạn là: <b id="masosinhvien">1234556789</b></p>
					</div>
					<div style="float: right;width: 100%;text-align: right;" class="condau">
						<p style="width: 150px;float: right;height: 150px;margin-top: 50px;margin-bottom: 50px;">Chữ kí và dấu nhà trường</p>
					</div>
					<div style="border-top: dashed 1px #000;float: left;width: 96%;padding: 10px;" class="note">
						<h3>THÍ SINH TRÚNG TUYỂN CẦN LƯU Ý</h3>
						<ul style="padding-left: 15px;">
							<li style="padding: 5px;">Khi nhận được giấy báo nhập học, Thí sinh trúng tuyển cần vào trang web của nhà trường để khai lý lịch ( Xem hướng dẫn ).Tài khoản đăng nhập là 81302973, mật khẩu <b>FRBPQF</b></li>
							<li style="padding: 5px;">Nếu không thể có mặt đúng theo lịch hẹn, thí sinh có thể nộp hồ sơ tại địa điểm trên cho đến 11g ngày 30/08/2018. Sau ngày này xin liên hệ Phòng đào tạo tại cơ sở 1 Số 268 Lý Thường Kiệt Q10 Tp HCM để được hướng dẫn cụ thể . Theo quy định, sau 15 ngày kể từ ngày được gọi nhập học ghi trong giấy báo thí sinh không có mặt coi như tự ý bỏ học</li>
							<li style="padding: 5px;">Trường hợp thí sinh muốn bảo lưu kết quả cần liên hệ Phòng đào tạo nhà trường hạn chót vào ngày 10/10/2018</li>
						</ul>
					</div>
				</td>
			</tr>
		</table>';
	return $html;
}

function send_email($recipient, $sender='', $subject, $message, $order_id, $masterMail = FALSE)
{
	global $setting, $database;
	if (PGRequest::getBool('test_mode', false, 'COOKIE')) return true;
	
	// DECODE SUBJECT AND EMAIL FOR SENDING
	$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
	$message = htmlspecialchars_decode($message, ENT_QUOTES);

	// ENCODE SUBJECT FOR UTF8
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	// REPLACE CARRIAGE RETURNS WITH BREAKS
	$message = str_replace("\n", "", $message);
	
	//@date_default_timezone_set('Bangkok/Hanoi/Jakarta');
	
	$sendmail = false;
	//echo $setting['mail_type'];
	//print_r($setting);
	$mail             = new PHPMailer();
	$mail->CharSet	  = "utf-8";
	//$mail->SetLanguage("vn",PG_ROOT.'/include/phpmailer/language/');
	
	if ($setting['mail_type']=='smtp'){
		$mail->IsSMTP();
		$mail->SMTPAuth   = $setting['mail_smtpauth'];                  // enable SMTP authentication
		$mail->SMTPSecure = $setting['mail_smtpsecure'];                 // sets the prefix to the servier
		$mail->Host       = $setting['mail_smtphost'];      // sets GMAIL as the SMTP server
		$mail->Port       = $setting['mail_smtpport'];                   // set the SMTP port for the GMAIL server
		
		$mail->Username   = $setting['mail_smtpuser'];  // GMAIL username
		$mail->Password   = $setting['mail_smtppass'];            // GMAIL password
	}
	else {
		$mail->IsSendmail();
		$mail->Sendmail	= $setting['mail_sendmailpath'];
	}
	
	// Do Sent mail
	if (!$sender) $sender=$setting['mail_smtpuser'];
  	$mail->AddReplyTo($sender);
	
	$mail->From       = $sender;
	$mail->FromName   = $setting["setting_title_web_product"];
	$mail->IsHTML(true); // send as HTML
	
	$mail->Subject    = $subject;
	$mail->MsgHTML($message);
	$mail->AddAddress($recipient,"");
	if ( $masterMail ){
		$mail->AddCC($masterMail);
	}
	if ($mail->Send()==true){
		return true;
	}
	else return false;
} // END FUNCTION

function send_email_system($recipient, $sender='', $subject, $message, $formHTML = null, $aryEmailCC = false)
{
	global $setting, $database;
	
	// DECODE SUBJECT AND EMAIL FOR SENDING
	$subject = htmlspecialchars_decode($subject, ENT_QUOTES);
	$message = htmlspecialchars_decode($message, ENT_QUOTES);

	// ENCODE SUBJECT FOR UTF8
	$subject="=?UTF-8?B?".base64_encode($subject)."?=";

	// REPLACE CARRIAGE RETURNS WITH BREAKS
	$message = str_replace("\n", "", $message);

	if ($formHTML = 1){
		$message = $message;
	}else{
	$message = '
			<div style="width: 723px; background-color: #FFFFFF; border: 1px solid #fea700; position: relative; padding: 10px; font-family: Arial, Tahoma, Verdana; font-size: 12px; color: #999; display: inline-block; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;">
				<div style="width: 100%; height: 84px; border-bottom: 1px dotted #999999;"> <a href="'.PG_URL_HOMEPAGE.'" style="width: 200px; height: 53px; display: block; float: left;"><img src="'.$setting['logo'].'" alt="'.$setting['setting_company'].'" width="200" height="53" border="0" /></a>
					<div style="float: right; font-size: 12px; color: #999; text-align:right">
						<h2 style="color: #FE890A; font-size: 22px; margin: 0;">EMAIL THÔNG BÁO</h2>
					</div>
					<div style="clear:both"></div>
					<div style="width:100%; height: 23px; float: left;">
						<div style="float: left; line-height: 35px;">'.date('d/m/Y').'</div>
						<ul style="float: right; margin: 0; padding: 0;">
							<li style="list-style: none; float: left; margin-right: 20px; padding: 10px 0;"><a href="'.PG_URL_HOMEPAGE.'" target="_blank" style="color: #FE890A; text-decoration: none; line-height: 20px; padding-left: 5px;"><img src="'.PG_URL_HOMEPAGE.'/images/email/li_homepage.jpg" style="float:left; border:none;" />'.$setting['logo'].'</a></li>
							<li style="list-style: none; float: left; margin-right: 20px; padding: 10px 0;"><a href="'.PG_URL_HOMEPAGE.'/lien-he.html" target="_blank" style="color: #FE890A; text-decoration: none; line-height: 20px; padding-left: 5px;"><img src="'.PG_URL_HOMEPAGE.'/images/email/li_contact.jpg" style="float:left; border:none;" />Liên hệ</a></li>
							<li style="list-style: none; float: left; margin-right: 20px; padding: 10px 0;"><a href="'.$setting['setting_facebook'].'" target="_blank" style="color: #FE890A; text-decoration: none; line-height: 20px; padding-left: 5px;"><img src="'.PG_URL_HOMEPAGE.'/images/email/li_face.jpg" style="float:left; border:none;" />Facebook</a></li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="clear:both"></div>
				<div style="color: #000000;padding: 10px 0 0 0;">'.$message.'</div>
				<div style="text-align: center; color: #FE890A; font-style: italic; font-size: 15px; width: 100%; float: left; padding-top: 10px; font-weight: bold; line-height: 25px;">'.$setting['setting_title_web'].'</div>
			</div>
			<div style="width: 723px; padding: 10px 0; text-align: center; color: #333; font-weight: normal; font-size: 12px; font-family: Arial, Tahoma, Verdana;">
				<ul style="margin: 0; padding: 0; margin-left: 40px;">
					<li style="list-style: none; float: left; margin-right: 30px; padding-left: 5px;"><img src="'.PG_URL_HOMEPAGE.'/images/email/li_contact.jpg" style="float:left; border:none; padding-right:3px; margin-top:-3px;" />Điện thoại: '.$setting['setting_hotline'].'</li>
					<li style="list-style: none; float: left; margin-right: 30px; padding-left: 5px;"><img src="'.PG_URL_HOMEPAGE.'/images/email/li_mail.jpg" style="float:left; border:none; padding-right:3px; margin-top:-3px;" />Email: <a style="color: #FE890A; text-decoration: none;" href="mailto:'.$setting['setting_email'].'">'.$setting['setting_email'].'</a></li>
					<li style="list-style: none; float: left; padding-left: 5px;"><img src="'.PG_URL_HOMEPAGE.'/images/email/li_yahoo.jpg" style="float:left; border:none; padding-right:3px; margin-top:-3px;" /><a style="color: #FE890A; text-decoration: none;" href="ymsgr:sendim?'.$setting['setting_support_yahoo'].'">YM: '.$setting['setting_support_yahoo'].'</a></li>
				</ul>
			</div>
			';
	}

	$sendmail = false;
	//echo $setting['mail_type'];
	//print_r($setting);
	$mail             = new PHPMailer();
	$mail->CharSet	  = "utf-8";
	
	if ($setting['mail_type']=='smtp'){
		$mail->IsSMTP();
		$mail->SMTPAuth   = $setting['mail_smtpauth'];                  // enable SMTP authentication
		$mail->SMTPSecure = $setting['mail_smtpsecure'];                 // sets the prefix to the servier
		$mail->Host       = $setting['mail_smtphost'];      // sets GMAIL as the SMTP server
		$mail->Port       = $setting['mail_smtpport'];                   // set the SMTP port for the GMAIL server
		
		$mail->Username   = $setting['mail_smtpuser'];  // GMAIL username
		$mail->Password   = $setting['mail_smtppass'];            // GMAIL password
	}
	else {
		$mail->IsSendmail();
		$mail->Sendmail	= $setting['mail_sendmailpath'];
	}
	
	// Debug mail
	$mail->SMTPDebug  = 1;
	
	// Do Sent mail
	if (!$sender) $sender=$setting['mail_smtpuser'];
  	$mail->AddReplyTo($sender);
	
	$mail->From       = $sender;
	$mail->FromName   = $setting["setting_title_web"];
	$mail->IsHTML(true); // send as HTML
	
	$mail->Subject    = $subject;
	$mail->MsgHTML($message);
	if ( is_array($recipient) ){
		foreach ($recipient as $fmail) {
			$mail->AddAddress($fmail,"");
		}
	}else{
		$mail->AddAddress($recipient,"");
	}
	if ( $aryEmailCC && is_array($aryEmailCC) && count($aryEmailCC) && !empty($aryEmailCC) ){
		foreach ($aryEmailCC as $cmail) {
			$mail->AddCC($cmail);
		}
	}else if ( is_string($aryEmailCC) ){
		$mail->AddCC($aryEmailCC);
	}else if ( $aryEmailCC === TRUE || $aryEmailCC == TRUE || $aryEmailCC == 1 ){
		$mail->AddCC($setting['setting_email']);
	}
	return $mail->Send();
} // END FUNCTION

function getSystemEmail($name, $aryReplace=null) {
	global $setting, $database;
	$sql = "SELECT * FROM ".TBL_SYSTEM_EMAIL." WHERE system_email_name='".mysql_escape_string($name)."' LIMIT 1";
	$aryEmail = $database->db_fetch_assoc($database->db_query($sql));

	if ($aryEmail['system_email_body'] != '') {
		$aryEmail['system_email_body'] = str_replace(array_keys($aryReplace), $aryReplace, $aryEmail['system_email_body']);
	}
	return $aryEmail;
}

// ADD FUNCTION CHECK MAIL TRUE
function checkMassMail($massmail_email){
	global $database, $validate, $site_id;

	$is_error = NULL;
	//CHECK EMAIL
	if ($massmail_email == '') {
		$is_error= 'Địa chỉ email rỗng';
	}
	if ($massmail_email !='') {
		if (!$validate->isEmail($massmail_email)) {
			$is_error = 'Email không đúng định dạng';
		}
	}
	$condition = '';
	if ( $site_id ){
		$condition = ' AND massmail_site_id='.$site_id;
	}
	//CHECK USER EXISTED
	$email = strtolower($massmail_email);
	if ($database->db_num_rows($database->db_query("SELECT massmail_email FROM ".TBL_MASSMAIL." WHERE LOWER(massmail_email)='{$email}'" . $condition)) ) {
		$is_error = 'Email này đã có trong hệ thống';
	}
	return $is_error;
}

// ADD FUNCTION ADD MAIL TO MASSMAIL
function addMassMail($aryInput){
	global $database, $site_id;

	if (is_array($aryInput) && count($aryInput) && !empty($aryInput)){
		if ( $site_id ){
			$aryInput['massmail_site_id'] = $site_id;
		}
		$error = checkMassMail($aryInput['massmail_email']);
		if (is_null($error)){
			if (!$database->insert(TBL_MASSMAIL, $aryInput))
				$is_message = "Lỗi hệ thống: " . $database->db_error();
			else
				$is_message = "Thêm mới email thành công !";
		}
	}else{
		$is_message = "Không tồn tại mảng dữ liệu !";
	}
	if (isset($is_message))return $is_message;
	else return;
}
?>