<?php

include("validation.php");

if( !defined('IN_SCRIPT') )
{
	die('Unauthorized Access is Forbidden');
}


// queries the database

function query_db($sql)
{
	$result = mysql_query($sql);
	$sql_error = mysql_error();
	
		if ( DEBUG )
		{
			$display_sql = $sql;
		}

		if( !$result )
		{
			print("<font color=red><b>SQL Error!</b></font><br><br>Query:<br>$display_sql<br>$sql_error");
		}

	return $result;
}


// makes sure user doesn't inject malicious code

function clean_var($var, $escape = true)
{
	$var = htmlspecialchars(str_replace("\'", "'", trim($var)));
	if( $escape )
	{
		$var = str_replace("'", "\'", $var);
	}
	return $var;
}


// displays an html table containing custom messages
// $title = title displayed at top of message
// $message = goes into body of message table
// $align = align the message on the page
// $br_tag = ads a <br> tag after the message table

function general_message($title, $message, $align="center", $br_tag = '')
{
	
	echo '
	<div align="' .$align . '" id="errorDisplay">
        <h3 class="error">'. $title .'</h3>
    
        <p class="error" style="color:green;">'. $message .'</p>
    
        <img src="/images/spacer.gif" width="1" height="5" alt=""><br>
        </div>
	';
	if ( $br_tag = 'br' )
	{
		echo '<br>';
	}

}

function general_error_message($title, $message, $align="center", $br_tag = '')
{
	
	echo '
	<div align="' .$align . '" id="errorDisplay">
        <h3 class="error">'. $title .'</h3>
    
        <p class="error" style="color:red;">'. $message .'</p>
    
        <img src="/images/spacer.gif" width="1" height="5" alt=""><br>
        </div>
	';
	if ( $br_tag = 'br' )
	{
		echo '<br>';
	}

}




// Admin ban insert

function add_ban($info, $type, $by, $added)
{
	global $go_back;
	
	// This query only selects user info from who banned the info
	$sql = "SELECT user_id FROM " . $t_users . " WHERE username = '$by' LIMIT 1";

	$result = query_db($sql);
	$row = mysql_fetch_array($result);
	
	// This query makes sure that you do not ban the owner
	$sql2 = "SELECT username, email, user_ip FROM " . $t_users . " WHERE level = " . OWNER;
	
	$result2 = query_db($sql2);
	$row2 = mysql_fetch_array($result2);
	
	if ( $row2['username'] != $info && $row2['email'] != $info && $row2['user_ip'] != $info )
	{
	
		$sql2 = "INSERT INTO " . $t_bans . " 
				 (ban_info, ban_type, banned_by, ban_added) 
				 VALUES 
				 ('$info', '$type', '".$row['user_id']."', '$added')";
		query_db($sql2);
	}
	else
	{
		general_message("ERROR", "You cannot ban the owner of the site ($type: $info). $go_back");
		exit;
	}

}

// Checks to see if the username, email, or IP is banned
// $type = the ban type field (example: email, ip, username)
// $info = the actual data to check (example: FuN, 56.345.345.3, test@noone.com)

function check_if_banned($type, $info)
{

	$sql = "SELECT ban_info FROM $t_acc_bans WHERE ban_type = '$type' AND ban_info = '$info' LIMIT 1";

	$result = query_db($sql);
	
	if ( mysql_num_rows($result) > 0 )
	{
		$denied = TRUE;
	}
	else
	{
		$denied = FALSE;
	}	
	
	return $denied;
	
}


// This will reorder a list such as plans
// $table_name = name of DB table 
// $id_name = name of the ID row (example: plan_id)


// Strips all slashes even when stripslashes doesn't work and uses htmlspecialchars_decode() php function
// to convert htmlspecialchars from DB back into normal form.

function decode_html($value)
{
	$stripped = str_replace('\\', '', htmlspecialchars_decode($value));
	return $stripped;
}


// This prevents slashes from showing up.  This usually happens when displaying the value on page
// and when going back and forth on page, it duplicates slashes.

function strip_slash_only($value)
{
	$stripped = str_replace('\\', '', $value);
	return $stripped;
}

// Return the image extension type of file.  Mainly used in inc/file_uploader.php file
function image_function($type)
{
	switch ($type) 
	{
		case 'image/gif':
			$img_ext = '.gif';
			break;
		case 'image/jpeg':
		case 'image/pjpeg':
			$img_ext = '.jpg';
			break;
		case 'image/png':
		case 'image/x-png':
			$img_ext = '.png';
			break;	
		case 'image/bmp':
		case 'image/wbmp':
			$img_ext = '.bmp'; // FuN note: bmp has to remain even though its not used for img_ext to detect this file
			break;					
	}
		
	return $img_ext;
}

// This uses GD to resize image.
// $source = where to find image
// $target = rename/move image
// $size = width of image such as 100
// $size_height = height of image such as 100
// $quality = use 100 for max

function scale_image($source, $target, $size, $size_height, $quality)
{
      // max values for downsizing
       $width = $size;
       $height = $size_height;
       list($width_orig, $height_orig) = getimagesize($source);
       $width = $size;
       $height = $size_height;
       // Resample
       $image_p = @imagecreatetruecolor($width, $height);
       if ($image_p === false) return false;
       $image = @imagecreatefromjpeg($source);
       if ($image === false)
       {
           $data = file_get_contents($source);
           $image = @imagecreatefromstring($data);
           if ($image === false) return false;
       }
       if (!@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) return false;
       $res = @imagejpeg($image_p, $target, $quality);
       @imagedestroy($image);
       @imagedestroy($image_p);
       return $res;
}

// Newly added on 7-08-09, same as above except doesn't set the same height and width for image.

function scale_image_no_set($source, $target, $size, $quality)
    {
        // max values for downsizing
        $width = $size;
        $height = $size;
        list($width_orig, $height_orig) = getimagesize($source);
        $ratio_orig = $width_orig / $height_orig;
        if ($width / $height > $ratio_orig)
        {
            $width = $height * $ratio_orig;
        }
        else
        {
            $height = $width / $ratio_orig;
        }
        // Resample
        $image_p = @imagecreatetruecolor($width, $height);
        if ($image_p === false) return false;
        $image = @imagecreatefromjpeg($source);
        if ($image === false)
        {
            $data = file_get_contents($source);
            $image = @imagecreatefromstring($data);
            if ($image === false) return false;
        }
        if (!@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) return false;
        $res = @imagejpeg($image_p, $target, $quality);
        @imagedestroy($image);
        @imagedestroy($image_p);
        return $res;
}  



?>