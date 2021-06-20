<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productListing/';?>">Product Listing</a>
        <small>Add / Edit Product</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addProduct" action="<?php echo base_url() ?>postProduct" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control required" id="name" name="name">
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
										<textarea class="form-control required" id="description" name="description"></textarea>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="specification">Product Specification</label>
										<textarea class="form-control required" id="specification" name="specification"></textarea>
                                    </div>     
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="brand">Product Brand</label>
                                        <select class="form-control required" name="brand" id="brand">
										<option value="">Select a brand</option>
										<?php
										foreach ($brandRecords as $br)
											{?>
												<option value="<?php echo $br->id; ?>"><?php echo $br->name; ?></option>
												<?php
												
											}
										?>
										</select>
									</div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="tags">Product Tags</label>
										<textarea class="form-control required" id="tags" name="tags"></textarea>
                                    </div> 
								</div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="tags">Product Unit</label>
										<select class="form-control required" name="unit" id="unit">
										<option value="">Select a unit</option>
										<?php
										foreach ($unitRecords as $ur)
											{?>
												<option value="<?php echo $ur->id; ?>"><?php echo $ur->name; ?></option>
												<?php
												
											}
										?>
										</select>
                                    </div> 									
                                
								</div>
							
							</div><!-- /.box-body -->
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="club_discount">Club Discount</label>
										<input type="text" class="form-control required" id="club_discount" name="club_discount">
                                    </div>     
                                </div>
							</div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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
<script src="<?php echo base_url(); ?>assets/js/addProduct.js" type="text/javascript"></script>