<?php

$id = '';
$name = '';
$product_id = '';
$email = '';
$contact = '';
$message = '';
$status = '';
$updated_by = '';
$updated_on = '';


if(!empty($reviewInfo))
{
    foreach ($reviewInfo as $pf)
    {
		$id = $pf->id;
		$name = $pf->name;
		$product_id = $pf->product_id;
		$email = $pf->email;
		$contact = $pf->contact;
		$message = $pf->message;
		$status = $pf->status;
		$updated_by = $pf->updated_by;
		$updated_on = $pf->updated_on;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Review Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'reviewListing/';?>">Review Listing</a>
        <small>Add / Edit Review</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Review Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editReview" method="post" id="editReview" role="form">
                        <div class="box-body">
						<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="product_id">Product Name</label>
										<select class="form-control required" id="product_id" name="product_id">
												<option value="">SELECT</option>
											<?php
											for($i=0;$i<count($brandRecords);$i++){
											?>
												<option value="<?php echo $brandRecords[$i]->id; ?>" <?php if($brandRecords[$i]->id==$product_id){ echo 'selected="selected"'; } ?>> <?php echo $brandRecords[$i]->name; ?></option>
											<?php
											}
											?>
										</select>
                                    </div>
                                </div>
							</div>
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Reviewer Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $name; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="email">Reviewer Email</label>
										<textarea class="form-control required" id="email" name="email"><?php echo $email; ?></textarea>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="contact">Reviewer Contact</label>
										<textarea class="form-control required" id="contact" name="contact"><?php echo $contact; ?></textarea>
                                    </div>     
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="message">Reviewer Message</label>
                                        <input type="text" class="form-control required" id="message" name="message" value="<?php echo $message; ?>">
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

<script src="<?php echo base_url(); ?>assets/js/editReview.js" type="text/javascript"></script>