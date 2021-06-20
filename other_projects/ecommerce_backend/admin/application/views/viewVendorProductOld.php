<?php

$id = '';
$product_name = '';
$vendor_email = '';
$status = '';
$updated_by = '';
$updated_on = '';
$created_by = '';
$created_on = '';

if(!empty($vendorProductInfo))
{
    foreach ($vendorProductInfo as $vf)
    {
		$id = $vf->id;
		$product_name = $vf->product_name;
		$vendor_email = $vf->vendor_email;
		$status = $vf->status;
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
        <i class="fa fa-users"></i> Vendor Product Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'vendorProductListing/'.$product_id.'/0';?>">Vendor Product Listing</a>
        <small>View Vendor Product</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Vendor Product Details</h3>
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
                                        <label for="vendor_email">Vendor Email</label>
                                        <?php echo $vendor_email; ?>
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