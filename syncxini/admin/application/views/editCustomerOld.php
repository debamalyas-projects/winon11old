<?php

$ID = '';
$FirstName = '';
$LastName = '';
$PanNumber = '';
$AadharNumber = '';

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

$BankProofFile = '';


if(!empty($customerInfo))
{
    foreach ($customerInfo as $cf)
    {
		$ID = $cf->ID;
		$FirstName = $cf->FirstName;
		$LastName = $cf->LastName;
		$PanNumber = $cf->PanNumber;
		$AadharNumber = $cf->AadharNumber;
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
    }
}

if(!empty($customerBankProofFileInfo))
{
    foreach ($customerBankProofFileInfo as $cbpf)
    {
		$CBPID = $cbpf->ID;
		$BankProofFile = $cbpf->BankProofFile;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Customer Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'customerListing/';?>">Customer Listing</a>
        <small>Add / Edit Customer</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Customer Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editCustomer" method="post" id="editCustomer" role="form" enctype="multipart/form-data">
                        <div class="box-body">
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="FirstName">First Name</label>
                                        <input type="text" class="form-control required" id="FirstName" name="FirstName" value="<?php echo $FirstName; ?>">
										<input type="hidden" name="ID" id="ID" value="<?php echo $ID; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="LastName">Last Name</label>
                                        <input type="text" class="form-control required" id="LastName" name="LastName" value="<?php echo $LastName; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="PanNumber">Pan Number</label>
                                        <input type="text" class="form-control required" id="PanNumber" name="PanNumber" value="<?php echo $PanNumber; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="AadharNumber">Aadhar Number</label>
                                        <input type="text" class="form-control required" id="AadharNumber" name="AadharNumber" value="<?php echo $AadharNumber; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerAddress">Customer Address</label>
                                        <input type="text" class="form-control" id="CustomerAddress" name="CustomerAddress" value="<?php echo $CustomerAddress; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerCity">Customer City</label>
                                        <input type="text" class="form-control" id="CustomerCity" name="CustomerCity" value="<?php echo $CustomerCity; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerState">Customer State</label>
                                        <input type="text" class="form-control" id="CustomerState" name="CustomerState" value="<?php echo $CustomerState; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerCountry">Customer Country</label>
                                        <input type="text" class="form-control" id="CustomerCountry" name="CustomerCountry" value="<?php echo $CustomerCountry; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPincode">Customer Pincode</label>
                                        <input type="text" class="form-control" id="CustomerPincode" name="CustomerPincode" value="<?php echo $CustomerPincode; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankName">Customer Bank Name</label>
                                        <input type="text" class="form-control" id="CustomerBankName" name="CustomerBankName" value="<?php echo $CustomerBankName; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankAccountNumber">Customer Bank Account Number</label>
                                        <input type="text" class="form-control" id="CustomerBankAccountNumber" name="CustomerBankAccountNumber" value="<?php echo $CustomerBankAccountNumber; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankIfsc">Customer Bank Ifsc</label>
                                        <input type="text" class="form-control" id="CustomerBankIfsc" name="CustomerBankIfsc" value="<?php echo $CustomerBankIfsc; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerAccountVerificationStatus">Customer Aadhar Verification Status</label><br>
                                        Verified <input type="radio" id="CustomerAccountVerificationStatus" name="CustomerAccountVerificationStatus" value="1" <?php if($CustomerAccountVerificationStatus==1){ echo 'checked="checked"'; }else{ echo ''; } ?>>
										Not verified <input type="radio" id="CustomerAccountVerificationStatus" name="CustomerAccountVerificationStatus" value="0" <?php if($CustomerAccountVerificationStatus==0){ echo 'checked="checked"'; }else{ echo ''; } ?>>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankVerificationDate">Customer Aadhar Verification Date</label>
                                        <input type="text" class="form-control datepicker" id="CustomerBankVerificationDate" name="CustomerBankVerificationDate" value="<?php echo $CustomerBankVerificationDate; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPANVerificationStatus">Customer PAN Verification Status</label><br>
                                        Verified <input type="radio" id="CustomerPANVerificationStatus" name="CustomerPANVerificationStatus" value="1" <?php if($CustomerPANVerificationStatus==1){ echo 'checked="checked"'; }else{ echo ''; } ?>>
										Not Verified <input type="radio" id="CustomerPANVerificationStatus" name="CustomerPANVerificationStatus" value="0" <?php if($CustomerPANVerificationStatus==0){ echo 'checked="checked"'; }else{ echo ''; } ?>>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPANVerificationDate">Customer PAN Verification Date</label>
                                        <input type="text" class="form-control datepicker" id="CustomerPANVerificationDate" name="CustomerPANVerificationDate" value="<?php echo $CustomerPANVerificationDate; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="PanCardFile">Pan Card File</label>
                                        <input type="file" class="form-control" id="PanCardFile" name="PanCardFile"><hr>
										<a href="<?php echo $PanCardFile; ?>" target="_blank">Download</a>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="BankProofFile">Aadhar Card File</label>
                                        <input type="file" class="form-control" id="BankProofFile" name="BankProofFile"><hr>
										<a href="<?php echo $BankProofFile; ?>" target="_blank">Download</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Edit" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editCustomer.js" type="text/javascript"></script>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-sliderAccess.js"></script>
<script>
$('.datepicker').datetimepicker();
</script>