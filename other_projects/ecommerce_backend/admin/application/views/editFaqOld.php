<?php

$id = '';
$question = '';
$answer = '';
$status = '';
$updated_by = '';
$updated_on = '';


if(!empty($faqInfo))
{
    foreach ($faqInfo as $ff)
    {
		$id = $ff->id;
		$question = $ff->question;
		$answer = $ff->answer;
		$status = $ff->status;
		$updated_by = $ff->updated_by;
		$updated_on = $ff->updated_on;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Faq Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'faqListing/';?>">Faq Listing</a>
        <small>Add / Edit Faq</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Faq Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editFaq" method="post" id="editFaq" role="form">
                        <div class="box-body">
                           <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="question">Faq Question</label>
                                        <input type="text" class="form-control required" id="question" name="question" value="<?php echo $question; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="answer">Faq Answer</label>
										<textarea class="form-control required" id="answer" name="answer"><?php echo $answer; ?></textarea>
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

<script src="<?php echo base_url(); ?>assets/js/editFaq.js" type="text/javascript"></script>