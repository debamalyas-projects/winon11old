<?php
include('common/include.php');
include('thirdParty/aadharintigration/aadhar.php');

check_login();

$id=$_SESSION['customer']['id'];
	
$header = file_get_contents('templates/account/common/header.html');
$account_form = file_get_contents('templates/account/account_form.html');
$footer = file_get_contents('templates/account/common/footer.html');

$content = $header.$account_form.$footer;

$tags_arr=array(
			'*{ASSET_LINK}*' => ASSET_LINK,
			'*{My_Account_Link}*' => 'myAccount.php',
			'*{BASE_URL}*' => BASE_URL,
			'*{My_Dashboard_Link}*' => 'dashboard.php',
			'*{Game_Link}*' => 'game.php',
			'*{active_status_account}*'=>'active',
			'*{Logout_Link}*' => 'logout.php'
			);
$content = replace_tags_html($tags_arr,$content);


//Fetching data from customer table
	
$request = array();
$request['tableName'] = 'customers';
$request['fields'] = array('ID'=>$id);

$request_json = json_encode($request);

$api = API_URL.'get_entity_by_fields_from_table';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array_customer = json_decode($result,true);

//customer table data store in variables
$firstName = $result_array_customer['data'][0]['FirstName'];
$lastName = $result_array_customer['data'][0]['LastName'];
$mobile = $result_array_customer['data'][0]['MobileNumber'];
$email = $result_array_customer['data'][0]['EmailAddress'];
$pan = $result_array_customer['data'][0]['PanNumber'];
$aadhar =$result_array_customer['data'][0]['AadharNumber'];
$EmailVerificationStatus = $result_array_customer['data'][0]['EmailVerificationStatus'];
$MobileVerificationStatus = $result_array_customer['data'][0]['MobileVerificationStatus'];

//Fetching data from customer information table
$request = array();
$request['tableName'] = 'customerinformation';
$request['fields'] = array('ID'=>$id);

$request_json = json_encode($request);

$api = API_URL.'get_entity_by_fields_from_table';

$curl_obj = new curl($request_json,$api);
$result = $curl_obj->exec_curl(); 

$result_array_customer_info = json_decode($result,true);

if(((count($result_array_customer_info['data']))==0)){
	$address='';
	$city='';
	$state='';
	$country='';
	$pincode='';
	$bank_name='';
	$bank_account_number='';
	$bank_ifsc='';
	$bank_branch='';
	
}else{
//customer information table data store in variables
$address=$result_array_customer_info['data'][0]['CustomerAddress'];
$city=$result_array_customer_info['data'][0]['CustomerCity'];
$state=$result_array_customer_info['data'][0]['CustomerState'];
$country=$result_array_customer_info['data'][0]['CustomerCountry'];
$pincode=$result_array_customer_info['data'][0]['CustomerPincode'];
$bank_name=$result_array_customer_info['data'][0]['CustomerBankName'];
$bank_account_number=$result_array_customer_info['data'][0]['CustomerBankAccountNumber'];
$bank_ifsc=$result_array_customer_info['data'][0]['CustomerBankIfsc'];
$bank_branch=$result_array_customer_info['data'][0]['CustomerBankBranch'];
}

$message='';
	
if(isset($_POST['account_edit'])){
	$message='';
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$pan = $_POST['pan'];
	$aadhar = $_POST['aadhar'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$country = $_POST['country'];
	$pincode = $_POST['pincode'];
	$bank_name = $_POST['bank_name'];
	$bank_account_number = $_POST['bank_account_number'];
	$bank_ifsc = $_POST['ifsc'];
	$bank_branch = $_POST['bank_branch'];
	$flag=0;
	
	// check aadhar number is valid or not

	$obj = new aadharImpliment;
	$return = $obj->aadharVerification($aadhar);
	
	// check aadhar number is valid or not
	
	if($firstName==''){
		$message=  '<div style="color:red;">Enter your first name.</div>';
	}else if($lastName==''){
		$message = '<div style="color:red;">Enter your last name.</div>';
	}else if($mobile==''){
		$message = '<div style="color:red;">Enter your mobile number.</div>';
	}else if($email==''){
		$message = '<div style="color:red;">Enter your email address.</div>';
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$message = '<div style="color:red;">Enter your valid email address.</div>';
	}else if($return==0){
		$message = '<div style="color:red;">You have entered an invalid aadhar card number.</div>';
	}else if($return==2){
		$message = '<div style="color:red;">Couldnot validate due to aadhar server error..</div>';
	}else{
		
		//check the data is allready exist in database or not
			
		$request_array = array();
		
		$request_array['query'] = 'SELECT 
		`MobileNumber`,
		`EmailAddress`,
		`PanNumber`,
		`AadharNumber` 
		 FROM `customers` WHERE `ID`!='.$id;
		 
		$request_json = json_encode($request_array);
		
		$api = API_URL.'select_query';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl();
		$result_array_customer = json_decode($result,true);
		
		for($i=0;$i<count($result_array_customer['data']);$i++){
			//echo $result_array_customer['data'][$i]['MobileNumber'];
			
			if($result_array_customer['data'][$i]['MobileNumber']==$mobile && $mobile!=''){
				$flag=1;
				$message_info='<div style="color:blue;">Mobile number is already exist</div>';
				break;
			}else if($result_array_customer['data'][$i]['EmailAddress']==$email && $email!=''){
				$flag=1;
				$message_info='<div style="color:blue;">Email is already exist</div>';
				break;
			}else if($result_array_customer['data'][$i]['PanNumber']==$pan && $pan!=''){
				$flag=1;
				$message_info='<div style="color:blue;">Pancard number is already exist</div>';
				break;
			}else if($result_array_customer['data'][$i]['AadharNumber']==$aadhar && $aadhar!=''){
				$flag=1;
				$message_info='<div style="color:blue;">Aadharcard number is already exist</div>';
				break;
			}
		}

		if($flag==1){
			$message = $message_info;
		}else{
		
			//Upload KYC Documents
			//aadhar file
			if($_FILES['aadharFile']['tmp_name']!=''){
				$file_upload_path = 'uploads/'.time().'_'.$_FILES['aadharFile']['name'];
				copy($_FILES['aadharFile']['tmp_name'],$file_upload_path);
				$file_upload_web_path = BASE_URL.$file_upload_path;
				
				$request = array();
				$request['tableName'] = 'customerbankprooffile';
				$request['fields'] = array('CustomerID'=>$id);
				
				$request_json = json_encode($request);
				
				$api = API_URL.'get_entity_by_fields_from_table';

				$curl_obj = new curl($request_json,$api);
				$result = $curl_obj->exec_curl(); 
				
				$result_array_customerbankprooffile_info = json_decode($result,true);
				
				if(count($result_array_customerbankprooffile_info['data'])==0){
					$request = array();
					$request['tableName'] = 'customerbankprooffile';
					$request['fields'] = array('CustomerID'=>$id,'BankProofFile'=>$file_upload_web_path,'UploadDate'=>date('Y/m/d h:i:s'));
					
					$request_json = json_encode($request);
					
					
					$api = API_URL.'insert_entity_into_table';

					$curl_obj = new curl($request_json,$api);

					$result = $curl_obj->exec_curl();
					$result_array_customer_info = json_decode($result,true);
				}else{
					$request = array();
					$request['tableName'] = 'customerbankprooffile';
					$request['fields_to_be_updated'] = array('BankProofFile'=>$file_upload_web_path,'UploadDate'=>date('Y/m/d h:i:s'));
					$request['fields'] = array('CustomerID'=>$id);
					
					$request_json = json_encode($request);
					
					$api = API_URL.'update_entity_fields_by_fields_from_table';

					$curl_obj = new curl($request_json,$api);

					$result = $curl_obj->exec_curl();
					$result_array_customer_info = json_decode($result,true);
				}
			}
			//aadhar file
			//pan card file
			if($_FILES['panFile']['tmp_name']!=''){
				$file_upload_path = 'uploads/'.time().'_'.$_FILES['panFile']['name'];
				copy($_FILES['panFile']['tmp_name'],$file_upload_path);
				$file_upload_web_path = BASE_URL.$file_upload_path;
				
				$request = array();
				$request['tableName'] = 'customerpancardfile';
				$request['fields'] = array('CustomerID'=>$id);
				
				$request_json = json_encode($request);
				
				$api = API_URL.'get_entity_by_fields_from_table';

				$curl_obj = new curl($request_json,$api);
				$result = $curl_obj->exec_curl(); 
				
				$result_array_customerpancardfile_info = json_decode($result,true);
				
				if(count($result_array_customerpancardfile_info['data'])==0){
					$request = array();
					$request['tableName'] = 'customerpancardfile';
					$request['fields'] = array('CustomerID'=>$id,'PanCardFile'=>$file_upload_web_path,'UploadDate'=>date('Y/m/d h:i:s'));
					
					$request_json = json_encode($request);
					
					
					$api = API_URL.'insert_entity_into_table';

					$curl_obj = new curl($request_json,$api);

					$result = $curl_obj->exec_curl();
					$result_array_customer_info = json_decode($result,true);
				}else{
					$request = array();
					$request['tableName'] = 'customerpancardfile';
					$request['fields_to_be_updated'] = array('PanCardFile'=>$file_upload_web_path,'UploadDate'=>date('Y/m/d h:i:s'));
					$request['fields'] = array('CustomerID'=>$id);
					
					$request_json = json_encode($request);
					
					$api = API_URL.'update_entity_fields_by_fields_from_table';

					$curl_obj = new curl($request_json,$api);

					$result = $curl_obj->exec_curl();
					$result_array_customer_info = json_decode($result,true);
				}
			}
			//pan card file
			//Upload KYC Documents
			
			//check the data is allready exist in database or not
		
		
			$request = array();
			$request['tableName'] = 'customers';
			$request['fields'] = array('ID'=>$id);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'get_entity_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl(); 
			
			$result_array_customer = json_decode($result,true);
			
			//if email and mobile are changed
			
			
			//update data in customers table
			$request = array();
			$request['tableName'] = 'customers';
			if(($result_array_customer['data'][0]['MobileNumber']!=$mobile)&&($result_array_customer['data'][0]['EmailAddress']!=$email)){
				$request['fields_to_be_updated'] = array('FirstName'=>$firstName,'LastName'=>$lastName,'MobileNumber'=>$mobile,'EmailAddress'=>$email,'UserName'=>$email,'PanNumber'=>$pan,'AadharNumber'=>$aadhar,'MobileVerificationStatus'=>0,'EmailVerificationStatus'=>0,'EmailVerificationCode'=>time().'email','MobileVerificationCode'=>time().'mobile');
			}else if($result_array_customer['data'][0]['MobileNumber']!=$mobile){
				$request['fields_to_be_updated'] = array('FirstName'=>$firstName,'LastName'=>$lastName,'MobileNumber'=>$mobile,'EmailAddress'=>$email,'UserName'=>$email,'PanNumber'=>$pan,'AadharNumber'=>$aadhar,'MobileVerificationStatus'=>0,'MobileVerificationCode'=>time().'mobile');
			}else if($result_array_customer['data'][0]['EmailAddress']!=$email){
				$request['fields_to_be_updated'] = array('FirstName'=>$firstName,'LastName'=>$lastName,'MobileNumber'=>$mobile,'EmailAddress'=>$email,'UserName'=>$email,'PanNumber'=>$pan,'AadharNumber'=>$aadhar,'EmailVerificationStatus'=>0,'EmailVerificationCode'=>time().'email');
			}else{
				$request['fields_to_be_updated'] = array('FirstName'=>$firstName,'LastName'=>$lastName,'MobileNumber'=>$mobile,'EmailAddress'=>$email,'UserName'=>$email,'PanNumber'=>$pan,'AadharNumber'=>$aadhar);
			}
			$request['fields'] = array('ID'=>$id);
			$request_json = json_encode($request);
			
			$api = API_URL.'update_entity_fields_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			$result_array_customer = json_decode($result,true);
			
			//check whether customer info data already available or not
			
			$request = array();
			$request['tableName'] = 'customerinformation';
			$request['fields'] = array('ID'=>$id);
			
			$request_json = json_encode($request);
			
			$api = API_URL.'get_entity_by_fields_from_table';

			$curl_obj = new curl($request_json,$api);
			$result = $curl_obj->exec_curl(); 
			
			$result_array_customer_info = json_decode($result,true);
			
			if(count($result_array_customer_info['data'])==0){
			//insert data in customerInformation table
			
			$request = array();
			$request['tableName'] = 'customerinformation';
			$request['fields'] = array('CustomerID'=>$id,'CustomerAddress'=>$address,'CustomerCity'=>$city,'CustomerState'=>$state,'CustomerCountry'=>$country,'CustomerPincode'=>$pincode,'CustomerBankName'=>$bank_name,'CustomerBankAccountNumber'=>$bank_account_number,'CustomerBankIfsc'=>$bank_ifsc);
			
			$request_json = json_encode($request);
			
			
			$api = API_URL.'insert_entity_into_table';

			$curl_obj = new curl($request_json,$api);

			$result = $curl_obj->exec_curl();
			$result_array_customer_info = json_decode($result,true);
			
			
			}else{
				// update customerinformation table
				
				$request = array();
				$request['tableName'] = 'customerinformation';
				$request['fields_to_be_updated'] = array('CustomerAddress'=>$address,'CustomerCity'=>$city,'CustomerState'=>$state,'CustomerCountry'=>$country,'CustomerPincode'=>$pincode,'CustomerBankName'=>$bank_name,'CustomerBankBranch'=>$bank_branch,'CustomerBankAccountNumber'=>$bank_account_number,'CustomerBankIfsc'=>$bank_ifsc);
				$request['fields'] = array('ID'=>$id);
				
				$request_json = json_encode($request);
				
				$api = API_URL.'update_entity_fields_by_fields_from_table';

				$curl_obj = new curl($request_json,$api);

				$result = $curl_obj->exec_curl();
				$result_array_customer_info = json_decode($result,true);
			}
			if(($result_array_customer['message']==1)&&($result_array_customer_info['message']==1)){
				$message='<div style="color:green;">Your account has been sucessfully updated.</div>';
			}else{
				$message='<div style="color:red;">We are facing temporary issue.!!!</div>';
			}
		}
	}
}
//Display customer cash

$request = array();
$request['tableName'] = 'customers';
$request['fields'] = array('ID'=>$id);

$request_json = json_encode($request);

$api = API_URL.'get_entity_by_fields_from_table';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array_customer = json_decode($result,true);

$amount=$result_array_customer['data'][0]['Amount'];
$win_amount=$result_array_customer['data'][0]['win_amount'];

/*Payumoney Payment Gateway*/
// Merchant key here as provided by Payu
$MERCHANT_KEY = MERCHANT_KEY;

// Merchant Salt as provided by Payu
$SALT = SALT;


$PAYU_BASE_URL = PAYU_BASE_URL;

$action = '';

$payu_amount='';

$posted = array();
if(isset($_POST['add_cash'])) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
$add_cash_btn = '<input type="submit" name="add_cash" class="btn btn-primary button-style w3-myfont" value="Add cash">';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
	$payu_amount='';
  } else {
	$payu_amount=$posted['amount'];
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
	$add_cash_btn = '';
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $payu_amount=$posted['amount'];
  $hash = $posted['hash'];
  $add_cash_btn = '';
  $action = $PAYU_BASE_URL . '/_payment';
}

if($formError==1){
	$formError_msg = '<span style="color:red">Please fill all mandatory fields.</span><br/>';
}else{
	$formError_msg = '';
}

if(isset($_SESSION['payu_message'])){
	$formError_msg = $_SESSION['payu_message'];
	unset($_SESSION['payu_message']);
}

$tags_arr=array(
					'*{payu_action}*' => $action,
					'*{payu_hash}*' => $hash,
					'*{payu_form_error}*' => $formError_msg,
					'*{key}*' => $MERCHANT_KEY,
					'*{txnid}*' => $txnid,
					'*{surl}*' => BASE_URL.'pay_response.php',
					'*{furl}*' => BASE_URL.'pay_fail.php',
					'*{add_cash_btn}*' => $add_cash_btn,
					'*{payu_amount}*' => $payu_amount
					);
$content = replace_tags_html($tags_arr,$content);

/*Payumoney Payment Gateway*/

//email verification


$EmailVerificationStatus=$result_array_customer['data'][0]['EmailVerificationStatus'];

if(isset($_POST["verify_email"])){
	if($EmailVerificationStatus==1){
	$message = '<div style="color:green;">Your email is allready verifyed.</div>';
	}else{
		$email=$_POST['email'];
		
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields'] = array('EmailAddress'=>$email);
		
		$request_json = json_encode($request);
		
		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 
		
		$result_array = json_decode($result,true);
		
		if($result_array['data'][0]['Status']==0){
			$message = '<div style="color:red;">Your email address is inactive.</div>';
		}else{
			
			$id = $result_array['data'][0]['ID'];
			
			//$recipient_arr = array();
			//$recipient_arr[]=array('address'=>$email,'name'=>$result_array['data'][0]['FirstName'].' '.$result_array['data'][0]['LastName']);
			
			$email_template = file_get_contents('templates/account/email_varification.html');
			
			$tags_email_arr=array(
					'*{NAME}*' => $result_array['data'][0]['FirstName'].' '.$result_array['data'][0]['LastName'],
					'*{LINK}*' => '<a href="'.BASE_URL.'email_varification.php?id='.$result_array['data'][0]['EmailVerificationCode'].'">'.BASE_URL.'email_varification.php?id='.$result_array['data'][0]['EmailVerificationCode'].'</a>'
					);
			$email_template = replace_tags_html($tags_email_arr,$email_template);
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <admin@winon11.com>' . "\r\n";
			
			mail($email,'Email verification from WinOn11',$email_template,$headers);
 
            $message ='<div style="color:green;">Email Verification Link has been sent to your Email. Please check spam mails also.</div>';
			/*$mailParams = array(
						'mailSystemArr_json'=>mailSystemArr_json,
						'recipient_arr'=>$recipient_arr,
						'replyto_arr'=>array(),
						'cc_arr'=>array(),
						'bcc_arr'=>array(),
						'attachment_arr'=>array(),
						'SetFromAddress'=>CLIENT_EMAIL,
						'SetFromName'=>CLIENT_NAME,
						'subject'=>'Email Varification',
						'content'=>$email_template
						);
			
			$mailObj = new mailer($mailParams);

			$return=$mailObj->sendMailer();

			if($return==1){
				$message ='<div style="color:green;">Email Verification Link has been sent to your Email.</div>';
			}else{
				$message = '<div style="color:red;">Failed to connect to Server. </div>';
			}*/
		}	
	}
	
}
if(isset($_SESSION['message'])){
	$value=$_SESSION['message'];
	if($value==1){
		$message ='<div style="color:green;">Your email is verified sucessfully.</div>';
		unset($_SESSION['message']); 
	}else{
		$message = '<div style="color:red;">Error !!!</div>';
		unset($_SESSION['message']);
	}
}
//email varfication

//Mobile Verfication

$MobileVerificationStatus = $result_array_customer['data'][0]['MobileVerificationStatus'];
if($MobileVerificationStatus==0){                 // check the mobile is verified or not
	$mvs='<div style="color:red;">(Unverified)</div>';
}else{
	$mvs='<div style="color:green;">(verified)</div>';
}
if(isset($_POST['verify_mobile'])){
	if($MobileVerificationStatus==1){
		$message = '<div style="color:red;">Your mobile is allready verified</div>';
	}else{
		$mobile = $_POST['mobile'];
		
		$request = array();
		$request['tableName'] = 'customers';
		$request['fields'] = array('MobileNumber'=>$mobile);

		$request_json = json_encode($request);

		$api = API_URL.'get_entity_by_fields_from_table';

		$curl_obj = new curl($request_json,$api);

		$result = $curl_obj->exec_curl(); 

		$result_array = json_decode($result,true);
		
		if($result_array['data'][0]['Status']==0){
			$message_otp = '<div style="color:red;">Your account is inactive.</div>';
		}else{
			
			$MobileOTP = $result_array['data'][0]['MobileVerificationCode'];
			
			
			$smsParams = array();
			$smsParams['sender'] = 'TXTLCL';
			$smsParams['numbers'] = array($mobile);
			$smsParams['message'] = 'Your OTP for account verification : '.$MobileOTP.' . OTP is valid for 180 seconds. Thanks - Zero2Crore .';

			$smsObj = new sms($smsParams);

			$return=$smsObj->sendSMS();
			
			header('location:mobile_otp.php');
		}
	}
}
if(isset($_SESSION['MobileVerificationStatus'])){
	$value = $_SESSION['MobileVerificationStatus'];
	if($value==1){
		$message = '<div style="color:green;">Your mobile is verified sucessfully.</div>';
		unset($_SESSION['MobileVerificationStatus']);
	}else{
		$message = '<div style="color:red;">Error !!!.</div>';
		unset($_SESSION['MobileVerificationStatus']);
	}
}
if($MobileVerificationStatus==1){
	$MobileVerificationStatusHTML = '<h3 style="color: green !important;" class="text-align-center">Verified</h3>';
}else{
	$MobileVerificationStatusHTML=file_get_contents('templates/account/mobile_verification_form.html');
	$MobileVerificationStatusHTML = replace_tags_html(array('*{mobile}*'=>$mobile),$MobileVerificationStatusHTML);
}

if($EmailVerificationStatus==1){
	$EmailVerificationStatusHTML='<h3 style="color: green !important;" class="text-align-center">Verified</h3>';
}else{
	$EmailVerificationStatusHTML=file_get_contents('templates/account/email_verification_form.html');
	$EmailVerificationStatusHTML = replace_tags_html(array('*{email}*'=>$email),$EmailVerificationStatusHTML);
}

//Mobile Varification

//Claim cash//
$request = array();
$request['query'] = "SELECT `CustomerBankName`,`CustomerBankBranch`,`CustomerBankAccountNumber`,`CustomerBankIfsc` FROM `customerinformation` WHERE `CustomerID`= '".$id."'";

$request_json = json_encode($request);

$api = API_URL.'select_query';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl(); 

$result_array = json_decode($result,true);

if(($result_array['data'][0]['CustomerBankName']=='')||($result_array['data'][0]['CustomerBankBranch']=='')||($result_array['data'][0]['CustomerBankAccountNumber']=='')||($result_array['data'][0]['CustomerBankIfsc']=='')){
	$claim_cash='';
}else{
	$claim_cash = file_get_contents('templates/account/claim_button.html');
}
//Claim cash//
$add_cash_play=file_get_contents('templates/account/add_cash_play.html');;
$tags_arr=array(
					'*{firstName}*' => $firstName,
					'*{lastName}*' => $lastName,
					'*{mobile}*' => $mobile,
					'*{email}*' => $email,
					'*{pan}*'=>$pan,
					'*{aadhar}*'=>$aadhar,
					'*{address}*'=>$address,
					'*{city}*'=>$city,
					'*{state}*'=>$state,
					'*{country}*'=>$country,
					'*{pincode}*'=>$pincode,
					'*{bank_name}*'=>$bank_name,
					'*{bank_branch}*'=>$bank_branch,
					'*{bank_account_number}*'=>$bank_account_number,
					'*{ifsc}*'=>$bank_ifsc,
					'*{amount}*'=>$amount,
					'*{win_amount}*'=>$win_amount,
					'*{alert-msg}*'=>$message,
					'*{email_verification_form}*'=>$EmailVerificationStatusHTML,
					'*{mobile_verification_form}*'=>$MobileVerificationStatusHTML,
					'*{claim_cash}*'=> $claim_cash,
					'*{add_cash_play}*'=>$add_cash_play
					);
$content = replace_tags_html($tags_arr,$content);
$tags_arr=array(
		'*{subscription_message}*' => $subscription_message
		);
$content = replace_tags_html($tags_arr,$content);
echo $content;