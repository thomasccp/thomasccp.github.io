#!/usr/bin/php
<?PHP
require_once("./include/membersite_config.php");

if(isset($_POST['submitted']))
{
	if($fgmembersite->RegisterUser())
	{
		$fgmembersite->RedirectToURL("thank-you.html");
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
	<title>The First OpenSPL Summer School Symposium Registration</title>
	<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
	<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>

<div id="page-area">

<div id='header'>
<img src="https://www.imperial.ac.uk/2007templates/images/logo_imperial_college_london.png" style="margin-left: 10px;" alt="Imperial College London" title="Imperial College London"  />
</div>

<!-- Form Code Start -->
<div id='fg_membersite'>
<form id='register' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>The First OpenSPL Summer School Symposium Registration</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<div class='short_explanation'>* required fields</div>
<input type='text'  class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<div class='container'>
	<label for='firstname' >First Name*: </label><br/>
	<input type='text' name='firstname' id='firstname' value='<?php echo $fgmembersite->SafeDisplay('firstname') ?>' maxlength="50" /><br/>
	<span id='register_firstname_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='lastname' >Last Name*: </label><br/>
	<input type='text' name='lastname' id='lastname' value='<?php echo $fgmembersite->SafeDisplay('lastname') ?>' maxlength="50" /><br/>
	<span id='register_lastname_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='institution' >Institution/Department*: </label><br/>
	<input type='text' name='institution' id='institution' value='<?php echo $fgmembersite->SafeDisplay('institution') ?>' maxlength="200" /><br/>
	<span id='register_institution_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='address' >Address*: </label><br/>
	<input type='text' name='address' id='address' value='<?php echo $fgmembersite->SafeDisplay('address') ?>' maxlength="500" /><br/>
	<span id='register_address_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='phone' >Phone Number*: </label><br/>
	<input type='text' name='phone' id='phone' value='<?php echo $fgmembersite->SafeDisplay('phone') ?>' maxlength="20" /><br/>
	<span id='register_phone_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='email' >Email*:</label><br/>
	<input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
	<span id='register_email_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='dietary' >Dietary Requirements:</label><br/>
	<input type='text' name='dietary' id='dietary' value='<?php echo $fgmembersite->SafeDisplay('dietary') ?>' maxlength="200" /><br/>
	<span id='register_dietary_errorloc' class='error'></span>
</div>

<div class='container'>
	<input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>

</div>

<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->
<script type='text/javascript'>
<![CDATA[
	var pwdwidget = new PasswordWidget('thepwddiv','password');
pwdwidget.MakePWDWidget();

var frmvalidator  = new Validator("register");
frmvalidator.EnableOnPageErrorDisplay();
frmvalidator.EnableMsgsTogether();
frmvalidator.addValidation("firstname","req","Please provide your first name");
frmvalidator.addValidation("lastname","req","Please provide your last name");
frmvalidator.addValidation("institution","req","Please provide your institution/department");
frmvalidator.addValidation("address","req","Please provide your address");
frmvalidator.addValidation("phone","req","Please provide your phone number");
frmvalidator.addValidation("email","req","Please provide your email address");
frmvalidator.addValidation("email","email","Please provide a valid email address");

]]>
</script>

<!--
Form Code End (see html-form-guide.com for more info.)
-->

</div>

</body>
</html>
