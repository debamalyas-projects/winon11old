<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Money Claim Request Management
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Money Claim Request List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>moneyClaim/moneyClaimListing" method="POST" id="searchList">
                            <div class="input-group">
							  <select name="searchText" class="form-control input-sm pull-right" style="width: 150px;">
								<option value="">Filter Claim Request</option>
								<option value="1" <?php if($searchText=='1'){ echo 'selected="selected"'; }else{ echo ''; } ?>>Not processed</option>
								<option value="0" <?php if($searchText=='0'){ echo 'selected="selected"'; }else{ echo ''; } ?>>Processed</option>
							  </select>
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
                      <th>Customer Name</th>
                      <th>Bank Account Number</th>
                      <th>Bank IFSC Code</th>
                      <th>Bank Branch</th>
					  <th>Claim Amount</th>
					  <th>Processing Status</th>
                    </tr>
                    <?php
                    if(!empty($moneyClaimRecords))
                    {
                        foreach($moneyClaimRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->ID; ?></td>
                      <td><?php echo $record->BankAccountNumber; ?></td>
                      <td><?php echo $record->IFSCCode; ?></td>
					  <td><?php echo $record->BankBranch; ?></td>
					  <td><?php echo $record->ClaimAmount; ?></td>
					  <td><?php
					  if($record->ProcessingStatus==0){
						echo "Processed";
					  }else{
						echo "Not Processed";
					  }
					  ?></td>
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
            jQuery("#searchList").attr("action", baseURL + "moneyClaim/moneyClaimListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
