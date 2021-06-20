<?php

$id = '';
$subject = '';
$content = '';
$status = '';
$created_by = '';
$created_on = '';
$updated_by = '';
$updated_on = '';
if(!empty($promotionInfo))
{
    foreach ($promotionInfo as $pf)
    {
		$id = $pf->id;
		$subject = $pf->subject;
		$content = $pf->content;
		$status = $pf->status;
		$created_by = $pf->created_by;
		$created_on = $pf->created_on;
		$updated_by = $pf->updated_by;
		$updated_on = $pf->updated_on;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Promotion Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'promotionListing/';?>">Promotion Listing</a>
        <small>View Promotion</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Promotion Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="subject">Promotion Subject</label>
                                        <?php echo $subject; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="content">Promotion Content</label>
                                        <?php echo $content; ?>
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