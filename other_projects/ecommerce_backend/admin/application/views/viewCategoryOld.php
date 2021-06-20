<?php


$name = '';
$permalink = '';
$status = '';
$created_by = '';
$created_on = '';
$updated_by = '';
$updated_on = '';



if(!empty($categoryInfo))
{
    foreach ($categoryInfo as $dpmf)
    {
		$name = $dpmf->name;
		$permalink = $dpmf->permalink;
		$status = $dpmf->status;
		$created_by = $dpmf->created_by;
		$created_on = $dpmf->created_on;
		$updated_by = $dpmf->updated_by;
		$updated_on = $dpmf->updated_on;
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Category Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'categoryListing/';?>">Category Listing</a>
        <small>View Category</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Category Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <?php echo $name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
									<div class="form-group">
                                        <label for="permalink">Category Permalink</label>
                                        <?php echo $permalink; ?>
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