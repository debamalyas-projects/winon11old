<?php

$id = '';
$name = '';
$product_name = '';
$email = '';
$contact = '';
$message = '';
$status = '';
$created_by = '';
$created_on = '';
$updated_by = '';
$updated_on = '';


if(!empty($reviewInfo))
{
    foreach ($reviewInfo as $pf)
    {
		$id = $pf->id;
		$name = $pf->name;
		$product_name = $pf->product_name;
		$email = $pf->email;
		$contact = $pf->contact;
		$message = $pf->message;
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
        <i class="fa fa-users"></i> Review Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'reviewListing/';?>">Review Listing</a>
        <small>View Review</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Review Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
						<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <?php echo $product_name; ?>
                                    </div>
                                    
                                </div>
							</div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Reviewer Name</label>
                                        <?php echo $name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="email">Reviewer Email</label>
                                        <?php echo $email; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="contact">Reviewer Contact Number</label>
                                        <?php echo $contact; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="message">Review Message</label>
                                        <?php echo $message; ?>
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