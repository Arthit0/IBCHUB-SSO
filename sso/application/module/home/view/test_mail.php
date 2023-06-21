<?php
$Body = '<!doctype html>';
$Body.= '<html>';
$Body.= '<head>';
$Body.= '<meta name="viewport" content="width=device-width" />';
$Body.= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
$Body.= '<title>SSO DITP Reset Password</title>';
$Body.= '<style>';
$Body.= '/* -------------------------------------';
$Body.= 'GLOBAL RESETS';
$Body.= '------------------------------------- */';
$Body.= '';
$Body.= '/*All the styling goes here*/';
$Body.= '';
$Body.= 'img {';
$Body.= 'border: none;';
$Body.= '-ms-interpolation-mode: bicubic;';
$Body.= 'max-width: 100%;';
$Body.= '}';
$Body.= '';
$Body.= 'body {';
$Body.= 'background-color: #f6f6f6;';
$Body.= 'font-family: sans-serif;';
$Body.= '-webkit-font-smoothing: antialiased;';
$Body.= 'font-size: 14px;';
$Body.= 'line-height: 1.4;';
$Body.= 'margin: 0;';
$Body.= 'padding: 0;';
$Body.= '-ms-text-size-adjust: 100%;';
$Body.= '-webkit-text-size-adjust: 100%;';
$Body.= '}';
$Body.= '';
$Body.= 'table {';
$Body.= 'border-collapse: separate;';
$Body.= 'mso-table-lspace: 0pt;';
$Body.= 'mso-table-rspace: 0pt;';
$Body.= 'width: 100%; }';
$Body.= 'table td {';
$Body.= 'font-family: sans-serif;';
$Body.= 'font-size: 14px;';
$Body.= 'vertical-align: top;';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'BODY & CONTAINER';
$Body.= '------------------------------------- */';
$Body.= '';
$Body.= '.body {';
$Body.= 'background-color: #f6f6f6;';
$Body.= 'width: 100%;';
$Body.= '}';
$Body.= '';
$Body.= '/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */';
$Body.= '.container {';
$Body.= 'display: block;';
$Body.= 'margin: 0 auto !important;';
$Body.= '/* makes it centered */';
$Body.= 'max-width: 580px;';
$Body.= 'padding: 10px;';
$Body.= 'width: 580px;';
$Body.= '}';
$Body.= '';
$Body.= '/* This should also be a block element, so that it will fill 100% of the .container */';
$Body.= '.content {';
$Body.= 'box-sizing: border-box;';
$Body.= 'display: block;';
$Body.= 'margin: 0 auto;';
$Body.= 'max-width: 580px;';
$Body.= 'padding: 10px;';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'HEADER, FOOTER, MAIN';
$Body.= '------------------------------------- */';
$Body.= '.main {';
$Body.= 'background: #ffffff;';
$Body.= 'border-radius: 3px;';
$Body.= 'width: 100%;';
$Body.= '}';
$Body.= '';
$Body.= '.wrapper {';
$Body.= 'box-sizing: border-box;';
$Body.= 'padding: 20px;';
$Body.= '}';
$Body.= '';
$Body.= '.content-block {';
$Body.= 'padding-bottom: 10px;';
$Body.= 'padding-top: 10px;';
$Body.= '}';
$Body.= '';
$Body.= '.footer {';
$Body.= 'clear: both;';
$Body.= 'margin-top: 10px;';
$Body.= 'text-align: center;';
$Body.= 'width: 100%;';
$Body.= '}';
$Body.= '.footer td,';
$Body.= '.footer p,';
$Body.= '.footer span,';
$Body.= '.footer a {';
$Body.= 'color: #999999;';
$Body.= 'font-size: 12px;';
$Body.= 'text-align: center;';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'TYPOGRAPHY';
$Body.= '------------------------------------- */';
$Body.= 'h1,';
$Body.= 'h2,';
$Body.= 'h3,';
$Body.= 'h4 {';
$Body.= 'color: #000000;';
$Body.= 'font-family: sans-serif;';
$Body.= 'font-weight: 400;';
$Body.= 'line-height: 1.4;';
$Body.= 'margin: 0;';
$Body.= 'margin-bottom: 30px;';
$Body.= '}';
$Body.= '';
$Body.= 'h1 {';
$Body.= 'font-size: 35px;';
$Body.= 'font-weight: 300;';
$Body.= 'text-align: center;';
$Body.= 'text-transform: capitalize;';
$Body.= '}';
$Body.= '';
$Body.= 'p,';
$Body.= 'ul,';
$Body.= 'ol {';
$Body.= 'font-family: sans-serif;';
$Body.= 'font-size: 14px;';
$Body.= 'font-weight: normal;';
$Body.= 'margin: 0;';
$Body.= 'margin-bottom: 15px;';
$Body.= '}';
$Body.= 'p li,';
$Body.= 'ul li,';
$Body.= 'ol li {';
$Body.= 'list-style-position: inside;';
$Body.= 'margin-left: 5px;';
$Body.= '}';
$Body.= '';
$Body.= 'a {';
$Body.= 'color: #3498db;';
$Body.= 'text-decoration: underline;';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'BUTTONS';
$Body.= '------------------------------------- */';
$Body.= '.btn {';
$Body.= 'box-sizing: border-box;';
$Body.= 'width: 100%; }';
$Body.= '.btn > tbody > tr > td {';
$Body.= 'padding-bottom: 15px; }';
$Body.= '.btn table {';
$Body.= 'width: auto;';
$Body.= '}';
$Body.= '.btn table td {';
$Body.= 'background-color: #ffffff;';
$Body.= 'border-radius: 5px;';
$Body.= 'text-align: center;';
$Body.= '}';
$Body.= '.btn a {';
$Body.= 'background-color: #ffffff;';
$Body.= 'border: solid 1px #3498db;';
$Body.= 'border-radius: 5px;';
$Body.= 'box-sizing: border-box;';
$Body.= 'color: #3498db;';
$Body.= 'cursor: pointer;';
$Body.= 'display: inline-block;';
$Body.= 'font-size: 14px;';
$Body.= 'font-weight: bold;';
$Body.= 'margin: 0;';
$Body.= 'padding: 12px 25px;';
$Body.= 'text-decoration: none;';
$Body.= 'text-transform: capitalize;';
$Body.= '}';
$Body.= '';
$Body.= '.btn-primary table td {';
$Body.= 'background-color: #3498db;';
$Body.= '}';
$Body.= '';
$Body.= '.btn-primary a {';
$Body.= 'background-color: #3498db;';
$Body.= 'border-color: #3498db;';
$Body.= 'color: #ffffff;';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'OTHER STYLES THAT MIGHT BE USEFUL';
$Body.= '------------------------------------- */';
$Body.= '.last {';
$Body.= 'margin-bottom: 0;';
$Body.= '}';
$Body.= '';
$Body.= '.first {';
$Body.= 'margin-top: 0;';
$Body.= '}';
$Body.= '';
$Body.= '.align-center {';
$Body.= 'text-align: center;';
$Body.= '}';
$Body.= '';
$Body.= '.align-right {';
$Body.= 'text-align: right;';
$Body.= '}';
$Body.= '';
$Body.= '.align-left {';
$Body.= 'text-align: left;';
$Body.= '}';
$Body.= '';
$Body.= '.clear {';
$Body.= 'clear: both;';
$Body.= '}';
$Body.= '';
$Body.= '.mt0 {';
$Body.= 'margin-top: 0;';
$Body.= '}';
$Body.= '';
$Body.= '.mb0 {';
$Body.= 'margin-bottom: 0;';
$Body.= '}';
$Body.= '';
$Body.= '.preheader {';
$Body.= 'color: transparent;';
$Body.= 'display: none;';
$Body.= 'height: 0;';
$Body.= 'max-height: 0;';
$Body.= 'max-width: 0;';
$Body.= 'opacity: 0;';
$Body.= 'overflow: hidden;';
$Body.= 'mso-hide: all;';
$Body.= 'visibility: hidden;';
$Body.= 'width: 0;';
$Body.= '}';
$Body.= '';
$Body.= '.powered-by a {';
$Body.= 'text-decoration: none;';
$Body.= '}';
$Body.= '';
$Body.= 'hr {';
$Body.= 'border: 0;';
$Body.= 'border-bottom: 1px solid #f6f6f6;';
$Body.= 'margin: 20px 0;';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'RESPONSIVE AND MOBILE FRIENDLY STYLES';
$Body.= '------------------------------------- */';
$Body.= '@media only screen and (max-width: 620px) {';
$Body.= 'table[class=body] h1 {';
$Body.= 'font-size: 28px !important;';
$Body.= 'margin-bottom: 10px !important;';
$Body.= '}';
$Body.= 'table[class=body] p,';
$Body.= 'table[class=body] ul,';
$Body.= 'table[class=body] ol,';
$Body.= 'table[class=body] td,';
$Body.= 'table[class=body] span,';
$Body.= 'table[class=body] a {';
$Body.= 'font-size: 16px !important;';
$Body.= '}';
$Body.= 'table[class=body] .wrapper,';
$Body.= 'table[class=body] .article {';
$Body.= 'padding: 10px !important;';
$Body.= '}';
$Body.= 'table[class=body] .content {';
$Body.= 'padding: 0 !important;';
$Body.= '}';
$Body.= 'table[class=body] .container {';
$Body.= 'padding: 0 !important;';
$Body.= 'width: 100% !important;';
$Body.= '}';
$Body.= 'table[class=body] .main {';
$Body.= 'border-left-width: 0 !important;';
$Body.= 'border-radius: 0 !important;';
$Body.= 'border-right-width: 0 !important;';
$Body.= '}';
$Body.= 'table[class=body] .btn table {';
$Body.= 'width: 100% !important;';
$Body.= '}';
$Body.= 'table[class=body] .btn a {';
$Body.= 'width: 100% !important;';
$Body.= '}';
$Body.= 'table[class=body] .img-responsive {';
$Body.= 'height: auto !important;';
$Body.= 'max-width: 100% !important;';
$Body.= 'width: auto !important;';
$Body.= '}';
$Body.= '}';
$Body.= '';
$Body.= '/* -------------------------------------';
$Body.= 'PRESERVE THESE STYLES IN THE HEAD';
$Body.= '------------------------------------- */';
$Body.= '@media all {';
$Body.= '.ExternalClass {';
$Body.= 'width: 100%;';
$Body.= '}';
$Body.= '.ExternalClass,';
$Body.= '.ExternalClass p,';
$Body.= '.ExternalClass span,';
$Body.= '.ExternalClass font,';
$Body.= '.ExternalClass td,';
$Body.= '.ExternalClass div {';
$Body.= 'line-height: 100%;';
$Body.= '}';
$Body.= '.apple-link a {';
$Body.= 'color: inherit !important;';
$Body.= 'font-family: inherit !important;';
$Body.= 'font-size: inherit !important;';
$Body.= 'font-weight: inherit !important;';
$Body.= 'line-height: inherit !important;';
$Body.= 'text-decoration: none !important;';
$Body.= '}';
$Body.= '#MessageViewBody a {';
$Body.= 'color: inherit;';
$Body.= 'text-decoration: none;';
$Body.= 'font-size: inherit;';
$Body.= 'font-family: inherit;';
$Body.= 'font-weight: inherit;';
$Body.= 'line-height: inherit;';
$Body.= '}';
$Body.= '.btn-primary table td:hover {';
$Body.= 'background-color: #34495e !important;';
$Body.= '}';
$Body.= '.btn-primary a:hover {';
$Body.= 'background-color: #34495e !important;';
$Body.= 'border-color: #34495e !important;';
$Body.= '}';
$Body.= '}';
$Body.= '';
$Body.= '</style>';
$Body.= '</head>';
$Body.= '<body class="">';
// $Body.= '<span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>';
$Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">';
$Body.= '<tr>';
$Body.= '<td>&nbsp;</td>';
$Body.= '<td class="container">';
$Body.= '<div class="content">';
$Body.= '';
$Body.= '<!-- START CENTERED WHITE CONTAINER -->';
$Body.= '<table role="presentation" class="main">';
$Body.= '';
$Body.= '<!-- START MAIN CONTENT AREA -->';
$Body.= '<tr>';
$Body.= '<td class="wrapper">';
$Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
$Body.= '<tr>';
$Body.= '<td>';
$Body.= '<center><img src="https://sso.ditp.go.th/sso/asset/img/sso-logo.png" alt="SSO Logo" width="120" border="0" style="border:0; outline:none; text-decoration:none; display:block;"></center><hr>';
//$Body.= "<p>เรียนคุณ {$name} {$lastname}</p>";
$Body.= '<p>ขั้นตอนยืนยันอีเมล (Email Verification)</p>';
$Body.= '<p>รหัสอ้างอิง : DIL8N2</p>';
$Body.= '<pกรุณายืนยันอีเมลของท่านอีกครั้ง เพื่อความสมบูรณ์ในการลงทะเบียน SSO โดยกดปุ่มยืนยันด้านล่าง</p>';
$Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">';
$Body.= '<tbody>';
$Body.= '<tr>';
$Body.= '<td align="center">';
$Body.= '<table role="presentation" border="0" cellpadding="0" cellspacing="0">';
$Body.= '<tbody>';
$Body.= '<tr>';
//$Body.= "<td><a>{$number}</a></td>";
// $Body.= "<td><a href={$url}>ยืนยันอีเมล (Confirmed Email)</a></td>";
$Body.= '</tr>';
$Body.= '</tbody>';
$Body.= '</table>';
$Body.= '</td>';
$Body.= '</tr>';
$Body.= '</tbody>';
$Body.= '</table>';
$Body.= '<p>การเปลี่ยนรหัสผ่าน</p>';
$Body.= '<p>กรุณาดำเนินการภายใน 15 นาที หากคุณไม่ได้ส่งคำขอ ตามเวลาที่กำหนดระบบจะละเว้น email ฉบับนี้</p>';     
$Body.= '</td>';
$Body.= '</tr>';
$Body.= '</table>';
$Body.= '</td>';
$Body.= '</tr>';
$Body.= '';
$Body.= '<!-- END MAIN CONTENT AREA -->';
$Body.= '</table>';
$Body.= '<!-- END CENTERED WHITE CONTAINER -->';
$Body.= '';
$Body.= '';
$Body.= '</div>';
$Body.= '</td>';
$Body.= '<td>&nbsp;</td>';
$Body.= '</tr>';
$Body.= '</table>';
$Body.= '</body>';
$Body.= '</html>';
$Body.= '';

// echo $Body;

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>SSO DITP Email Verification</title>
</head>
<body>
	<div class="container" style="display: flex;justify-content: center;">
		<div  style="max-width: 740px;display: flex;flex-direction: column;justify-content: center;align-items: center;width:100%;padding: 1rem;">
			<div style="background:linear-gradient(318.86deg, #5DBDE6 -33.84%, #1D61BD 135.37%);display:flex;width:100%;justify-content: center;padding: 1rem;">
				<img style="max-width: 110px;" src="https://sso-uat.ditp.go.th/sso/asset/img/new-sso-logo-white.png" alt="">
			</div>
			<div style="width:100%;padding: 1rem;">
				<h4 class="t-main1" style="color: #39414F!important;">ขั้นตอนยืนยันอีเมล (Email Verification)</h4>
				<p class="t-main1" style="color: #39414F!important;">รหัสอ้างอิง : DIL8N2</p>
				<p class="t-main1" style="color: #39414F!important;">กรุณายืนยันอีเมลของท่านอีกครั้ง เพื่อความสมบูรณ์ในการลงทะเบียน SSO โดยกดปุ่มยืนยันด้านล่าง</p>
				<div style="display:flex;flex-direction: column;justify-content:center;text-align: center;">
					<a style="font-weight: 400;line-height: 1.5;text-align: center;text-decoration: none;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;border: 1px solid transparent;font-size: 1rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;background-color: #2D6DC4;border-radius: 8px;color: white;width: 41%;display: inline-flex;justify-content: center;padding: 8px 15px;margin: 0 auto;"
					 href="#">ยืนยันอีเมล (Confirmed Email)</a>
					<small class="t-main1" style="color: #39414F!important;">หากท่านมีข้อสงสัยสามารถติดต่อ : 1169</small>
				</div>
			</div>
			<div style="background-color: #EFF6F9;width: 100%;padding:1rem;">
				<div style="--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(var(--bs-gutter-y) * -1);margin-right: calc(var(--bs-gutter-x) * -.5);margin-left: calc(var(--bs-gutter-x) * -.5);padding:1rem;">
					<div style="flex:0 0 auto;width:75%;">
						<p style="color: #39414F!important;">
							563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>
							โทร : 02507 7999 | e-mail : 1169@ditp.go.th
						</p>
					</div>
					<div style="flex:0 0 auto;width:25%;">
						<img style="width:100%;" src="https://sso-uat.ditp.go.th/sso/asset/img/ditp-logo.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
