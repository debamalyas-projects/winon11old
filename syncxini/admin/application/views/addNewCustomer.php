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
                    
                    <form role="form" id="addCustomer" action="<?php echo base_url() ?>postCustomer" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="FirstName">First Name</label>
                                        <input type="text" class="form-control required" id="FirstName" name="FirstName">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="LastName">Last Name</label>
                                        <input type="text" class="form-control required" id="LastName" name="LastName">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MobileNumber">Mobile Number</label>
                                        <input type="text" class="form-control required" id="MobileNumber" name="MobileNumber">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="EmailAddress">Email Address</label>
                                        <input type="text" class="form-control required" id="EmailAddress" name="EmailAddress">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="PanNumber">Pan Number</label>
                                        <input type="text" class="form-control required" id="PanNumber" name="PanNumber">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="AadharNumber">Aadhar Number</label>
                                        <input type="text" class="form-control required" id="AadharNumber" name="AadharNumber">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerAddress">Customer Address</label>
                                        <input type="text" class="form-control" id="CustomerAddress" name="CustomerAddress">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerCity">Customer City</label>
                                        <input type="text" class="form-control" id="CustomerCity" name="CustomerCity">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerState">Customer State</label>
                                        <input type="text" class="form-control" id="CustomerState" name="CustomerState">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerCountry">Customer Country</label>
                                        <input type="text" class="form-control" id="CustomerCountry" name="CustomerCountry">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPincode">Customer Pincode</label>
                                        <input type="text" class="form-control" id="CustomerPincode" name="CustomerPincode">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankName">Customer Bank Name</label>
                                        <input type="text" class="form-control" id="CustomerBankName" name="CustomerBankName">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankAccountNumber">Customer Bank Account Number</label>
                                        <input type="text" class="form-control" id="CustomerBankAccountNumber" name="CustomerBankAccountNumber">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankIfsc">Customer Bank Ifsc</label>
                                        <input type="text" class="form-control" id="CustomerBankIfsc" name="CustomerBankIfsc">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerAccountVerificationStatus">Customer Aadhar Verification Status</label><br>
                                        Verified <input type="radio" id="CustomerAccountVerificationStatus" name="CustomerAccountVerificationStatus" value="1">
										Not verified <input type="radio" id="CustomerAccountVerificationStatus" name="CustomerAccountVerificationStatus" value="0" checked="checked">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerBankVerificationDate">Customer Aadhar Verification Date</label>
                                        <input type="text" class="form-control datepicker" id="CustomerBankVerificationDate" name="CustomerBankVerificationDate">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPANVerificationStatus">Customer PAN Verification Status</label><br>
                                        Verified <input type="radio" id="CustomerPANVerificationStatus" name="CustomerPANVerificationStatus" value="1">
										Not Verified <input type="radio" id="CustomerPANVerificationStatus" name="CustomerPANVerificationStatus" value="0" checked="checked">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CustomerPANVerificationDate">Customer PAN Verification Date</label>
                                        <input type="text" class="form-control datepicker" id="CustomerPANVerificationDate" name="CustomerPANVerificationDate">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="password" class="form-control required" id="Password" name="Password">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ConfirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control required" id="ConfirmPassword" name="ConfirmPassword">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="PanCardFile">Pan Card File</label>
                                        <input type="file" class="form-control" id="PanCardFile" name="PanCardFile">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="BankProofFile">Aadhar Card File</label>
                                        <input type="file" class="form-control" id="BankProofFile" name="BankProofFile">
                                    </div>
                                    
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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
<script src="<?php echo base_url(); ?>assets/js/addCustomer.js" type="text/javascript"></script>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-sliderAccess.js"></script>
<script>
$('.datepicker').datetimepicker();
</script>