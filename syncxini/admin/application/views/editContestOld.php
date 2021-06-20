<?php

$ID = '';
$ContestName = '';
$ContestPrizePool = '';
$ContestEntryFees = '';
$Zero2CroreMargin = '';
$ContestSpotsTotal = '';
$ContestDate = '';
$ContestAllowMultipleTeams = '';
$ContestMaximumTeamAllowed = '';
$ContestFinalPrizePool = '';
$ContestOpenDateTime = '';
$ContestCloseDateTime = '';
$ContestVisibleToAll = '';
$PSMCDT = '';


if(!empty($contestInfo))
{
    foreach ($contestInfo as $cf)
    {
		$ID = $cf->ID;
		$ContestName = $cf->ContestName;
		$ContestPrizePool = $cf->ContestPrizePool;
		$ContestEntryFees = $cf->ContestEntryFees;
		$Zero2CroreMargin = $cf->Zero2CroreMargin;
		$ContestSpotsTotal = $cf->ContestSpotsTotal;
		$ContestDate = $cf->ContestDate;
		$PSMCDT = $cf->PSMCDT;
		$ContestAllowMultipleTeams = $cf->ContestAllowMultipleTeams;
		$ContestMaximumTeamAllowed = $cf->ContestMaximumTeamAllowed;
		$ContestFinalPrizePool = $cf->ContestFinalPrizePool;
		$ContestOpenDateTime = $cf->ContestOpenDateTime;
		$ContestCloseDateTime = $cf->ContestCloseDateTime;
		$ContestVisibleToAll = $cf->ContestVisibleToAll;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Contest Management
		<a class="btn btn-sm btn-info" href="<?php echo base_url().'contestListing/';?>">Contest Listing</a>
        <small>Add / Edit Contest</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Contest Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editContest" method="post" id="editContest" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestName">Contest Name</label>
                                        <input type="text" class="form-control required" id="ContestName" name="ContestName" value="<?php echo $ContestName; ?>">
										<input type="hidden" name="ID" id="ID" value="<?php echo $ID; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestPrizePool">Contest Prize Pool</label>
                                        <input type="text" class="form-control required" id="ContestPrizePool" name="ContestPrizePool" value="<?php echo $ContestPrizePool; ?>" onblur="calculateContestEntryFees();">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestEntryFees">Contest Entry Fees</label>
                                        <input type="text" class="form-control required" id="ContestEntryFees" name="ContestEntryFees" value="<?php echo $ContestEntryFees; ?>" readonly="readonly">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestSpotsTotal">Contest Spots Total</label>
                                        <input type="text" class="form-control required" id="ContestSpotsTotal" name="ContestSpotsTotal" value="<?php echo $ContestSpotsTotal; ?>" onblur="calculateContestEntryFees();">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Zero2CroreMargin">Zero2Crore Margin (in %)</label>
                                        <input type="text" class="form-control required" id="Zero2CroreMargin" name="Zero2CroreMargin" value="<?php echo $Zero2CroreMargin; ?>" onblur="calculateContestEntryFees();">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestDate">Contest Date</label>
                                        <input type="text" class="form-control required datepicker" id="ContestDate" name="ContestDate" value="<?php echo $ContestDate; ?>">
										<input type="hidden" name="ContestAllowMultipleTeams" id="ContestAllowMultipleTeams" value="<?php echo $ContestAllowMultipleTeams; ?>">
										<input type="hidden" id="ContestMaximumTeamAllowed" name="ContestMaximumTeamAllowed" value="<?php echo $ContestMaximumTeamAllowed; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestDate">Previous Stock Market Closing Date Time</label>
                                        <input type="text" class="form-control required datepicker" id="PSMCDT" name="PSMCDT" value="<?php echo $PSMCDT; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestAllowMultipleTeams">Contest Allow Multiple Teams</label>
										<select id="ContestAllowMultipleTeams" name="ContestAllowMultipleTeams" class="form-control required" onchange="changeMaxTeam(this.value);">
											<option value="1" <?php if($ContestAllowMultipleTeams=='1'){ echo 'selected="selected"';} ?>>Yes</option>
											<option value="0" <?php if($ContestAllowMultipleTeams=='0'){ echo 'selected="selected"';} ?>>No</option>
										</select>
                                    </div>
                                    <script>
										function changeMaxTeam(val){
											if(val==0){
												$('.ContestMaximumTeamAllowed').val('1');
												$('.ContestMaximumTeamAllowed').attr('readonly','true');
											}else{
												$('.ContestMaximumTeamAllowed').val('2');
												$('.ContestMaximumTeamAllowed').removeAttr('readonly');
											}
										}
									</script>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestMaximumTeamAllowed">Contest Maximum Team Allowed</label>
                                        <input type="text" class="form-control required ContestMaximumTeamAllowed" id="ContestMaximumTeamAllowed" name="ContestMaximumTeamAllowed" value="<?php echo $ContestMaximumTeamAllowed; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestFinalPrizePool">Contest Final Prize Pool</label>
                                        <input type="text" class="form-control required" id="ContestFinalPrizePool" name="ContestFinalPrizePool" value="<?php echo $ContestFinalPrizePool; ?>" readonly="readonly">
                                    </div>
                                    
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestOpenDateTime">Contest Open Date Time</label>
                                        <input type="text" class="form-control required datepicker" id="ContestOpenDateTime" name="ContestOpenDateTime" value="<?php echo $ContestOpenDateTime; ?>">
                                    </div>
                                    
                                </div>
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestCloseDateTime">Contest Close Date Time</label>
                                        <input type="text" class="form-control required datepicker" id="ContestCloseDateTime" name="ContestCloseDateTime" value="<?php echo $ContestCloseDateTime; ?>">
										<input type="hidden" id="ContestVisibleToAll" name="ContestVisibleToAll" value="<?php echo $ContestVisibleToAll; ?>">
                                    </div>
                                    
                                </div>
                            </div>
							<!--<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="ContestVisibleToAll">Contest Visible To All</label>
                                        Yes <input type="radio" id="ContestVisibleToAll" name="ContestVisibleToAll" <?php if($ContestVisibleToAll=='1'){ echo 'checked="checked"';} ?> value="1">
										No <input type="radio" id="ContestVisibleToAll" name="ContestVisibleToAll" <?php if($ContestVisibleToAll=='0'){ echo 'checked="checked"';} ?> value="0">
                                    </div>
                                    
                                </div>
                            </div>-->
                        </div><!-- /.box-body -->
						<div class="box-body">
							<h2>Edit company in contest</h2>
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
								<div class="col-md-3">
									<b><u>Action</u></b>
                                </div>
                            </div>
							<hr>
							<div id="droparea_company">
							<?php
								for($i=0;$i<count($contestCompanyZonePointInfo);$i++){
							?>
								<div id="row_<?php echo $contestCompanyZonePointInfo[$i]['companyId']; ?>">
									<div class="row">
										<div class="col-md-3">
											<?php echo $contestCompanyZonePointInfo[$i]['CompanyCode']; ?><input type="hidden" name="companies[]" value="<?php echo $contestCompanyZonePointInfo[$i]['companyId']; ?>">
										</div>
										<div class="col-md-3">
											<?php echo $contestCompanyZonePointInfo[$i]['ZoneName']; ?><input type="hidden" name="zones[]" value="<?php echo $contestCompanyZonePointInfo[$i]['zoneId']; ?>">
										</div>
										<div class="col-md-3">
										<?php echo $contestCompanyZonePointInfo[$i]['companyPoint']; ?><input type="hidden" name="company_points[]" value="<?php echo $contestCompanyZonePointInfo[$i]['companyPoint']; ?>">
										</div>
										<div class="col-md-3">
											<a href="javascript:void(0);" onclick="deleteCompany('row_<?php echo $contestCompanyZonePointInfo[$i]['companyId']; ?>','<?php echo $contestCompanyZonePointInfo[$i]['companyId']; ?>');">Delete</a>
										</div>
									</div>
									<hr>
								</div>
							<?php
								}
							?>
							</div>
							<div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select id="company" class="form-control limitedNumbChosen" multiple="true">
											<?php
												for($i=0;$i<count($company_arr);$i++){
											?>
											<option value="<?php echo $company_arr[$i]->ID; ?>_<?php echo $company_arr[$i]->CompanyCode; ?>"><?php echo $company_arr[$i]->CompanyCode; ?></option>
											<?php
												}
											?>
										</select>
                                    </div>
                                    
                                </div>
								<div class="col-md-4">                                
                                    <div class="form-group">
                                        <label>Zone</label>
                                        <select id="zone" class="form-control">
                                            <option value="">SELECT ZONE</option>
											<?php
												for($i=0;$i<count($zone_arr);$i++){
											?>
											<option value="<?php echo $zone_arr[$i]->ID; ?>_<?php echo $zone_arr[$i]->ZoneName; ?>"><?php echo $zone_arr[$i]->ZoneName; ?></option>
											<?php
												}
											?>
										</select>
                                    </div>
                                    
                                </div>
								<div class="col-md-4">                                
                                    <div class="form-group">
                                        <label>Company Points</label>
                                        <input type="text" class="form-control" id="company_points">
                                    </div>
                                    
                                </div>
                            </div>
						</div>
						<div class="box-footer">
                            <a href="javascript:void(0);" class="btn btn-primary" onclick="addCompany();">Add Company</a>
                        </div>
						<script>
							<?php
								$array_str='';
								for($i=0;$i<count($contestCompanyZonePointInfo);$i++){
									if($i==count($contestCompanyZonePointInfo)-1){
										$array_str.='"'.$contestCompanyZonePointInfo[$i]['companyId'].'"';
									}else{
										$array_str.='"'.$contestCompanyZonePointInfo[$i]['companyId'].'",';
									}
								}
							?>
							var companies_added=new Array(<?php echo $array_str; ?>);
							function addCompany(){
								var company=$('#company').chosen().val().toString();
								var company_arr=company.split('_');
								var zone=$('#zone').val();
								var zone_arr=zone.split('_');
								var company_points=$('#company_points').val();
								
								if(zone==''){
								    alert('Please select zone.');
								}else{
    								if(isNaN(company_points)==false){
    									if(companies_added.indexOf(company_arr[0])!=-1){
    										alert('Company already added in this contest.');
    									}else{
    										var droparea='<div id="row_'+company_arr[0]+'"><div class="row"><div class="col-md-3">'+company_arr[1]+'<input type="hidden" name="companies[]" value="'+company_arr[0]+'"></div><div class="col-md-3">'+zone_arr[1]+'<input type="hidden" name="zones[]" value="'+zone_arr[0]+'"></div><div class="col-md-3">'+company_points+'<input type="hidden" name="company_points[]" value="'+company_points+'"></div><div class="col-md-3"><a href="javascript:void(0);" onclick="deleteCompany(\'row_'+company_arr[0]+'\',\''+company_arr[0]+'\');">Delete</a></div></div><hr></div>';
    										$('#droparea_company').append(droparea);
    										companies_added.push(company_arr[0]);
    										$('#company').val('').trigger('chosen:updated');
    										$('#company_points').val('');
    										$('#zone').val('');
    									}
    								}else{
    									alert('Company points is not numeric.');
    								}
								}
							}
							function deleteCompany(id,company_id){
								$('#'+id).remove();
								companies_added.splice(companies_added.indexOf(company_id),1);
							}
						</script>
						
						<div class="box-body">
							<h2>Edit prize distribution in contest</h2>
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
								<div class="col-md-3">
									<b><u>Action</u></b>
                                </div>
								<hr>
                            </div>
							<div id="droparea_rank">
							<?php
								for($i=0;$i<count($contestLowerBoundRankUpperBoundRankPrizrMoneyInfo);$i++){
							?>
								<div id="row_<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['lowerBoundRank']; ?>_<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['upperBoundRank']; ?>">
									<div class="row">
										<div class="col-md-3">
											<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['lowerBoundRank']; ?><input type="hidden" name="lower_bound_rank[]" value="<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['lowerBoundRank']; ?>">
										</div>
										<div class="col-md-3">
											<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['upperBoundRank']; ?><input type="hidden" name="upper_bound_rank[]" value="<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['upperBoundRank']; ?>">
										</div>
										<div class="col-md-3">
											<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['prizeMoney']; ?><input type="hidden" name="prize_money[]" value="<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['prizeMoney']; ?>">
										</div>
										<div class="col-md-3">
											<a href="javascript:void(0);" onclick="deletePrize('row_<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['lowerBoundRank']; ?>_<?php echo $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['upperBoundRank']; ?>');">Delete</a>
										</div>
									</div>
								<hr>
								</div>
							<?php
								}
							?>
							</div>
							<div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label>Lower bound rank</label>
                                        <input type="text" id="lower_bound_rank" class="form-control">
                                    </div>
                                </div>
								<div class="col-md-4">                                
                                    <div class="form-group">
                                        <label>Upper bound rank</label>
                                        <input type="text" id="upper_bound_rank" class="form-control">
                                    </div>
                                </div>
								<div class="col-md-4">                                
                                    <div class="form-group">
                                        <label>Prize money</label>
                                        <input type="text" id="prize_money" class="form-control">
                                    </div>
                                </div>
                            </div>
						</div>
						<div class="box-footer">
                            <a href="javascript:void(0);" class="btn btn-primary" onclick="addPrize();">Add prize</a>
                        </div>
						<script>
						<?php
						$rank_str='';
						for($i=0;$i<count($contestLowerBoundRankUpperBoundRankPrizrMoneyInfo);$i++){
							$lowerBoundRank=$contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['lowerBoundRank'];
							$upperBoundRank=$contestLowerBoundRankUpperBoundRankPrizrMoneyInfo[$i]['upperBoundRank'];
							
							for($j=$lowerBoundRank;$j<=$upperBoundRank;$j++){
								$rank_str.=$j.',';
							}
						}
						$rank_str = rtrim($rank_str, ',');
						
						?>
							var ranks_added=new Array(<?php echo $rank_str; ?>);
							ranks_added.sort();
							function addPrize(){
								var rank_add=new Array();
								var op=1;
								var lower_bound_rank=parseInt($('#lower_bound_rank').val());
								var upper_bound_rank=parseInt($('#upper_bound_rank').val());
								var prize_money=parseFloat($('#prize_money').val());
								if(lower_bound_rank>upper_bound_rank){
									alert('Lower bound rank can\'t be greater than upper bound rank.');
									return false;
								}
								if(isNaN(lower_bound_rank)==true){
									op=0;
								}
								if(isNaN(upper_bound_rank)==true){
									op=0;
								}
								if(isNaN(prize_money)==true){
									op=0;
								}
								if(op==1){
									for(var i=lower_bound_rank;i<=upper_bound_rank;i++){
										if(ranks_added.indexOf(i)!=-1){
											rank_add.push(0);
										}else{
											rank_add.push(1);
										}
									}
									if(rank_add.indexOf(0)==-1){
										var droparea='<div id="row_'+lower_bound_rank+'_'+upper_bound_rank+'"><div class="row"><div class="col-md-3">'+lower_bound_rank+'<input type="hidden" name="lower_bound_rank[]" value="'+lower_bound_rank+'"></div><div class="col-md-3">'+upper_bound_rank+'<input type="hidden" name="upper_bound_rank[]" value="'+upper_bound_rank+'"></div><div class="col-md-3">'+prize_money+'<input type="hidden" name="prize_money[]" value="'+prize_money+'"></div><div class="col-md-3"><a href="javascript:void(0);" onclick="deletePrize(\'row_'+lower_bound_rank+'_'+upper_bound_rank+'\');">Delete</a></div></div><hr></div>';
										$('#droparea_rank').append(droparea);
										for(var j=lower_bound_rank;j<=upper_bound_rank;j++){
											ranks_added.push(j);
										}
										ranks_added.sort();
									}else{
										alert('Rank already added in this contest.');
									}
								}
							}
							function deletePrize(id){
								$('#'+id).remove();
								var id_arr=id.split('_');
								var lower_bound_rank=parseInt(id_arr[1]);
								var upper_bound_rank=parseInt(id_arr[2]);
								for(var i=lower_bound_rank;i<=upper_bound_rank;i++){
									ranks_added.splice(ranks_added.indexOf(i),1);
								}
							}
						</script>
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Edit" />
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
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-timepicker-addon.css" />
<script src="<?php echo base_url(); ?>assets/js/editContest.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datetimepicker/jquery-ui-sliderAccess.js"></script>
<script>
$('.datepicker').datetimepicker();
function calculateContestEntryFees(){
	var ContestPrizePool=parseFloat($('#ContestPrizePool').val());
	var ContestSpotsTotal=parseInt($('#ContestSpotsTotal').val());
	var Zero2CroreMargin=parseInt($('#Zero2CroreMargin').val());
	if(isNaN(ContestPrizePool)==false && isNaN(ContestSpotsTotal)==false && isNaN(Zero2CroreMargin)==false){
		var ContestEntryFees=ContestPrizePool/ContestSpotsTotal+(Zero2CroreMargin/100)*(ContestPrizePool/ContestSpotsTotal);
		$('#ContestEntryFees').val(ContestEntryFees);
	}else{
		$('#ContestEntryFees').val('');
	}
}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script>
$(document).ready(function(){
  //Chosen
  $(".limitedNumbChosen").chosen({
        max_selected_options: 1,
    placeholder_text_multiple: ""
    })
});
</script>