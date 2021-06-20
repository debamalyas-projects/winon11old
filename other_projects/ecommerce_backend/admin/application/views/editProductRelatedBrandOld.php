<?php

$id = '';
$product_id = '';
$product_name = '';
$brand_name = '';
$updated_by = '';
$updated_on = '';

if(!empty($productRelatedBrandInfo))
{
    foreach ($productRelatedBrandInfo as $vf)
    {
		$id = $vf->id;
		$product_id = $vf->product_id;
		$brand_id = $vf->brand_id;
		$product_name = $vf->product_name;
		$brand_name = $vf->brand_name;
		$updated_by = $vf->updated_by;
		$updated_on = $vf->updated_on;
    }
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Related Brand Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productRelatedBrand/'.$product_id.'/0';?>">Product Related Brand Listing</a>
        <small>Add / Edit Product Related Brand</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Related Brand Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editProductRelatedBrand" method="post" id="editProductRelatedBrand" role="form">
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
                                       <label for="brand_id">Brand name</label>							
										<select class="form-control required" id="brand_id" name="brand_id">
													<option value="">SELECT</option>
												<?php
												for($i=0;$i<count($brandRecords);$i++){
												?>
													<option value="<?php echo $brandRecords[$i]->id; ?>" <?php if($brandRecords[$i]->id==$brand_id){ echo 'selected="selected"'; } ?>> <?php echo $brandRecords[$i]->name; ?></option>
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

<script src="<?php echo base_url(); ?>assets/js/editProductRelatedBrand.js" type="text/javascript"></script>