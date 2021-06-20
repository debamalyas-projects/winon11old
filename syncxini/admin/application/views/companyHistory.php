<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company History List
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'companyListing/';?>">Company Listing</a>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">'<?php echo $companyName; ?>' Company History List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>companyHistoryListing/<?php echo $companyID; ?>" method="POST" id="searchList">
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
                      <th>Date</th>
                      <th>Open Price</th>
                      <th>High Price</th>
                      <th>Low Price</th>
					  <th>Close Price</th>
                      <th>Volume</th>
					  <th>Created On</th>
                    </tr>
                    <?php
                    if(!empty($companyHistoryRecords))
                    {
                        foreach($companyHistoryRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->ID; ?></td>
                      <td><?php echo $record->Date; ?></td>
                      <td><?php echo $record->OpenPrice; ?></td>
                      <td><?php echo $record->HighPrice; ?></td>
                      <td><?php echo $record->LowPrice; ?></td>
					  <td><?php echo $record->ClosePrice; ?></td>
					  <td><?php echo $record->Volume; ?></td>
					  <td><?php echo $record->CreatedOn; ?></td>
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
            jQuery("#searchList").attr("action", baseURL + "companyHistoryListing/" + value + '/' + <?php echo $companyID; ?>);
            jQuery("#searchList").submit();
        });
    });
</script>
