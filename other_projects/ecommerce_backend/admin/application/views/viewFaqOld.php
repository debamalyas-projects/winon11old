<?php

$id = '';
$question ='';
$answer ='';
$status = '';
$created_by = '';
$created_on = '';
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
		$created_by = $ff->created_by;
		$created_on = $ff->created_on;
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
        <small>View Faq</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Faq Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="question">Questions</label>
                                        <?php echo $question; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="answer">Answers</label>
                                        <?php echo $answer; ?>
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