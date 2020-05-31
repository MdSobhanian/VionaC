 <script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>
<center>
<?php 

require_once('form_config.php');
// Check to see if the form has been submitted
if (isset($_POST['submit'])) { 


require_once('recaptchalib.php');   
$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);    

// Assign the post variable and sanitize it  
  	$name = (filter_var($_POST['name'], FILTER_SANITIZE_STRING)); 
	if ($name == "") $errors .= 'Please enter a valid name.<br />';
         
 // Sanitize the email address and check it is valid 
  	$email = (filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
  	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors .= "Please enter a correct email address.<br />";
  
// Sanitize the phone number if it exists
	if ($_POST['phone'] != "") {
	$phone = (filter_var($_POST['phone'], FILTER_SANITIZE_STRING));
	}

// Sanitize the company if it exists 
	if ($_POST['company'] != "") { 
  	$company = (filter_var($_POST['company'], FILTER_SANITIZE_STRING));
	}
  
// Sanitize the URL if it exists
	if ($_POST['website'] != "") {
  		$website = (filter_var($_POST['website'], FILTER_SANITIZE_URL));
 		 if (!filter_var($website, FILTER_VALIDATE_URL)) $errors .= "$website is not a valid URL.<br />";
	}
  
// Sanitize the comments  
	$comments = (filter_var($_POST['comments'], FILTER_SANITIZE_STRING));
	if ($comments == "") $errors .= 'Please enter some comments.<br />';
  
// Check to see if any errors did occur
	$validation_check="";
	if(isset($errors)) $validation_check.= $errors;   
	if (!$resp->is_valid) $validation_check.="The reCAPTCHA wasn't entered correctly.<br />";

// If no errors then send the mail and create the success message
	if (!$validation_check) {
	$message = "Name: ".$name."\r\n"."Company: ".$company."\r\n"."Phone: ".$phone."\r\n"."Website: ".$website."\r\n\r\n"."Comments: ".$comments."\r\n";
	mail( $my_email, "Subject: Enquiry from $my_website", $message, "From: $email" );
	$validation_message = $success_message; 
	} else {
	$validation_message = $validation_check;}
}
?>
 <br />
<form method="post" class="contactForm" action="contact-us">
<table class="form_table" style="font-family:Tahoma !important; font-size:12px;">
  <? //Display Error Message
if($validation_message== $success_message) { ?>
<tr><td colspan="2"><span class="form_message_success" style="color:green; font-weight:bold;"><?php echo $validation_message; ?></span><br /></td></tr>
<?php } else if($validation_message!="") { ?>
<tr><td colspan="2"><span class="form_message_fail" style="color:red; font-weight:bold;"><?php echo $validation_message; ?></span><br /></td></tr>
<?php } ?>
<tr><td colspan="2"><p align="left"><center>Use the <strong>Contact Form</strong> below to reach us.<br />Fields marked with <span class="required">*</span> are required.</center></p><br /></td></tr>
<tr>
    <td class="form_title"><p>Name:<span class="required">*</span></p></td>
    <td><input type="text" name="name" id="name" required value="<?php echo $_POST['name']; ?>" /></td>
  </tr>
  <tr>
    <td class="form_title"><p>Email:<span class="required">*</span></p></td>
    <td><input type="text" name="email" id="email" required value="<?php echo $_POST['email']; ?>" /></td>
  </tr>
  <tr>
    <td class="form_title"><p>Phone:<span class="not_required">*</span></p></td>
    <td><input type="text" name="phone" id="phone" value="<?php echo $_POST['phone']; ?>" /></td>
  </tr>
  <tr>
    <td class="form_title"><p>Company:<span class="not_required">*</span></p></td>
    <td><input type="text" name="company" id="company" value="<?php echo $_POST['company']; ?>" /></td>
  </tr>
  <tr>
    <td class="form_title"><p>Website:<span class="not_required">*</span></p></td>
    <td><input type="text" name="website" id="website" value="http://<?php echo $_POST['website']; ?>" /><br />
    <span class="url_example" style="font-size:10px;">(e.g. http://www.your-site.com)</span></td>
  </tr>
  <tr>
    <td class="form_title"><p>Message:<span class="required">*</span></p></td>
    <td><textarea name="comments" id="comments" required rows="6"><?php echo $_POST['comments']; ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php  
  require_once('recaptchalib.php');       
  echo recaptcha_get_html($publickey,null,1);     
  ?><br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Submit" /></td>
  </tr>
 
  </table>
</form>
</center>