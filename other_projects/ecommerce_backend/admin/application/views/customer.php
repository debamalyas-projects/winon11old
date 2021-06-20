<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Customer Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewCustomer"><i class="fa fa-plus"></i> Add New Customer</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Customer List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>customerListing" method="POST" id="searchList">
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
                      <th>Customer Name</th>
                      <th>Customer contact Number</th>
					  <th>Customer Email</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($customerRecords))
                    {
                        foreach($customerRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->id; ?></td>
                      <td><?php echo $record->name; ?></td>
                      <td><?php echo $record->contact_number; ?></td>
					  <td><?php echo $record->email; ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editCustomerOld/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'viewCustomerOld/'.$record->id; ?>"><i class="fa fa-eye"></i></a>
                          <a class="btn btn-sm btn-danger changeStatusCustomer" href="javascript:void(0);" data-customerid="<?php echo $record->id; ?>">
							<?php
								if($record->status==1){
									echo "Disable";
								}else{
									echo"Enable";
								}
							?>
						  </a>
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
            jQuery("#searchList").attr("action", baseURL + "customerListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>