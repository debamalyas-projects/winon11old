<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Related Pincode Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productPincodeListing/'.$product_id.'/0';?>">Product Related Pincode Listing</a>
        <small>Add / Edit Product Related Pincode</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Related Pincode Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                     <form role="form" id="addProductBrand" action="<?php echo base_url() ?>postProductPincode" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="product_id">Product name</label>
										<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
										 <?php echo $productRecord[0]->name; ?>
                                    </div>
                                    
                                </div>
							</div>
							<div class="row"><div class="col-md-4">        
									<label for="pincode">Pincode</label>							
                                    <input type="text" name="pincode" id="pincode" value="">
								
                                </div>
							</div>
							
                        </div><!-- /.box-body -->
    
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
<script src="<?php echo base_url(); ?>assets/js/addProductInformation.js" type="text/javascript"></script>