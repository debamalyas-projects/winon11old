<?php

$id = '';
$product_id = '';
$related_product_id = '';
$product_name = '';
$related_product_name = '';
$updated_by = '';
$updated_on = '';

if(!empty($addRelatedProductInfo))
{
    foreach ($addRelatedProductInfo as $vf)
    {
		$id = $vf->id;
		$product_id = $vf->product_id;
		$related_product_id = $vf->related_product_id;
		$product_name = $vf->product_name;
		$related_product_name = $vf->related_product_name;
		$updated_by = $vf->updated_by;
		$updated_on = $vf->updated_on;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i>Related Product Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'addRelatedProduct/'.$product_id.'/0';?>">Related Product Listing</a>
        <small>Add / Edit Related Product</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Related Product Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editAddRelatedProduct" method="post" id="editAddRelatedProduct" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="title">Product Name</label>
										<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
										<?php echo $product_name; ?>
                                    </div>
								</div>
								<div class="col-md-12">                                
                                    <div class="form-group">
                                       <label for="related_product_id">Related Product Name</label>							
										<select class="form-control required" id="related_product_id" name="related_product_id">
													<option value="">SELECT</option>
												<?php
												for($i=0;$i<count($brandRecords);$i++){
												?>
													<option value="<?php echo $brandRecords[$i]->id; ?>" <?php if($brandRecords[$i]->id==$related_product_id){ echo 'selected="selected"'; } ?>> <?php echo $brandRecords[$i]->name; ?></option>
												<?php
												}
												?>
										</select>
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

<script src="<?php echo base_url(); ?>assets/js/editAddRelatedProduct.js" type="text/javascript"></script>