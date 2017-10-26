<?php

$lang['upload_userfile_not_set'] = "اطلاعات فرم ارسالی صحیح نیست";
$lang['upload_file_exceeds_limit'] = "برای آپلود فایل ، باید محدودیت حجم را از فایل تنظیمات پی اچ پی تغییر دهید .";
$lang['upload_file_exceeds_form_limit'] = "برای آپلود فایل باید محدودیت حجم را از داخل اسکریپت تغییر دهید .";
$lang['upload_file_partial'] = "The file was only partially uploaded.";
$lang['upload_no_temp_directory'] = "پوشه ذخیره سازی موقت یافت نشد /";
$lang['upload_unable_to_write_file'] = "فایل قابل نوشتن نیست .";
$lang['upload_stopped_by_extension'] = "آپلود فایل با یک اکستنشن متوقف شد .";
$lang['upload_no_file_selected'] = "";
$lang['upload_invalid_filetype'] = "پسوند فایل انتخابی ، در لیست پسوند های مجاز نیست .";
$lang['upload_invalid_filesize'] = "حجم فایل بیشتر از میزان تعیین شده است .";
$lang['upload_invalid_dimensions'] = "The image you are attempting to upload exceedes the maximum height or width.";
$lang['upload_destination_error'] = "خطایی در انتقال فایل از پوشه تمپ به پوشه محصولات پیش آمد";
$lang['upload_no_filepath'] = "مسیر آپلود فایل نامعتبر است .";
$lang['upload_no_file_types'] = "شما اجازه هیچ فایلی را ندارید .";
$lang['upload_bad_filename'] = "فایل انتخابی شما برروی سرور موجود است .";
$lang['upload_not_writable'] = "پوشه محصولات ، غیرقابل نوشتن است .";


foreach($lang as $key=>$val)
{
	if($key !='upload_no_file_selected')
	$lang[$key] = "<div class=err-no>{$val}</div>";
	else
	$lang[$key] = "";
}

	
