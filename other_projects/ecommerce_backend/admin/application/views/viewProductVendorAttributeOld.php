<?php

$id = '';
$product_name = '';
$vendor_name = '';
$attribute_name = '';
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
        <i class="fa fa-users"></i>Product Related Attributes Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productVendorAttributeListing/'.$vendor_id.'/'.$product_id.'/0';?>">Product Related Attributes Listing</a>
        <small>View Related Attributes </small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Product Related Category Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <?php echo $product_name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="vendor_name">Vendor Name</label>
                                        <?php echo $vendor_name; ?>
                                    </div>
                                    
                                </div>
                            </div>
							 <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="attribute_name">Attribute Name</label>
                                        <?php echo $attribute_name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <?php echo $type; ?>
                                    </div>
                                    
                                </div>
                            </div>
							 <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="value">Value</label>
                                        <?php echo $value; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <?php echo $price; ?>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="created_by">Created By</label>
                                        <?php echo $created_by; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updated_by">Updated By</label>
                                        <?php echo $updated_by; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="created_on">Created On</label>
                                        <?php echo $created_on; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updated_on">Updated On</label>
                                        <?php echo $updated_on; ?>
                                    </div>
                                </div>
                            </div>
							
                               
                        </div><!-- /.box-body -->
                        
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>