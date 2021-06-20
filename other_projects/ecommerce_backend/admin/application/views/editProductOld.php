<?php

$id = '';
$name = '';
$tags = '';
$description = '';
$specification = '';
$club_discount = '';
$status = '';
$updated_by = '';
$updated_on = '';


/*if(!empty($productInfo))
{
    foreach ($productInfo as $pf)
    {
		$id = $pf->id;
		$name = $pf->name;
		$description = $pf->description;
		$specification = $pf->specification;
		$status = $pf->status;
		$updated_by = $pf->updated_by;
		$updated_on = $pf->updated_on;
    }
}*/
$brand_array = array();
for($i=0;$i<count($productInfo);$i++){
	if($i>1){
		$brand_array[$i] = $productInfo[$i];	
	}
}

$id = $productInfo[0]->id;
$name = $productInfo[0]->name;
$tags = $productInfo[0]->tags;
$description = $productInfo[0]->description;
$specification = $productInfo[0]->specification;
$status = $productInfo[0]->status;
$brand_id = $productInfo[0]->brand;
$unit_id = $productInfo[0]->unit;
$club_discount = $productInfo[0]->club_discount;
$brand = $productInfo[1]->name;
$created_by = $productInfo[0]->created_by;
$created_on = $productInfo[0]->created_on;
$updated_by = $productInfo[0]->updated_by;
$updated_on = $productInfo[0]->updated_on;

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productListing/';?>">Product Listing</a>
        <small>Add / Edit Product</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editProduct" method="post" id="editProduct" role="form">
                        <div class="box-body">
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $name; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
										<textarea class="form-control required" id="description" name="description"><?php echo $description; ?></textarea>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="specification">Product Specification</label>
										<textarea class="form-control required" id="specification" name="specification"><?php echo $specification; ?></textarea>
                                    </div>     
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="brand">Product Brand</label>
                                        <select class="form-control required" name="brand" id="brand">
										
										<?php
										for($i=2;$i<count($brand_array)+2;$i++){?>
											<option value="<?php echo $brand_array[$i]->id ?>" <?php if($brand_id==$brand_array[$i]->id){ echo 'selected="selected"'; }else{ echo ''; } ?>><?php echo $brand_array[$i]->name; ?></option><?php
										}
										?>
										</select>
                                    </div>     
                                </div>
								<!--brand-->
							</div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="tags">Product Tags</label>
										<textarea class="form-control required" id="tags" name="tags"><?php echo $tags; ?></textarea>
                                    </div>  
								</div>
								<div class="col-md-6">      
									<div class="form-group">
                                        <label for="unit">Product Unit</label>
										<select class="form-control required" name="unit" id="unit">
										
										<?php
										for($i=0;$i<count($unitInfo);$i++){?>
											<option value="<?php echo $unitInfo[$i]->id ?>" <?php if($unit_id==$unitInfo[$i]->id){ echo 'selected="selected"'; }else{ echo ''; } ?>><?php echo $unitInfo[$i]->name; ?></option><?php
										}
										?>
										</select>
                                    </div>  									
                                </div>
							</div>
							<div class="row">
								<div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="club_discount">Club Discount</label>
										<input type="text" class="form-control required" id="club_discount" name="club_discount" value="<?php echo $club_discount; ?>">
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

<script src="<?php echo base_url(); ?>assets/js/editProduct.js" type="text/javascript"></script>