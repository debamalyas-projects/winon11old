<?php

$ID = '';
$ZoneName = '';
$ZoneOrder = '';
$Status = '';
$updatedBy = '';
$UpdatedOn = '';
$createdBy = '';
$CreatedOn = '';

if(!empty($zoneInfo))
{
    foreach ($zoneInfo as $zf)
    {
		$ID = $zf->ID;
		$ZoneName = $zf->ZoneName;
		$ZoneOrder = $zf->ZoneOrder;
		$Status = $zf->Status;
		$updatedBy = $zf->updatedBy;
		$UpdatedOn = $zf->UpdatedOn;
		$createdBy = $zf->createdBy;
		$CreatedOn = $zf->CreatedOn;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Zone Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'zoneListing/';?>">Zone Listing</a>
        <small>View Zone</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Zone Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ZoneName">Zone Name</label>
                                        <?php echo $ZoneName; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ZoneOrder">Zone Order</label>
                                        <?php echo $ZoneOrder; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="createdBy">Created By</label>
                                        <?php echo $createdBy; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updatedBy">Updated By</label>
                                        <?php echo $updatedBy; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CreatedOn">Created On</label>
                                        <?php echo $CreatedOn; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="UpdatedOn">Updated On</label>
                                        <?php echo $UpdatedOn; ?>
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