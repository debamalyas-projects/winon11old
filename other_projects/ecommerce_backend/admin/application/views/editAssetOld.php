<?php

$id = '';
$name = '';
$path = '';
$status = '';
$updated_by = '';
$updated_on = '';

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
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Asset Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'assetListing/';?>">Asset Listing</a>
        <small>Add / Edit Asset</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Asset Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editAsset" method="post" id="editAsset" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Asset name</label>
										<input type="text" class="form-control required" id="name" name="name" value="<?php echo $name; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                    </div>
									
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="path">Upload Asset</label>
										<input type="file" class="form-control" id="path" name="path">
										<a href="<?php echo $path; ?>" target="_blank">Download</a>
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

<script src="<?php echo base_url(); ?>assets/js/editAsset.js" type="text/javascript"></script>