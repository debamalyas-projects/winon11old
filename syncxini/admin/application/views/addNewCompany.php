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
                    
                    <form role="form" id="addCompany" action="<?php echo base_url() ?>postCompany" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyName">Company Name</label>
                                        <input type="text" class="form-control required" id="CompanyName" name="CompanyName">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyCode">Company Code</label>
                                        <input type="text" class="form-control required" id="CompanyCode" name="CompanyCode">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="InstrumentToken">Instrument Token</label>
                                        <input type="text" class="form-control required" id="InstrumentToken" name="InstrumentToken">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ExchangeToken">Exchange Token</label>
                                        <input type="text" class="form-control required" id="ExchangeToken" name="ExchangeToken">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="InstrumentType">Instrument Type</label>
                                        <input type="text" class="form-control required" id="InstrumentType" name="InstrumentType">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Segment">Segment</label>
                                        <input type="text" class="form-control required" id="Segment" name="Segment">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Exchange">Exchange</label>
                                        <input type="text" class="form-control required" id="Exchange" name="Exchange">
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
<script src="<?php echo base_url(); ?>assets/js/addCompany.js" type="text/javascript"></script>