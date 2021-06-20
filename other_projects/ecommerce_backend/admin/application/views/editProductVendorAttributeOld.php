<?php

$id = '';
$product_name = '';
$vendor_name = '';
$attribute_name = '';
$attribute_id = '';
$product_id = '';
$vendor_id = '';
$value = '';
$type = '';
$price = '';
$updated_by = '';
$updated_on = '';
$created_by = '';
$created_on = '';
if(!empty($productVendorAttributeInfo))
{
    foreach ($productVendorAttributeInfo as $vf)
    {
		$id = $vf->id;
		$product_name = $vf->product_name;
		$vendor_name = $vf->vendor_name;
		$attribute_name = $vf->attribute_name;
		$attribute_id = $vf->attribute_id;
		$product_id = $vf->product_id;
		$vendor_id = $vf->vendor_id;
		$value = $vf->value;
		$type = $vf->type;
		$price = $vf->price;
		$updated_by = $vf->updated_by;
		$updated_on = $vf->updated_on;
		$created_by = $vf->created_by;
		$created_on = $vf->created_on;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Related Attribute Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productVendorAttributeListing/'.$product_id.'/0';?>">Product Related Attribute Listing</a>
        <small>Add / Edit Product Related Attribute</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Related Category Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editProductVendorAttribute" method="post" id="editProductVendorAttribute" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
										<?php echo $product_name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name</label>
                                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $vendor_id; ?>">
										
										<?php echo $vendor_name; ?>
                                    </div>
                                    
                                </div>
                            </div>
							  <div class="row">
                                <div class="col-md-6">                                
                                   <div class="form-group">
                                       <label for="attribute_id">Attribute name</label>							
										<select class="form-control required" id="attribute_id" name="attribute_id">
													<option value="">SELECT</option>
												<?php
												for($i=0;$i<count($brandRecords);$i++){
												?>
													<option value="<?php echo $brandRecords[$i]->id; ?>" <?php if($brandRecords[$i]->id==$attribute_id){ echo 'selected="selected"'; } ?>> <?php echo $brandRecords[$i]->name; ?></option>
												<?php
												}
												?>
										</select>
                                    </div>
                                   </div>
                                
								<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="type">Type</label>
										<select class="form-control required" id="type" name="type">
                                        <option value="">SELECT</option>
										<option value="flat" <?php if('flat'==$type){ echo 'selected="selected"'; } ?>> Flat</option>
										<option value="percentage" <?php if('percentage'==$type){ echo 'selected="selected"'; } ?>> Percentage</option>
										</select>
                                    </div>
                                    
                                </div>
								</div>
                           </div>
							 <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="value">Value</label>
                                        <input type="text" name="value" id="value" value="<?php echo $value; ?>"/>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" value="<?php echo $price; ?>"/>
                                    </div>
                                    
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

<script src="<?php echo base_url(); ?>assets/js/editProductVendorAttribute.js" type="text/javascript"></script>