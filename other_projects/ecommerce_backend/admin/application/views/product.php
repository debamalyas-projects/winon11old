<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Product Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewProduct"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Product List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>productListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <th>Product Name</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($productRecords))
                    {
                        foreach($productRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->id; ?></td>
                      <td><?php echo $record->name; ?></td>
				   <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editProductOld/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'viewProductOld/'.$record->id; ?>"><i class="fa fa-eye"></i></a>
                          <a class="btn btn-sm btn-danger changeStatusProduct" href="javascript:void(0);" data-productid="<?php echo $record->id; ?>">
							<?php
								if($record->status==1){
									echo "Disable";
								}else{
									echo"Enable";
								}
							?>
						  </a>
						   <a class="btn btn-sm btn-info" href="<?php echo base_url().'productInformationListing/'.$record->id.'/0'; ?>">Product Information</a>
						   <a class="btn btn-sm btn-info" href="<?php echo base_url().'productRelatedBrandListing/'.$record->id.'/0'; ?>">Product Related Brand</a>
						    <a class="btn btn-sm btn-info" href="<?php echo base_url().'productRelatedCategoryListing/'.$record->id.'/0'; ?>">Product Related Category</a>
							<a class="btn btn-sm btn-info" href="<?php echo base_url().'productRelatedAssetListing/'.$record->id.'/0'; ?>">Product Related Asset</a>
							<a class="btn btn-sm btn-info" href="<?php echo base_url().'productRelatedAssetLinkListing/'.$record->id.'/0'; ?>">Product Related Asset Link</a>
							<a class="btn btn-sm btn-info" href="<?php echo base_url().'addRelatedProductListing/'.$record->id.'/0'; ?>">Add Related Product</a>
                      </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "productListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>