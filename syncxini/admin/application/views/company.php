<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewCompany"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Company List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>companyListing" method="POST" id="searchList">
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
                      <th>Id</th>
                      <th>Company Name</th>
                      <th>Company Code</th>
                      <th>Instrument Type</th>
                      <th>Segment</th>
					  <th>Exchange</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($companyRecords))
                    {
                        foreach($companyRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->ID; ?></td>
                      <td><?php echo $record->CompanyName; ?></td>
                      <td><?php echo $record->CompanyCode; ?></td>
                      <td><?php echo $record->InstrumentType; ?></td>
                      <td><?php echo $record->Segment; ?></td>
					  <td><?php echo $record->Exchange; ?></td>
                      <td class="text-center">
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'companyHistoryListing/'.$record->ID; ?>">View History</a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editCompanyOld/'.$record->ID; ?>"><i class="fa fa-pencil"></i>Edit</a>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'viewCompanyOld/'.$record->ID; ?>"><i class="fa fa-eye"></i>View details</a>
                          <a class="btn btn-sm btn-danger changeStatusCompany" href="javascript:void(0);" data-companyid="<?php echo $record->ID; ?>">
							<?php
								if($record->Status==1){
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
            jQuery("#searchList").attr("action", baseURL + "companyListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
