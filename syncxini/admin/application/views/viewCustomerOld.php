<?php

$ID = '';
$FirstName = '';
$LastName = '';
$UserName = '';
$Password = '';
$MobileNumber = '';
$EmailAddress = '';
$PanNumber = '';
$AadharNumber = '';
$MobileVerificationStatus = '';
$MobileVerificationCode = '';
$EmailVerificationStatus = '';
$EmailVerificationCode = '';
$FacebookLinkedAccount = '';
$FacebookAccountEmailAddress = '';
$GoogleLinkedAccount = '';
$GoogleAccountEmailAddress = '';
$updatedBy = '';
$updatedOn = '';
$createdBy = '';
$createdOn = '';
$Status = '';

$CDID = '';
$CustomerAddress = '';
$CustomerCity = '';
$CustomerState = '';
$CustomerCountry = '';
$CustomerPincode = '';
$CustomerBankName = '';
$CustomerBankAccountNumber = '';
$CustomerAccountVerificationStatus = '';
$CustomerBankVerificationDate = '';
$CustomerPANVerificationStatus = '';
$CustomerPANVerificationDate = '';
$CustomerBankIfsc = '';

$PanCardFile = '';
$UploadDatePF = '';

$BankProofFile = '';
$UploadDateBP = '';

if(!empty($customerInfo))
{
    foreach ($customerInfo as $cf)
    {
		$ID = $cf->ID;
		$FirstName = $cf->FirstName;
		$LastName = $cf->LastName;
		$UserName = $cf->UserName;
		$Password = $cf->Password;
		$MobileNumber = $cf->MobileNumber;
		$EmailAddress = $cf->EmailAddress;
		$PanNumber = $cf->PanNumber;
		$AadharNumber = $cf->AadharNumber;
		$MobileVerificationStatus = $cf->MobileVerificationStatus;
		$MobileVerificationCode = $cf->MobileVerificationCode;
		$EmailVerificationStatus = $cf->EmailVerificationStatus;
		$EmailVerificationCode = $cf->EmailVerificationCode;
		$FacebookLinkedAccount = $cf->FacebookLinkedAccount;
		$FacebookAccountEmailAddress = $cf->FacebookAccountEmailAddress;
		$GoogleLinkedAccount = $cf->GoogleLinkedAccount;
		$GoogleAccountEmailAddress = $cf->GoogleAccountEmailAddress;
		$updatedBy = $cf->updatedBy;
		$updatedOn = $cf->updatedOn;
		$createdBy = $cf->createdBy;
		$createdOn = $cf->createdOn;
		$Status = $cf->Status;
    }
}

if(!empty($customerDetailsInfo))
{
    foreach ($customerDetailsInfo as $cdf)
    {
		$CDID = $cdf->ID;
		$CustomerAddress = $cdf->CustomerAddress;
		$CustomerCity = $cdf->CustomerCity;
		$CustomerState = $cdf->CustomerState;
		$CustomerCountry = $cdf->CustomerCountry;
		$CustomerPincode = $cdf->CustomerPincode;
		$CustomerBankName = $cdf->CustomerBankName;
		$CustomerBankAccountNumber = $cdf->CustomerBankAccountNumber;
		$CustomerAccountVerificationStatus = $cdf->CustomerAccountVerificationStatus;
		$CustomerBankVerificationDate = $cdf->CustomerBankVerificationDate;
		$CustomerPANVerificationStatus = $cdf->CustomerPANVerificationStatus;
		$CustomerPANVerificationDate = $cdf->CustomerPANVerificationDate;
		$CustomerBankIfsc = $cdf->CustomerBankIfsc;
    }
}

if(!empty($customerPanFileInfo))
{
    foreach ($customerPanFileInfo as $cpf)
    {
		$CPID = $cpf->ID;
		$PanCardFile = $cpf->PanCardFile;
		$UploadDatePF = $cpf->UploadDate;
    }
}

if(!empty($customerBankProofFileInfo))
{
    foreach ($customerBankProofFileInfo as $cbpf)
    {
		$CBPID = $cbpf->ID;
		$BankProofFile = $cbpf->BankProofFile;
		$UploadDateBP = $cbpf->UploadDate;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Customer Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'customerListing/';?>">Customer Listing</a>
        <small>View Customer</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Customer Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="FirstName">First Name</label>
                                        <?php echo $FirstName; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="LastName">Last Name</label>
                                        <?php echo $LastName; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="UserName">User Name</label>
                                        <?php echo $UserName; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MobileNumber">Mobile Number</label>
                                        <?php echo $MobileNumber; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="EmailAddress">Email Address</label>
                                        <?php echo $EmailAddress; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="PanNumber">Pan Number</label>
                                        <?php echo $PanNumber; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="AadharNumber">Aadhar Number</label>
                                        <?php echo $AadharNumber; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MobileVerificationStatus">Mobile Verification Status</label>
                                        <?php
											if($MobileVerificationStatus=='1'){
												echo 'Verified'; 
											}else{
												echo 'Not verified';
											}
										?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MobileVerificationCode">Mobile Verification Code</label>
                                        <?php echo $MobileVerificationCode; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="EmailVerificationStatus">Email Verification Status</label>
                                        <?php
											if($EmailVerificationStatus=='1'){
												echo 'Verified'; 
											}else{
												echo 'Not verified';
											}
										?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="EmailVerificationCode">Email Verification Code</label>
                                        <?php echo $EmailVerificationCode; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="FacebookLinkedAccount">Facebook Linked Account</label>
                                        <?php
											if($FacebookLinkedAccount=='0'){
												echo 'Not linked'; 
											}else{
												echo 'Linked';
											}
										?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="FacebookAccountEmailAddress">Facebook Account Email Address</label>
                                        <?php echo $FacebookAccountEmailAddress; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="GoogleLinkedAccount">Google Linked Account</label>
                                        <?php
											if($GoogleLinkedAccount=='0'){
												echo 'Not linked'; 
											}else{
												echo 'Linked';
											}
										?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="GoogleAccountEmailAddress">Google Account Email Address</label>
                                        <?php echo $GoogleAccountEmailAddress; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Status">Status</label>
                                        <?php
											if($Status=='0'){
												echo 'Disabled'; 
											}else{
												echo 'Enabled';
											}
										?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="createdBy">Created By</label>
                                        <?php echo $createdBy; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updatedBy">Updated By</label>
                                        <?php echo $updatedBy; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="createdOn">Created On</label>
                                        <?php echo $createdOn; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updatedOn">Updated On</label>
                                        <?php echo $updatedOn; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerAddress">Customer Address</label>
                                        <?php echo $CustomerAddress; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerCity">Customer City</label>
                                        <?php echo $CustomerCity; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerState">Customer State</label>
                                        <?php echo $CustomerState; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerCountry">Customer Country</label>
                                        <?php echo $CustomerCountry; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPincode">Customer Pincode</label>
                                        <?php echo $CustomerPincode; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankName">Customer Bank Name</label>
                                        <?php echo $CustomerBankName; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankAccountNumber">Customer Bank Account Number</label>
                                        <?php echo $CustomerBankAccountNumber; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankIfsc">Customer Bank Ifsc</label>
                                        <?php echo $CustomerBankIfsc; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerAccountVerificationStatus">Customer Aadhar Verification Status</label>
                                        <?php 
											if($CustomerAccountVerificationStatus==0){
												echo 'Not verified';
											}else{
												echo 'Verified';
											}
										?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankVerificationDate">Customer Aadhar Verification Date</label>
                                        <?php echo $CustomerBankVerificationDate; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPANVerificationStatus">Customer PAN Verification Status</label>
                                        <?php 
											if($CustomerPANVerificationStatus==0){
												echo 'Not verified';
											}else{
												echo 'Verified';
											}
										?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPANVerificationDate">Customer PAN Verification Date</label>
                                        <?php echo $CustomerPANVerificationDate; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="BankProofFile">Aadhar Card File</label>
										<?php
											if($BankProofFile!=''){
										?>
										
										<a href="<?php echo $BankProofFile; ?>" target="_blank">Download</a>
										<?php
											}else{
												echo 'Not uploaded yet.';
											}
										?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="UploadDate">Upload Date of Aadhar Card file</label>
                                        <?php echo $UploadDateBP; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="PanCardFile">Pan Card File</label>
										<?php
											if($PanCardFile!=''){
										?>
										
										<a href="<?php echo $PanCardFile; ?>" target="_blank">Download</a>
										<?php
											}else{
												echo 'Not uploaded yet.';
											}
										?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="UploadDate">Upload Date of Pan Card file</label>
                                        <?php echo $UploadDatePF; ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>