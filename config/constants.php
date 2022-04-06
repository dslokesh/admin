<?php
$pageURL = @$_SERVER["SERVER_NAME"];
$siteFoler = dirname(dirname(@$_SERVER['SCRIPT_NAME']));
$siteUrl = $pageURL.$siteFoler.'/';
$siteUrl = str_replace('\\','/',$siteUrl);
$siteUrl = str_replace('//','/',$siteUrl);

$siteUrl = @$_SERVER['APP_URL'];

return [
	'SITE_URL' =>$siteUrl,
	'ADMIN_PAGE_LIMIT' => '10',
	'ADMIN_NAME' => 'MyQuip Admin',
	'SITE_NAME' => 'MyQuip',
	'SITE_FOOTER' => "© ".date('Y')." MyQuip. All Rights Reserved.",
	'MAIL_FROM_EMAIL' => 'myquip@mailinator.com',
	'MAIL_FROM_NAME' => 'MyQuip',
	'CONTACT_EMAIL' => 'myquip_contact@yopmail.com',
	'CONTACT_EMAIL_SUBJECT' => 'Contact us enquiry from MyQuip',
	'CONTACT_EMAIL_SUBJECT_USER' => 'Thank You',
	'ADMIN_MAIL' => 'myquip_admin@yopmail.com',
	//'RECAPTCHA_SITE_KEY' => '6LdeR9UUAAAAADpy3OzNUr6P04htVf3UtZtVFMEZ',
	//'RECAPTCHA_SECRET_KEY' => '6LdeR9UUAAAAAL7zjTU6NhSfCVGqj6k1Rmji1cvv',
	//'formErrorMsg' => 'There are some error in form submission, please find error in below form.',
];
?>