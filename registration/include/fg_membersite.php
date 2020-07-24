<?PHP
/*
	Registration/Login script from HTML Form Guide
	V1.0

	This program is free software published under the
	terms of the GNU Lesser General Public License.
	http://www.gnu.org/copyleft/lesser.html


This program is distributed in the hope that it will
be useful - WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.

For updates, please visit:
http://www.html-form-guide.com/php-form/php-registration-form.html
http://www.html-form-guide.com/php-form/php-login-form.html

 */
require_once("class.phpmailer.php");
require_once("formvalidator.php");

class FGMembersite
{
	var $admin_email_1;
	var $admin_email_2;
	var $admin_email_3;
	var $admin_email_4;
	var $from_address;

	var $username;
	var $pwd;
	var $database;
	var $tablename;
	var $connection;
	var $rand_key;

	var $error_message;

	//-----Initialization -------
	function FGMembersite()
	{
		$this->sitename = 'doc.ic.ac.uk';
		$this->rand_key = 'AzbKhnufuj558R4';
	}

	function SetAdminEmail($email_1, $email_2 = '', $email_3 = '', $email_4 = '')
	{
		$this->admin_email_1 = $email_1;
		$this->admin_email_2 = $email_2;
		$this->admin_email_3 = $email_3;
		$this->admin_email_4 = $email_4;
	}

	function SetWebsiteName($sitename)
	{
		$this->sitename = $sitename;
	}

	function SetRandomKey($key)
	{
		$this->rand_key = $key;
	}

	//-------Main Operations ----------------------
	function RegisterUser()
	{
		if(!isset($_POST['submitted']))
		{
			return false;
		}

		$formvars = array();

		if(!$this->ValidateRegistrationSubmission())
		{
			return false;
		}

		$this->CollectRegistrationSubmission($formvars);

		if(!$this->SaveToCSV($formvars))
		{
			return false;
		}

		//if(!$this->SendUserRegistrationEmail($formvars))
		//{
		//    return false;
		//}

		$this->SendAdminIntimationEmail($formvars);

		return true;
	}

	//-------Public Helper functions -------------
	function GetSelfScript()
	{
		return htmlentities($_SERVER['PHP_SELF']);
	}    

	function SafeDisplay($value_name)
	{
		if(empty($_POST[$value_name]))
		{
			return'';
		}
		return htmlentities($_POST[$value_name]);
	}

	function RedirectToURL($url)
	{
		header("Location: $url");
		exit;
	}

	function GetSpamTrapInputName()
	{
		return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
	}

	function GetErrorMessage()
	{
		if(empty($this->error_message))
		{
			return '';
		}
		$errormsg = nl2br(htmlentities($this->error_message));
		return $errormsg;
	}    
	//-------Private Helper functions-----------

	function HandleError($err)
	{
		$this->error_message .= $err."\r\n";
	}

	function GetFromAddress()
	{
		if(!empty($this->from_address))
		{
			return $this->from_address;
		}

		$host = $_SERVER['SERVER_NAME'];

		$from ="no-reply@$host";
		return $from;
	} 

	function ValidateRegistrationSubmission()
	{
		//This is a hidden input field. Humans won't fill this field.
		if(!empty($_POST[$this->GetSpamTrapInputName()]) )
		{
			//The proper error is not given intentionally
			$this->HandleError("Automated submission prevention: case 2 failed");
			return false;
		}

		$validator = new FormValidator();
		$validator->addValidation("firstname","req","Please fill in first name");
		$validator->addValidation("lastname","req","Please fill in last name");
		$validator->addValidation("institution","req","Please fill in institution/department");
		$validator->addValidation("address","req","Please fill in address");
		$validator->addValidation("phone","req","Please fill in phone number");
		$validator->addValidation("email","req","Please fill in email");
		$validator->addValidation("email","email","The input for email should be a valid email value");


		if(!$validator->ValidateForm())
		{
			$error='';
			$error_hash = $validator->GetErrors();
			foreach($error_hash as $inpname => $inp_err)
			{
				$error .= $inpname.':'.$inp_err."\n";
			}
			$this->HandleError($error);
			return false;
		}        
		return true;
	}

	function CollectRegistrationSubmission(&$formvars)
	{
		$formvars['firstname'] = $this->Sanitize($_POST['firstname']);
		$formvars['lastname'] = $this->Sanitize($_POST['lastname']);
		$formvars['institution'] = $this->Sanitize($_POST['institution']);
		$formvars['address'] = $this->Sanitize($_POST['address']);
		$formvars['phone'] = $this->Sanitize($_POST['phone']);
		$formvars['email'] = $this->Sanitize($_POST['email']);
		$formvars['dietary'] = $this->Sanitize($_POST['dietary']);
		if ($formvars['dietary'] == '') {
			$formvars['dietary'] = "None";
		}
	}

	function SendUserRegistrationEmail(&$formvars)
	{
		$mailer = new PHPMailer();

		$mailer->CharSet = 'utf-8';

		$mailer->AddAddress($formvars['email'],$formvars['firstname']." ".$formvars['lastname']);

		$mailer->Subject = "Your registration for the First OpenSPL Summer School Symposium";

		$mailer->FromName = "OpenSPL Summer School Symposium";

		$mailer->From = $this->GetFromAddress();        

		$mailer->Body ="Hello ".$formvars['firstname'].",\r\n\r\n".
			"Thank you very much for your interest in attending the First OpenSPL Summer School Symposium. Your registration is confirmed and further information about the schedule and location of this event will be sent to you. For further information, please contact w.luk@imperial.ac.uk\r\n\r\n".
			"Here are your provided details:\r\n\r\n".
			"Name: ".$formvars['firstname']." ".$formvars['lastname']."\r\n".
			"Institution/department: ".$formvars['institution']."\r\n".
			"Address: ".$formvars['address']."\r\n".
			"Phone number: ".$formvars['phone']."\r\n".
			"Email: ".$formvars['email']."\r\n".
			"Dietary requirement: ".$formvars['dierary']."\r\n\r\n";

		if(!$mailer->Send())
		{
			$this->HandleError("Failed sending registration confirmation email.");
			return false;
		}
		return true;
	}

	function SendAdminIntimationEmail(&$formvars)
	{
		if(empty($this->admin_email_1))
		{
			return false;
		}
		$mailer = new PHPMailer();

		$mailer->CharSet = 'utf-8';

		$mailer->AddAddress($this->admin_email_1);
		if(!empty($this->admin_email_2))
		{
			$mailer->AddAddress($this->admin_email_2);
			if(!empty($this->admin_email_3))
			{
				$mailer->AddAddress($this->admin_email_3);
				if(!empty($this->admin_email_4))
				{
					$mailer->AddAddress($this->admin_email_4);
				}
			}
		}

		$mailer->Subject = "The First OpenSPL Summer School Symposium new registration: ".$formvars['firstname']." ".$formvars['lastname'];

		$mailer->FromName = "OpenSPL Summer School Symposium";        

		$mailer->From = $this->GetFromAddress();         

		$mailer->Body ="A new person is registered for the First OpenSPL Summer School Symposium:\r\n\r\n".
			"Name: ".$formvars['firstname']." ".$formvars['lastname']."\r\n".
			"Institution/department: ".$formvars['institution']."\r\n".
			"Address: ".$formvars['address']."\r\n".
			"Phone number: ".$formvars['phone']."\r\n".
			"Email: ".$formvars['email']."\r\n".
			"Dietary requirement: ".$formvars['dietary']."\r\n";

		if(!$mailer->Send())
		{
			return false;
		}
		return true;
	}

	function SaveToCSV(&$formvars)
	{
		$cvsData = "\"".$formvars['firstname']."\",\"".$formvars['lastname']."\",\"".$formvars['institution']."\",\"".$formvars['address']."\",\"".$formvars['phone']."\",\"".$formvars['email']."\",\"".$formvars['dietary']."\"".PHP_EOL; 
		$fp = fopen("data/registration_data.csv", "a"); 

		if($fp) 
		{ 
			fwrite($fp,$cvsData); // Write information to the file 
			fclose($fp); // Close the file 
		} 
		return true;
	}

 /*
	Sanitize() function removes any potential threat from the
	data submitted. Prevents email injections or any other hacker attempts.
	if $remove_nl is true, newline chracters are removed from the input.
  */
	function Sanitize($str,$remove_nl=true)
	{
		$str = $this->StripSlashes($str);

		if($remove_nl)
		{
			$injections = array('/(\n+)/i',
				'/(\r+)/i',
				'/(\t+)/i',
				'/(%0A+)/i',
				'/(%0D+)/i',
				'/(%08+)/i',
				'/(%09+)/i'
			);
			$str = preg_replace($injections,'',$str);
		}

		return $str;
	}    
	function StripSlashes($str)
	{
		if(get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		return $str;
	}    
}
?>
