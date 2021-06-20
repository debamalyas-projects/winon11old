<?php

$id = '';
$name = '';
$contact_number = '';
$email = '';
$address = '';
$status = '';
$updated_by = '';
$updated_on = '';


if(!empty($deliverypersonmanagementInfo))
{
    foreach ($deliverypersonmanagementInfo as $dpmf)
    {
		$id = $dpmf->id;
		$name = $dpmf->name;
		$contact_number = $dpmf->contact_number;
		$email = $dpmf->email;
		$address = $dpmf->address;
		$status = $dpmf->status;
		$updated_by = $dpmf->updated_by;
		$updated_on = $dpmf->updated_on;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Delivery Person Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'deliverypersonmanagementListing/';?>">Delivery Person Management Listing</a>
        <small>Add / Edit Delivery Person</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Delivery Person Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editDeliverypersonmanagement" method="post" id="editDeliverypersonmanagement" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Delivery Person Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $name?>">
										<input type="hidden" class="form-control required" id="id" name="id" value="<?php echo $id?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="text" class="form-control required" id="contact_number" name="contact_number" value="<?php echo $contact_number?>">
                                    </div>     
                                </div>
							</div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="email">Contact Email</label>
                                        <input type="text" class="form-control required" id="email" name="email" value="<?php echo $email?>">
                                    </div>     
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="address">Contact Address</label>
                                        <textarea class="form-control required" id="address" name="address"><?php echo $address; ?></textarea>
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

<script src="<?php echo base_url(); ?>assets/js/editDeliverypersonmanagement.js" type="text/javascript"></script>