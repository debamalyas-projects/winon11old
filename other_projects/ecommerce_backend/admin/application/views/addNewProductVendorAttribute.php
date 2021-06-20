<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Vendor Atribute Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'productVendorAttributeListing/'.$vendor_id.'/'.$product_id.'/0';?>">Product Vendor Atribute Listing</a>
        <small>Add / Edit Product Vendor Atribute</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Product Vendor Atribute Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                     <form role="form" id="addProductBrand" action="<?php echo base_url() ?>postProductVendorAttribute" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="product_id">Product name</label>
										<input type="hidden" name="product_id" id="product_id" value="<?php echo $productRecord[0]->id; ?>">
										 <?php echo $productRecord[0]->name; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_id">Vendor name</label>
										<input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $vendorRecord[0]->id; ?>">
										 <?php echo $vendorRecord[0]->name; ?>
                                    </div>
                                </div>
							</div>
							<div class="row">
								<div class="col-md-6">        
									<label for="attribute_id">Attribute name</label>							
                                    <select class="form-control required" id="attribute_id" name="attribute_id">
												<option value="">SELECT</option>
											<?php
											for($i=0;$i<count($brandRecords);$i++){
											?>
												<option value="<?php echo $brandRecords[$i]->id; ?>"><?php echo $brandRecords[$i]->name; ?></option>
											<?php
											}
											?>
										</select>
                                </div>
								<div class="col-md-6">        
									<label for="type">Type</label>							
                                    <select class="form-control required" id="type" name="type">
											<option value="">SELECT</option>
											<option value="flat">Flat</option>
											<option value="percentage">Percentage</option>
										</select>
                                </div>
								
							</div>
							<div class="row">
                                <div class="col-md-6">                                
                                   <div class="form-group">
                                        <label for="value">Value</label>
										<input type="text" name="value" id="value" value="">
									</div>
								</div>
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
										<input type="text" name="price" id="price" value="">
                                    </div>
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