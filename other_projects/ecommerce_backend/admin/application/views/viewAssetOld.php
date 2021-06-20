<?php

$id = '';
$name = '';
$path = '';
$status = '';
$updated_by = '';
$updated_on = '';
$created_by = '';
$created_on = '';

if(!empty($assetInfo))
{
    foreach ($assetInfo as $af)
    {
		$id = $af->id;
		$name = $af->name;
		$path = $af->path;
		$status = $af->status;
		$updated_by = $af->updated_by;
		$updated_on = $af->updated_on;
		$created_by = $af->created_by;
		$created_on = $af->created_on;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Asset Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'assetListing/';?>">Asset Listing</a>
        <small>View Asset</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Asset Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Asset Name</label>
                                        <?php echo $name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="path">File</label>
                                        <a href="<?php echo $path; ?>" target="_blank">Download</a>
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