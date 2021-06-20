<?php

$ID = '';
$CompanyName = '';
$CompanyCode = '';
$InstrumentToken = '';
$ExchangeToken = '';
$InstrumentType = '';
$Segment = '';
$Exchange = '';
$Status = '';
$updatedBy = '';
$UpdatedOn = '';
$createdBy = '';
$CreatedOn = '';

if(!empty($companyInfo))
{
    foreach ($companyInfo as $cf)
    {
		$ID = $cf->ID;
		$CompanyName = $cf->CompanyName;
		$CompanyCode = $cf->CompanyCode;
		$InstrumentToken = $cf->InstrumentToken;
		$ExchangeToken = $cf->ExchangeToken;
		$InstrumentType = $cf->InstrumentType;
		$Segment = $cf->Segment;
		$Exchange = $cf->Exchange;
		$Status = $cf->Status;
		$updatedBy = $cf->updatedBy;
		$UpdatedOn = $cf->UpdatedOn;
		$createdBy = $cf->createdBy;
		$CreatedOn = $cf->CreatedOn;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'companyListing/';?>">Company Listing</a>
        <small>View Company</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Company Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyName">Company Name</label>
                                        <?php echo $CompanyName; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CompanyCode">Company Code</label>
                                        <?php echo $CompanyCode; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="InstrumentToken">Instrument Token</label>
                                        <?php echo $InstrumentToken; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ExchangeTokename">Exchange Token</label>
                                        <?php echo $ExchangeToken; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="InstrumentType">Instrument Type</label>
                                        <?php echo $InstrumentType; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Segment">Segment</label>
                                        <?php echo $Segment; ?>
                                    </div>     
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Exchange">Exchange</label>
                                        <?php echo $Exchange; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="createdBy">Created By</label>
                                        <?php echo $createdBy; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updatedBy">Updated By</label>
                                        <?php echo $updatedBy; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CreatedOn">Created On</label>
                                        <?php echo $CreatedOn; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="UpdatedOn">Updated On</label>
                                        <?php echo $UpdatedOn; ?>
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