<?php

$id = '';
$subject = '';
$content = '';
$status = '';
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
        <small>Add / Edit Promotion</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Promotion Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editPromotion" method="post" id="editPromotion" role="form">
                        <div class="box-body">
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="subject">Promotion Subject</label>
                                       <textarea class="ckeditor" class="form-control" id="subject" name="subject" rows="4" cols="50"><?php echo $subject; ?></textarea>
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="content">Promotion Content</label>
										<textarea class="ckeditor" class="form-control" id="content" name="content" rows="4" cols="50"><?php echo $content; ?></textarea>
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
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/js/editPromotion.js" type="text/javascript"></script>