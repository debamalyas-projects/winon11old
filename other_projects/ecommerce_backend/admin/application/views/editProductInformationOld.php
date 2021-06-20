<?php

$id = '';
$product_id = '';
$product_name = '';
$title = '';
$description = '';
$updated_by = '';
$updated_on = '';

if(!empty($productInformationInfo))
{
    foreach ($productInformationInfo as $vf)
    {
		$id = $vf->id;
		$product_id = $vf->product_id;
		$title = $vf->title;
		$description = $vf->description;
		$status = $vf->status;
		$updated_by = $vf->updated_by;
		$updated_on = $vf->updated_on;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Information Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productInformationListing/'.$product_id.'/0';?>">Product Information Listing</a>
        <small>Add / Edit Product Information</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Information Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editProductInformation" method="post" id="editProductInformation" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="title">Product Name</label>
										<input type="hidden" name="title" id="title" value="<?php echo $title; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
										<select class="form-control required" id="product_id" name="product_id">
												<option value="">SELECT</option>
											<?php
											for($i=0;$i<count($productRecords);$i++){
											?>
												<option value="<?php echo $productRecords[$i]->id; ?>" <?php if($productRecords[$i]->id==$product_id){ echo 'selected="selected"'; } ?>><?php echo $productRecords[$i]->name; ?></option>
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
                                        <label for="title">Product Title</label>
										<input type="text" class="form-control required" id="title" name="title" value="<?php echo $title; ?>">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
										<input type="text" class="form-control required" id="description" name="description" value="<?php echo $description; ?>">
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

<script src="<?php echo base_url(); ?>assets/js/editProductInformation.js" type="text/javascript"></script>