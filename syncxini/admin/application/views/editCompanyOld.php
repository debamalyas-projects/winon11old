<?php

$ID = '';
$CompanyName = '';
$CompanyCode = '';
$InstrumentToken = '';
$ExchangeToken = '';
$InstrumentType = '';
$Segment = '';
$Exchange = '';
$Status = '';
$updatedBy = '';
$UpdatedOn = '';


if(!empty($companyInfo))
{
    foreach ($companyInfo as $cf)
    {
		$ID = $cf->ID;
		$CompanyName = $cf->CompanyName;
		$CompanyCode = $cf->CompanyCode;
		$InstrumentToken = $cf->InstrumentToken;
		$ExchangeToken = $cf->ExchangeToken;
		$InstrumentType = $cf->InstrumentType;
		$Segment = $cf->Segment;
		$Exchange = $cf->Exchange;
		$Status = $cf->Status;
		$updatedBy = $cf->updatedBy;
		$UpdatedOn = $cf->UpdatedOn;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'companyListing/';?>">Company Listing</a>
        <small>Add / Edit Company</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Company Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editCompany" method="post" id="editCompany" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyName">Company Name</label>
                                        <input type="text" class="form-control required" id="CompanyName" name="CompanyName" value="<?php echo $CompanyName; ?>">
										<input type="hidden" name="ID" id="ID" value="<?php echo $ID; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyCode">Company Code</label>
                                        <input type="text" class="form-control required" id="CompanyCode" name="CompanyCode" value="<?php echo $CompanyCode; ?>">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="InstrumentToken">Instrument Token</label>
                                        <input type="text" class="form-control required" id="InstrumentToken" name="InstrumentToken" value="<?php echo $InstrumentToken; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ExchangeTokename">Exchange Token</label>
                                        <input type="text" class="form-control required" id="ExchangeToken" name="ExchangeToken" value="<?php echo $ExchangeToken; ?>">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="InstrumentType">Instrument Type</label>
                                        <input type="text" class="form-control required" id="InstrumentType" name="InstrumentType" value="<?php echo $InstrumentType; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Segment">Segment</label>
                                        <input type="text" class="form-control required" id="Segment" name="Segment" value="<?php echo $Segment; ?>">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Exchange">Exchange</label>
                                        <input type="text" class="form-control required" id="Exchange" name="Exchange" value="<?php echo $Exchange; ?>">
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

<script src="<?php echo base_url(); ?>assets/js/editCompany.js" type="text/javascript"></script>