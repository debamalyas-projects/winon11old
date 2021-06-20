<?php

$id = '';
$name = '';
$contact_number = '';
$email = '';
$address = '';
$status = '';
$created_by = '';
$created_on = '';
$updated_by = '';
$updated_on = '';



if(!empty($deliverypersonmanagementInfo))
{
    foreach ($deliverypersonmanagementInfo as $dpmf)
    {
		$id = $dpmf->id;
		$name = $dpmf->name;
		$contact_number = $dpmf->contact_number;
		$email = $dpmf->email;
		$address = $dpmf->address;
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
        <i class="fa fa-users"></i> Delivery Person Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'deliverypersonmanagementListing/';?>">Delivery Person Listing</a>
        <small>View Delivery Person</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Delivery Person Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Delivery Person Name</label>
                                        <?php echo $name; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="contact_number">Delivery Person Contact Number</label>
                                        <?php echo $contact_number; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="email">Delivery Person Email</label>
                                        <?php echo $email; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="address">Delivery Person Contact Address</label>
                                        <?php echo $address; ?>
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