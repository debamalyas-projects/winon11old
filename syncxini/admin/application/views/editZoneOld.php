<?php

$ID = '';
$ZoneName = '';
$ZoneOrder = '';
$Status = '';
$updatedBy = '';
$UpdatedOn = '';


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
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Zone Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'zoneListing/';?>">Zone Listing</a>
        <small>Add / Edit Zone</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Zone Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editZone" method="post" id="editZone" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ZoneName">Zone Name</label>
                                        <input type="text" class="form-control required" id="ZoneName" name="ZoneName" value="<?php echo $ZoneName; ?>">
										<input type="hidden" name="ID" id="ID" value="<?php echo $ID; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ZoneOrder">Zone Order</label>
                                        <input type="text" class="form-control required" id="ZoneOrder" name="ZoneOrder" value="<?php echo $ZoneOrder; ?>">
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

<script src="<?php echo base_url(); ?>assets/js/editZone.js" type="text/javascript"></script>