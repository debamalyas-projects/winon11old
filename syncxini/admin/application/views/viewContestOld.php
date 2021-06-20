<?php

$ID = '';
$ContestName = '';
$ContestCode = '';
$ContestPrizePool = '';
$ContestEntryFees = '';
$Zero2CroreMargin = '';
$ContestSpotsTotal = '';
$ContestSpotsAvailable = '';
$ContestSpotsJoined = '';
$ContestDate = '';
$PSMCDT = '';
$ContestAllowMultipleTeams = '';
$ContestMaximumTeamAllowed = '';
$ContestFinalPrizePool = '';
$ContestOpenDateTime = '';
$ContestCloseDateTime = '';
$ContestVisibleToAll = '';
$Status = '';
$updatedBy = '';
$UpdatedOn = '';
$createdBy = '';
$CreatedOn = '';

if(!empty($contestInfo))
{
    foreach ($contestInfo as $cf)
    {
		$ID = $cf->ID;
		$ContestName = $cf->ContestName;
		$ContestCode = $cf->ContestCode;
		$ContestPrizePool = $cf->ContestPrizePool;
		$ContestEntryFees = $cf->ContestEntryFees;
		$Zero2CroreMargin = $cf->Zero2CroreMargin;
		$ContestSpotsTotal = $cf->ContestSpotsTotal;
		$ContestSpotsAvailable = $cf->ContestSpotsAvailable;
		$ContestSpotsJoined = $cf->ContestSpotsJoined;
		$ContestDate = $cf->ContestDate;
		$PSMCDT = $cf->PSMCDT;
		$ContestAllowMultipleTeams = $cf->ContestAllowMultipleTeams;
		$ContestMaximumTeamAllowed = $cf->ContestMaximumTeamAllowed;
		$ContestFinalPrizePool = $cf->ContestFinalPrizePool;
		$ContestOpenDateTime = $cf->ContestOpenDateTime;
		$ContestCloseDateTime = $cf->ContestCloseDateTime;
		$ContestVisibleToAll = $cf->ContestVisibleToAll;
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
        <i class="fa fa-users"></i> Contest Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'contestListing/';?>">Contest Listing</a>
        <small>View Contest</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Contest Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestName">Contest Name</label>
                                        <?php echo $ContestName; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestPrizePool">Contest Prize Pool</label>
                                        <?php echo $ContestPrizePool; ?>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestEntryFees">Contest Entry Fees</label>
                                        <?php echo $ContestEntryFees; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestSpotsTotal">Contest Spots Total</label>
                                        <?php echo $ContestSpotsTotal; ?>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Zero2CroreMargin">Zero2Crore Margin (in %)</label>
                                        <?php echo $Zero2CroreMargin; ?>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestDate">Contest Date</label>
                                        <?php echo $ContestDate; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestDate">Previous Stock Market Closing Date Time</label>
                                        <?php echo $PSMCDT; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestAllowMultipleTeams">Contest Allow Multiple Teams</label>
                                        <?php if($ContestAllowMultipleTeams=='1'){ echo 'Yes';}else{ echo 'No'; } ?> 
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestMaximumTeamAllowed">Contest Maximum Team Allowed</label>
                                        <?php echo $ContestMaximumTeamAllowed; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestFinalPrizePool">Contest Final Prize Pool</label>
                                        <?php echo $ContestFinalPrizePool; ?>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestOpenDateTime">Contest Open Date Time</label>
                                        <?php echo $ContestOpenDateTime; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestCloseDateTime">Contest Close Date Time</label>
                                        <?php echo $ContestCloseDateTime; ?>
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestSpotsAvailable">Contest Spots Available</label>
                                        <?php echo $ContestSpotsAvailable; ?>
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestSpotsJoined">Contest Spots Joined</label>
                                        <?php
											if($ContestSpotsJoined==''){
												echo 'Unavailable';
											}else{
												echo $ContestSpotsJoined;
											}
										?>
                                    </div>
                                    
                                </div>
                            </div>
							<!--<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestVisibleToAll">Contest Visible To All</label>
                                        <?php if($ContestVisibleToAll=='1'){ echo 'Yes';}else{ echo 'No'; } ?>
                                    </div>
                                    
                                </div>
                            </div>-->
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="createdBy">Created By</label>
                                        <?php echo $createdBy; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="updatedBy">Updated By</label>
                                        <?php echo $updatedBy; ?>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="CreatedOn">Created On</label>
                                        <?php echo $CreatedOn; ?>
                                    </div>
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="UpdatedOn">Updated On</label>
                                        <?php echo $UpdatedOn; ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
						<div class="box-body">
							<h2>Companies in this contest</h2>
						</div>
						<div class="box-body">
							<div class="row" id="header_company">
                                <div class="col-md-3">
									<b><u>Company</u></b>
                                </div>
								<div class="col-md-3">
									<b><u>Zone</u></b>
                                </div>
								<div class="col-md-3">
									<b><u>Company Points</u></b>
                                </div>
                            </div>
							<hr>
							<?php
								for($i=0;$i<count($contestCompanyZonePointInfo);$i++){
							?>
							<div class="row" id="header_company">
                                <div class="col-md-3">
									<?php echo $contestCompanyZonePointInfo[$i]['CompanyCode']; ?>
                                </div>
								<div class="col-md-3">
									<?php echo $contestCompanyZonePointInfo[$i]['ZoneName']; ?>
                                </div>
								<div class="col-md-3">
									<?php echo $contestCompanyZonePointInfo[$i]['companyPoint']; ?>
                                </div>
                            </div>
							<hr>
							<?php
								}
							?>
						</div>
						<div class="box-body">
							<h2>Prize distribution in this contest</h2>
						</div>
						<div class="box-body">
							<div class="row" id="header_rank">
                                <div class="col-md-3">
									<b><u>Lower bound rank</u></b>
                                </div>
								<div class="col-md-3">
									<b><u>Upper bound rank</u></b>
                                </div>
								<div class="col-md-3">
									<b><u>Prize money</u></b>
                                </div>
                            </div>
							<hr>
							<?php
								for($i=0;$i<count($contestLowerBoundRankUpperBoundRankPrizrMoneyInfo);$i++){
							?>
							<div class="row" id="header_company">
                                <div class="col-md-3">
									<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['lowerBoundRank']; ?>
                                </div>
								<div class="col-md-3">
									<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['upperBoundRank']; ?>
                                </div>
								<div class="col-md-3">
									<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['prizeMoney']; ?>
                                </div>
                            </div>
							<hr>
							<?php
								}
							?>
						</div>
                        
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>