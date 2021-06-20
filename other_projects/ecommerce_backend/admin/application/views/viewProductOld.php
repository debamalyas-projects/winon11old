<?php

$id = '';
$name = '';
$description = '';
$specification = '';
$brand = '';
$permalink = '';
$club_discount = '';
$tags = '';
$unit = '';
$status = '';
$created_by = '';
$created_on = '';
$updated_by = '';
$updated_on = '';


/*if(!empty($productInfo))
{
    foreach ($productInfo as $pf)
    {
		$id = $pf[0]->id;
		$name = $pf[0]->name;
		$description = $pf[0]->description;
		$specification = $pf[0]->specification;
		$status = $pf[0]->status;
		$brand = $pf[1]->name;
		$created_by = $pf[0]->created_by;
		$created_on = $pf[0]->created_on;
		$updated_by = $pf[0]->updated_by;
		$updated_on = $pf[0]->updated_on;
    }
}*/

$id = $productInfo[0]->id;
$name = $productInfo[0]->name;
$description = $productInfo[0]->description;
$specification = $productInfo[0]->specification;
$permalink = $productInfo[0]->permalink;
$tags = $productInfo[0]->tags;
$unit = $productInfo[0]->unit;
$club_discount = $productInfo[0]->club_discount;;
$status = $productInfo[0]->status;
$brand = $productInfo[1]->name;
$created_by = $productInfo[0]->created_by;
$created_on = $productInfo[0]->created_on;
$updated_by = $productInfo[0]->updated_by;
$updated_on = $productInfo[0]->updated_on;

$unit = $unitInfo[0]->name;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productListing/';?>">Product Listing</a>
        <small>View Product</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Product Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
						<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <?php echo $name; ?>
                                    </div>
								</div>
								<div>
                                    <div class="form-group">
                                        <label for="name">Club Discount</label>
                                        <?php echo $club_discount; ?>
                                    </div>
                                </div>
							</div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="unit">Product Unit</label>
                                        <?php echo $unit; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <?php echo $description; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="specification">Product Specification</label>
                                        <?php echo $specification; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="brand">Product Brand</label>
                                        <?php echo $brand; ?>
                                    </div>
                                    
                                </div>
								
                            </div>
							
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="permalink">Product Permalink</label>
                                        <?php echo $permalink; ?>
                                    </div>
                                    
                                </div>
								 <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="tags">Product Tags</label>
                                        <?php echo $tags; ?>
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