<?php


if( !defined('IN_SCRIPT') )
{
	die('Unauthorized Access is Forbidden');
}



// Convert bytes to KB

$kb_convert = round(($_FILES["img_upload"]["size"] / 1024), 2);


switch ($upload_type) 
{
case 'avatar':

	// full avatar path
	
	$full_avatar_path = $site_path . $avatar_dir . '/';

	$img_ext = image_function($_FILES["img_upload"]["type"]);	
	
	//echo dirname($_SERVER['PHP_SELF']) . ' ' . $full_avatar_path; exit; // testing
		

	// rename image after user's ID

	$img_upload_name = str_replace($_FILES["img_upload"]["name"], $user_id . $img_ext, $_FILES["img_upload"]["name"]);

	//echo $img_upload_name; exit; // testing
	
		
	// Check avatar dimensions

	$imagesize = getimagesize($_FILES["img_upload"]["tmp_name"]);
	$imagewidth = $imagesize[0];
	$imageheight = $imagesize[1];
	


	// error checks
		
     
	if ( !preg_match('/^image/', $img_upload_type, $matches) )
	{ 
	     general_message("ERROR", "Avatar has to be an image $go_back");
		 exit(); 
	}
	
	if ( $imagewidth > $avatar_max_width || $imageheight > $avatar_max_height )
	{ 
	     general_message("ERROR", "Avatar is too large. ($imagewidth height X $imageheight width pixels)
		 						   Max size is $avatar_max_width height X $avatar_max_height width pixels.  $go_back");					
		 exit(); 
	}
	  
	if ( $_FILES["img_upload"]["size"] > $file_size )
	{
		general_message("ERROR", "Avatar is too large (".$_FILES["img_upload"]["size"]." bytes).  The max file size is $file_size bytes ($kb_convert) kb. $go_back");
		exit();
	}
	 
	 

	 
	if ( file_exists($full_avatar_path . $img_upload_name) )
	{
		general_message("ERROR", "Please delete your current avatar if you wish to upload a new one. $go_back");
		exit();
	}
	// if all is ok upload file
	elseif (@is_uploaded_file($_FILES["img_upload"]["tmp_name"])) 
	{
		copy($_FILES["img_upload"]["tmp_name"], $full_avatar_path . $img_upload_name);
		
		if ( $no_display_success_msg != 1 )
		{
			general_message("Avatar Uploaded Successfully", 
			"File Rename: " . $img_upload_name . "<br />
			 File Type: " . $img_upload_type . "<br />
			 File Size: " . ($_FILES["img_upload"]["size"] ) . " bytes ($kb_convert KB)<br />");
		
			 echo  "<br />";
		 }
		 
		 // BEGIN New GD addon
		 $av_img_rename = str_replace($_FILES["img_upload"]["name"], $user_id . '_gd'.  $img_ext, $_FILES["img_upload"]["name"]);
		 $av_img_path = $site_path . 'images/avatars/' . $av_img_rename; 
	
		 scale_image($_FILES["img_upload"]["tmp_name"], $av_img_path, 60, 60, 100);	
		 // END New GD addon
	}
	 
break;


default:

echo 'This page is not complete';

break;
} // end switch

?> 