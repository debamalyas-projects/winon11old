<?php

$id = '';
$name = '';
$contact_number = '';
$email = '';
$shipping_address = '';
$billing_address = '';
$status = '';
$created_by='';
$updated_by = '';
$created_on='';
$updated_on = '';


if(!empty($customerInfo))
{
    foreach ($customerInfo as $cf)
    {
		$id = $cf->id;
		$name = $cf->name;
		$contact_number = $cf->contact_number;
		$email = $cf->email;
		$shipping_address = $cf->shipping_address;
		$billing_address = $cf->billing_address;
		$status = $cf->status;
		$created_by=$cf->created_by;
		$updated_by = $cf->updated_by;
		$created_on=$cf->created_on;
		$updated_on = $cf->updated_on;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Customer Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'customerListing/';?>">Customer Listing</a>
        <small>Add / Edit customer</small>
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
                    
                    <form role="form" action="<?php echo base_url() ?>editCustomer" method="post" id="editCustomer" role="form">
                        <div class="box-body">
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Customer Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $name; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="contact_number">Customer Contact Number</label>
										<input type="text" class="form-control required" id="contact_number" name="contact_number" value="<?php echo $contact_number; ?>">
                                    </div>     
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="email">Customer Email</label>
										<input type="text" class="form-control required" id="email" name="email" value="<?php echo $email; ?>">
                                    </div>     
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="shipping_address">Customer Shipping Address</label>
                                        <textarea class="form-control required" id="shipping_address" name="shipping_address"><?php echo $shipping_address; ?></textarea>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="billing_address">Customer Billing Address</label>
										<textarea class="form-control required" id="billing_address" name="billing_address"><?php echo $billing_address; ?></textarea>
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